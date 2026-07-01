@extends('layouts.app')

@section('title', 'Remarks')

@push('styles')
<style>
/*── Remarks Index ──────────────────────────────────────────────────────*/

.remark-timeline { position: relative; }
.remark-timeline::before {
    content: '';
    position: absolute;
    left: 27px;
    top: 0; bottom: 0;
    width: 2px;
    background: linear-gradient(to bottom, #e2e8f0 0%, transparent 100%);
    z-index: 0;
}

.remark-item {
    position: relative;
    z-index: 1;
    transition: transform .2s;
}
.remark-item:hover { transform: translateX(3px); }

.remark-avatar {
    width: 56px; height: 56px;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-weight: 800; font-size: 1.1rem; color: #fff;
    flex-shrink: 0;
    position: relative; z-index: 1;
    box-shadow: 0 0 0 3px #fff, 0 0 0 5px #e2e8f0;
}

.remark-bubble {
    background: #fff;
    border-radius: 16px;
    border: 1px solid #f1f5f9;
    box-shadow: 0 2px 12px rgba(0,0,0,.05);
    transition: box-shadow .2s, border-color .2s;
    overflow: hidden;
}
.remark-bubble:hover {
    box-shadow: 0 8px 24px rgba(0,0,0,.09);
    border-color: #e2e8f0;
}

.remark-bubble-header {
    padding: 14px 18px 10px;
    border-bottom: 1px solid #f8fafc;
    display: flex; justify-content: space-between; align-items: flex-start; gap: 12px;
}
.remark-bubble-body { padding: 14px 18px; }
.remark-bubble-footer {
    padding: 10px 18px;
    background: #fafbfc;
    border-top: 1px solid #f1f5f9;
    display: flex; align-items: center; gap: 8px; flex-wrap: wrap;
}

.task-chip {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 3px 10px; border-radius: 999px;
    background: rgba(79,70,229,.08); color: #4f46e5;
    font-size: .75rem; font-weight: 600; text-decoration: none;
    transition: background .2s;
}
.task-chip:hover { background: rgba(79,70,229,.15); color: #4f46e5; }

.remark-text {
    font-size: .93rem; line-height: 1.75; color: #334155;
    white-space: pre-wrap; word-break: break-word;
}

.remark-action-btn {
    border: none; background: none;
    font-size: .78rem; color: #94a3b8; padding: 4px 8px;
    border-radius: 8px; font-weight: 600; cursor: pointer;
    display: inline-flex; align-items: center; gap: 5px;
    transition: background .15s, color .15s;
}
.remark-action-btn:hover { background: #f1f5f9; color: #475569; }
.remark-action-btn.danger:hover { background: #fef2f2; color: #ef4444; }

/* Priority dot */
.priority-dot {
    width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0;
}

/* Stats strip */
.remark-stat {
    text-align: center;
    padding: 16px 0;
}
.remark-stat-num { font-size: 1.8rem; font-weight: 800; line-height: 1; }
.remark-stat-label { font-size: .72rem; font-weight: 600; color: #94a3b8;
                     text-transform: uppercase; letter-spacing: .05em; margin-top: 4px; }

/* Search highlight */
mark { background: #fef3c7; color: #92400e; padding: 0 2px; border-radius: 3px; }

/* Empty state */
.empty-remarks { padding: 80px 24px; text-align: center; }
.empty-remarks-icon { font-size: 4rem; color: #e2e8f0; margin-bottom: 16px; }

/* Fade in animation */
@keyframes remarkIn {
    from { opacity: 0; transform: translateY(12px); }
    to   { opacity: 1; transform: translateY(0); }
}
.remark-item { animation: remarkIn .35s ease both; }
@for($i=1;$i<=20;$i++)
.remark-item:nth-child({{ $i }}) { animation-delay: {{ ($i - 1) * 0.04 }}s; }
@endfor
</style>
@endpush

@section('content')

@php
    $avatarColors = ['#4f46e5','#10b981','#f59e0b','#ef4444','#0ea5e9','#7c3aed','#ec4899','#14b8a6'];
    $priorityDots = ['low'=>'#10b981','medium'=>'#f59e0b','high'=>'#f97316','urgent'=>'#ef4444'];
    $totalRemarks = $remarks->total();
    $todayCount   = $remarks->getCollection()->filter(fn($r) => $r->created_at->isToday())->count();
@endphp

<div class="container-fluid px-3 px-lg-4">

    {{-- ── Header ──────────────────────────────────────────────────────── --}}
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1">Remarks</h2>
            <p class="text-muted mb-0">Notes, updates and progress logs across all tasks.</p>
        </div>
        <a href="{{ route('remarks.create') }}" class="btn btn-primary px-4 fw-semibold">
            <i class="bi bi-plus-circle me-2"></i>Add Remark
        </a>
    </div>

    {{-- ── Stats Strip ─────────────────────────────────────────────────── --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body py-2">
            <div class="row g-0 text-center divide-x">
                <div class="col-4 col-md-3">
                    <div class="remark-stat">
                        <div class="remark-stat-num text-primary">{{ $totalRemarks }}</div>
                        <div class="remark-stat-label">Total Remarks</div>
                    </div>
                </div>
                <div class="col-4 col-md-3">
                    <div class="remark-stat">
                        <div class="remark-stat-num text-success">{{ $todayCount }}</div>
                        <div class="remark-stat-label">Added Today</div>
                    </div>
                </div>
                <div class="col-4 col-md-3">
                    <div class="remark-stat">
                        <div class="remark-stat-num text-warning">{{ $tasks->count() }}</div>
                        <div class="remark-stat-label">Tasks with Notes</div>
                    </div>
                </div>
                <div class="col-12 col-md-3 d-none d-md-block">
                    <div class="remark-stat">
                        <div class="remark-stat-num text-info">
                            {{ $remarks->getCollection()->avg(fn($r) => str_word_count($r->remark)) ? round($remarks->getCollection()->avg(fn($r) => str_word_count($r->remark))) : 0 }}
                        </div>
                        <div class="remark-stat-label">Avg Words / Note</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Filters ──────────────────────────────────────────────────────── --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body py-3">
            <form method="GET" class="row g-2 align-items-center">
                <div class="col-12 col-md-4">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="bi bi-search text-muted"></i>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}"
                               class="form-control border-start-0 ps-0"
                               placeholder="Search remarks…">
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <select name="task_id" class="form-select form-select-sm">
                        <option value="">All Tasks</option>
                        @foreach($tasks as $task)
                            <option value="{{ $task->id }}" @selected(request('task_id')==$task->id)>
                                {{ Str::limit($task->title, 40) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6 col-md-2">
                    <select name="date_filter" class="form-select form-select-sm">
                        <option value="">Any time</option>
                        <option value="today"   @selected(request('date_filter')==='today')>Today</option>
                        <option value="week"    @selected(request('date_filter')==='week')>This week</option>
                        <option value="month"   @selected(request('date_filter')==='month')>This month</option>
                    </select>
                </div>
                <div class="col-6 col-md-2">
                    <select name="sort" class="form-select form-select-sm">
                        <option value="newest" @selected(request('sort','newest')==='newest')>Newest first</option>
                        <option value="oldest" @selected(request('sort')==='oldest')>Oldest first</option>
                        <option value="longest" @selected(request('sort')==='longest')>Longest</option>
                    </select>
                </div>
                <div class="col-3 col-md-1">
                    <button class="btn btn-primary btn-sm w-100">Go</button>
                </div>
                @if(request()->hasAny(['search','task_id','date_filter','sort']))
                    <div class="col-3 col-md-auto">
                        <a href="{{ route('remarks.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-x me-1"></i>Clear
                        </a>
                    </div>
                @endif
            </form>
        </div>
    </div>

    {{-- ── Timeline Feed ────────────────────────────────────────────────── --}}
    <div class="remark-timeline">
        @forelse($remarks as $remark)
            @php
                $color     = $avatarColors[crc32($remark->user->name) % count($avatarColors)];
                $initial   = strtoupper(substr($remark->user->name, 0, 1));
                $priority  = $remark->task->priority ?? 'medium';
                $dotColor  = $priorityDots[$priority] ?? '#94a3b8';
                $wordCount = str_word_count($remark->remark);
                $search    = request('search');
                $text      = $search
                    ? preg_replace('/(' . preg_quote($search, '/') . ')/i', '<mark>$1</mark>', e($remark->remark))
                    : e($remark->remark);
            @endphp

            <div class="remark-item d-flex gap-3 mb-4">

                {{-- Avatar --}}
                <div class="remark-avatar" style="background:{{ $color }};">
                    {{ $initial }}
                </div>

                {{-- Bubble --}}
                <div class="remark-bubble flex-grow-1">

                    {{-- Header --}}
                    <div class="remark-bubble-header">
                        <div>
                            <div class="d-flex align-items-center gap-2 flex-wrap">
                                <span class="fw-bold" style="font-size:.95rem;">{{ $remark->user->name }}</span>
                                <a href="{{ route('tasks.show', $remark->task) }}" class="task-chip">
                                    <i class="bi bi-tag" style="font-size:.7rem;"></i>
                                    {{ Str::limit($remark->task->title, 30) }}
                                </a>
                                <span class="priority-dot" style="background:{{ $dotColor }};" title="{{ ucfirst($priority) }} priority"></span>
                            </div>
                            <div class="text-muted mt-1" style="font-size:.78rem;">
                                <i class="bi bi-clock me-1"></i>
                                {{ $remark->created_at->format('d M Y · H:i') }}
                                <span class="ms-2">·</span>
                                <span class="ms-2">{{ $remark->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                        {{-- Word count badge --}}
                        <span class="badge bg-light text-muted border fw-normal" style="font-size:.7rem;flex-shrink:0;">
                            {{ $wordCount }} word{{ $wordCount != 1 ? 's' : '' }}
                        </span>
                    </div>

                    {{-- Body --}}
                    <div class="remark-bubble-body">
                        <div class="remark-text">{!! $text !!}</div>
                    </div>

                    {{-- Footer --}}
                    <div class="remark-bubble-footer">
                        <a href="{{ route('tasks.show', $remark->task) }}"
                           class="remark-action-btn">
                            <i class="bi bi-eye"></i> View Task
                        </a>

                        @if(auth()->id() === $remark->user_id)
                            <a href="{{ route('remarks.edit', $remark) }}"
                               class="remark-action-btn">
                                <i class="bi bi-pencil"></i> Edit
                            </a>

                            <form method="POST" action="{{ route('remarks.destroy', $remark) }}"
                                  class="d-inline"
                                  onsubmit="return confirm('Delete this remark?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="remark-action-btn danger">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            </form>
                        @endif

                        <span class="ms-auto text-muted" style="font-size:.72rem;">
                            @if($remark->updated_at->ne($remark->created_at))
                                <i class="bi bi-pencil-square me-1"></i>Edited {{ $remark->updated_at->diffForHumans() }}
                            @endif
                        </span>
                    </div>

                </div>
            </div>
        @empty
            <div class="card border-0 shadow-sm">
                <div class="empty-remarks">
                    <div class="empty-remarks-icon"><i class="bi bi-chat-left-text"></i></div>
                    <h4 class="fw-bold mb-2">No remarks yet</h4>
                    <p class="text-muted mb-4">
                        @if(request('search'))
                            No remarks match "{{ request('search') }}".
                        @else
                            Start adding notes and progress updates to your tasks.
                        @endif
                    </p>
                    <a href="{{ route('remarks.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus me-2"></i>Add First Remark
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($remarks->hasPages())
        <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap gap-2">
            <small class="text-muted">
                Showing {{ $remarks->firstItem() }}–{{ $remarks->lastItem() }} of {{ $remarks->total() }} remarks
            </small>
            {{ $remarks->links() }}
        </div>
    @endif

</div>
@endsection