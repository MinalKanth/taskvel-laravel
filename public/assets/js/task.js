/*
|--------------------------------------------------------------------------
| Taskvel Task Management
|--------------------------------------------------------------------------
*/

'use strict';

document.addEventListener('DOMContentLoaded', function() {

    initializeTaskSearch();
    initializeTaskFilters();
    initializeTaskSorting();
    initializeTaskCompletion();
    initializeDeleteConfirmation();
    initializeDuplicateTask();
    initializeDueDatePicker();
    initializePrioritySelector();
    initializeBulkSelection();
    initializeTaskStatistics();

});


/*
|--------------------------------------------------------------------------
| Live Search
|--------------------------------------------------------------------------
*/

function initializeTaskSearch() {

    const search = document.getElementById('taskSearch');

    if (!search) return;

    search.addEventListener('keyup', function() {

        const keyword = this.value.toLowerCase();

        document.querySelectorAll('.task-card').forEach(function(card) {

            const text = card.innerText.toLowerCase();

            card.style.display = text.includes(keyword) ?
                '' :
                'none';

        });

    });

}


/*
|--------------------------------------------------------------------------
| Task Filters
|--------------------------------------------------------------------------
*/

function initializeTaskFilters() {

    document.querySelectorAll('.task-filter').forEach(function(filter) {

        filter.addEventListener('change', function() {

            console.log('Filter:', this.value);

        });

    });

}


/*
|--------------------------------------------------------------------------
| Drag & Drop
|--------------------------------------------------------------------------
*/

function initializeTaskSorting() {

    const container = document.querySelector('.task-list');

    if (!container) return;

    if (typeof Sortable !== 'undefined') {

        new Sortable(container, {

            animation: 250,

            ghostClass: 'sortable-ghost',

            handle: '.drag-handle',

            onEnd: function() {

                showToast(

                    'Updated',

                    'Task order saved.',

                    'success'

                );

            }

        });

    }

}


/*
|--------------------------------------------------------------------------
| Complete Task
|--------------------------------------------------------------------------
*/

function initializeTaskCompletion() {

    document.querySelectorAll('.complete-task').forEach(function(checkbox) {

        checkbox.addEventListener('change', function() {

            const card = this.closest('.task-card');

            if (!card) return;

            if (this.checked) {

                card.classList.add('completed');

            } else {

                card.classList.remove('completed');

            }

        });

    });

}


/*
|--------------------------------------------------------------------------
| Delete Task
|--------------------------------------------------------------------------
*/

function initializeDeleteConfirmation() {

    document.querySelectorAll('.delete-task').forEach(function(button) {

        button.addEventListener('click', function(e) {

            e.preventDefault();

            const form = this.closest('form');

            if (form) {

                confirmDelete(form);

            }

        });

    });

}


/*
|--------------------------------------------------------------------------
| Duplicate Task
|--------------------------------------------------------------------------
*/

function initializeDuplicateTask() {

    document.querySelectorAll('.duplicate-task').forEach(function(button) {

        button.addEventListener('click', function() {

            showToast(

                'Duplicated',

                'Task duplicated successfully.',

                'success'

            );

        });

    });

}


/*
|--------------------------------------------------------------------------
| Due Date Picker
|--------------------------------------------------------------------------
*/

function initializeDueDatePicker() {

    if (typeof flatpickr === 'undefined') return;

    flatpickr('.task-date', {

        enableTime: false,

        dateFormat: 'Y-m-d'

    });

}


/*
|--------------------------------------------------------------------------
| Priority Selector
|--------------------------------------------------------------------------
*/

function initializePrioritySelector() {

    document.querySelectorAll('.priority-select').forEach(function(select) {

        select.addEventListener('change', function() {

            const value = this.value;

            this.classList.remove(

                'border-danger',

                'border-warning',

                'border-success'

            );

            if (value === 'High') {

                this.classList.add('border-danger');

            }

            if (value === 'Medium') {

                this.classList.add('border-warning');

            }

            if (value === 'Low') {

                this.classList.add('border-success');

            }

        });

    });

}


/*
|--------------------------------------------------------------------------
| Bulk Selection
|--------------------------------------------------------------------------
*/

function initializeBulkSelection() {

    const master = document.getElementById('selectAllTasks');

    if (!master) return;

    master.addEventListener('change', function() {

        document.querySelectorAll('.task-checkbox').forEach(function(box) {

            box.checked = master.checked;

        });

    });

}


/*
|--------------------------------------------------------------------------
| Statistics
|--------------------------------------------------------------------------
*/

function initializeTaskStatistics() {

    const total = document.querySelectorAll('.task-card').length;

    const completed = document.querySelectorAll('.task-card.completed').length;

    const totalLabel = document.getElementById('totalTasks');

    const completedLabel = document.getElementById('completedTasks');

    if (totalLabel) {

        totalLabel.textContent = total;

    }

    if (completedLabel) {

        completedLabel.textContent = completed;

    }

}

/*
|--------------------------------------------------------------------------
| Taskvel Task Management
| Part 2
|--------------------------------------------------------------------------
*/

'use strict';

