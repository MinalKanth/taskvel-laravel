@extends('layouts.app')

@section('title', $task->title)

@section('content')

@php
    $priorityColor = ['low'=>'secondary','medium'=>'info','high'=>'warning','urgent'=>'danger'];
    $statusColor   = ['pending'=>'warning','in_progress'=>'primary','completed'=>'success','cancelled'=>'danger'];
    $completedSteps = $task->steps->where('is_completed', true)->count();
    $totalSteps     = $task->steps->count();
    $stepPercent    = $totalSteps > 0 ? round(($completedSteps/$totalSteps)*100) : 0;
    $totalFocusMins = $task->focusSessions->sum('actual_minutes');
@endphp

<div class="container-fluid">

    {{-- ── Header ──────────────────────────────────────────────────────────── --}}
    <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4">
        <div class="d-flex align-items-center gap-3">
            {{-- Color dot --}}
            <div style="width:12px;height:12px;border-radius:50%;background:{{ $task->color ?? '#4f46e5' }};flex-shrink:0;margin-top:6px;"></div>
            <div>
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <h2 class="fw-bold mb-0">{{ $task->title }}</h2>
                    @if($task->is_pinned) <i class="bi bi-pin-fill text-primary" title="Pinned"></i> @endif
                    @if($task->is_favorite) <i class="bi bi-star-fill text-warning" title="Favorite"></i> @endif
                </div>
                <div class="d-flex align-items-center gap-2 mt-1 flex-wrap">
                    <span class="badge bg-{{ $priorityColor[$task->priority] ?? 'secondary' }}">{{ ucfirst($task->priority) }}</span>
                    <span class="badge bg-{{ $statusColor[$task->status] ?? 'secondary' }}">{{ ucwords(str_replace('_',' ',$task->status)) }}</span>
                    @if($task->is_overdue) <span class="badge bg-danger">Overdue</span> @endif
                    @if($task->is_due_today) <span class="badge bg-warning text-dark">Due Today</span> @endif
                    @if($task->category) <span class="badge bg-light text-secondary border">{{ $task->category }}</span> @endif
                    <small class="text-muted">Created {{ $task->created_at->diffForHumans() }}</small>
                </div>
            </div>
        </div>

        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('focus.index', ['task' => $task->id]) }}" class="btn btn-success">
                <i class="bi bi-play-circle me-2"></i>Start Focus
            </a>
            <a href="{{ route('tasks.edit', $task) }}" class="btn btn-warning">
                <i class="bi bi-pencil-square me-2"></i>Edit
            </a>
            {{-- Favorite toggle --}}
            <form method="POST" action="{{ route('tasks.favorite', $task) }}" class="d-inline">
                @csrf
                <button class="btn {{ $task->is_favorite ? 'btn-warning' : 'btn-outline-warning' }}" title="Toggle Favorite">
                    <i class="bi bi-star{{ $task->is_favorite ? '-fill' : '' }}"></i>
                </button>
            </form>
            {{-- Archive --}}
            <form method="POST" action="{{ route('tasks.archive', $task) }}" class="d-inline">
                @csrf
                <button class="btn btn-outline-secondary" title="Archive">
                    <i class="bi bi-archive"></i>
                </button>
            </form>
            <form action="{{ route('tasks.destroy', $task) }}" method="POST"
                  onsubmit="return confirm('Delete this task?')" class="d-inline">
                @csrf @method('DELETE')
                <button class="btn btn-outline-danger" title="Delete">
                    <i class="bi bi-trash"></i>
                </button>
            </form>
        </div>
    </div>

    {{-- ── Mini Stats ───────────────────────────────────────────────────────── --}}
    <div class="row g-3 mb-4">
        @php
            $miniStats = [
                ['label'=>'Progress',      'value'=>($task->progress??0).'%',   'icon'=>'bi-bar-chart-fill',  'color'=>'primary'],
                ['label'=>'Steps Done',    'value'=>$completedSteps.'/'.$totalSteps, 'icon'=>'bi-check2-all','color'=>'success'],
                ['label'=>'Focus Time',    'value'=>$totalFocusMins.'m',         'icon'=>'bi-stopwatch',       'color'=>'info'],
                ['label'=>'Est. Time',     'value'=>($task->estimated_minutes??'—').'m','icon'=>'bi-clock',   'color'=>'warning'],
            ];
        @endphp
        @foreach($miniStats as $ms)
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-3 d-flex align-items-center gap-3">
                    <div class="stats-icon stats-{{ $ms['color'] }}" style="width:40px;height:40px;font-size:1rem;border-radius:10px;flex-shrink:0;">
                        <i class="bi {{ $ms['icon'] }}"></i>
                    </div>
                    <div>
                        <div class="fw-bold fs-5 lh-1">{{ $ms['value'] }}</div>
                        <div class="text-muted" style="font-size:.78rem;">{{ $ms['label'] }}</div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="row g-4">

        {{-- ── Left ────────────────────────────────────────────────────────── --}}
        <div class="col-lg-8">

            {{-- Progress bar --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body py-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="fw-semibold">Overall Progress</span>
                        <span class="fw-bold text-primary">{{ $task->progress ?? 0 }}%</span>
                    </div>
                    <div class="progress" style="height:10px;border-radius:20px;">
                        <div class="progress-bar {{ ($task->progress??0)===100 ? 'bg-success' : '' }}"
                             style="width:{{ $task->progress ?? 0 }}%;transition:width .6s ease;border-radius:20px;"></div>
                    </div>
                    @if($totalSteps > 0)
                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <small class="text-muted">Steps: {{ $completedSteps }}/{{ $totalSteps }}</small>
                            <small class="text-muted">{{ $stepPercent }}% steps done</small>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Description --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-text-left me-2 text-primary"></i>Description</h5>
                </div>
                <div class="card-body" style="line-height:1.8;">
                    @if($task->description)
                        {!! nl2br(e($task->description)) !!}
                    @else
                        <p class="text-muted mb-0">No description provided.</p>
                    @endif
                </div>
            </div>

            @if($task->notes)
            <div class="card border-0 shadow-sm mb-4" style="border-left:4px solid var(--primary) !important;">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-journal-text me-2 text-primary"></i>Private Notes</h5>
                </div>
                <div class="card-body">
                    {!! nl2br(e($task->notes)) !!}
                </div>
            </div>
            @endif

            {{-- Checklist --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-check2-square me-2 text-primary"></i>Checklist</h5>
                    @if($totalSteps > 0)
                        <small class="text-muted">{{ $completedSteps }}/{{ $totalSteps }} done</small>
                    @endif
                </div>
                <div class="card-body">
                    @forelse($task->steps as $step)
                        <div class="d-flex align-items-center gap-3 py-2 border-bottom">
                            <input class="form-check-input flex-shrink-0" type="checkbox"
                                   style="width:18px;height:18px;" disabled
                                   {{ $step->is_completed ? 'checked' : '' }}>
                            <span class="{{ $step->is_completed ? 'text-muted text-decoration-line-through' : '' }}">
                                {{ $step->title }}
                            </span>
                        </div>
                    @empty
                        <p class="text-muted mb-0">No steps added.</p>
                    @endforelse
                </div>
            </div>

            {{-- Remarks --}}
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-chat-left-text me-2 text-primary"></i>Remarks</h5>
                    <a href="{{ route('remarks.create', ['task'=>$task->id]) }}" class="btn btn-sm btn-primary">
                        <i class="bi bi-plus me-1"></i>Add
                    </a>
                </div>
                <div class="card-body">
                    @forelse($task->remarks as $remark)
                        <div class="d-flex gap-3 mb-4">
                            <div class="user-avatar flex-shrink-0" style="width:38px;height:38px;font-size:.85rem;">
                                {{ strtoupper(substr($remark->user->name,0,1)) }}
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <strong style="font-size:.95rem;">{{ $remark->user->name }}</strong>
                                    <small class="text-muted">{{ $remark->created_at->format('d M Y, h:i A') }}</small>
                                </div>
                                <div class="p-3 rounded" style="background:var(--gray-100,#f8fafc);font-size:.92rem;line-height:1.7;">
                                    {{ $remark->remark }}
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4 text-muted">
                            <i class="bi bi-chat-square d-block mb-2" style="font-size:2rem;"></i>
                            No remarks yet.
                        </div>
                    @endforelse
                </div>
            </div>

        </div>

        {{-- ── Right Sidebar ────────────────────────────────────────────────── --}}
        <div class="col-lg-4">

            {{-- Task Info --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-info-circle me-2 text-primary"></i>Details</h5>
                </div>
                <div class="card-body p-0">
                    @php
                        $details = [
                            ['label'=>'Priority',    'value'=>ucfirst($task->priority)],
                            ['label'=>'Status',      'value'=>ucwords(str_replace('_',' ',$task->status))],
                            ['label'=>'Due Date',    'value'=>optional($task->due_date)->format('d M Y, H:i') ?? '—'],
                            ['label'=>'Reminder',    'value'=>optional($task->reminder_at)->format('d M Y, H:i') ?? '—'],
                            ['label'=>'Recurrence',  'value'=>ucfirst($task->recurrence ?? 'None')],
                            ['label'=>'Est. Time',   'value'=>($task->estimated_minutes ?? '—').' min'],
                            ['label'=>'Actual Time', 'value'=>($task->actual_minutes ?? 0).' min'],
                            ['label'=>'Urgency',     'value'=>($task->urgency ?? '—').'/5'],
                            ['label'=>'Impact',      'value'=>($task->impact ?? '—').'/5'],
                            ['label'=>'Completed',   'value'=>optional($task->completed_at)->format('d M Y') ?? '—'],
                        ];
                    @endphp
                    <table class="table table-borderless mb-0" style="font-size:.9rem;">
                        @foreach($details as $d)
                        <tr>
                            <th class="text-muted fw-normal ps-4" style="width:45%;">{{ $d['label'] }}</th>
                            <td class="fw-semibold pe-4">{{ $d['value'] }}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>

            {{-- Tags --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-tags me-2 text-primary"></i>Tags</h5>
                </div>
                <div class="card-body">
                    @forelse($task->tags as $tag)
                        <span class="badge bg-light text-secondary border me-1 mb-1 px-3 py-2">{{ $tag->name }}</span>
                    @empty
                        <span class="text-muted">No tags assigned.</span>
                    @endforelse
                </div>
            </div>

            {{-- Focus Sessions --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-stopwatch me-2 text-primary"></i>Focus Sessions</h5>
                    <span class="badge bg-primary rounded-pill">{{ $task->focusSessions->count() }}</span>
                </div>
                <div class="card-body p-0">
                    @forelse($task->focusSessions->take(6) as $session)
                        <div class="d-flex justify-content-between align-items-center px-4 py-2 border-bottom">
                            <div>
                                <span class="fw-semibold">{{ $session->actual_minutes ?? 0 }} min</span>
                                @if($session->completed)
                                    <span class="badge bg-success ms-1" style="font-size:.65rem;">Done</span>
                                @endif
                            </div>
                            <small class="text-muted">{{ $session->started_at?->format('d M, H:i') }}</small>
                        </div>
                    @empty
                        <div class="text-muted text-center py-4">
                            <i class="bi bi-stopwatch d-block mb-1" style="font-size:1.5rem;"></i>
                            No focus sessions yet.
                        </div>
                    @endforelse
                    @if($task->focusSessions->count() > 6)
                        <div class="text-center py-2">
                            <small class="text-muted">+{{ $task->focusSessions->count()-6 }} more sessions</small>
                        </div>
                    @endif
                </div>
                @if($totalFocusMins > 0)
                <div class="card-footer bg-white py-2">
                    <small class="text-muted">Total: <strong>{{ $totalFocusMins }} min</strong>
                    @if($task->estimated_minutes && $task->estimated_minutes > 0)
                        ({{ round(($totalFocusMins / $task->estimated_minutes)*100) }}% of estimate)
                    @endif
                    </small>
                </div>
                @endif
            </div>

            {{-- Quick actions --}}
            <div class="card border-0 shadow-sm">
                <div class="card-body d-grid gap-2">
                    <a href="{{ route('focus.index', ['task'=>$task->id]) }}" class="btn btn-success">
                        <i class="bi bi-play-circle me-2"></i>Start Focus Session
                    </a>
                    <a href="{{ route('tasks.edit', $task) }}" class="btn btn-warning">
                        <i class="bi bi-pencil me-2"></i>Edit Task
                    </a>
                    <a href="{{ route('tasks.create') }}" class="btn btn-outline-primary">
                        <i class="bi bi-plus-circle me-2"></i>New Task
                    </a>
                    <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-2"></i>All Tasks
                    </a>
                </div>
            </div>

        </div>
    </div>

</div>
@endsection