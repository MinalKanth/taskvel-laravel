/*
|--------------------------------------------------------------------------
| Taskvel Focus Timer
| Fixed: button IDs, progress ring selector, sessionStorage persistence,
|        floating mini-widget visible on all pages
|--------------------------------------------------------------------------
*/

'use strict';

/*
|--------------------------------------------------------------------------
| Global State
|--------------------------------------------------------------------------
*/

let timer = null;
let timerRunning = false;
let totalSeconds = 25 * 60;
let remainingSeconds = totalSeconds;
let currentMode = 'focus';

let stopwatch = null;
let stopwatchRunning = false;
let stopwatchSeconds = 0;

let focusIdleTimer = null;

const STORAGE_KEY = 'taskvel_pomodoro';

/*
|--------------------------------------------------------------------------
| DOM Ready
|--------------------------------------------------------------------------
*/

document.addEventListener('DOMContentLoaded', function() {

    restorePomodoro(); // restore FIRST so state is set before UI init

    initializePomodoro();
    initializeStopwatch();
    initializeFocusStatistics();
    initializeSessionHistory();
    initializeFocusSounds();
    initializeBrowserNotifications();
    initializeDailyGoal();
    initializeAutoStart();
    initializeSessionNotes();
    initializeWeeklyAnalytics();
    initializeFocusShortcuts();
    initializeIdleDetection();
    initializeExportHistory();
    injectFloatingWidget(); // floating mini-timer shown on every page

    if (document.getElementById('timerDisplay')) {
        setInterval(savePomodoro, 10000);
    }

});


/*
|--------------------------------------------------------------------------
| Initialize Pomodoro
| NOTE: Blade uses id="startBtn", id="pauseBtn", id="resetBtn"
|       The old JS was looking for "startTimer", "pauseTimer", "resetTimer"
|       — that mismatch was why the timer never started.
|--------------------------------------------------------------------------
*/

function initializePomodoro() {

    updateTimerDisplay();
    updateCircleProgress();

    // --- Mode buttons ---
    document.querySelectorAll('.mode-btn').forEach(function(button) {
        button.addEventListener('click', function() {

            document.querySelectorAll('.mode-btn').forEach(function(btn) {
                btn.classList.remove('active');
            });

            this.classList.add('active');
            currentMode = this.dataset.mode;

            switch (currentMode) {
                case 'focus':
                    totalSeconds = 25 * 60;
                    break;
                case 'short':
                    totalSeconds = 5 * 60;
                    break;
                case 'long':
                    totalSeconds = 15 * 60;
                    break;
                default:
                    totalSeconds = 25 * 60;
            }

            remainingSeconds = totalSeconds;
            updateTimerDisplay();
            updateCircleProgress();
            savePomodoro();

        });
    });

    // --- Control buttons (IDs match the Blade template) ---
    const startBtn = document.getElementById('startBtn');
    const pauseBtn = document.getElementById('pauseBtn');
    const resetBtn = document.getElementById('resetBtn');

    // Also support the older IDs in case another view uses them
    const startTimer = document.getElementById('startTimer');
    const pauseTimer = document.getElementById('pauseTimer');
    const resetTimer = document.getElementById('resetTimer');

    if (startBtn) startBtn.addEventListener('click', startPomodoro);
    if (pauseBtn) pauseBtn.addEventListener('click', pausePomodoro);
    if (resetBtn) resetBtn.addEventListener('click', resetPomodoro);

    if (startTimer) startTimer.addEventListener('click', startPomodoro);
    if (pauseTimer) pauseTimer.addEventListener('click', pausePomodoro);
    if (resetTimer) resetTimer.addEventListener('click', resetPomodoro);

}


/*
|--------------------------------------------------------------------------
| Start Timer
|--------------------------------------------------------------------------
*/

function startPomodoro() {

    if (timerRunning) { return; }

    clearInterval(timer);
    timerRunning = true;

    savePomodoro(); // persist the running state immediately
    updateFloatingWidget();

    timer = setInterval(function() {

        remainingSeconds = Math.max(remainingSeconds - 1, 0);

        updateTimerDisplay();
        updateCircleProgress();
        updateFloatingWidget();

        if (remainingSeconds === 0) {
            completePomodoro();
        }

    }, 1000);

}


/*
|--------------------------------------------------------------------------
| Pause Timer
|--------------------------------------------------------------------------
*/

function pausePomodoro() {

    timerRunning = false;
    clearInterval(timer);

    savePomodoro();
    updateFloatingWidget();

}


/*
|--------------------------------------------------------------------------
| Reset Timer
|--------------------------------------------------------------------------
*/

function resetPomodoro() {

    pausePomodoro();

    remainingSeconds = totalSeconds;

    updateTimerDisplay();
    updateCircleProgress();
    updateFloatingWidget();

    savePomodoro();

}


