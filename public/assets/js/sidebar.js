/*
|--------------------------------------------------------------------------
| Taskvel — sidebar.js (Fixed)
|--------------------------------------------------------------------------
| Fixes:
|  1. Persists collapsed state across page loads (localStorage)
|  2. Restores collapsed state on every page load
|  3. Tooltips on icon-only links when collapsed
|  4. Chevron icon direction synced to state
|  5. Mobile: full reset of collapsed styles on small screens
|--------------------------------------------------------------------------
*/

'use strict';

document.addEventListener('DOMContentLoaded', function () {

    const sidebar      = document.getElementById('sidebar');
    const mainWrapper  = document.querySelector('.main-wrapper');
    const collapseBtn  = document.getElementById('sidebarCollapseBtn');
    const mobileToggle = document.getElementById('sidebarToggle');
    const STORAGE_KEY  = 'taskvel_sidebar_collapsed';

    if (!sidebar || !mainWrapper) { return; }

    /* ── Helpers ─────────────────────────────────────────────── */

    function isDesktop() {
        return window.innerWidth >= 992;
    }

    function updateChevron(collapsed) {
        const icon = collapseBtn?.querySelector('i');
        if (!icon) { return; }
        icon.className = collapsed ? 'bi bi-chevron-right' : 'bi bi-chevron-left';
    }

    /* ── Apply collapsed state ────────────────────────────────── */

    function applyCollapsed(collapsed, save) {

        if (collapsed) {
            sidebar.classList.add('collapsed');
            mainWrapper.classList.add('sidebar-collapsed');
        } else {
            sidebar.classList.remove('collapsed');
            mainWrapper.classList.remove('sidebar-collapsed');
        }

        updateChevron(collapsed);

        if (save) {
            localStorage.setItem(STORAGE_KEY, collapsed ? '1' : '0');
        }

        // Wait for CSS transition, then update tooltips
        setTimeout(function () {
            if (collapsed && isDesktop()) {
                enableTooltips();
            } else {
                disableTooltips();
            }
        }, 260);
    }

    /* ── Restore on page load ─────────────────────────────────── */

    if (isDesktop()) {
        const saved = localStorage.getItem(STORAGE_KEY);
        // Apply without saving again (save = false)
        applyCollapsed(saved === '1', false);
    }

    /* ── Desktop collapse button ──────────────────────────────── */

    collapseBtn?.addEventListener('click', function () {
        const willCollapse = !sidebar.classList.contains('collapsed');
        applyCollapsed(willCollapse, true);
    });

    /* ── Mobile slide toggle ──────────────────────────────────── */

    let overlay = null;

    function openMobile() {
        sidebar.classList.add('show');
        if (!overlay) {
            overlay = document.createElement('div');
            overlay.className = 'sidebar-overlay';
            document.body.appendChild(overlay);
            overlay.addEventListener('click', closeMobile);
        }
        document.body.style.overflow = 'hidden';
    }

    function closeMobile() {
        sidebar.classList.remove('show');
        if (overlay) { overlay.remove(); overlay = null; }
        document.body.style.overflow = '';
    }

    mobileToggle?.addEventListener('click', function () {
        sidebar.classList.contains('show') ? closeMobile() : openMobile();
    });

    /* ── Resize handler ───────────────────────────────────────── */

    window.addEventListener('resize', function () {
        if (isDesktop()) {
            closeMobile();
            const saved = localStorage.getItem(STORAGE_KEY);
            applyCollapsed(saved === '1', false);
        } else {
            // On mobile: always show full sidebar styles
            mainWrapper.classList.remove('sidebar-collapsed');
            disableTooltips();
        }
    });

    /* ── Tooltips (shown only in collapsed desktop mode) ─────── */

    function enableTooltips() {
        document.querySelectorAll('.sidebar .nav-link').forEach(function (link) {
            const text = link.querySelector('.nav-text')?.textContent?.trim();
            if (!text) { return; }

            // Set tooltip attributes
            link.setAttribute('title', text);
            link.setAttribute('data-bs-placement', 'right');

            // Init or update
            let tip = bootstrap.Tooltip.getInstance(link);
            if (!tip) {
                tip = new bootstrap.Tooltip(link, {
                    placement: 'right',
                    trigger:   'hover',
                    container: 'body',
                });
            }
        });
    }

    function disableTooltips() {
        document.querySelectorAll('.sidebar .nav-link').forEach(function (link) {
            const tip = bootstrap.Tooltip.getInstance(link);
            if (tip) { tip.dispose(); }
            link.removeAttribute('title');
        });
    }

});