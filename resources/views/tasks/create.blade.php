@extends('layouts.app')

@section('title', 'Create Task')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Create New Task</h2>
            <p class="text-muted mb-0">Add a task and start tracking your progress.</p>
        </div>
        <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back
        </a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger mb-4">
            <strong>Please fix the following errors:</strong>
            <ul class="mb-0 mt-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('tasks.store') }}" method="POST">
        @csrf

        <div class="row g-4">

            {{-- ── Left Column ──────────────────────────────────────────── --}}
            <div class="col-lg-8">

                {{-- Core Details --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold"><i class="bi bi-card-text me-2 text-primary"></i>Task Details</h5>
                    </div>
                    <div class="card-body">

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Task Title <span class="text-danger">*</span></label>
                            <input type="text" name="title"
                                   class="form-control form-control-lg @error('title') is-invalid @enderror"
                                   value="{{ old('title') }}" placeholder="What needs to be done?">
                            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Description</label>
                            <textarea name="description" rows="5"
                                      class="form-control @error('description') is-invalid @enderror"
                                      placeholder="Add a detailed description…">{{ old('description') }}</textarea>
                            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-0">
                            <label class="form-label fw-semibold">Private Notes</label>
                            <textarea name="notes" rows="3" class="form-control"
                                      placeholder="Personal notes, reminders…">{{ old('notes') }}</textarea>
                        </div>

                    </div>
                </div>

                {{-- Timeline --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold"><i class="bi bi-calendar3 me-2 text-primary"></i>Timeline</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Due Date</label>
                                <input type="text" id="due_date" name="due_date"
                                       class="form-control" value="{{ old('due_date') }}"
                                       placeholder="Pick date & time">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Reminder</label>
                                <input type="text" id="reminder_at" name="reminder_at"
                                       class="form-control" value="{{ old('reminder_at') }}"
                                       placeholder="Remind me at…">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Estimated Time</label>
                                <div class="input-group">
                                    <input type="number" name="estimated_minutes"
                                           class="form-control" value="{{ old('estimated_minutes') }}"
                                           min="1" placeholder="0">
                                    <span class="input-group-text">min</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Steps --}}
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold"><i class="bi bi-check2-square me-2 text-primary"></i>Checklist Steps</h5>
                        <button type="button" class="btn btn-sm btn-primary" id="addStep">
                            <i class="bi bi-plus me-1"></i>Add Step
                        </button>
                    </div>
                    <div class="card-body">
                        <div id="stepsContainer">
                            <div class="input-group mb-2 step-item">
                                <span class="input-group-text bg-white border-end-0 text-muted drag-handle" style="cursor:grab;">
                                    <i class="bi bi-grip-vertical"></i>
                                </span>
                                <input type="text" name="steps[]" class="form-control border-start-0 border-end-0 ps-0"
                                       placeholder="Step 1…">
                                <button type="button" class="btn btn-outline-danger border remove-step">
                                    <i class="bi bi-x"></i>
                                </button>
                            </div>
                        </div>
                        <p class="text-muted mb-0 mt-2" style="font-size:.85rem;">
                            <i class="bi bi-info-circle me-1"></i>Break your task into smaller, actionable steps.
                        </p>
                    </div>
                </div>

            </div>

            {{-- ── Right Column ─────────────────────────────────────────── --}}
            <div class="col-lg-4">

                {{-- Settings --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold"><i class="bi bi-sliders me-2 text-primary"></i>Settings</h5>
                    </div>
                    <div class="card-body">

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Priority</label>
                            <select name="priority" class="form-select" id="prioritySelect">
                                @foreach(['low'=>'🟢 Low','medium'=>'🟡 Medium','high'=>'🟠 High','urgent'=>'🔴 Urgent'] as $val=>$label)
                                    <option value="{{ $val }}" @selected(old('priority','medium')===$val)>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Status</label>
                            <select name="status" class="form-select">
                                @foreach(['pending'=>'Pending','in_progress'=>'In Progress','completed'=>'Completed'] as $val=>$label)
                                    <option value="{{ $val }}" @selected(old('status','pending')===$val)>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Recurrence</label>
                            <select name="recurrence" class="form-select">
                                @foreach(['none'=>'No recurrence','daily'=>'Daily','weekly'=>'Weekly','monthly'=>'Monthly'] as $val=>$label)
                                    <option value="{{ $val }}" @selected(old('recurrence','none')===$val)>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Category</label>
                            <input type="text" name="category" class="form-control"
                                   value="{{ old('category') }}" placeholder="e.g. Work, Personal…"
                                   list="category-list">
                            <datalist id="category-list">
                                <option value="Work"><option value="Personal"><option value="Health">
                                <option value="Learning"><option value="Finance"><option value="Home">
                            </datalist>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Task Color</label>
                            <div class="d-flex gap-2 flex-wrap">
                                @foreach(['#4f46e5','#10b981','#f59e0b','#ef4444','#0ea5e9','#7c3aed','#ec4899'] as $c)
                                    <label class="cursor-pointer" title="{{ $c }}">
                                        <input type="radio" name="color" value="{{ $c }}" class="visually-hidden color-radio"
                                               @checked(old('color','#4f46e5')===$c)>
                                        <span class="color-swatch d-block" style="width:28px;height:28px;border-radius:50%;background:{{ $c }};border:3px solid transparent;transition:.2s;"></span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="mb-0">
                            <label class="form-label fw-semibold">Tags</label>
                            <select name="tags[]" id="tags" class="form-select" multiple>
                                @foreach($tags as $tag)
                                    <option value="{{ $tag->id }}" @selected(in_array($tag->id, old('tags',[]) ))>
                                        {{ $tag->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                </div>

                {{-- Eisenhower Matrix --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold"><i class="bi bi-grid-3x3 me-2 text-primary"></i>Impact Matrix</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-semibold d-flex justify-content-between">
                                <span>Urgency</span>
                                <span id="urgencyVal" class="text-primary">{{ old('urgency',3) }}/5</span>
                            </label>
                            <input type="range" class="form-range" name="urgency"
                                   min="1" max="5" value="{{ old('urgency',3) }}" id="urgencyRange">
                        </div>
                        <div class="mb-0">
                            <label class="form-label fw-semibold d-flex justify-content-between">
                                <span>Impact</span>
                                <span id="impactVal" class="text-primary">{{ old('impact',3) }}/5</span>
                            </label>
                            <input type="range" class="form-range" name="impact"
                                   min="1" max="5" value="{{ old('impact',3) }}" id="impactRange">
                        </div>
                        <div id="matrixQuadrant" class="mt-3 p-2 rounded text-center" style="font-size:.82rem;"></div>
                    </div>
                </div>

                {{-- Save --}}
                <div class="card border-0 shadow-sm">
                    <div class="card-body d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg fw-semibold">
                            <i class="bi bi-check-circle me-2"></i>Save Task
                        </button>
                        <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </div>

            </div>
        </div>
    </form>

</div>
@endsection

@push('scripts')
<script>
// ── Flatpickr ────────────────────────────────────────────────────────────────
flatpickr('#due_date',    { enableTime:true, dateFormat:'Y-m-d H:i' });
flatpickr('#reminder_at', { enableTime:true, dateFormat:'Y-m-d H:i' });

// ── TomSelect ────────────────────────────────────────────────────────────────
new TomSelect('#tags', { create: false, plugins: ['remove_button'] });

// ── Color swatches ───────────────────────────────────────────────────────────
document.querySelectorAll('.color-radio').forEach(function(radio) {
    const swatch = radio.nextElementSibling;

    function update() {
        document.querySelectorAll('.color-swatch').forEach(s => s.style.border='3px solid transparent');
        if (radio.checked) swatch.style.border = '3px solid #111';
    }

    update();
    radio.addEventListener('change', () => {
        document.querySelectorAll('.color-swatch').forEach(s => s.style.border='3px solid transparent');
        swatch.style.border = '3px solid #111';
    });
});

// ── Eisenhower matrix label ──────────────────────────────────────────────────
const urgencyRange = document.getElementById('urgencyRange');
const impactRange  = document.getElementById('impactRange');
const urgencyVal   = document.getElementById('urgencyVal');
const impactVal    = document.getElementById('impactVal');
const quadrant     = document.getElementById('matrixQuadrant');

const quadrantInfo = [
    { label:'Schedule',  desc:'Low urgency, low impact',   bg:'#f1f5f9', color:'#64748b' },
    { label:'Delegate',  desc:'Low urgency, high impact',  bg:'#eff6ff', color:'#1d4ed8' },
    { label:'Consider',  desc:'High urgency, low impact',  bg:'#fefce8', color:'#a16207' },
    { label:'Do First',  desc:'High urgency, high impact', bg:'#fef2f2', color:'#b91c1c' },
];

function updateQuadrant() {
    const u = parseInt(urgencyRange.value);
    const i = parseInt(impactRange.value);
    urgencyVal.textContent = u + '/5';
    impactVal.textContent  = i + '/5';
    const idx = (u >= 3 ? 2 : 0) + (i >= 3 ? 1 : 0);
    const q   = quadrantInfo[idx];
    quadrant.style.background = q.bg;
    quadrant.style.color      = q.color;
    quadrant.innerHTML = `<strong>${q.label}</strong> — ${q.desc}`;
}

urgencyRange.addEventListener('input', updateQuadrant);
impactRange.addEventListener('input',  updateQuadrant);
updateQuadrant();

// ── Steps ────────────────────────────────────────────────────────────────────
let stepCount = 1;

document.getElementById('addStep').addEventListener('click', function() {
    stepCount++;
    document.getElementById('stepsContainer').insertAdjacentHTML('beforeend', `
        <div class="input-group mb-2 step-item">
            <span class="input-group-text bg-white border-end-0 text-muted drag-handle" style="cursor:grab;">
                <i class="bi bi-grip-vertical"></i>
            </span>
            <input type="text" name="steps[]" class="form-control border-start-0 border-end-0 ps-0"
                   placeholder="Step ${stepCount}…">
            <button type="button" class="btn btn-outline-danger border remove-step">
                <i class="bi bi-x"></i>
            </button>
        </div>
    `);
});

document.addEventListener('click', function(e) {
    if (e.target.closest('.remove-step')) {
        const item = e.target.closest('.step-item');
        if (document.querySelectorAll('.step-item').length > 1) {
            item.remove();
        }
    }
});
</script>
@endpush