/*
|--------------------------------------------------------------------------
| Complete Session
|--------------------------------------------------------------------------
*/

function completePomodoro() {

    pausePomodoro();

    incrementCompletedSessions();
    calculateFocusStreak();
    initializeDailyGoal();

    savePomodoro();
    playNotificationSound();

    sendNotification('Pomodoro Completed', 'Great job! Time for a break.');

    if (typeof showToast === 'function') {
        showToast('Session Completed', 'Excellent work!', 'success');
    }

}


/*
|--------------------------------------------------------------------------
| Update Timer Display
| Blade uses id="timerDisplay" — kept the same
|--------------------------------------------------------------------------
*/

function updateTimerDisplay() {

    const display = document.getElementById('timerDisplay');
    if (!display) { return; }

    const minutes = Math.floor(remainingSeconds / 60);
    const seconds = remainingSeconds % 60;

    display.textContent =
        String(minutes).padStart(2, '0') + ':' + String(seconds).padStart(2, '0');

}


/*
|--------------------------------------------------------------------------
| Progress Ring
| Blade uses id="progressRing" on the circle element.
| We support BOTH the id selector AND the class selector (.timer-progress)
| so this works with whatever markup is in the view.
|--------------------------------------------------------------------------
*/

function updateCircleProgress() {

    // Try the id first (matches the Blade template), then fall back to the class
    const circle =
        document.getElementById('progressRing') ||
        document.querySelector('.timer-progress');

    if (!circle) { return; }

    // The Blade SVG uses r=135, circumference = 2πr ≈ 848
    // The CSS class version uses circumference = 879 (r=140)
    // Detect which one we're dealing with
    const r = parseFloat(circle.getAttribute('r') || '140');
    const circ = parseFloat(circle.getAttribute('stroke-dasharray') || '') || Math.round(2 * Math.PI * r);

    const progress = totalSeconds > 0 ? remainingSeconds / totalSeconds : 0;

    circle.style.strokeDashoffset = circ - (circ * progress);

}


/*
|--------------------------------------------------------------------------
| sessionStorage Persistence
| Using sessionStorage so data survives navigation within the same tab
| but doesn't persist forever like localStorage.
|--------------------------------------------------------------------------
*/

function savePomodoro() {

    const completedCounter = document.getElementById('completedSessions');

    const data = {
        mode: currentMode,
        total: totalSeconds,
        remaining: remainingSeconds,
        timerRunning: timerRunning,
        // Store the absolute wall-clock start so we can compensate for time
        // spent on other pages
        startedAt: timerRunning ?
            (Date.now() - ((totalSeconds - remainingSeconds) * 1000)) : null,
        completed: completedCounter ? completedCounter.textContent : 0,
    };

    sessionStorage.setItem(STORAGE_KEY, JSON.stringify(data));

}


/*
|--------------------------------------------------------------------------
| Restore Session (called on every DOMContentLoaded)
|--------------------------------------------------------------------------
*/

function restorePomodoro() {

    const raw = sessionStorage.getItem(STORAGE_KEY);
    if (!raw) { return; }

    try {

        const session = JSON.parse(raw);

        currentMode = session.mode || 'focus';
        totalSeconds = Number(session.total) || 1500;

        if (session.timerRunning && session.startedAt) {
            // Account for time that passed while we were on another page
            const elapsed = Math.floor((Date.now() - session.startedAt) / 1000);
            remainingSeconds = Math.max(totalSeconds - elapsed, 0);
        } else {
            remainingSeconds = Number(session.remaining) || totalSeconds;
        }

        updateTimerDisplay();
        updateCircleProgress();

        // Restore completed counter
        const completedEl = document.getElementById('completedSessions');
        if (completedEl) {
            completedEl.textContent = session.completed || 0;
        }

        // Restore active mode button highlight
        document.querySelectorAll('.mode-btn').forEach(function(btn) {
            btn.classList.toggle('active', btn.dataset.mode === currentMode);
        });

        // Auto-resume if it was running
        if (session.timerRunning && remainingSeconds > 0) {
            timerRunning = false; // ensure startPomodoro() can start
            startPomodoro();
        }

    } catch (e) {
        console.error('Taskvel: could not restore Pomodoro session.', e);
    }

}


/*
|--------------------------------------------------------------------------
| Floating Mini-Widget
| Injected into every page so users can see the timer is running
| even when they navigate away from /focus
|--------------------------------------------------------------------------
*/

