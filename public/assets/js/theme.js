/*
|--------------------------------------------------------------------------
| Taskvel Theme Manager
|--------------------------------------------------------------------------
*/

'use strict';

document.addEventListener('DOMContentLoaded', function() {

    initializeTheme();

    initializeAccentColors();

    initializeFontSize();

    initializeCompactMode();

    initializeAnimations();

    initializeResetTheme();

});


/*
|--------------------------------------------------------------------------
| Theme
|--------------------------------------------------------------------------
*/

function initializeTheme() {

    const html = document.documentElement;

    const toggle = document.getElementById('themeToggle');

    let theme = localStorage.getItem('theme') || 'light';

    html.setAttribute('data-bs-theme', theme);

    updateThemeIcon(theme);

    if (!toggle) return;

    toggle.addEventListener('click', function() {

        theme = theme === 'light' ?
            'dark' :
            'light';

        html.setAttribute('data-bs-theme', theme);

        localStorage.setItem('theme', theme);

        updateThemeIcon(theme);

        showToast(

            'Theme Updated',

            theme.charAt(0).toUpperCase() +
            theme.slice(1) +
            ' mode enabled.',

            'success'

        );

    });

}

function updateThemeIcon(theme) {

    const icon = document.getElementById('themeIcon');

    if (!icon) return;

    if (theme === 'dark') {

        icon.className = 'bi bi-sun-fill';

    } else {

        icon.className = 'bi bi-moon-stars-fill';

    }

}


/*
|--------------------------------------------------------------------------
| Accent Colors
|--------------------------------------------------------------------------
*/

function initializeAccentColors() {

    document.querySelectorAll('.theme-color').forEach(function(color) {

        color.addEventListener('click', function() {

            document.querySelectorAll('.theme-color').forEach(function(item) {

                item.classList.remove('active');

            });

            this.classList.add('active');

            const selected = this.dataset.color;

            document.documentElement.style.setProperty(

                '--primary',

                selected

            );

            localStorage.setItem(

                'accent',

                selected

            );

        });

    });

    const saved = localStorage.getItem('accent');

    if (saved) {

        document.documentElement.style.setProperty(

            '--primary',

            saved

        );

    }

}


/*
|--------------------------------------------------------------------------
| Font Size
|--------------------------------------------------------------------------
*/

function initializeFontSize() {

    const select = document.getElementById('fontSize');

    if (!select) return;

    const saved = localStorage.getItem('font-size');

    if (saved) {

        document.documentElement.style.fontSize = saved;

        select.value = saved;

    }

    select.addEventListener('change', function() {

        document.documentElement.style.fontSize = this.value;

        localStorage.setItem(

            'font-size',

            this.value

        );

    });

}


/*
|--------------------------------------------------------------------------
| Compact Mode
|--------------------------------------------------------------------------
*/

function initializeCompactMode() {

    const toggle = document.getElementById('compactMode');

    if (!toggle) return;

    if (localStorage.getItem('compact') === '1') {

        document.body.classList.add('compact-mode');

        toggle.checked = true;

    }

    toggle.addEventListener('change', function() {

        document.body.classList.toggle(

            'compact-mode',

            this.checked

        );

        localStorage.setItem(

            'compact',

            this.checked ? '1' : '0'

        );

    });

}


/*
|--------------------------------------------------------------------------
| Animations
|--------------------------------------------------------------------------
*/

function initializeAnimations() {

    const toggle = document.getElementById('animationToggle');

    if (!toggle) return;

    if (localStorage.getItem('animations') === '0') {

        document.body.classList.add('no-animation');

        toggle.checked = false;

    } else {

        toggle.checked = true;

    }

    toggle.addEventListener('change', function() {

        document.body.classList.toggle(

            'no-animation',

            !this.checked

        );

        localStorage.setItem(

            'animations',

            this.checked ? '1' : '0'

        );

    });

}


/*
|--------------------------------------------------------------------------
| Sidebar Preference
|--------------------------------------------------------------------------
*/

(function() {

    const state = localStorage.getItem('sidebar-collapsed');

    if (state === '1') {

        document.body.classList.add('sidebar-collapsed');

    }

})();

function toggleSidebarState() {

    document.body.classList.toggle('sidebar-collapsed');

    localStorage.setItem(

        'sidebar-collapsed',

        document.body.classList.contains('sidebar-collapsed')

        ?
        '1'

        :
        '0'

    );

}


/*
|--------------------------------------------------------------------------
| Reset Theme
|--------------------------------------------------------------------------
*/

function initializeResetTheme() {

    const button = document.getElementById('resetTheme');

    if (!button) return;

    button.addEventListener('click', function() {

        Swal.fire({

            title: 'Reset Settings?',

            text: 'All appearance preferences will be removed.',

            icon: 'question',

            showCancelButton: true,

            confirmButtonText: 'Reset'

        }).then(function(result) {

            if (!result.isConfirmed) return;

            localStorage.removeItem('theme');

            localStorage.removeItem('accent');

            localStorage.removeItem('compact');

            localStorage.removeItem('font-size');

            localStorage.removeItem('animations');

            localStorage.removeItem('sidebar-collapsed');

            location.reload();

        });

    });

}


/*
|--------------------------------------------------------------------------
| Reduced Motion
|--------------------------------------------------------------------------
*/

if (

    window.matchMedia(

        '(prefers-reduced-motion: reduce)'

    ).matches

) {

    document.body.classList.add('no-animation');

}


/*
|--------------------------------------------------------------------------
| Auto Apply Saved Accent
|--------------------------------------------------------------------------
*/

window.addEventListener('load', function() {

    const accent = localStorage.getItem('accent');

    if (accent) {

        document.documentElement.style.setProperty(

            '--primary',

            accent

        );

    }

});


/*
|--------------------------------------------------------------------------
| Theme Ready
|--------------------------------------------------------------------------
*/

console.log('Taskvel Theme Initialized');