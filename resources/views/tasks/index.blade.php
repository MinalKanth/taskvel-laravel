@extends('layouts.app')

@section('title', 'Tasks')

@section('content')

<style>
    .stats-card::before {
    background: rgb(79 70 229 / 25%) !important;
}
</style>

<div class="container-fluid">

    {{-- ── Page Header ──────────────────────────────────────────────────── --}}
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1">Task Management</h2>
            <p class="text-muted mb-0">Organize, prioritize and track your work.</p>
        </div>
        <a href="{{ route('tasks.create') }}" class="btn btn-primary px-4">
            <i class="bi bi-plus-circle me-2"></i>New Task
        </a>
    </div>

    {{-- ── Stats Row ────────────────────────────────────────────────────── --}}
    <div class="row g-3 mb-4">
        @php
            $statCards = [
                ['label'=>'Total Tasks',   'value'=>$stats['total'],       'icon'=>'bi-list-task',       'color'=>'primary'],
                ['label'=>'In Progress',   'value'=>$stats['in_progress'], 'icon'=>'bi-arrow-repeat',    'color'=>'warning'],
                ['label'=>'Completed',     'value'=>$stats['completed'],   'icon'=>'bi-check-circle',    'color'=>'success'],
                ['label'=>'Overdue',       'value'=>$stats['overdue'],     'icon'=>'bi-exclamation-circle','color'=>'danger'],
                ['label'=>'Due Today',     'value'=>$stats['due_today'],   'icon'=>'bi-calendar-event',  'color'=>'info'],
                ['label'=>'Focus (today)', 'value'=>$stats['focus_mins'].'m','icon'=>'bi-stopwatch',     'color'=>'secondary'],
            ];
        @endphp
        @foreach($statCards as $card)
        <div class="col-6 col-md-4 col-xl-2">
            <div class="card border-0 shadow-sm h-100 stats-card">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="stats-icon stats-{{ $card['color'] }} flex-shrink-0" style="width:44px;height:44px;font-size:1.1rem;border-radius:12px;">
                            <i class="bi {{ $card['icon'] }}"></i>
                        </div>
                        <div>
                            <div class="fw-bold fs-5 lh-1">{{ $card['value'] }}</div>
                            <div class="text-muted" style="font-size:.78rem;">{{ $card['label'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- ── Filters ──────────────────────────────────────────────────────── --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body py-3">
            <form method="GET" class="row g-2 align-items-center">
                <div class="col-12 col-md-3">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                        <input type="text" name="search" value="{{ request('search') }}"
                               class="form-control border-start-0 ps-0" placeholder="Search tasks…">
                    </div>
                </div>
                <div class="col-6 col-md-2">
                    <select name="status" class="form-select form-select-sm">
                        <option value="">All Status</option>
                        @foreach(['pending'=>'Pending','in_progress'=>'In Progress','completed'=>'Completed','cancelled'=>'Cancelled'] as $val=>$label)
                            <option value="{{ $val }}" @selected(request('status')===$val)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6 col-md-2">
                    <select name="priority" class="form-select form-select-sm">
                        <option value="">All Priority</option>
                        @foreach(['low','medium','high','urgent'] as $p)
                            <option value="{{ $p }}" @selected(request('priority')===$p)>{{ ucfirst($p) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6 col-md-2">
                    <select name="due" class="form-select form-select-sm">
                        <option value="">Any Due Date</option>
                        <option value="today"   @selected(request('due')==='today')>Due Today</option>
                        <option value="overdue" @selected(request('due')==='overdue')>Overdue</option>
                    </select>
                </div>
                <div class="col-6 col-md-1">
                    <select name="sort" class="form-select form-select-sm">
                        <option value="newest"   @selected(request('sort')==='newest')>Newest</option>
                        <option value="due_date" @selected(request('sort')==='due_date')>Due Date</option>
                        <option value="priority" @selected(request('sort')==='priority')>Priority</option>
                        <option value="progress" @selected(request('sort')==='progress')>Progress</option>
                        <option value="title"    @selected(request('sort')==='title')>Title</option>
                    </select>
                </div>
                <div class="col-6 col-md-1">
                    <button class="btn btn-primary btn-sm w-100">Filter</button>
                </div>
                <div class="col-6 col-md-1">
                    <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary btn-sm w-100">Reset</a>
                </div>
            </form>
        </div>
    </div>

    {{-- ── Task Table ───────────────────────────────────────────────────── --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
            <h5 class="mb-0 fw-bold">All Tasks</h5>
            <span class="badge bg-primary rounded-pill">{{ $tasks->total() }}</span>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="min-width:900px;">
                <thead class="table-light">
                    <tr>
                        <th style="width:40px;"></th>
                        <th>Title</th>
                        <th>Priority</th>
                        <th>Status</th>
                        <th style="width:160px;">Progress</th>
                        <th>Due Date</th>
                        <th>Tags</th>
                        <th style="width:130px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($tasks as $task)
                    @php
                        $priorityBadge = ['low'=>'secondary','medium'=>'info','high'=>'warning','urgent'=>'danger'];
                        $statusBadge   = ['pending'=>'warning','in_progress'=>'primary','completed'=>'success','cancelled'=>'danger'];
                    @endphp
                    <tr class="{{ $task->is_overdue ? 'table-danger' : '' }}">
                        {{-- Pin / Fav indicator --}}
                        <td class="text-center">
                            @if($task->is_pinned)
                                <i class="bi bi-pin-fill text-primary" title="Pinned"></i>
                            @elseif($task->is_favorite)
                                <i class="bi bi-star-fill text-warning" title="Favorite"></i>
                            @endif
                        </td>

                        {{-- Title --}}
                        <td>
                            <a href="{{ route('tasks.show',$task) }}" class="fw-semibold text-dark text-decoration-none d-block">
                                {{ $task->title }}
                            </a>
                            @if($task->description)
                                <small class="text-muted">{{ Str::limit($task->description, 60) }}</small>
                            @endif
                            @if($task->category)
                                <span class="badge bg-light text-secondary border mt-1" style="font-size:.7rem;">{{ $task->category }}</span>
                            @endif
                        </td>

                        {{-- Priority --}}
                        <td>
                            <span class="badge bg-{{ $priorityBadge[$task->priority] ?? 'secondary' }}">
                                {{ ucfirst($task->priority) }}
                            </span>
                        </td>

                        {{-- Status --}}
                        <td>
                            <span class="badge bg-{{ $statusBadge[$task->status] ?? 'secondary' }}">
                                {{ ucwords(str_replace('_',' ',$task->status)) }}
                            </span>
                        </td>

                        {{-- Progress --}}
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="progress flex-grow-1" style="height:6px;border-radius:20px;">
                                    <div class="progress-bar @if($task->progress==100) bg-success @endif"
                                         style="width:{{ $task->progress ?? 0 }}%"></div>
                                </div>
                                <small class="text-muted fw-semibold" style="min-width:28px;">{{ $task->progress ?? 0 }}%</small>
                            </div>
                        </td>

                        {{-- Due Date --}}
                        <td>
                            @if($task->due_date)
                                <span class="{{ $task->is_overdue ? 'text-danger fw-semibold' : 'text-muted' }}">
                                    <i class="bi bi-calendar3 me-1"></i>
                                    {{ $task->due_date->format('d M Y') }}
                                </span>
                                @if($task->is_overdue)
                                    <br><small class="text-danger">Overdue</small>
                                @elseif($task->is_due_today)
                                    <br><small class="text-warning fw-semibold">Due today</small>
                                @endif
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>

                        {{-- Tags --}}
                        <td>
                            @foreach($task->tags->take(2) as $tag)
                                <span class="badge bg-light text-secondary border" style="font-size:.7rem;">{{ $tag->name }}</span>
                            @endforeach
                            @if($task->tags->count() > 2)
                                <span class="text-muted" style="font-size:.75rem;">+{{ $task->tags->count()-2 }}</span>
                            @endif
                        </td>

                        {{-- Actions --}}
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('tasks.show',$task) }}"
                                   class="btn btn-sm btn-outline-primary" title="View">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('tasks.edit',$task) }}"
                                   class="btn btn-sm btn-outline-warning" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST" action="{{ route('tasks.destroy',$task) }}" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('Delete \'{{ addslashes($task->title) }}\'?')"
                                            title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-5">
                            <i class="bi bi-inbox display-4 text-muted d-block mb-3"></i>
                            <p class="text-muted mb-2">No tasks found.</p>
                            <a href="{{ route('tasks.create') }}" class="btn btn-primary btn-sm">
                                <i class="bi bi-plus me-1"></i>Create your first task
                            </a>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        @if($tasks->hasPages())
        <div class="card-footer bg-white d-flex justify-content-between align-items-center flex-wrap gap-2 py-3">
            <small class="text-muted">
                Showing {{ $tasks->firstItem() }}–{{ $tasks->lastItem() }} of {{ $tasks->total() }} tasks
            </small>
            {{ $tasks->links() }}
        </div>
        @endif
    </div>

</div>
@endsection