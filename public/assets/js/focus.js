/*
|--------------------------------------------------------------------------
| Taskvel Focus Timer
|--------------------------------------------------------------------------
*/

'use strict';

/*
|--------------------------------------------------------------------------
| Global Variables
|--------------------------------------------------------------------------
*/

// let timer = null;
let timerRunning = false;

let totalSeconds = 25 * 60;
let remainingSeconds = totalSeconds;

let currentMode = 'focus';

let stopwatch = null;
let stopwatchRunning = false;
let stopwatchSeconds = 0;

let focusIdleTimer = null;


/*
|--------------------------------------------------------------------------
| DOM Ready
|--------------------------------------------------------------------------
*/

document.addEventListener('DOMContentLoaded', function() {

    initializePomodoro();

    initializeStopwatch();

    initializeFocusStatistics();

    initializeSessionHistory();

    initializeFocusSounds();

    restorePomodoro();

    initializeBrowserNotifications();

    initializeDailyGoal();

    initializeAutoStart();

    initializeSessionNotes();

    initializeWeeklyAnalytics();

    initializeFocusShortcuts();

    initializeIdleDetection();

    initializeExportHistory();

    if (document.getElementById('timerDisplay')) {

        setInterval(savePomodoro, 10000);

    }

});


/*
|--------------------------------------------------------------------------
| Initialize Pomodoro
|--------------------------------------------------------------------------
*/

function initializePomodoro() {

    updateTimerDisplay();

    updateCircleProgress();

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

    const start = document.getElementById('startTimer');
    const pause = document.getElementById('pauseTimer');
    const reset = document.getElementById('resetTimer');

    if (start) {

        start.addEventListener('click', startPomodoro);

    }

    if (pause) {

        pause.addEventListener('click', pausePomodoro);

    }

    if (reset) {

        reset.addEventListener('click', resetPomodoro);

    }

}


/*
|--------------------------------------------------------------------------
| Start Timer
|--------------------------------------------------------------------------
*/

