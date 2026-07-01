document.addEventListener('DOMContentLoaded', function() {

    const sidebar = document.getElementById('sidebar');
    const mainWrapper = document.querySelector('.main-wrapper');
    const collapseBtn = document.getElementById('sidebarCollapseBtn');
    const mobileToggleBtn = document.getElementById('sidebarToggle');

    // ===== Desktop collapse/expand =====
    if (collapseBtn) {
        collapseBtn.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
            if (mainWrapper) {
                mainWrapper.classList.toggle('sidebar-collapsed');
            }
        });
    }

    // ===== Mobile show/hide =====
    if (mobileToggleBtn) {
        mobileToggleBtn.addEventListener('click', function() {
            sidebar.classList.toggle('show');
            toggleOverlay();
        });
    }

    // ===== Overlay for mobile (click outside to close) =====
    function toggleOverlay() {
        let overlay = document.getElementById('sidebarOverlay');

        if (sidebar.classList.contains('show')) {
            if (!overlay) {
                overlay = document.createElement('div');
                overlay.id = 'sidebarOverlay';
                overlay.className = 'sidebar-overlay';
                document.body.appendChild(overlay);

                overlay.addEventListener('click', function() {
                    sidebar.classList.remove('show');
                    overlay.remove();
                });
            }
        } else if (overlay) {
            overlay.remove();
        }
    }

    // ===== Auto-close sidebar on window resize to desktop =====
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 992 && sidebar.classList.contains('show')) {
            sidebar.classList.remove('show');
            const overlay = document.getElementById('sidebarOverlay');
            if (overlay) overlay.remove();
        }
    });

});