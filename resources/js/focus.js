/*
|--------------------------------------------------------------------------
| Taskvel Focus — focus.js
|--------------------------------------------------------------------------
| All timer logic now lives in the Blade view's inline script for
| tighter coupling with session-specific state.
|
| This file only provides:
|  1. The floating mini-widget injection on non-focus pages
|  2. Cross-page sessionStorage restore (so widget shows on other pages)
|--------------------------------------------------------------------------
*/

'use strict';

const TV_KEY = 'taskvel_pomodoro';

document.addEventListener('DOMContentLoaded', function() {

    // Don't inject the widget if we're already on the focus page
    // (the focus page handles its own widget)
    if (!document.getElementById('timerDisplay')) {
        injectFloatingWidgetStandalone();
    }

});


/*
|--------------------------------------------------------------------------
| Floating Mini-Widget (non-focus pages only)
|--------------------------------------------------------------------------
*/

function injectFloatingWidgetStandalone() {

    if (document.getElementById('tvFloatWidget')) { return; }

    const raw = sessionStorage.getItem(TV_KEY);
    if (!raw) { return; }

    let session;
    try { session = JSON.parse(raw); } catch (e) { return; }

    // Compute real remaining seconds (timer may have been running)
    let remaining = Number(session.remaining) || 0;
    let running = session.timerRunning || false;

    if (running && session.startedAt) {
        const elapsed = Math.floor((Date.now() - session.startedAt) / 1000);
        remaining = Math.max((Number(session.total) || 1500) - elapsed, 0);
    }

    const hasActive = remaining > 0 && remaining < (Number(session.total) || 1500);
    if (!hasActive) { return; }

    // Build widget
    const w = document.createElement('div');
    w.id = 'tvFloatWidget';

    const m = String(Math.floor(remaining / 60)).padStart(2, '0');
    const s = String(remaining % 60).padStart(2, '0');

    w.innerHTML = `
        <span id="tvFloatTime" style="font-variant-numeric:tabular-nums;">${m}:${s}</span>
        <span id="tvFloatIcon" style="font-size:.85rem;">${running ? '▶' : '⏸'}</span>
        <a id="tvFloatLink" href="/focus"
           style="color:rgba(255,255,255,.85);font-size:.78rem;font-weight:600;text-decoration:none;
                  background:rgba(255,255,255,.15);padding:3px 10px;border-radius:999px;">
            Open
        </a>
    `;

    w.style.cssText = [
        'position:fixed', 'bottom:24px', 'right:24px',
        'display:flex', 'align-items:center', 'gap:10px',
        'background:var(--primary,#4f46e5)', 'color:#fff',
        'padding:10px 16px', 'border-radius:999px',
        'box-shadow:0 8px 24px rgba(79,70,229,.35)',
        'font-weight:700', 'font-size:.92rem', 'z-index:9999',
    ].join(';');

    document.body.appendChild(w);

    // Live-update the countdown every second (read-only — no timer control here)
    if (running && remaining > 0) {

        let r = remaining;

        const tick = setInterval(function() {

            r = Math.max(r - 1, 0);

            const tm = document.getElementById('tvFloatTime');
            if (tm) {
                tm.textContent =
                    String(Math.floor(r / 60)).padStart(2, '0') + ':' +
                    String(r % 60).padStart(2, '0');
            }

            if (r === 0) {
                clearInterval(tick);
                const widget = document.getElementById('tvFloatWidget');
                if (widget) { widget.style.display = 'none'; }
            }

        }, 1000);
    }
}