function injectFloatingWidget() {

    // Don't add a second widget if we're already on the focus page
    if (document.getElementById('tvFloatWidget')) { return; }

    const widget = document.createElement('div');
    widget.id = 'tvFloatWidget';
    widget.innerHTML = `
        <span id="tvFloatTime">--:--</span>
        <button id="tvFloatPause" title="Pause/Resume">⏸</button>
        <a id="tvFloatLink" href="/focus" title="Go to Focus">▶ Focus</a>
    `;

    widget.style.cssText = `
        position: fixed;
        bottom: 24px;
        right: 24px;
        display: none;
        align-items: center;
        gap: 10px;
        background: var(--primary, #4f46e5);
        color: #fff;
        padding: 10px 16px;
        border-radius: 999px;
        box-shadow: 0 8px 24px rgba(79,70,229,.35);
        font-weight: 700;
        font-size: .95rem;
        z-index: 9999;
        cursor: default;
    `;

    const pauseBtn = widget.querySelector('#tvFloatPause');
    pauseBtn.style.cssText = `
        background: rgba(255,255,255,.2);
        border: none;
        color: #fff;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        cursor: pointer;
        font-size: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
    `;

    widget.querySelector('#tvFloatLink').style.cssText = `
        color: rgba(255,255,255,.85);
        font-size: .8rem;
        font-weight: 600;
        text-decoration: none;
        white-space: nowrap;
    `;

    pauseBtn.addEventListener('click', function() {
        if (timerRunning) {
            pausePomodoro();
            pauseBtn.textContent = '▶';
        } else {
            startPomodoro();
            pauseBtn.textContent = '⏸';
        }
    });

    document.body.appendChild(widget);
    updateFloatingWidget();

}

function updateFloatingWidget() {

    const widget = document.getElementById('tvFloatWidget');
    const timeEl = document.getElementById('tvFloatTime');
    const pauseBtn = document.getElementById('tvFloatPause');

    if (!widget) { return; }

    const minutes = Math.floor(remainingSeconds / 60);
    const seconds = remainingSeconds % 60;
    const timeStr = String(minutes).padStart(2, '0') + ':' + String(seconds).padStart(2, '0');

    // Show widget only when a session is active (running OR paused mid-session)
    const hasActiveSession = remainingSeconds > 0 && remainingSeconds < totalSeconds;

    widget.style.display = hasActiveSession ? 'flex' : 'none';

    if (timeEl) { timeEl.textContent = timeStr; }
    if (pauseBtn) { pauseBtn.textContent = timerRunning ? '⏸' : '▶'; }

}


/*
|--------------------------------------------------------------------------
| Stopwatch
|--------------------------------------------------------------------------
*/

function initializeStopwatch() {

    const start = document.getElementById('startStopwatch');
    const stop = document.getElementById('stopStopwatch');
    const reset = document.getElementById('resetStopwatch');

    if (start) { start.addEventListener('click', startStopwatch); }
    if (stop) { stop.addEventListener('click', stopStopwatch); }
    if (reset) { reset.addEventListener('click', resetStopwatch); }

}

function startStopwatch() {

    if (stopwatchRunning) { return; }

    clearInterval(stopwatch);
    stopwatchRunning = true;

    stopwatch = setInterval(function() {
        stopwatchSeconds++;
        updateStopwatch();
    }, 1000);

}

function stopStopwatch() {
    stopwatchRunning = false;
    clearInterval(stopwatch);
}

function resetStopwatch() {
    stopStopwatch();
    stopwatchSeconds = 0;
    updateStopwatch();
}

function updateStopwatch() {

    const display = document.getElementById('stopwatchDisplay');
    if (!display) { return; }

    const h = Math.floor(stopwatchSeconds / 3600);
    const m = Math.floor((stopwatchSeconds % 3600) / 60);
    const s = stopwatchSeconds % 60;

    display.textContent =
        String(h).padStart(2, '0') + ':' +
        String(m).padStart(2, '0') + ':' +
        String(s).padStart(2, '0');

}


/*
|--------------------------------------------------------------------------
| Focus Statistics
|--------------------------------------------------------------------------
*/

function initializeFocusStatistics() {

    document.querySelectorAll('[data-focus-count]').forEach(function(item) {
        item.textContent = item.dataset.focusCount || 0;
    });

}


/*
|--------------------------------------------------------------------------
| Session History
|--------------------------------------------------------------------------
*/

function initializeSessionHistory() {

    const history = document.getElementById('focusHistory');
    if (!history) { return; }

}


/*
|--------------------------------------------------------------------------
| Notification Sound
|--------------------------------------------------------------------------
*/

function initializeFocusSounds() {
    window.focusAudio = null;
}

function playNotificationSound() {

    if (!window.focusAudio) { return; }

    window.focusAudio.currentTime = 0;
    window.focusAudio.play().catch(function() { /* autoplay restriction */ });

}


/*
|--------------------------------------------------------------------------
| Browser Notifications
|--------------------------------------------------------------------------
*/

function initializeBrowserNotifications() {

    if (typeof Notification === 'undefined') { return; }

    if (Notification.permission === 'default') {
        Notification.requestPermission();
    }

}

