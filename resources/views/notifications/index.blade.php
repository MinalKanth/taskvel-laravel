@extends('layouts.app')

@section('title', 'Notifications')

@push('styles')
<style>
/*══════════════════════════════════════════════
  NOTIFICATION CENTER — Premium
══════════════════════════════════════════════*/

/* Hero header */
.notif-hero {
    background: linear-gradient(135deg, #1e1b4b 0%, #312e81 60%, #4338ca 100%);
    border-radius: 20px;
    padding: 28px 32px;
    color: #fff;
    margin-bottom: 24px;
    position: relative;
    overflow: hidden;
}
.notif-hero::before {
    content: '';
    position: absolute;
    width: 250px; height: 250px;
    border-radius: 50%;
    background: rgba(255,255,255,.05);
    top: -80px; right: -60px;
    pointer-events: none;
}

/* Stat pills */
.notif-stat {
    background: rgba(255,255,255,.12);
    border: 1px solid rgba(255,255,255,.18);
    border-radius: 12px;
    padding: 10px 18px;
    text-align: center;
    min-width: 90px;
}
.notif-stat-num  { font-size: 1.5rem; font-weight: 800; line-height: 1; }
.notif-stat-label{ font-size: .7rem; font-weight: 600; opacity: .65;
                   text-transform: uppercase; letter-spacing: .05em; }

/* Filter tabs */
.notif-tab {
    border: none; background: none; padding: 8px 16px;
    border-radius: 999px; font-weight: 600; font-size: .83rem;
    color: #64748b; transition: .2s; cursor: pointer;
}
.notif-tab:hover  { background: #f1f5f9; color: #334155; }
.notif-tab.active { background: #4f46e5; color: #fff; box-shadow: 0 4px 12px rgba(79,70,229,.25); }
.notif-tab .count-pill {
    display: inline-flex; align-items: center; justify-content: center;
    width: 18px; height: 18px; border-radius: 50%;
    background: rgba(255,255,255,.3); font-size: .65rem; font-weight: 700;
    margin-left: 5px;
}
.notif-tab:not(.active) .count-pill { background: #e2e8f0; color: #64748b; }

/* Notification card */
.notif-card {
    border-radius: 16px;
    border: 1px solid #f1f5f9;
    background: #fff;
    transition: box-shadow .2s, border-color .2s, transform .2s;
    overflow: hidden;
    position: relative;
}
.notif-card:hover {
    box-shadow: 0 8px 24px rgba(0,0,0,.08);
    border-color: #e2e8f0;
    transform: translateX(3px);
}
.notif-card.unread { border-left: 4px solid #4f46e5; background: #fafbff; }
.notif-card.unread .notif-card-body { padding-left: 16px; }

/* Unread dot pulse */
@keyframes pulse {
    0%,100% { box-shadow: 0 0 0 0 rgba(79,70,229,.4); }
    50%      { box-shadow: 0 0 0 6px rgba(79,70,229,0); }
}
.unread-dot {
    width: 9px; height: 9px; border-radius: 50%;
    background: #4f46e5; flex-shrink: 0; margin-top: 6px;
    animation: pulse 2s infinite;
}

/* Type icon */
.notif-icon {
    width: 44px; height: 44px; border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.15rem; flex-shrink: 0;
}

/* Priority strip */
.priority-strip {
    position: absolute; top: 0; bottom: 0; left: 0; width: 3px;
    border-radius: 16px 0 0 16px;
}

/* Action buttons */
.notif-btn {
    border: none; background: none; padding: 4px 10px;
    font-size: .75rem; font-weight: 600; border-radius: 8px;
    cursor: pointer; transition: .15s; display: inline-flex;
    align-items: center; gap: 4px; color: #64748b;
}
.notif-btn:hover        { background: #f1f5f9; color: #334155; }
.notif-btn.danger:hover { background: #fef2f2; color: #ef4444; }
.notif-btn.primary:hover{ background: rgba(79,70,229,.08); color: #4f46e5; }

/* Bulk action bar */
.bulk-bar {
    background: #fff; border: 1px solid #e2e8f0;
    border-radius: 14px; padding: 10px 16px;
    display: none; align-items: center; gap: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,.06);
    position: sticky; top: 12px; z-index: 100;
    margin-bottom: 16px;
}
.bulk-bar.show { display: flex; }
.bulk-count { font-weight: 700; color: #4f46e5; font-size: .88rem; }

/* Group date divider */
.date-divider {
    display: flex; align-items: center; gap: 12px;
    margin: 20px 0 12px;
}
.date-divider-line { flex: 1; height: 1px; background: #f1f5f9; }
.date-divider-label {
    font-size: .72rem; font-weight: 700; color: #94a3b8;
    text-transform: uppercase; letter-spacing: .08em;
    white-space: nowrap;
}

/* Empty state */
.notif-empty { text-align: center; padding: 80px 24px; }
.notif-empty-icon { font-size: 4rem; color: #e2e8f0; margin-bottom: 16px; }

/* Slide in */
@keyframes slideIn {
    from { opacity: 0; transform: translateY(10px); }
    to   { opacity: 1; transform: translateY(0); }
}
.notif-card { animation: slideIn .3s ease both; }
@for($i=1;$i<=20;$i++)
.notif-card:nth-child({{ $i }}) { animation-delay: {{ ($i-1)*0.03 }}s; }
@endfor
</style>
@endpush

@section('content')

@php
    $typeConfig = [
        'task'     => ['icon'=>'bi-list-check',      'bg'=>'rgba(79,70,229,.1)',   'color'=>'#4f46e5', 'label'=>'Task'],
        'focus'    => ['icon'=>'bi-stopwatch-fill',  'bg'=>'rgba(16,185,129,.1)',  'color'=>'#10b981', 'label'=>'Focus'],
        'remark'   => ['icon'=>'bi-chat-left-text',  'bg'=>'rgba(245,158,11,.1)',  'color'=>'#f59e0b', 'label'=>'Remark'],
        'reminder' => ['icon'=>'bi-alarm-fill',      'bg'=>'rgba(239,68,68,.1)',   'color'=>'#ef4444', 'label'=>'Reminder'],
        'system'   => ['icon'=>'bi-gear-fill',       'bg'=>'rgba(100,116,139,.1)', 'color'=>'#64748b', 'label'=>'System'],
    ];
    $priorityColors = ['high'=>'#ef4444','medium'=>'#f59e0b','low'=>'#10b981'];

    $allCount      = $notifications->total();
    $unreadCount   = $notifications->getCollection()->where('is_read', false)->count();
    $readCount     = $notifications->getCollection()->where('is_read', true)->count();
    $todayCount    = $notifications->getCollection()->filter(fn($n) => $n->created_at->isToday())->count();

    // Group by date for timeline display
    $grouped = $notifications->getCollection()->groupBy(fn($n) => $n->created_at->isToday()
        ? 'Today'
        : ($n->created_at->isYesterday() ? 'Yesterday' : $n->created_at->format('d M Y'))
    );

    $activeFilter = request('filter', 'all');
    $activeType   = request('type', '');
@endphp

<div class="container-fluid px-3 px-lg-4">

    {{-- ── Hero ──────────────────────────────────────────────────────────── --}}
    <div class="notif-hero">
        <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
            <div>
                <div style="font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:rgba(255,255,255,.5);margin-bottom:6px;">
                    Notification Center
                </div>
                <h2 class="fw-bold mb-1" style="font-size:1.6rem;">
                    @if($unreadCount > 0)
                        You have <span style="color:#a5f3fc;">{{ $unreadCount }}</span> unread
                        notification{{ $unreadCount > 1 ? 's' : '' }}
                    @else
                        You're all caught up 🎉
                    @endif
                </h2>
                <p style="color:rgba(255,255,255,.6);font-size:.9rem;margin-bottom:20px;">
                    Stay on top of task updates, reminders and focus milestones.
                </p>

                <div class="d-flex gap-2 flex-wrap">
                    <form action="{{ route('notifications.readAll') }}" method="POST" class="d-inline">
                        @csrf
                        <button class="btn btn-sm fw-semibold px-3"
                                style="background:#fff;color:#4338ca;border-radius:999px;">
                            <i class="bi bi-check2-all me-1"></i>Mark All Read
                        </button>
                    </form>
                    <form action="{{ route('notifications.clearRead') }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm fw-semibold px-3"
                                style="background:rgba(255,255,255,.15);color:#fff;border-radius:999px;border:1px solid rgba(255,255,255,.25);">
                            <i class="bi bi-trash me-1"></i>Clear Read
                        </button>
                    </form>
                    <a href="{{ route('dashboard') }}"
                       class="btn btn-sm fw-semibold px-3"
                       style="background:rgba(255,255,255,.15);color:#fff;border-radius:999px;border:1px solid rgba(255,255,255,.25);">
                        <i class="bi bi-arrow-left me-1"></i>Dashboard
                    </a>
                </div>
            </div>

            {{-- Stats --}}
            <div class="d-flex gap-2 flex-wrap">
                <div class="notif-stat">
                    <div class="notif-stat-num">{{ $allCount }}</div>
                    <div class="notif-stat-label">Total</div>
                </div>
                <div class="notif-stat">
                    <div class="notif-stat-num" style="color:#a5f3fc;">{{ $unreadCount }}</div>
                    <div class="notif-stat-label">Unread</div>
                </div>
                <div class="notif-stat">
                    <div class="notif-stat-num" style="color:#86efac;">{{ $readCount }}</div>
                    <div class="notif-stat-label">Read</div>
                </div>
                <div class="notif-stat">
                    <div class="notif-stat-num" style="color:#fde68a;">{{ $todayCount }}</div>
                    <div class="notif-stat-label">Today</div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Flash --}}
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4" style="border-radius:14px;">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        </div>
    @endif

    {{-- ── Filter Row ──────────────────────────────────────────────────────── --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body py-3">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                {{-- Read/unread tabs --}}
                <div class="d-flex gap-1 flex-wrap">
                    @foreach([
                        ['key'=>'all',    'label'=>'All',    'cnt'=>$allCount],
                        ['key'=>'unread', 'label'=>'Unread', 'cnt'=>$unreadCount],
                        ['key'=>'read',   'label'=>'Read',   'cnt'=>$readCount],
                    ] as $tab)
                        <a href="{{ route('notifications.index', array_merge(request()->query(), ['filter'=>$tab['key']])) }}"
                           class="notif-tab {{ $activeFilter === $tab['key'] ? 'active' : '' }}">
                            {{ $tab['label'] }}
                            <span class="count-pill">{{ $tab['cnt'] }}</span>
                        </a>
                    @endforeach
                </div>

                {{-- Type + sort filters --}}
                <form method="GET" class="d-flex gap-2 flex-wrap align-items-center">
                    <input type="hidden" name="filter" value="{{ $activeFilter }}">
                    <select name="type" class="form-select form-select-sm" style="width:auto;border-radius:10px;"
                            onchange="this.form.submit()">
                        <option value="">All types</option>
                        @foreach(['task','focus','remark','reminder','system'] as $t)
                            <option value="{{ $t }}" @selected($activeType===$t)>{{ ucfirst($t) }}</option>
                        @endforeach
                    </select>
                    <select name="sort" class="form-select form-select-sm" style="width:auto;border-radius:10px;"
                            onchange="this.form.submit()">
                        <option value="newest" @selected(request('sort','newest')==='newest')>Newest first</option>
                        <option value="oldest" @selected(request('sort')==='oldest')>Oldest first</option>
                        <option value="priority" @selected(request('sort')==='priority')>By priority</option>
                    </select>
                </form>

            </div>
        </div>
    </div>

    {{-- ── Bulk Action Bar ─────────────────────────────────────────────────── --}}
    <div class="bulk-bar" id="bulkBar">
        <input type="checkbox" id="masterCheck" class="form-check-input me-1">
        <span class="bulk-count" id="bulkCount">0 selected</span>
        <form method="POST" action="{{ route('notifications.readAll') }}" class="d-inline" id="bulkReadForm">
            @csrf
            <button type="submit" class="btn btn-sm btn-primary" style="border-radius:8px;">
                <i class="bi bi-check2-all me-1"></i>Mark selected read
            </button>
        </form>
        <button class="btn btn-sm btn-outline-danger ms-auto" style="border-radius:8px;" id="bulkDeleteBtn">
            <i class="bi bi-trash me-1"></i>Delete selected
        </button>
    </div>

    {{-- ── Notification Feed ───────────────────────────────────────────────── --}}
    @forelse($grouped as $dateLabel => $group)

        <div class="date-divider">
            <div class="date-divider-line"></div>
            <div class="date-divider-label">{{ $dateLabel }}</div>
            <div class="date-divider-line"></div>
        </div>

        @foreach($group as $notification)
            @php
                $cfg      = $typeConfig[$notification->type] ?? $typeConfig['system'];
                $isUnread = !$notification->is_read;
                $priority = $notification->priority ?? 'medium';
                $stripClr = $priorityColors[$priority] ?? '#94a3b8';
            @endphp

            <div class="notif-card mb-3 {{ $isUnread ? 'unread' : '' }}" data-id="{{ $notification->id }}">

                {{-- Priority strip (right edge) --}}
                <div class="priority-strip" style="background:{{ $stripClr }};"></div>

                <div class="notif-card-body p-3 ps-4">
                    <div class="d-flex gap-3 align-items-start">

                        {{-- Checkbox --}}
                        <div class="pt-1">
                            <input type="checkbox" class="form-check-input notif-check"
                                   value="{{ $notification->id }}"
                                   style="width:15px;height:15px;cursor:pointer;">
                        </div>

                        {{-- Unread dot --}}
                        @if($isUnread)
                            <div class="unread-dot"></div>
                        @else
                            <div style="width:9px;flex-shrink:0;"></div>
                        @endif

                        {{-- Type icon --}}
                        <div class="notif-icon" style="background:{{ $cfg['bg'] }};color:{{ $cfg['color'] }};">
                            <i class="bi {{ $cfg['icon'] }}"></i>
                        </div>

                        {{-- Content --}}
                        <div class="flex-grow-1 min-width-0">
                            <div class="d-flex justify-content-between align-items-start gap-2 flex-wrap">
                                <div>
                                    <div class="d-flex align-items-center gap-2 flex-wrap mb-1">
                                        <span class="fw-bold" style="font-size:.95rem;">
                                            {{ $notification->title }}
                                        </span>
                                        {{-- Type badge --}}
                                        <span class="badge" style="background:{{ $cfg['bg'] }};color:{{ $cfg['color'] }};font-size:.65rem;font-weight:700;">
                                            {{ $cfg['label'] }}
                                        </span>
                                        {{-- Priority badge --}}
                                        @if($priority === 'high')
                                            <span class="badge bg-danger" style="font-size:.65rem;">High</span>
                                        @elseif($priority === 'medium')
                                            <span class="badge bg-warning text-dark" style="font-size:.65rem;">Medium</span>
                                        @endif
                                        {{-- Unread badge --}}
                                        @if($isUnread)
                                            <span class="badge bg-primary" style="font-size:.62rem;border-radius:999px;">New</span>
                                        @endif
                                    </div>
                                    <p class="text-muted mb-1" style="font-size:.87rem;line-height:1.6;">
                                        {{ $notification->message }}
                                    </p>
                                    <div class="d-flex align-items-center gap-3 flex-wrap">
                                        <span class="text-muted" style="font-size:.75rem;">
                                            <i class="bi bi-clock me-1"></i>
                                            {{ $notification->created_at->diffForHumans() }}
                                        </span>
                                        @if($notification->read_at)
                                            <span class="text-muted" style="font-size:.75rem;">
                                                <i class="bi bi-eye me-1"></i>
                                                Read {{ \Carbon\Carbon::parse($notification->read_at)->diffForHumans() }}
                                            </span>
                                        @endif
                                        @if($notification->scheduled_at)
                                            <span style="font-size:.75rem;color:#f59e0b;font-weight:600;">
                                                <i class="bi bi-alarm me-1"></i>
                                                Scheduled {{ \Carbon\Carbon::parse($notification->scheduled_at)->format('d M, H:i') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                {{-- Actions --}}
                                <div class="d-flex flex-column gap-1 flex-shrink-0 align-items-end">
                                    @if($isUnread)
                                        <form action="{{ route('notifications.read', $notification) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="notif-btn primary">
                                                <i class="bi bi-check2"></i> Mark read
                                            </button>
                                        </form>
                                    @else
                                        <span class="notif-btn" style="cursor:default;color:#10b981;">
                                            <i class="bi bi-check2-all"></i> Read
                                        </span>
                                    @endif

                                    @if(isset($notification->data['task_id']))
                                        <a href="{{ route('tasks.show', $notification->data['task_id']) }}"
                                           class="notif-btn primary">
                                            <i class="bi bi-arrow-right"></i> View task
                                        </a>
                                    @endif

                                    <form action="{{ route('notifications.destroy', $notification) }}"
                                          method="POST"
                                          onsubmit="return confirm('Delete this notification?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="notif-btn danger">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        @endforeach

    @empty
        <div class="card border-0 shadow-sm">
            <div class="notif-empty">
                <div class="notif-empty-icon"><i class="bi bi-bell-slash"></i></div>
                <h4 class="fw-bold mb-2">
                    @if($activeFilter === 'unread') No unread notifications
                    @elseif($activeFilter === 'read') No read notifications
                    @else No notifications yet
                    @endif
                </h4>
                <p class="text-muted mb-0">
                    @if($activeFilter === 'unread') All caught up — nothing new to read.
                    @elseif($activeType) No {{ $activeType }} notifications found.
                    @else Task updates, reminders and focus milestones will appear here.
                    @endif
                </p>
                @if($activeFilter !== 'all' || $activeType)
                    <a href="{{ route('notifications.index') }}" class="btn btn-outline-primary mt-3 btn-sm">
                        <i class="bi bi-x me-1"></i>Clear filters
                    </a>
                @endif
            </div>
        </div>
    @endforelse

    {{-- Pagination --}}
    @if($notifications->hasPages())
        <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap gap-2">
            <small class="text-muted">
                Showing {{ $notifications->firstItem() }}–{{ $notifications->lastItem() }}
                of {{ $notifications->total() }} notifications
            </small>
            {{ $notifications->links() }}
        </div>
    @endif

</div>
@endsection

@push('scripts')
<script>
'use strict';

/*── Bulk selection ───────────────────────────────────────────────────*/
const checks    = document.querySelectorAll('.notif-check');
const bulkBar   = document.getElementById('bulkBar');
const bulkCount = document.getElementById('bulkCount');
const master    = document.getElementById('masterCheck');

function updateBulk() {
    const selected = [...checks].filter(c => c.checked);
    const n = selected.length;
    bulkCount.textContent = n + ' selected';
    bulkBar.classList.toggle('show', n > 0);
    master.indeterminate = n > 0 && n < checks.length;
    master.checked = n === checks.length;
}

checks.forEach(c => c.addEventListener('change', updateBulk));

master?.addEventListener('change', function () {
    checks.forEach(c => { c.checked = this.checked; });
    updateBulk();
});

/*── Bulk delete (multi-form submit) ─────────────────────────────────*/
document.getElementById('bulkDeleteBtn')?.addEventListener('click', function () {
    const selected = [...checks].filter(c => c.checked).map(c => c.value);
    if (!selected.length) return;
    if (!confirm('Delete ' + selected.length + ' notification(s)?')) return;

    selected.forEach(id => {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/notifications/' + id;
        form.innerHTML = `
            @csrf
            <input name="_method" value="DELETE">
        `;
        document.body.appendChild(form);
        form.submit();
    });
});

/*── Auto-dismiss flash ───────────────────────────────────────────────*/
const flash = document.querySelector('.alert-success');
if (flash) setTimeout(() => {
    flash.style.transition = 'opacity .5s';
    flash.style.opacity = '0';
    setTimeout(() => flash.remove(), 500);
}, 3000);
</script>
@endpush