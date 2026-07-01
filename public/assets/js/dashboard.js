/*
|--------------------------------------------------------------------------
| Taskvel Dashboard
|--------------------------------------------------------------------------
*/

'use strict';

document.addEventListener('DOMContentLoaded', function() {

    initializeDashboard();

});

function initializeDashboard() {

    initializeWelcomeMessage();

    initializeDashboardCounters();

    initializeTaskStatusChart();

    initializeWeeklyProductivityChart();

    initializeCompletionGauge();

    initializeRecentActivity();

    initializeDashboardRefresh();

}

/*
|--------------------------------------------------------------------------
| Welcome Message
|--------------------------------------------------------------------------
*/

function initializeWelcomeMessage() {

    const welcome = document.getElementById('welcomeMessage');

    if (!welcome) return;

    const hour = new Date().getHours();

    let message = 'Good Evening';

    if (hour < 12) {

        message = 'Good Morning';

    } else if (hour < 17) {

        message = 'Good Afternoon';

    }

    welcome.textContent = message;

}

/*
|--------------------------------------------------------------------------
| Animated Counters
|--------------------------------------------------------------------------
*/

function initializeDashboardCounters() {

    document.querySelectorAll('.dashboard-counter').forEach(function(counter) {

        const target = parseInt(counter.dataset.value);

        if (isNaN(target)) return;

        const animation = new countUp.CountUp(counter, target);

        if (!animation.error) {

            animation.start();

        }

    });

}

/*
|--------------------------------------------------------------------------
| Task Status Chart
|--------------------------------------------------------------------------
*/

function initializeTaskStatusChart() {

    const element = document.querySelector('#taskStatusChart');

    if (!element) return;

    const options = {

        chart: {

            type: 'donut',

            height: 340

        },

        labels: [

            'Completed',

            'In Progress',

            'Pending',

            'Overdue'

        ],

        series: [

            parseInt(element.dataset.completed || 0),

            parseInt(element.dataset.progress || 0),

            parseInt(element.dataset.pending || 0),

            parseInt(element.dataset.overdue || 0)

        ],

        legend: {

            position: 'bottom'

        },

        dataLabels: {

            enabled: true

        },

        responsive: [

            {

                breakpoint: 768,

                options: {

                    chart: {

                        height: 280

                    }

                }

            }

        ]

    };

    new ApexCharts(element, options).render();

}

/*
|--------------------------------------------------------------------------
| Weekly Productivity
|--------------------------------------------------------------------------
*/