document.addEventListener('DOMContentLoaded', function() {

    initializeKanbanBoard();
    initializeQuickEdit();
    initializeTaskModal();
    initializeArchiveRestore();
    initializeTaskTags();
    initializeReminderToggle();
    initializePrintTasks();
    initializeExportTasks();
    initializeInfiniteScroll();
    initializeTaskKeyboardShortcuts();

});


/*
|--------------------------------------------------------------------------
| Kanban Drag & Drop
|--------------------------------------------------------------------------
*/

function initializeKanbanBoard() {

    if (typeof Sortable === 'undefined') return;

    document.querySelectorAll('.kanban-column').forEach(function(column) {

        new Sortable(column, {

            group: 'tasks',

            animation: 250,

            ghostClass: 'sortable-ghost',

            dragClass: 'sortable-drag',

            onEnd: function(event) {

                const taskId = event.item.dataset.id;

                const status = event.to.dataset.status;

                console.log(taskId, status);

                showToast(
                    'Task Updated',
                    'Task moved successfully.',
                    'success'
                );

            }

        });

    });

}


/*
|--------------------------------------------------------------------------
| Quick Edit
|--------------------------------------------------------------------------
*/

function initializeQuickEdit() {

    document.querySelectorAll('.quick-edit').forEach(function(button) {

        button.addEventListener('click', function() {

            const card = button.closest('.task-card');

            if (!card) return;

            card.classList.toggle('editing');

        });

    });

}


/*
|--------------------------------------------------------------------------
| Task Modal
|--------------------------------------------------------------------------
*/

function initializeTaskModal() {

    document.querySelectorAll('[data-task-modal]').forEach(function(button) {

        button.addEventListener('click', function() {

            const modal = document.getElementById('taskModal');

            if (!modal) return;

            bootstrap.Modal
                .getOrCreateInstance(modal)
                .show();

        });

    });

}


/*
|--------------------------------------------------------------------------
| Archive / Restore
|--------------------------------------------------------------------------
*/

function initializeArchiveRestore() {

    document.querySelectorAll('.archive-task').forEach(function(button) {

        button.addEventListener('click', function() {

            const card = button.closest('.task-card');

            if (!card) return;

            card.style.opacity = '.5';

            showToast(

                'Archived',

                'Task archived successfully.',

                'success'

            );

        });

    });

    document.querySelectorAll('.restore-task').forEach(function(button) {

        button.addEventListener('click', function() {

            const card = button.closest('.task-card');

            if (!card) return;

            card.style.opacity = '1';

            showToast(

                'Restored',

                'Task restored successfully.',

                'success'

            );

        });

    });

}


/*
|--------------------------------------------------------------------------
| Tags
|--------------------------------------------------------------------------
*/

function initializeTaskTags() {

    if (typeof TomSelect === 'undefined') return;

    document.querySelectorAll('.task-tags').forEach(function(element) {

        new TomSelect(element, {

            create: true,

            persist: false

        });

    });

}


/*
|--------------------------------------------------------------------------
| Reminder Toggle
|--------------------------------------------------------------------------
*/

function initializeReminderToggle() {

    document.querySelectorAll('.task-reminder').forEach(function(checkbox) {

        checkbox.addEventListener('change', function() {

            showToast(

                'Reminder Updated',

                this.checked ?
                'Reminder enabled.' :
                'Reminder disabled.',

                'info'

            );

        });

    });

}


/*
|--------------------------------------------------------------------------
| Print Tasks
|--------------------------------------------------------------------------
*/

function initializePrintTasks() {

    const button = document.getElementById('printTasks');

    if (!button) return;

    button.addEventListener('click', function() {

        window.print();

    });

}


/*
|--------------------------------------------------------------------------
| Export Selected Tasks
|--------------------------------------------------------------------------
*/

function initializeExportTasks() {

    const button = document.getElementById('exportTasks');

    if (!button) return;

    button.addEventListener('click', function() {

        const selected = document.querySelectorAll(

            '.task-checkbox:checked'

        ).length;

        showToast(

            'Export',

            selected + ' task(s) selected.',

            'success'

        );

    });

}


/*
|--------------------------------------------------------------------------
| Infinite Scroll
|--------------------------------------------------------------------------
*/

function initializeInfiniteScroll() {

    window.addEventListener('scroll', function() {

        if (

            window.innerHeight + window.scrollY >=
            document.body.offsetHeight - 100

        ) {

            console.log('Load more tasks...');

        }

    });

}


/*
|--------------------------------------------------------------------------
| Keyboard Shortcuts
|--------------------------------------------------------------------------
*/

function initializeTaskKeyboardShortcuts() {

    document.addEventListener('keydown', function(event) {

        if (event.ctrlKey && event.key === 'n') {

            event.preventDefault();

            const modal = document.getElementById('taskModal');

            if (modal) {

                bootstrap.Modal
                    .getOrCreateInstance(modal)
                    .show();

            }

        }

        if (event.key === 'Delete') {

            const checked = document.querySelectorAll(

                '.task-checkbox:checked'

            );

            if (checked.length > 0) {

                showToast(

                    'Bulk Delete',

                    checked.length + ' task(s) selected.',

                    'warning'

                );

            }

        }

    });

}


/*
|--------------------------------------------------------------------------
| End Task.js Part 2
|--------------------------------------------------------------------------
*/