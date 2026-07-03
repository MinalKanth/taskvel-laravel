@extends('layouts.app')

@section('title', 'Dashboard')

@push('styles')
<style>
/*══════════════════════════════════════════════════════
  DASHBOARD — Premium overrides
══════════════════════════════════════════════════════*/

/* Hero greeting strip */
.dash-hero {
    background: linear-gradient(135deg, #1e1b4b 0%, #312e81 50%, #4338ca 100%);
    border-radius: 20px;
    color: #fff;
    padding: 32px 36px;
    position: relative;
    overflow: hidden;
    margin-bottom: 28px;
}
.dash-hero::before {
    content: '';
    position: absolute;
    width: 300px; height: 300px;
    border-radius: 50%;
    background: rgba(255,255,255,.05);
    top: -80px; right: -60px;
    pointer-events: none;
}
.dash-hero::after {
    content: '';
    position: absolute;
    width: 180px; height: 180px;
    border-radius: 50%;
    background: rgba(255,255,255,.04);
    bottom: -50px; right: 200px;
    pointer-events: none;
}
.dash-hero-title {
    font-size: 1.75rem;
    font-weight: 800;
    letter-spacing: -.02em;
    line-height: 1.2;
}
.dash-hero-sub {
    color: rgba(255,255,255,.65);
    margin-top: 6px;
    font-size: .95rem;
}
.dash-hero-date {
    font-size: .78rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: .08em;
    color: rgba(255,255,255,.5);
    margin-bottom: 8px;
}

/* Score ring */
.score-ring-wrap {
    position: relative;
    width: 110px;
    height: 110px;
    flex-shrink: 0;
}
.score-ring-wrap svg { transform: rotate(-90deg); }
.score-ring-track { fill: none; stroke: rgba(255,255,255,.12); stroke-width: 8; }
.score-ring-fill  { fill: none; stroke: #a5f3fc; stroke-width: 8; stroke-linecap: round;
                    stroke-dasharray: 295; stroke-dashoffset: 295;
                    transition: stroke-dashoffset 1.4s cubic-bezier(.4,0,.2,1); }
.score-ring-inner {
    position: absolute; inset: 0;
    display: flex; flex-direction: column;
    align-items: center; justify-content: center;
}
.score-ring-num  { font-size: 1.6rem; font-weight: 800; line-height: 1; color: #fff; }
.score-ring-label{ font-size: .6rem; font-weight: 600; text-transform: uppercase;
                   letter-spacing: .06em; color: rgba(255,255,255,.55); }

/* KPI cards */
.kpi-card {
    border: none;
    border-radius: 18px;
    background: #fff;
    box-shadow: 0 2px 12px rgba(0,0,0,.06);
    transition: transform .22s, box-shadow .22s;
    overflow: hidden;
    position: relative;
}
.kpi-card:hover { transform: translateY(-4px); box-shadow: 0 12px 32px rgba(0,0,0,.1); }
.kpi-accent {
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 4px;
    border-radius: 18px 18px 0 0;
}
.kpi-icon {
    width: 52px; height: 52px;
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.35rem;
    flex-shrink: 0;
}
.kpi-num  { font-size: 2rem; font-weight: 800; line-height: 1; letter-spacing: -.02em; }
.kpi-label{ font-size: .78rem; color: #94a3b8; font-weight: 600; text-transform: uppercase; letter-spacing: .05em; margin-top: 4px; }
.kpi-trend{ font-size: .78rem; font-weight: 700; }
.kpi-trend.up   { color: #10b981; }
.kpi-trend.down { color: #ef4444; }
.kpi-trend.warn { color: #f59e0b; }

/* Sparkline canvas */
.sparkline { display: block; margin-top: 12px; }

/* Section labels */
.section-eyebrow {
    font-size: .72rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .1em;
    color: #94a3b8;
    margin-bottom: 14px;
}

/* Task rows */
.dash-task-row { transition: background .15s; }
.dash-task-row:hover { background: #f8faff !important; }
.task-title-link { color: #1e293b; text-decoration: none; font-weight: 600; }
.task-title-link:hover { color: var(--primary, #4f46e5); }

/* Heatmap */
.heatmap-grid {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 4px;
}
.hm-cell {
    aspect-ratio: 1;
    border-radius: 4px;
    background: #f1f5f9;
    transition: transform .15s;
    cursor: default;
    position: relative;
}
.hm-cell:hover { transform: scale(1.25); z-index: 1; }
.hm-cell[data-level="1"] { background: #c7d2fe; }
.hm-cell[data-level="2"] { background: #818cf8; }
.hm-cell[data-level="3"] { background: #4f46e5; }
.hm-cell[data-level="4"] { background: #3730a3; }

/* Activity feed */
.activity-dot {
    width: 10px; height: 10px;
    border-radius: 50%;
    flex-shrink: 0;
    margin-top: 5px;
}
.activity-line {
    width: 2px;
    background: #e2e8f0;
    flex: 1;
    margin: 2px auto;
}

/* Focus ring mini */
.focus-ring-mini {
    width: 60px; height: 60px;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: .75rem; font-weight: 800;
    background: conic-gradient(#4f46e5 var(--pct, 0%), #eef2ff var(--pct, 0%));
    position: relative;
}
.focus-ring-mini::after {
    content: attr(data-label);
    position: absolute;
    inset: 6px;
    background: #fff;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: .7rem; font-weight: 800; color: #4f46e5;
}

/* Overdue pill blink */
@keyframes blink { 0%,100%{opacity:1} 50%{opacity:.45} }
.overdue-badge { animation: blink 2.5s infinite; }

/* Count-up animation */
.count-up { transition: opacity .3s; }

/* Responsive */
@media(max-width:768px) {
    .dash-hero { padding: 22px 20px; }
    .dash-hero-title { font-size: 1.3rem; }
    .score-ring-wrap { width: 80px; height: 80px; }
    .score-ring-num { font-size: 1.2rem; }
    .kpi-num { font-size: 1.6rem; }
}
</style>
@endpush

@section('content')

@php
    $productivity   = $stats['productivity']       ?? 0;
    $totalTasks     = $stats['total_tasks']         ?? 0;
    $completedTasks = $stats['completed_tasks']     ?? 0;
    $pendingTasks   = $stats['pending_tasks']       ?? 0;
    $focusHours     = $stats['focus_hours']         ?? 0;
    $overdueTasks   = $stats['overdue_tasks']       ?? 0;
    $inProgressTasks= $stats['in_progress_tasks']   ?? 0;
    $todaySessions  = $stats['today_sessions']      ?? 0;
    $focusMinsToday = $stats['focus_minutes_today'] ?? 0;
    $weeklyChart    = $weeklyChart                  ?? [0,0,0,0,0,0,0];
    $heatmapData    = $heatmapData                  ?? array_fill(0, 28, 0);

    $hour = (int) now()->format('H');
    $greeting = $hour < 12 ? 'Good morning' : ($hour < 17 ? 'Good afternoon' : 'Good evening');

    // Score ring offset: circumference 295
    $ringOffset = 295 - round(($productivity / 100) * 295);
@endphp

<div class="container-fluid px-3 px-lg-4">

    {{-- ══════════════════════════════════════════════════
         HERO STRIP
    ═══════════════════════════════════════════════════════ --}}
    <div class="dash-hero fade-up">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

            <div>
                <div class="dash-hero-date">{{ now()->format('l, d F Y') }}</div>
                <div class="dash-hero-title">
                    {{ $greeting }}, {{ auth()->user()->name }} 👋
                </div>
                <div class="dash-hero-sub">
                    @if($overdueTasks > 0)
                        You have <strong style="color:#fca5a5;">{{ $overdueTasks }} overdue task{{ $overdueTasks > 1 ? 's' : '' }}</strong> —
                    @endif
                    @if($inProgressTasks > 0)
                        <strong style="color:#bfdbfe;">{{ $inProgressTasks }}</strong> in progress today.
                    @else
                        Ready to get into flow? Let's go.
                    @endif
                </div>

                <div class="d-flex gap-2 mt-4 flex-wrap">
                    <a href="{{ route('tasks.create') }}" class="btn btn-sm fw-semibold px-3"
                       style="background:#fff;color:#4338ca;border-radius:999px;">
                        <i class="bi bi-plus me-1"></i>New Task
                    </a>
                    <a href="{{ route('focus.index') }}" class="btn btn-sm fw-semibold px-3"
                       style="background:rgba(255,255,255,.15);color:#fff;border-radius:999px;border:1px solid rgba(255,255,255,.25);">
                        <i class="bi bi-stopwatch me-1"></i>Focus Mode
                    </a>
                    <a href="{{ route('tasks.index') }}" class="btn btn-sm fw-semibold px-3"
                       style="background:rgba(255,255,255,.15);color:#fff;border-radius:999px;border:1px solid rgba(255,255,255,.25);">
                        <i class="bi bi-list-task me-1"></i>All Tasks
                    </a>
                </div>
            </div>

            {{-- Productivity score ring --}}
            <div class="text-center">
                <div class="score-ring-wrap" id="scoreRingWrap">
                    <svg width="110" height="110" viewBox="0 0 110 110">
                        <circle class="score-ring-track" cx="55" cy="55" r="47"/>
                        <circle class="score-ring-fill"  cx="55" cy="55" r="47"
                                id="scoreRingFill" data-offset="{{ $ringOffset }}"/>
                    </svg>
                    <div class="score-ring-inner">
                        <div class="score-ring-num" id="scoreNum">0</div>
                        <div class="score-ring-label">Score</div>
                    </div>
                </div>
                <div style="color:rgba(255,255,255,.5);font-size:.72rem;margin-top:6px;">Productivity</div>
            </div>

        </div>
    </div>

    {{-- ══════════════════════════════════════════════════
         KPI CARDS — 6-up
    ═══════════════════════════════════════════════════════ --}}
    <div class="row g-3 mb-4">

        @php
            $kpis = [
                [
                    'label'   => 'Total Tasks',
                    'value'   => $totalTasks,
                    'icon'    => 'bi-list-task',
                    'accent'  => 'linear-gradient(90deg,#4f46e5,#818cf8)',
                    'bg'      => 'rgba(79,70,229,.08)',
                    'color'   => '#4f46e5',
                    'trend'   => null,
                ],
                [
                    'label'   => 'Completed',
                    'value'   => $completedTasks,
                    'icon'    => 'bi-check-circle-fill',
                    'accent'  => 'linear-gradient(90deg,#10b981,#34d399)',
                    'bg'      => 'rgba(16,185,129,.1)',
                    'color'   => '#10b981',
                    'trend'   => ['class'=>'up','icon'=>'bi-arrow-up','text'=>'Done'],
                ],
                [
                    'label'   => 'In Progress',
                    'value'   => $inProgressTasks,
                    'icon'    => 'bi-arrow-repeat',
                    'accent'  => 'linear-gradient(90deg,#3b82f6,#60a5fa)',
                    'bg'      => 'rgba(59,130,246,.1)',
                    'color'   => '#3b82f6',
                    'trend'   => null,
                ],
                [
                    'label'   => 'Pending',
                    'value'   => $pendingTasks,
                    'icon'    => 'bi-hourglass-split',
                    'accent'  => 'linear-gradient(90deg,#f59e0b,#fbbf24)',
                    'bg'      => 'rgba(245,158,11,.1)',
                    'color'   => '#f59e0b',
                    'trend'   => null,
                ],
                [
                    'label'   => 'Overdue',
                    'value'   => $overdueTasks,
                    'icon'    => 'bi-exclamation-circle-fill',
                    'accent'  => 'linear-gradient(90deg,#ef4444,#f87171)',
                    'bg'      => 'rgba(239,68,68,.1)',
                    'color'   => '#ef4444',
                    'trend'   => $overdueTasks > 0 ? ['class'=>'down','icon'=>'bi-exclamation','text'=>'Needs attention'] : null,
                ],
                [
                    'label'   => 'Focus Today',
                    'value'   => $focusMinsToday.'m',
                    'icon'    => 'bi-stopwatch-fill',
                    'accent'  => 'linear-gradient(90deg,#7c3aed,#a78bfa)',
                    'bg'      => 'rgba(124,58,237,.1)',
                    'color'   => '#7c3aed',
                    'trend'   => $todaySessions > 0 ? ['class'=>'up','icon'=>'bi-lightning','text'=>$todaySessions.' sessions'] : null,
                ],
            ];
        @endphp

        @foreach($kpis as $kpi)
        <div class="col-6 col-md-4 col-xl-2">
            <div class="kpi-card h-100">
                <div class="kpi-accent" style="background:{{ $kpi['accent'] }};"></div>
                <div class="card-body p-3 pt-4">
                    <div class="kpi-icon mb-3" style="background:{{ $kpi['bg'] }};color:{{ $kpi['color'] }};">
                        <i class="bi {{ $kpi['icon'] }}"></i>
                    </div>
                    <div class="kpi-num count-up" data-target="{{ is_numeric($kpi['value']) ? $kpi['value'] : 0 }}"
                         style="color:{{ $kpi['color'] }};">
                        {{ $kpi['value'] }}
                    </div>
                    <div class="kpi-label">{{ $kpi['label'] }}</div>
                    @if($kpi['trend'])
                        <div class="kpi-trend {{ $kpi['trend']['class'] }} mt-2">
                            <i class="bi {{ $kpi['trend']['icon'] }} me-1"></i>{{ $kpi['trend']['text'] }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
        @endforeach

    </div>

    {{-- ══════════════════════════════════════════════════
         MAIN CONTENT ROW
    ═══════════════════════════════════════════════════════ --}}
    <div class="row g-4 mb-4">

        {{-- Recent Tasks ── wide --}}
        <div class="col-xl-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <div>
                        <div class="section-eyebrow mb-0">Recent Activity</div>
                        <h5 class="mb-0 fw-bold">Latest Tasks</h5>
                    </div>
                    <a href="{{ route('tasks.index') }}" class="btn btn-sm btn-primary" style="border-radius:999px;">
                        View all <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table align-middle mb-0" style="min-width:580px;">
                        <thead>
                            <tr style="background:#f8fafc;">
                                <th style="padding:10px 20px;font-size:.75rem;text-transform:uppercase;letter-spacing:.06em;color:#94a3b8;font-weight:700;">Task</th>
                                <th style="padding:10px 12px;font-size:.75rem;text-transform:uppercase;letter-spacing:.06em;color:#94a3b8;font-weight:700;">Priority</th>
                                <th style="padding:10px 12px;font-size:.75rem;text-transform:uppercase;letter-spacing:.06em;color:#94a3b8;font-weight:700;">Status</th>
                                <th style="padding:10px 12px;font-size:.75rem;text-transform:uppercase;letter-spacing:.06em;color:#94a3b8;font-weight:700;width:120px;">Progress</th>
                                <th style="padding:10px 12px;font-size:.75rem;text-transform:uppercase;letter-spacing:.06em;color:#94a3b8;font-weight:700;">Due</th>
                                <th style="padding:10px 20px;font-size:.75rem;text-transform:uppercase;letter-spacing:.06em;color:#94a3b8;font-weight:700;"></th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($recentTasks as $task)
                            @php
                                $pBadge = ['low'=>['secondary','🟢'],'medium'=>['info','🟡'],'high'=>['warning','🟠'],'urgent'=>['danger','🔴']];
                                $sBadge = ['pending'=>['warning','Pending'],'in_progress'=>['primary','In Progress'],'completed'=>['success','Done'],'cancelled'=>['danger','Cancelled']];
                                $pb = $pBadge[$task->priority] ?? ['secondary','⚪'];
                                $sb = $sBadge[$task->status]   ?? ['secondary','—'];
                                $isOverdue = $task->due_date && $task->due_date->isPast() && $task->status !== 'completed';
                            @endphp
                            <tr class="dash-task-row {{ $isOverdue ? 'table-danger' : '' }}" style="border-bottom:1px solid #f1f5f9;">
                                <td style="padding:14px 20px;">
                                    <a href="{{ route('tasks.show', $task) }}" class="task-title-link d-block">
                                        {{ Str::limit($task->title, 40) }}
                                    </a>
                                    @if($task->tags->isNotEmpty())
                                        <div class="mt-1">
                                            @foreach($task->tags->take(2) as $tag)
                                                <span class="badge bg-light text-secondary border" style="font-size:.65rem;">{{ $tag->name }}</span>
                                            @endforeach
                                        </div>
                                    @endif
                                </td>
                                <td style="padding:14px 12px;">
                                    <span class="badge bg-{{ $pb[0] }}" style="font-size:.72rem;">{{ $pb[1] }} {{ ucfirst($task->priority) }}</span>
                                </td>
                                <td style="padding:14px 12px;">
                                    <span class="badge bg-{{ $sb[0] }}" style="font-size:.72rem;">{{ $sb[1] }}</span>
                                </td>
                                <td style="padding:14px 12px;">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="progress flex-grow-1" style="height:5px;border-radius:20px;">
                                            <div class="progress-bar {{ ($task->progress??0)==100 ? 'bg-success' : '' }}"
                                                 style="width:{{ $task->progress ?? 0 }}%"></div>
                                        </div>
                                        <span style="font-size:.72rem;color:#94a3b8;min-width:24px;">{{ $task->progress ?? 0 }}%</span>
                                    </div>
                                </td>
                                <td style="padding:14px 12px;font-size:.82rem;">
                                    @if($task->due_date)
                                        <span class="{{ $isOverdue ? 'text-danger fw-semibold' : 'text-muted' }}">
                                            {{ $task->due_date->format('d M') }}
                                        </span>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td style="padding:14px 20px;">
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('tasks.show', $task) }}" class="btn btn-xs btn-primary"
                                           style="padding:3px 8px;font-size:.75rem;border-radius:8px;">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('focus.index', ['task'=>$task->id]) }}" class="btn btn-xs btn-success"
                                           style="padding:3px 8px;font-size:.75rem;border-radius:8px;" title="Focus">
                                            <i class="bi bi-play-fill"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <i class="bi bi-inbox text-muted d-block mb-2" style="font-size:2.5rem;"></i>
                                    <p class="text-muted mb-3">No tasks yet.</p>
                                    <a href="{{ route('tasks.create') }}" class="btn btn-primary btn-sm">
                                        <i class="bi bi-plus me-1"></i>Create your first task
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                @if(isset($recentTasks) && method_exists($recentTasks, 'hasPages') && $recentTasks->hasPages())
                    <div class="card-footer bg-white py-2">{{ $recentTasks->links() }}</div>
                @endif
            </div>
        </div>

        {{-- Right column --}}
        <div class="col-xl-4">

            {{-- Weekly Chart --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <div>
                        <div class="section-eyebrow mb-0">This Week</div>
                        <h5 class="mb-0 fw-bold">Completion Trend</h5>
                    </div>
                    <div class="d-flex gap-2 align-items-center">
                        <span class="d-inline-block rounded" style="width:10px;height:10px;background:#4f46e5;"></span>
                        <small class="text-muted">Done</small>
                    </div>
                </div>
                <div class="card-body pt-2 pb-3">
                    <canvas id="weeklyChart" height="140"></canvas>
                </div>
            </div>

            {{-- Focus Sessions Today --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <div class="section-eyebrow mb-0">Today</div>
                    <h5 class="mb-0 fw-bold">Focus Sessions</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div>
                            <div style="font-size:2.2rem;font-weight:800;color:#4f46e5;line-height:1;">
                                {{ $focusMinsToday }}<span style="font-size:1rem;font-weight:600;color:#94a3b8;"> min</span>
                            </div>
                            <div class="text-muted" style="font-size:.82rem;">{{ $todaySessions }} session{{ $todaySessions!=1?'s':'' }} completed</div>
                        </div>
                        <a href="{{ route('focus.index') }}"
                           class="btn btn-success btn-sm fw-semibold px-3" style="border-radius:999px;">
                            <i class="bi bi-play-fill me-1"></i>Focus Now
                        </a>
                    </div>

                    {{-- Session boxes --}}
                    <div class="d-flex gap-1 flex-wrap">
                        @for($i = 0; $i < 8; $i++)
                            <div style="width:24px;height:24px;border-radius:6px;background:{{ $i < $todaySessions ? '#4f46e5' : '#e2e8f0' }};transition:.3s;"></div>
                        @endfor
                        @if($todaySessions > 8)
                            <span class="text-muted" style="font-size:.75rem;align-self:center;">+{{ $todaySessions - 8 }}</span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Productivity gauge --}}
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <div class="section-eyebrow mb-0">Overall</div>
                    <h5 class="mb-0 fw-bold">Productivity Score</h5>
                </div>
                <div class="card-body text-center py-4">
                    <div style="font-size:3.5rem;font-weight:900;letter-spacing:-.04em;
                                background:linear-gradient(135deg,#4f46e5,#7c3aed);
                                -webkit-background-clip:text;-webkit-text-fill-color:transparent;
                                background-clip:text;">
                        {{ $productivity }}%
                    </div>
                    <div class="progress mt-3 mb-3" style="height:10px;border-radius:20px;">
                        <div class="progress-bar" style="width:{{ $productivity }}%;
                             background:linear-gradient(90deg,#4f46e5,#7c3aed);border-radius:20px;
                             transition:width 1.2s ease;"></div>
                    </div>
                    <div class="d-flex justify-content-around text-center">
                        <div>
                            <div class="fw-bold text-success">{{ $completedTasks }}</div>
                            <div class="text-muted" style="font-size:.72rem;">Done</div>
                        </div>
                        <div>
                            <div class="fw-bold text-warning">{{ $pendingTasks }}</div>
                            <div class="text-muted" style="font-size:.72rem;">Pending</div>
                        </div>
                        <div>
                            <div class="fw-bold text-danger {{ $overdueTasks > 0 ? 'overdue-badge' : '' }}">{{ $overdueTasks }}</div>
                            <div class="text-muted" style="font-size:.72rem;">Overdue</div>
                        </div>
                        <div>
                            <div class="fw-bold text-primary">{{ number_format($focusHours, 1) }}h</div>
                            <div class="text-muted" style="font-size:.72rem;">Focus</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

    {{-- ══════════════════════════════════════════════════
         BOTTOM ROW — Heatmap + Activity Feed
    ═══════════════════════════════════════════════════════ --}}
    <div class="row g-4 mb-4">

        {{-- 28-day heatmap --}}
        <div class="col-xl-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <div>
                        <div class="section-eyebrow mb-0">Last 28 Days</div>
                        <h5 class="mb-0 fw-bold">Focus Heatmap</h5>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span class="text-muted" style="font-size:.75rem;">Less</span>
                        @foreach(['#f1f5f9','#c7d2fe','#818cf8','#4f46e5','#3730a3'] as $hc)
                            <div style="width:14px;height:14px;border-radius:3px;background:{{ $hc }};"></div>
                        @endforeach
                        <span class="text-muted" style="font-size:.75rem;">More</span>
                    </div>
                </div>
                <div class="card-body">
                    {{-- Day labels --}}
                    <div class="heatmap-grid mb-1" style="margin-bottom:4px!important;">
                        @foreach(['M','T','W','T','F','S','S'] as $d)
                            <div style="text-align:center;font-size:.65rem;font-weight:700;color:#cbd5e1;text-transform:uppercase;">{{ $d }}</div>
                        @endforeach
                    </div>
                    <div class="heatmap-grid" id="heatmapGrid">
                        @foreach($heatmapData as $day => $count)
                            @php
                                $level = $count === 0 ? 0 : ($count <= 1 ? 1 : ($count <= 3 ? 2 : ($count <= 5 ? 3 : 4)));
                                $date  = now()->subDays(27 - $day)->format('d M');
                            @endphp
                            <div class="hm-cell"
                                 data-level="{{ $level }}"
                                 title="{{ $date }}: {{ $count }} session{{ $count != 1 ? 's' : '' }}">
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-3 d-flex gap-4">
                        @php
                            $totalHeatSessions = array_sum($heatmapData);
                            $activeDays = count(array_filter($heatmapData));
                        @endphp
                        <div>
                            <span class="fw-bold text-primary">{{ $totalHeatSessions }}</span>
                            <span class="text-muted ms-1" style="font-size:.82rem;">total sessions</span>
                        </div>
                        <div>
                            <span class="fw-bold text-primary">{{ $activeDays }}</span>
                            <span class="text-muted ms-1" style="font-size:.82rem;">active days</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Activity Feed --}}
        <div class="col-xl-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <div class="section-eyebrow mb-0">Live</div>
                    <h5 class="mb-0 fw-bold">Recent Remarks</h5>
                </div>
                <div class="card-body p-0" style="max-height:320px;overflow-y:auto;">
                    @forelse($remarks as $remark)
                        <div class="d-flex gap-3 px-4 py-3 border-bottom">
                            <div style="display:flex;flex-direction:column;align-items:center;flex-shrink:0;">
                                <div style="width:34px;height:34px;border-radius:50%;
                                            background:linear-gradient(135deg,#4f46e5,#7c3aed);
                                            display:flex;align-items:center;justify-content:center;
                                            color:#fff;font-weight:700;font-size:.8rem;">
                                    {{ strtoupper(substr($remark->task->title ?? 'T', 0, 1)) }}
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-start">
                                    <a href="{{ route('tasks.show', $remark->task) }}"
                                       class="fw-semibold text-dark text-decoration-none" style="font-size:.88rem;">
                                        {{ Str::limit($remark->task->title ?? 'Task', 28) }}
                                    </a>
                                    <small class="text-muted flex-shrink-0 ms-2" style="font-size:.7rem;">
                                        {{ $remark->created_at->diffForHumans(null, true) }}
                                    </small>
                                </div>
                                <p class="mb-0 text-muted" style="font-size:.82rem;line-height:1.5;margin-top:3px;">
                                    {{ Str::limit($remark->remark, 70) }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5 text-muted">
                            <i class="bi bi-chat-square d-block mb-2" style="font-size:2rem;"></i>
                            No remarks yet.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>

    {{-- ══════════════════════════════════════════════════
         QUICK ACTIONS STRIP
    ═══════════════════════════════════════════════════════ --}}
    <div class="row g-3 mb-4">
        @php
            $quickActions = [
                ['label'=>'New Task',      'icon'=>'bi-plus-circle-fill',  'color'=>'#4f46e5', 'bg'=>'rgba(79,70,229,.08)',   'route'=>route('tasks.create')],
                ['label'=>'Focus Mode',    'icon'=>'bi-stopwatch-fill',    'color'=>'#10b981', 'bg'=>'rgba(16,185,129,.1)',   'route'=>route('focus.index')],
                ['label'=>'View Tasks',    'icon'=>'bi-list-task',         'color'=>'#3b82f6', 'bg'=>'rgba(59,130,246,.1)',   'route'=>route('tasks.index')],
                ['label'=>'Overdue',       'icon'=>'bi-exclamation-circle','color'=>'#ef4444', 'bg'=>'rgba(239,68,68,.08)',   'route'=>route('tasks.index', ['due'=>'overdue'])],
                ['label'=>'Favorites',     'icon'=>'bi-star-fill',         'color'=>'#f59e0b', 'bg'=>'rgba(245,158,11,.1)',   'route'=>route('tasks.index')],
            ];
        @endphp
        @foreach($quickActions as $qa)
        <div class="col">
            <a href="{{ $qa['route'] }}"
               class="card border-0 shadow-sm text-decoration-none text-center py-3 px-2 d-block"
               style="border-radius:16px;transition:.22s;"
               onmouseover="this.style.transform='translateY(-4px)';this.style.boxShadow='0 12px 28px rgba(0,0,0,.1)'"
               onmouseout="this.style.transform='';this.style.boxShadow=''">
                <div style="width:48px;height:48px;border-radius:14px;background:{{ $qa['bg'] }};
                             display:flex;align-items:center;justify-content:center;margin:0 auto 10px;font-size:1.2rem;color:{{ $qa['color'] }};">
                    <i class="bi {{ $qa['icon'] }}"></i>
                </div>
                <div style="font-size:.82rem;font-weight:700;color:#334155;">{{ $qa['label'] }}</div>
            </a>
        </div>
        @endforeach
    </div>

</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    /*── Score ring animate ───────────────────────────────────────────*/
    const fill = document.getElementById('scoreRingFill');
    const scoreNum = document.getElementById('scoreNum');
    const targetOffset = parseInt(fill?.dataset.offset || 295);
    const targetScore  = {{ $productivity }};

    if (fill) {
        requestAnimationFrame(() => {
            setTimeout(() => {
                fill.style.strokeDashoffset = targetOffset;
            }, 300);
        });
    }

    // Count-up for score ring
    if (scoreNum) {
        let current = 0;
        const step  = Math.ceil(targetScore / 60);
        const tick  = setInterval(() => {
            current = Math.min(current + step, targetScore);
            scoreNum.textContent = current;
            if (current >= targetScore) clearInterval(tick);
        }, 20);
    }

    /*── KPI count-up ────────────────────────────────────────────────*/
    document.querySelectorAll('.count-up[data-target]').forEach(el => {
        const target = parseInt(el.dataset.target || 0);
        if (target === 0) return;
        let current  = 0;
        const step   = Math.max(1, Math.ceil(target / 40));
        const tick   = setInterval(() => {
            current = Math.min(current + step, target);
            // Keep suffix (e.g. "m" for minutes)
            const suffix = el.textContent.replace(/[\d]/g, '').trim();
            el.textContent = current + (suffix || '');
            if (current >= target) clearInterval(tick);
        }, 25);
    });

    /*── Weekly Chart ────────────────────────────────────────────────*/
    const ctx = document.getElementById('weeklyChart');
    if (ctx && typeof Chart !== 'undefined') {
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [
                    {
                        label: 'Completed',
                        data: @json($weeklyChart),
                        backgroundColor: (context) => {
                            const chart = context.chart;
                            const { ctx: c, chartArea } = chart;
                            if (!chartArea) return '#4f46e5';
                            const gradient = c.createLinearGradient(0, chartArea.top, 0, chartArea.bottom);
                            gradient.addColorStop(0, '#4f46e5');
                            gradient.addColorStop(1, '#818cf8');
                            return gradient;
                        },
                        borderRadius: 8,
                        borderSkipped: false,
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: ctx => ' ' + ctx.raw + ' tasks done',
                        },
                        backgroundColor: '#1e293b',
                        titleColor: '#94a3b8',
                        bodyColor: '#fff',
                        cornerRadius: 10,
                        padding: 10,
                    },
                },
                scales: {
                    x: {
                        grid: { display: false },
                        border: { display: false },
                        ticks: { color: '#94a3b8', font: { weight: '600', size: 12 } },
                    },
                    y: {
                        grid: { color: '#f1f5f9', lineWidth: 1 },
                        border: { display: false },
                        ticks: { color: '#94a3b8', font: { size: 11 }, stepSize: 1 },
                        beginAtZero: true,
                    },
                },
            },
        });
    }

    /*── Heatmap tooltip (Bootstrap) ─────────────────────────────────*/
    document.querySelectorAll('.hm-cell[title]').forEach(cell => {
        new bootstrap.Tooltip(cell, { placement: 'top', trigger: 'hover' });
    });

});
</script>
@endpush