function sendNotification(title, body) {

    if (typeof Notification === 'undefined') { return; }
    if (Notification.permission !== 'granted') { return; }

    new Notification(title, { body: body, icon: '/favicon.ico' });

}


/*
|--------------------------------------------------------------------------
| Daily Goal
|--------------------------------------------------------------------------
*/

function initializeDailyGoal() {

    const goal = document.getElementById('dailyGoal');
    const progress = document.getElementById('goalProgress');
    const counter = document.getElementById('completedSessions');

    if (!goal || !progress || !counter) { return; }

    const target = parseInt(goal.dataset.goal || 8);
    const completed = parseInt(counter.textContent || 0);
    const percent = Math.min(Math.round((completed / target) * 100), 100);

    progress.style.width = percent + '%';
    progress.textContent = percent + '%';

}


/*
|--------------------------------------------------------------------------
| Auto Start
|--------------------------------------------------------------------------
*/

function initializeAutoStart() {

    const checkbox = document.getElementById('autoStart');
    if (!checkbox) { return; }

    checkbox.checked = sessionStorage.getItem('auto_start') === '1';

    checkbox.addEventListener('change', function() {
        sessionStorage.setItem('auto_start', this.checked ? '1' : '0');
    });

}


/*
|--------------------------------------------------------------------------
| Session Notes
|--------------------------------------------------------------------------
*/

function initializeSessionNotes() {

    const textarea = document.getElementById('sessionNotes');
    if (!textarea) { return; }

    textarea.value = sessionStorage.getItem('focus_notes') || '';

    textarea.addEventListener('input', function() {
        sessionStorage.setItem('focus_notes', this.value);
    });

}


/*
|--------------------------------------------------------------------------
| Weekly Analytics
|--------------------------------------------------------------------------
*/

function initializeWeeklyAnalytics() {

    if (typeof Chart === 'undefined') { return; }

    const chart = document.getElementById('focusWeeklyChart');
    if (!chart) { return; }

    new Chart(chart, {
        type: 'bar',
        data: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            datasets: [{ label: 'Focus Hours', data: [2, 3, 4, 5, 4, 2, 1] }],
        },
        options: { responsive: true, maintainAspectRatio: false },
    });

}


/*
|--------------------------------------------------------------------------
| Keyboard Shortcuts
|--------------------------------------------------------------------------
*/

function initializeFocusShortcuts() {

    document.addEventListener('keydown', function(e) {

        if (e.repeat) { return; }

        if (e.code === 'Space') {

            if (
                document.activeElement.tagName === 'INPUT' ||
                document.activeElement.tagName === 'TEXTAREA'
            ) { return; }

            e.preventDefault();
            timerRunning ? pausePomodoro() : startPomodoro();

        }

        if (e.key.toLowerCase() === 'r') {
            resetPomodoro();
        }

    });

}


/*
|--------------------------------------------------------------------------
| Idle Detection (auto-pause after 5 min of inactivity)
|--------------------------------------------------------------------------
*/

function initializeIdleDetection() {

    ['mousemove', 'keydown', 'scroll', 'click'].forEach(function(event) {
        document.addEventListener(event, resetFocusIdle);
    });

}

function resetFocusIdle() {

    clearTimeout(focusIdleTimer);

    focusIdleTimer = setTimeout(function() {

        if (!timerRunning) { return; }

        pausePomodoro();

        if (typeof showToast === 'function') {
            showToast('Focus Paused', 'Paused because of inactivity.', 'warning');
        }

    }, 300000); // 5 minutes

}


/*
|--------------------------------------------------------------------------
| Focus Streak
|--------------------------------------------------------------------------
*/

function calculateFocusStreak() {

    let streak = parseInt(sessionStorage.getItem('focus_streak') || 0);
    streak++;
    sessionStorage.setItem('focus_streak', streak);

    const label = document.getElementById('focusStreak');
    if (label) { label.textContent = streak; }

}


/*
|--------------------------------------------------------------------------
| Completed Sessions Counter
|--------------------------------------------------------------------------
*/

function incrementCompletedSessions() {

    const counter = document.getElementById('completedSessions');
    if (!counter) { return; }

    let value = parseInt(counter.textContent);
    if (isNaN(value)) { value = 0; }

    counter.textContent = ++value;

}


/*
|--------------------------------------------------------------------------
| Export History
|--------------------------------------------------------------------------
*/

function initializeExportHistory() {

    const button = document.getElementById('exportFocusHistory');
    if (!button) { return; }

    button.addEventListener('click', function() {
        if (typeof showToast === 'function') {
            showToast('Export', 'Preparing export...', 'success');
        }
    });

}


/*
|--------------------------------------------------------------------------
| End Focus.js
|--------------------------------------------------------------------------
*/