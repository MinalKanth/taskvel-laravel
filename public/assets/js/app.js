/*
|--------------------------------------------------------------------------
| Taskvel App
|--------------------------------------------------------------------------
*/

'use strict';

document.addEventListener('DOMContentLoaded', function() {

    initializeLoader();
    initializeTooltips();
    initializePopovers();
    initializeDropdowns();
    initializeAlerts();
    initializeScrollTop();
    initializeSidebar();
    initializeSearch();
    initializeCounterAnimation();

});


/*
|--------------------------------------------------------------------------
| Page Loader
|--------------------------------------------------------------------------
*/

function initializeLoader() {

    const loader = document.getElementById('pageLoader');

    if (!loader) return;

    window.addEventListener('load', function() {

        loader.style.opacity = '0';

        setTimeout(() => {

            loader.style.display = 'none';

        }, 300);

    });

}


/*
|--------------------------------------------------------------------------
| Bootstrap Tooltips
|--------------------------------------------------------------------------
*/

function initializeTooltips() {

    const tooltipTriggerList = [].slice.call(
        document.querySelectorAll('[data-bs-toggle="tooltip"]')
    );

    tooltipTriggerList.forEach(function(tooltipTriggerEl) {

        new bootstrap.Tooltip(tooltipTriggerEl);

    });

}


/*
|--------------------------------------------------------------------------
| Bootstrap Popovers
|--------------------------------------------------------------------------
*/

function initializePopovers() {

    const popoverTriggerList = [].slice.call(
        document.querySelectorAll('[data-bs-toggle="popover"]')
    );

    popoverTriggerList.forEach(function(popoverTriggerEl) {

        new bootstrap.Popover(popoverTriggerEl);

    });

}


/*
|--------------------------------------------------------------------------
| Dropdown Auto Close
|--------------------------------------------------------------------------
*/

function initializeDropdowns() {

    document.querySelectorAll('.dropdown-menu').forEach(function(menu) {

        menu.addEventListener('click', function(e) {

            e.stopPropagation();

        });

    });

}


/*
|--------------------------------------------------------------------------
| Auto Hide Alerts
|--------------------------------------------------------------------------
*/

function initializeAlerts() {

    const alerts = document.querySelectorAll('.alert');

    alerts.forEach(function(alert) {

        setTimeout(function() {

            const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);

            bsAlert.close();

        }, 5000);

    });

}


/*
|--------------------------------------------------------------------------
| Scroll To Top
|--------------------------------------------------------------------------
*/

function initializeScrollTop() {

    const button = document.getElementById('scrollTop');

    if (!button) return;

    window.addEventListener('scroll', function() {

        if (window.scrollY > 300) {

            button.classList.add('show');

        } else {

            button.classList.remove('show');

        }

    });

    button.addEventListener('click', function() {

        window.scrollTo({

            top: 0,

            behavior: 'smooth'

        });

    });

}


/*
|--------------------------------------------------------------------------
| Sidebar Toggle
|--------------------------------------------------------------------------
*/

function initializeSidebar() {

    const toggle = document.getElementById('sidebarToggle');

    const sidebar = document.querySelector('.sidebar');

    if (!toggle || !sidebar) return;

    toggle.addEventListener('click', function() {

        sidebar.classList.toggle('show');

    });

}


/*
|--------------------------------------------------------------------------
| Navbar Search
|--------------------------------------------------------------------------
*/

function initializeSearch() {

    const search = document.getElementById('globalSearch');

    if (!search) return;

    search.addEventListener('keyup', function() {

        console.log('Searching:', this.value);

    });

}


/*
|--------------------------------------------------------------------------
| CountUp Animation
|--------------------------------------------------------------------------
*/

function initializeCounterAnimation() {

    document.querySelectorAll('[data-count]').forEach(function(el) {

        const endValue = parseInt(el.dataset.count);

        if (isNaN(endValue)) return;

        const counter = new countUp.CountUp(el, endValue);

        if (!counter.error) {

            counter.start();

        }

    });

}