function initializeWeeklyProductivityChart() {

    const canvas = document.getElementById('weeklyChart');

    if (!canvas) return;

    new Chart(canvas, {

        type: 'line',

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

                    label: 'Tasks Completed',

                    data: [

                        5,

                        8,

                        6,

                        10,

                        7,

                        9,

                        4

                    ],

                    tension: .4,

                    fill: true

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
| Completion Gauge
|--------------------------------------------------------------------------
*/

function initializeCompletionGauge() {

    const gauge = document.querySelector('#completionGauge');

    if (!gauge) return;

    const percent = parseInt(gauge.dataset.value || 0);

    gauge.style.background =
        `conic-gradient(#4f46e5 ${percent * 3.6}deg,#e5e7eb 0deg)`;

    const label = gauge.querySelector('.gauge-value');

    if (label) {

        label.textContent = percent + '%';

    }

}

/*
|--------------------------------------------------------------------------
| Recent Activity
|--------------------------------------------------------------------------
*/

function initializeRecentActivity() {

    const list = document.querySelector('#recentActivity');

    if (!list) return;

    list.querySelectorAll('.activity-item').forEach(function(item, index) {

        item.style.opacity = 0;

        item.style.transform = 'translateY(20px)';

        setTimeout(function() {

            item.style.transition = '.4s';

            item.style.opacity = 1;

            item.style.transform = 'translateY(0)';

        }, index * 120);

    });

}

/*
|--------------------------------------------------------------------------
| Auto Refresh
|--------------------------------------------------------------------------
*/

function initializeDashboardRefresh() {

    const button = document.getElementById('refreshDashboard');

    if (!button) return;

    button.addEventListener('click', function() {

        button.disabled = true;

        button.innerHTML =
            '<span class="spinner-border spinner-border-sm me-2"></span>Refreshing';

        setTimeout(function() {

            location.reload();

        }, 1000);

    });

}
/*
|--------------------------------------------------------------------------
| Dashboard Part 2
| Live Updates • Filters • Widgets • Charts
|--------------------------------------------------------------------------
*/

'use strict';

document.addEventListener('DOMContentLoaded', function() {

    initializeMonthlyChart();
    initializePriorityChart();
    initializeWidgetSorting();
    initializeDashboardFilters();
    initializeDashboardSettings();
    initializeNotificationWidget();
    initializeCalendarWidget();
    initializeFullscreenDashboard();

});


/*
|--------------------------------------------------------------------------
| Monthly Productivity Chart
|--------------------------------------------------------------------------
*/

function initializeMonthlyChart() {

    const canvas = document.getElementById('monthlyChart');

    if (!canvas) return;

    new Chart(canvas, {

        type: 'bar',

        data: {

            labels: [

                'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'

            ],

            datasets: [{

                label: 'Completed Tasks',

                data: [

                    24, 35, 42, 37, 55, 61,
                    70, 66, 74, 81, 69, 88

                ],

                borderWidth: 1

            }]

        },

        options: {

            responsive: true,

            maintainAspectRatio: false,

            plugins: {

                legend: {
                    display: false
                }

            }

        }

    });

}


/*
|--------------------------------------------------------------------------
| Priority Distribution
|--------------------------------------------------------------------------
*/

function initializePriorityChart() {

    const element = document.querySelector('#priorityChart');

    if (!element) return;

    new ApexCharts(element, {

        chart: {

            type: 'radialBar',

            height: 320

        },

        series: [65, 25, 10],

        labels: [

            'High',

            'Medium',

            'Low'

        ],

        plotOptions: {

            radialBar: {

                dataLabels: {

                    total: {

                        show: true,

                        label: 'Tasks'

                    }

                }

            }

        }

    }).render();

}


/*
|--------------------------------------------------------------------------
| Widget Sorting
|--------------------------------------------------------------------------
*/

function initializeWidgetSorting() {

    const grid = document.querySelector('.dashboard-grid');

    if (!grid) return;

    if (typeof Sortable !== 'undefined') {

        new Sortable(grid, {

            animation: 250,

            ghostClass: 'sortable-ghost',

            handle: '.card-header'

        });

    }

}


/*
|--------------------------------------------------------------------------
| Dashboard Filters
|--------------------------------------------------------------------------
*/

function initializeDashboardFilters() {

    document.querySelectorAll('.dashboard-filter').forEach(function(select) {

        select.addEventListener('change', function() {

            console.log('Filter:', this.value);

        });

    });

}


/*
|--------------------------------------------------------------------------
| Dashboard Settings
|--------------------------------------------------------------------------
*/

function initializeDashboardSettings() {

    const cards = document.querySelectorAll('.dashboard-card');

    if (!cards.length) return;

    const saved = JSON.parse(

        localStorage.getItem('dashboard-hidden-cards') || '[]'

    );

    cards.forEach(function(card) {

        if (saved.includes(card.id)) {

            card.style.display = 'none';

        }

    });

}


/*
|--------------------------------------------------------------------------
| Notification Widget
|--------------------------------------------------------------------------
*/

function initializeNotificationWidget() {

    const list = document.getElementById('notificationWidget');

    if (!list) return;

    list.querySelectorAll('.notification-item').forEach(function(item, index) {

        item.style.opacity = 0;

        setTimeout(function() {

            item.style.transition = '.35s';

            item.style.opacity = 1;

        }, index * 120);

    });

}


/*
|--------------------------------------------------------------------------
| Mini Calendar
|--------------------------------------------------------------------------
*/

function initializeCalendarWidget() {

    const calendar = document.getElementById('miniCalendar');

    if (!calendar) return;

    const today = new Date();

    const label = document.getElementById('calendarToday');

    if (label) {

        label.textContent = today.toDateString();

    }

}


/*
|--------------------------------------------------------------------------
| Fullscreen Dashboard
|--------------------------------------------------------------------------
*/

function initializeFullscreenDashboard() {

    const btn = document.getElementById('dashboardFullscreen');

    if (!btn) return;

    btn.addEventListener('click', function() {

        if (!document.fullscreenElement) {

            document.documentElement.requestFullscreen();

        } else {

            document.exitFullscreen();

        }

    });

}


/*
|--------------------------------------------------------------------------
| Live Dashboard Refresh
|--------------------------------------------------------------------------
*/

function refreshDashboardData() {

    console.log('Refreshing dashboard...');

    fetch('/dashboard')

    .then(function() {

        console.log('Dashboard refreshed.');

    })

    .catch(function() {

        console.log('Refresh failed.');

    });

}


/*
|--------------------------------------------------------------------------
| Auto Refresh Every 5 Minutes
|--------------------------------------------------------------------------
*/

setInterval(function() {

    if (document.visibilityState === 'visible') {

        refreshDashboardData();

    }

}, 300000);


/*
|--------------------------------------------------------------------------
| Export Dashboard
|--------------------------------------------------------------------------
*/

function exportDashboard() {

    const btn = document.getElementById('exportDashboard');

    if (!btn) return;

    btn.addEventListener('click', function() {

        showToast(

            'Preparing Export',

            'Generating dashboard report...',

            'info'

        );

    });

}

exportDashboard();


/*
|--------------------------------------------------------------------------
| End Dashboard Part 2
|--------------------------------------------------------------------------
*/