function startPomodoro() {

    if (timerRunning) {

        return;

    }

    clearInterval(timer);

    timerRunning = true;

    timer = setInterval(function() {

        remainingSeconds = Math.max(remainingSeconds - 1, 0);

        updateTimerDisplay();

        updateCircleProgress();

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

    sendNotification(

        'Pomodoro Completed',

        'Great job! Time for a break.'

    );

    if (typeof showToast === 'function') {

        showToast(

            'Session Completed',

            'Excellent work!',

            'success'

        );

    }

}


/*
|--------------------------------------------------------------------------
| Update Timer Display
|--------------------------------------------------------------------------
*/

function updateTimerDisplay() {

    const display = document.getElementById('timerDisplay');

    if (!display) {

        return;

    }

    const minutes = Math.floor(remainingSeconds / 60);

    const seconds = remainingSeconds % 60;

    display.textContent =

        String(minutes).padStart(2, '0') +

        ':' +

        String(seconds).padStart(2, '0');

}


/*
|--------------------------------------------------------------------------
| Progress Ring
|--------------------------------------------------------------------------
*/

function updateCircleProgress() {

    const circle = document.querySelector('.timer-progress');

    if (!circle) {

        return;

    }

    const circumference = 879;

    const progress = totalSeconds > 0

        ?
        remainingSeconds / totalSeconds

        : 0;

    circle.style.strokeDashoffset =

        circumference - (circumference * progress);

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

    if (start) {
        start.addEventListener('click', startStopwatch);
    }

    if (stop) {
        stop.addEventListener('click', stopStopwatch);
    }

    if (reset) {
        reset.addEventListener('click', resetStopwatch);
    }

}

function startStopwatch() {

    if (stopwatchRunning) {
        return;
    }

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

    if (!display) {
        return;
    }

    const hours = Math.floor(stopwatchSeconds / 3600);
    const minutes = Math.floor((stopwatchSeconds % 3600) / 60);
    const seconds = stopwatchSeconds % 60;

    display.textContent =
        String(hours).padStart(2, '0') + ':' +
        String(minutes).padStart(2, '0') + ':' +
        String(seconds).padStart(2, '0');

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

    if (!history) {
        return;
    }

    console.log('Focus history initialized.');

}


/*
|--------------------------------------------------------------------------
| Notification Sound
|--------------------------------------------------------------------------
*/

function initializeFocusSounds() {

    // try {

    //     window.focusAudio = new Audio('/assets/audio/complete.mp3');

    //     window.focusAudio.preload = 'auto';

    // } catch (e) {

    //     window.focusAudio = null;

    // }
    function initializeFocusSounds() {

        window.focusAudio = null;

    }

}

function playNotificationSound() {

    if (!window.focusAudio) {
        return;
    }

    window.focusAudio.currentTime = 0;

    window.focusAudio.play().catch(function() {

        // Ignore autoplay restriction

    });

}


/*
|--------------------------------------------------------------------------
| Save Session
|--------------------------------------------------------------------------
*/

function savePomodoro() {

    const completedCounter = document.getElementById('completedSessions');

    localStorage.setItem('taskvel_pomodoro', JSON.stringify({

        mode: currentMode,

        total: totalSeconds,

        remaining: remainingSeconds,

        completed: completedCounter ?
            completedCounter.textContent : 0

    }));

}


/*
|--------------------------------------------------------------------------
| Restore Session
|--------------------------------------------------------------------------
*/

function restorePomodoro() {

    const data = localStorage.getItem('taskvel_pomodoro');

    if (!data) {
        return;
    }

    try {

        const session = JSON.parse(data);

        currentMode = session.mode || 'focus';

        totalSeconds = Number(session.total) || 1500;

        remainingSeconds = Number(session.remaining) || totalSeconds;

        updateTimerDisplay();

        updateCircleProgress();

        const completed = document.getElementById('completedSessions');

        if (completed) {

            completed.textContent = session.completed || 0;

        }

    } catch (error) {

        console.error('Unable to restore Pomodoro session.', error);

    }

}


/*
|--------------------------------------------------------------------------
| Completed Sessions
|--------------------------------------------------------------------------
*/

function incrementCompletedSessions() {

    const counter = document.getElementById('completedSessions');

    if (!counter) {
        return;
    }

    let value = parseInt(counter.textContent);

    if (isNaN(value)) {

        value = 0;

    }

    value++;

    counter.textContent = value;

}

/*
|--------------------------------------------------------------------------
| Browser Notifications
|--------------------------------------------------------------------------
*/

function initializeBrowserNotifications() {

    if (typeof Notification === 'undefined') {
        return;
    }

    if (Notification.permission === 'default') {
        Notification.requestPermission();
    }

}

function sendNotification(title, body) {

    if (typeof Notification === 'undefined') {
        return;
    }

    if (Notification.permission !== 'granted') {
        return;
    }

    new Notification(title, {
        body: body,
        icon: '/favicon.ico'
    });

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

    if (!goal || !progress || !counter) {
        return;
    }

    const target = parseInt(goal.dataset.goal || 8);

    const completed = parseInt(counter.textContent || 0);

    const percent = Math.min(
        Math.round((completed / target) * 100),
        100
    );

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

    if (!checkbox) {
        return;
    }

    checkbox.checked =
        localStorage.getItem('auto_start') === '1';

    checkbox.addEventListener('change', function() {

        localStorage.setItem(
            'auto_start',
            this.checked ? '1' : '0'
        );

    });

}


/*
|--------------------------------------------------------------------------
| Session Notes
|--------------------------------------------------------------------------
*/

function initializeSessionNotes() {

    const textarea = document.getElementById('sessionNotes');

    if (!textarea) {
        return;
    }

    textarea.value =
        localStorage.getItem('focus_notes') || '';

    textarea.addEventListener('input', function() {

        localStorage.setItem(
            'focus_notes',
            this.value
        );

    });

}


/*
|--------------------------------------------------------------------------
| Weekly Analytics
|--------------------------------------------------------------------------
*/

function initializeWeeklyAnalytics() {

    if (typeof Chart === 'undefined') {
        return;
    }

    const chart = document.getElementById('focusWeeklyChart');

    if (!chart) {
        return;
    }

    new Chart(chart, {

        type: 'bar',

        data: {

            labels: [
                'Mon',
                'Tue',
                'Wed',
                'Thu',
                'Fri',
                'Sat',
                'Sun'
            ],

            datasets: [

                {

                    label: 'Focus Hours',

                    data: [2, 3, 4, 5, 4, 2, 1]

                }

            ]

        },

        options: {

            responsive: true,

            maintainAspectRatio: false

        }

    });

}


/*
|--------------------------------------------------------------------------
| Keyboard Shortcuts
|--------------------------------------------------------------------------
*/

function initializeFocusShortcuts() {

    document.addEventListener('keydown', function(e) {

        if (e.repeat) {
            return;
        }

        if (e.code === 'Space') {

            if (
                document.activeElement.tagName === 'INPUT' ||
                document.activeElement.tagName === 'TEXTAREA'
            ) {
                return;
            }

            e.preventDefault();

            timerRunning
                ?
                pausePomodoro() :
                startPomodoro();

        }

        if (e.key.toLowerCase() === 'r') {

            resetPomodoro();

        }

    });

}


/*
|--------------------------------------------------------------------------
| Idle Detection
|--------------------------------------------------------------------------
*/

function initializeIdleDetection() {

    ['mousemove', 'keydown', 'scroll', 'click']
    .forEach(function(event) {

        document.addEventListener(event, resetFocusIdle);

    });

}

function resetFocusIdle() {

    clearTimeout(focusIdleTimer);

    focusIdleTimer = setTimeout(function() {

        if (!timerRunning) {
            return;
        }

        pausePomodoro();

        if (typeof showToast === 'function') {

            showToast(
                'Focus Paused',
                'Paused because of inactivity.',
                'warning'
            );

        }

    }, 300000);

}


/*
|--------------------------------------------------------------------------
| Focus Streak
|--------------------------------------------------------------------------
*/

function calculateFocusStreak() {

    let streak = parseInt(
        localStorage.getItem('focus_streak') || 0
    );

    streak++;

    localStorage.setItem(
        'focus_streak',
        streak
    );

    const label =
        document.getElementById('focusStreak');

    if (label) {

        label.textContent = streak;

    }

}


/*
|--------------------------------------------------------------------------
| Export
|--------------------------------------------------------------------------
*/

function initializeExportHistory() {

    const button =
        document.getElementById('exportFocusHistory');

    if (!button) {
        return;
    }

    button.addEventListener('click', function() {

        if (typeof showToast === 'function') {

            showToast(
                'Export',
                'Preparing export...',
                'success'
            );

        }

    });

}


/*
|--------------------------------------------------------------------------
| End Focus.js
|--------------------------------------------------------------------------
*/

console.log('Taskvel Focus Module Loaded');