/*
|--------------------------------------------------------------------------
| Toast Helper
|--------------------------------------------------------------------------
*/

function showToast(title, message, icon = 'success') {

    Swal.fire({

        toast: true,

        position: 'top-end',

        timer: 3000,

        showConfirmButton: false,

        icon: icon,

        title: title,

        text: message

    });

}


/*
|--------------------------------------------------------------------------
| Confirm Delete
|--------------------------------------------------------------------------
*/

function confirmDelete(form) {

    Swal.fire({

        title: 'Delete this item?',

        text: 'This action cannot be undone.',

        icon: 'warning',

        showCancelButton: true,

        confirmButtonColor: '#dc3545',

        confirmButtonText: 'Delete',

        cancelButtonText: 'Cancel'

    }).then((result) => {

        if (result.isConfirmed) {

            form.submit();

        }

    });

}


/*
|--------------------------------------------------------------------------
| AJAX CSRF
|--------------------------------------------------------------------------
*/

if (window.axios) {

    window.axios.defaults.headers.common['X-CSRF-TOKEN'] =
        document.querySelector('meta[name="csrf-token"]').content;

}

/*
|--------------------------------------------------------------------------
| APP.JS PART 2
| Theme • Utilities • Fullscreen • Clipboard • Ripple
|--------------------------------------------------------------------------
*/

'use strict';


/*
|--------------------------------------------------------------------------
| Initialize Extra Features
|--------------------------------------------------------------------------
*/

document.addEventListener('DOMContentLoaded', function() {

    initializeTheme();

    initializeRippleEffect();

    initializeCardTools();

    initializeFullscreen();

    initializeClipboard();

    initializeKeyboardShortcuts();

    initializeConnectionStatus();

    initializePageTransitions();

});


/*
|--------------------------------------------------------------------------
| Theme Switcher
|--------------------------------------------------------------------------
*/

function initializeTheme() {

    const toggle = document.getElementById('themeToggle');

    const html = document.documentElement;

    const savedTheme = localStorage.getItem('taskvel-theme');

    if (savedTheme) {

        html.setAttribute('data-bs-theme', savedTheme);

    }

    if (!toggle) return;

    toggle.addEventListener('click', function() {

        const current = html.getAttribute('data-bs-theme') || 'light';

        const next = current === 'light' ?
            'dark' :
            'light';

        html.setAttribute('data-bs-theme', next);

        localStorage.setItem('taskvel-theme', next);

        showToast(
            'Theme Updated',
            next.charAt(0).toUpperCase() + next.slice(1) + ' mode enabled.',
            'success'
        );

    });

}


/*
|--------------------------------------------------------------------------
| Ripple Effect
|--------------------------------------------------------------------------
*/

function initializeRippleEffect() {

    document.querySelectorAll('.btn').forEach(function(button) {

        button.addEventListener('click', function(e) {

            const circle = document.createElement('span');

            const diameter = Math.max(button.clientWidth, button.clientHeight);

            circle.style.width = diameter + 'px';

            circle.style.height = diameter + 'px';

            circle.style.left = e.offsetX - diameter / 2 + 'px';

            circle.style.top = e.offsetY - diameter / 2 + 'px';

            circle.classList.add('ripple-effect');

            button.appendChild(circle);

            setTimeout(function() {

                circle.remove();

            }, 600);

        });

    });

}


/*
|--------------------------------------------------------------------------
| Card Tools
|--------------------------------------------------------------------------
*/

function initializeCardTools() {

    document.querySelectorAll('[data-card-collapse]').forEach(function(button) {

        button.addEventListener('click', function() {

            const card = button.closest('.card');

            if (!card) return;

            const body = card.querySelector('.card-body');

            if (!body) return;

            const icon = button.querySelector('i');

            body.classList.toggle('d-none');

            if (icon) {
                icon.classList.toggle('bi-chevron-up');
                icon.classList.toggle('bi-chevron-down');
            }

        });

    });

}


/*
|--------------------------------------------------------------------------
| Fullscreen
|--------------------------------------------------------------------------
*/

function initializeFullscreen() {

    const button = document.getElementById('fullscreenToggle');

    if (!button) return;

    button.addEventListener('click', function() {

        if (!document.fullscreenElement) {

            document.documentElement.requestFullscreen();

        } else {

            document.exitFullscreen();

        }

    });

}


/*
|--------------------------------------------------------------------------
| Clipboard
|--------------------------------------------------------------------------
*/

function initializeClipboard() {

    document.querySelectorAll('[data-copy]').forEach(function(button) {

        button.addEventListener('click', function() {

            navigator.clipboard.writeText(button.dataset.copy);

            showToast(

                'Copied',

                'Copied to clipboard.',

                'success'

            );

        });

    });

}


/*
|--------------------------------------------------------------------------
| Keyboard Shortcuts
|--------------------------------------------------------------------------
*/

function initializeKeyboardShortcuts() {

    document.addEventListener('keydown', function(e) {

        if (e.ctrlKey && e.key === '/') {

            e.preventDefault();

            const search = document.getElementById('globalSearch');

            if (search) {

                search.focus();

            }

        }

        if (e.ctrlKey && e.key === 'k') {

            e.preventDefault();

            const modal = document.getElementById('quickSearchModal');

            if (modal) {

                bootstrap.Modal.getOrCreateInstance(modal).show();

            }

        }

    });

}


/*
|--------------------------------------------------------------------------
| Online / Offline Status
|--------------------------------------------------------------------------
*/

function initializeConnectionStatus() {

    window.addEventListener('online', function() {

        showToast(

            'Connected',

            'Internet connection restored.',

            'success'

        );

    });

    window.addEventListener('offline', function() {

        showToast(

            'Offline',

            'You are currently offline.',

            'warning'

        );

    });

}


/*
|--------------------------------------------------------------------------
| Page Transition
|--------------------------------------------------------------------------
*/

function initializePageTransitions() {

    document.querySelectorAll('a').forEach(function(link) {

        if (

            link.hostname === window.location.hostname &&

            !link.hasAttribute('target') &&

            !link.href.includes('#')

        ) {

            link.addEventListener('click', function() {

                document.body.classList.add('fade-out');

            });

        }

    });

}


/*
|--------------------------------------------------------------------------
| Loading Overlay
|--------------------------------------------------------------------------
*/

function showLoader() {

    const loader = document.getElementById('pageLoader');

    if (loader) {

        loader.style.display = 'flex';

    }

}

function hideLoader() {

    const loader = document.getElementById('pageLoader');

    if (loader) {

        loader.style.display = 'none';

    }

}


/*
|--------------------------------------------------------------------------
| Utility Functions
|--------------------------------------------------------------------------
*/

function formatNumber(number) {

    return new Intl.NumberFormat().format(number);

}

function formatDate(date) {

    return new Date(date).toLocaleDateString();

}

function formatTime(date) {

    return new Date(date).toLocaleTimeString();

}


/*
|--------------------------------------------------------------------------
| AJAX Helper
|--------------------------------------------------------------------------
*/

async function request(url, options = {}) {

    showLoader();

    try {

        const response = await fetch(url, {

            headers: {

                'X-CSRF-TOKEN': document
                    .querySelector('meta[name="csrf-token"]')
                    .content,

                'Accept': 'application/json',

                ...options.headers

            },

            ...options

        });

        hideLoader();

        return response;

    } catch (error) {

        hideLoader();

        console.error(error);

        showToast(

            'Error',

            'Unexpected error occurred.',

            'error'

        );

        throw error;

    }

}


/*
|--------------------------------------------------------------------------
| Idle Timer
|--------------------------------------------------------------------------
*/

let idleTimer;

['mousemove', 'keypress', 'click', 'scroll'].forEach(function(event) {

    document.addEventListener(event, resetIdleTimer);

});

function resetIdleTimer() {

    clearTimeout(idleTimer);

    idleTimer = setTimeout(function() {

        console.log('User idle');

    }, 600000);

}


/*
|--------------------------------------------------------------------------
| End Part 2
|--------------------------------------------------------------------------
*/