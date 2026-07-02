@extends('layouts.app')

@section('title', 'Export Data')

@section('content')

@php
    $user        = auth()->user();
    $taskCount   = $user->tasks()->count();
    $focusCount  = $user->focusSessions()->count();
    $focusMins   = $user->focusSessions()->where('completed',true)->sum('actual_minutes');
    $remarkCount = \App\Models\Remark::where('user_id',$user->id)->count();
    $tagCount    = $user->tags()->count();
    $previewTasks = $user->tasks()->with('tags')->latest()->take(5)->get();
@endphp

<div class="export-page">

{{-- ════════════════════════════════════════════════
     HERO
════════════════════════════════════════════════════ --}}
<div class="export-hero">
    <div class="hero-glow hero-glow-1"></div>
    <div class="hero-glow hero-glow-2"></div>
    <div class="hero-glow hero-glow-3"></div>

    <div class="d-flex justify-content-between align-items-start flex-wrap gap-4">
        <div style="position:relative;z-index:1;">
            <div class="hero-badge">
                <i class="bi bi-cloud-arrow-down-fill"></i>
                Data Export Center
            </div>
            <h1 class="hero-title">Export Your Taskvel Data</h1>
            <p class="hero-subtitle">
                Download tasks, focus sessions, remarks and productivity reports
                in PDF, Excel, CSV or JSON — filtered exactly how you need.
            </p>

            {{-- Live data pills --}}
            <div class="d-flex gap-2 flex-wrap mt-4">
                @foreach([
                    ['num'=>$taskCount,                          'label'=>'Tasks',        'icon'=>'bi-list-task'],
                    ['num'=>$focusCount,                         'label'=>'Sessions',     'icon'=>'bi-stopwatch'],
                    ['num'=>$remarkCount,                        'label'=>'Remarks',      'icon'=>'bi-chat-left-text'],
                    ['num'=>round($focusMins/60,1).'h',          'label'=>'Focus',        'icon'=>'bi-clock'],
                    ['num'=>$tagCount,                           'label'=>'Tags',         'icon'=>'bi-tags'],
                ] as $s)
                <div class="hero-pill">
                    <i class="bi {{ $s['icon'] }} me-1" style="opacity:.7;"></i>
                    <strong>{{ $s['num'] }}</strong>
                    <span>{{ $s['label'] }}</span>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Productivity ring --}}
        <div class="hero-ring-wrap" style="position:relative;z-index:1;">
            @php
                $total     = $taskCount ?: 1;
                $completed = $user->tasks()->where('status','completed')->count();
                $pct       = round(($completed/$total)*100);
                $offset    = 314 - round(($pct/100)*314);
            @endphp
            <svg width="120" height="120" viewBox="0 0 120 120" style="transform:rotate(-90deg);">
                <circle cx="60" cy="60" r="50" fill="none" stroke="rgba(255,255,255,.12)" stroke-width="10"/>
                <circle cx="60" cy="60" r="50" fill="none"
                        stroke="rgba(255,255,255,.85)" stroke-width="10"
                        stroke-linecap="round"
                        stroke-dasharray="314"
                        stroke-dashoffset="{{ $offset }}"
                        id="heroRing"
                        style="transition:stroke-dashoffset 1.4s cubic-bezier(.4,0,.2,1);"/>
            </svg>
            <div class="hero-ring-inner">
                <div class="hero-ring-num" id="heroRingNum">0</div>
                <div class="hero-ring-label">Done</div>
            </div>
        </div>
    </div>

    <a href="{{ route('dashboard') }}" class="hero-back-btn">
        <i class="bi bi-arrow-left"></i> Dashboard
    </a>
</div>

{{-- ════════════════════════════════════════════════
     MAIN GRID
════════════════════════════════════════════════════ --}}
<div class="row g-4">

    {{-- ── LEFT — Builder ────────────────────────────────────────────── --}}
    <div class="col-xl-8">

        <form method="POST" action="{{ route('export.download') }}" id="exportForm">
        @csrf
        <input type="hidden" name="type"   id="typeInput"   value="tasks">
        <input type="hidden" name="format" id="formatInput" value="csv">

        {{-- ── Step 1: Data Source ─────────────────────────────────── --}}
        <div class="ec">
            <div class="ec-head">
                <div class="step-num">1</div>
                <div>
                    <div class="ec-title">Data Source</div>
                    <div class="ec-sub">What do you want to export?</div>
                </div>
            </div>
            <div class="type-grid" id="typeGrid">
                @php
                    $types = [
                        ['key'=>'tasks',   'icon'=>'bi-check2-square',        'grad'=>'#6d5efc,#a06dfc','label'=>'Tasks',
                         'desc'=>$taskCount.' records','badge'=>''],
                        ['key'=>'focus',   'icon'=>'bi-stopwatch-fill',       'grad'=>'#3b9dfc,#6dc6fc','label'=>'Focus Sessions',
                         'desc'=>$focusCount.' records','badge'=>''],
                        ['key'=>'remarks', 'icon'=>'bi-chat-left-text-fill',  'grad'=>'#f59e0b,#fbbf24','label'=>'Remarks',
                         'desc'=>$remarkCount.' records','badge'=>''],
                        ['key'=>'summary', 'icon'=>'bi-bar-chart-line-fill',  'grad'=>'#10b981,#34d399','label'=>'Summary',
                         'desc'=>'Key metrics','badge'=>''],
                        ['key'=>'full',    'icon'=>'bi-archive-fill',         'grad'=>'#ef4444,#f87171','label'=>'Full Export',
                         'desc'=>'Everything','badge'=>'New'],
                    ];
                @endphp
                @foreach($types as $t)
                <button type="button"
                        class="type-card {{ $loop->first ? 'active':'' }}"
                        data-type="{{ $t['key'] }}"
                        data-count="{{ $t['desc'] }}">
                    @if($t['badge'])
                        <span class="type-badge">{{ $t['badge'] }}</span>
                    @endif
                    <div class="type-icon" style="background:linear-gradient(135deg,{{ $t['grad'] }});">
                        <i class="bi {{ $t['icon'] }}"></i>
                    </div>
                    <div class="type-label">{{ $t['label'] }}</div>
                    <div class="type-desc">{{ $t['desc'] }}</div>
                </button>
                @endforeach
            </div>
        </div>

        {{-- ── Step 2: Format ──────────────────────────────────────── --}}
        <div class="ec">
            <div class="ec-head">
                <div class="step-num">2</div>
                <div>
                    <div class="ec-title">File Format</div>
                    <div class="ec-sub">Pick the output format for your download.</div>
                </div>
            </div>
            <div class="format-grid">
                @php
                    $formats = [
                        ['key'=>'csv',   'icon'=>'bi-filetype-csv',            'grad'=>'#6d5efc,#a06dfc',
                         'label'=>'CSV', 'tag'=>'Universal',    'pros'=>['Smallest size','Opens anywhere','UTF-8 encoded']],
                        ['key'=>'excel', 'icon'=>'bi-file-earmark-excel-fill', 'grad'=>'#10b981,#34d399',
                         'label'=>'Excel','tag'=>'Popular',     'pros'=>['Rich formatting','Multi-sheet','Formulas ready']],
                        ['key'=>'pdf',   'icon'=>'bi-file-earmark-pdf-fill',   'grad'=>'#ef4444,#f87171',
                         'label'=>'PDF', 'tag'=>'Print-ready',  'pros'=>['Branded layout','Charts included','Shareable']],
                        ['key'=>'json',  'icon'=>'bi-braces',                  'grad'=>'#f59e0b,#fbbf24',
                         'label'=>'JSON','tag'=>'Developer',    'pros'=>['Full structure','API-ready','All relations']],
                    ];
                @endphp
                @foreach($formats as $fmt)
                <label class="format-card {{ $loop->first ? 'selected':'' }}"
                       id="fmt_{{ $fmt['key'] }}">
                    <input type="radio" name="_fmt_display" value="{{ $fmt['key'] }}"
                           class="visually-hidden fmt-radio" {{ $loop->first ? 'checked':'' }}>
                    <div class="fmt-top">
                        <div class="fmt-icon" style="background:linear-gradient(135deg,{{ $fmt['grad'] }});">
                            <i class="bi {{ $fmt['icon'] }}"></i>
                        </div>
                        <div class="fmt-check"><i class="bi bi-check-circle-fill"></i></div>
                    </div>
                    <div class="fmt-label">{{ $fmt['label'] }}</div>
                    <div class="fmt-tag">{{ $fmt['tag'] }}</div>
                    <ul class="fmt-pros">
                        @foreach($fmt['pros'] as $p)
                            <li><i class="bi bi-check2 me-1"></i>{{ $p }}</li>
                        @endforeach
                    </ul>
                </label>
                @endforeach
            </div>
        </div>

        {{-- ── Step 3: Filters ─────────────────────────────────────── --}}
        <div class="ec">
            <div class="ec-head">
                <div class="step-num">3</div>
                <div>
                    <div class="ec-title">Filters</div>
                    <div class="ec-sub">Narrow your export by date, status or priority.</div>
                </div>
                <button type="button" class="ms-auto clr-btn" id="clearFilters">
                    <i class="bi bi-x me-1"></i>Clear
                </button>
            </div>

            {{-- Date presets --}}
            <div class="preset-row mb-3">
                @foreach([
                    ['r'=>'today',  'l'=>'Today'],
                    ['r'=>'week',   'l'=>'This week'],
                    ['r'=>'month',  'l'=>'This month'],
                    ['r'=>'30d',    'l'=>'Last 30 days'],
                    ['r'=>'90d',    'l'=>'Last 90 days'],
                    ['r'=>'year',   'l'=>'This year'],
                    ['r'=>'all',    'l'=>'All time'],
                ] as $p)
                    <button type="button" class="pchip {{ $loop->last ? 'active':'' }}"
                            data-r="{{ $p['r'] }}">{{ $p['l'] }}</button>
                @endforeach
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="ex-label">From Date</label>
                    <div class="ex-inp-w"><i class="bi bi-calendar3"></i>
                        <input type="date" name="from_date" id="fromDate" class="ex-inp">
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="ex-label">To Date</label>
                    <div class="ex-inp-w"><i class="bi bi-calendar3"></i>
                        <input type="date" name="to_date" id="toDate" class="ex-inp">
                    </div>
                </div>
            </div>

            <div class="row g-3 task-only">
                <div class="col-md-4">
                    <label class="ex-label">Status</label>
                    <div class="ex-inp-w"><i class="bi bi-flag-fill"></i>
                        <select name="status" class="ex-inp">
                            <option value="">All Status</option>
                            <option value="pending">Pending</option>
                            <option value="in_progress">In Progress</option>
                            <option value="completed">Completed</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="ex-label">Priority</label>
                    <div class="ex-inp-w"><i class="bi bi-exclamation-diamond-fill"></i>
                        <select name="priority" class="ex-inp">
                            <option value="">All Priorities</option>
                            <option value="low">Low</option>
                            <option value="medium">Medium</option>
                            <option value="high">High</option>
                            <option value="urgent">Urgent</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="ex-label">Include</label>
                    <div class="ex-inp-w"><i class="bi bi-archive-fill"></i>
                        <select name="include" class="ex-inp">
                            <option value="active">Active only</option>
                            <option value="archived">Archived only</option>
                            <option value="all">All records</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Step 4: Columns ─────────────────────────────────────── --}}
        <div class="ec task-only" id="colsCard">
            <div class="ec-head">
                <div class="step-num">4</div>
                <div>
                    <div class="ec-title">Columns</div>
                    <div class="ec-sub">Choose and reorder the fields to include.</div>
                </div>
                <div class="ms-auto d-flex gap-2">
                    <button type="button" class="clr-btn" id="allCols">All</button>
                    <button type="button" class="clr-btn" id="noneCols">None</button>
                </div>
            </div>
            <div class="col-chips" id="colChips">
                @php
                    $cols = [
                        'title'=>'Title','description'=>'Description','priority'=>'Priority',
                        'status'=>'Status','progress'=>'Progress','category'=>'Category',
                        'due_date'=>'Due Date','reminder_at'=>'Reminder','recurrence'=>'Recurrence',
                        'estimated_minutes'=>'Est. Minutes','actual_minutes'=>'Actual Minutes',
                        'tags'=>'Tags','notes'=>'Notes','urgency'=>'Urgency','impact'=>'Impact',
                        'is_favorite'=>'Favorite','is_pinned'=>'Pinned',
                        'completed_at'=>'Completed At','created_at'=>'Created At',
                    ];
                    $defaultOn = ['title','priority','status','progress','due_date','tags','created_at'];
                @endphp
                @foreach($cols as $k => $v)
                    <label class="col-chip {{ in_array($k,$defaultOn)?'on':'' }}" draggable="true">
                        <i class="bi bi-grip-vertical drag-h"></i>
                        <input type="checkbox" name="columns[]" value="{{ $k }}"
                               {{ in_array($k,$defaultOn)?'checked':'' }} class="visually-hidden">
                        {{ $v }}
                    </label>
                @endforeach
            </div>
            <p class="text-muted mt-2" style="font-size:.75rem;">
                <i class="bi bi-info-circle me-1"></i>Drag to reorder columns in the export file.
            </p>
        </div>

        {{-- ── Submit bar ──────────────────────────────────────────── --}}
        <div class="ec submit-bar">
            <div class="submit-summary" id="submitSummary">
                Exporting <strong>Tasks</strong> · <strong>CSV</strong> · All time
            </div>
            <div class="d-flex gap-3 align-items-center flex-wrap">
                <div class="text-muted" style="font-size:.8rem;">
                    <i class="bi bi-shield-check text-success me-1"></i>
                    Secure download — never stored on our servers
                </div>
                <button type="submit" class="export-btn" id="exportBtn">
                    <i class="bi bi-download me-2"></i>Export Now
                </button>
            </div>
        </div>

        </form>
    </div>

    {{-- ── RIGHT — Sidebar ────────────────────────────────────────── --}}
    <div class="col-xl-4">

        {{-- Live preview --}}
        <div class="ec mb-4">
            <div class="ec-head mb-3">
                <div class="step-num" style="background:linear-gradient(135deg,#10b981,#34d399);">
                    <i class="bi bi-eye" style="font-size:.75rem;"></i>
                </div>
                <div><div class="ec-title">Live Preview</div></div>
            </div>
            <div class="preview-file-pill" id="previewPill">
                <i class="bi bi-file-earmark-text text-primary fs-5"></i>
                <div>
                    <div class="fw-semibold" style="font-size:.82rem;" id="previewName">tasks_{{ now()->format('Ymd') }}.csv</div>
                    <div class="text-muted" style="font-size:.7rem;" id="previewMeta">{{ $taskCount }} records · CSV</div>
                </div>
                <span class="badge bg-light text-secondary border ms-auto" style="font-size:.65rem;" id="previewFmt">CSV</span>
            </div>
            <div style="overflow-x:auto;border-radius:10px;border:1px solid #f1f5f9;margin-top:12px;">
                <table class="table table-sm mb-0" style="font-size:.72rem;" id="previewTable">
                    <thead style="background:#f8fafc;">
                        <tr>
                            <th style="padding:8px 12px;color:#94a3b8;font-weight:700;text-transform:uppercase;letter-spacing:.04em;">Title</th>
                            <th style="padding:8px 12px;color:#94a3b8;font-weight:700;text-transform:uppercase;letter-spacing:.04em;">Priority</th>
                            <th style="padding:8px 12px;color:#94a3b8;font-weight:700;text-transform:uppercase;letter-spacing:.04em;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($previewTasks as $pt)
                        <tr>
                            <td style="padding:7px 12px;max-width:120px;" class="text-truncate">{{ $pt->title }}</td>
                            <td style="padding:7px 12px;">{{ ucfirst($pt->priority) }}</td>
                            <td style="padding:7px 12px;">{{ ucwords(str_replace('_',' ',$pt->status)) }}</td>
                        </tr>
                        @endforeach
                        <tr>
                            <td colspan="3" style="padding:6px 12px;text-align:center;font-style:italic;color:#94a3b8;font-size:.68rem;">
                                … and {{ max(0,$taskCount-5) }} more rows
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Quick exports --}}
        <div class="ec mb-4">
            <div class="ec-head mb-3">
                <div class="step-num" style="background:linear-gradient(135deg,#f59e0b,#fbbf24);">
                    <i class="bi bi-lightning-fill" style="font-size:.75rem;"></i>
                </div>
                <div><div class="ec-title">Quick Exports</div></div>
            </div>
            <div class="d-flex flex-column gap-2">
                @foreach([
                    ['l'=>"Today's Tasks",       't'=>'tasks',   'f'=>'csv',  'r'=>'today', 'icon'=>'bi-calendar-check'],
                    ['l'=>"All Completed",        't'=>'tasks',   'f'=>'excel','r'=>'all',   'icon'=>'bi-check2-all'],
                    ['l'=>"Focus Sessions",       't'=>'focus',   'f'=>'csv',  'r'=>'all',   'icon'=>'bi-stopwatch'],
                    ['l'=>"This Month Summary",   't'=>'summary', 'f'=>'pdf',  'r'=>'month', 'icon'=>'bi-bar-chart'],
                    ['l'=>"Full Data Backup",     't'=>'full',    'f'=>'json', 'r'=>'all',   'icon'=>'bi-archive'],
                ] as $qe)
                    <form method="POST" action="{{ route('export.download') }}">
                        @csrf
                        <input type="hidden" name="type"   value="{{ $qe['t'] }}">
                        <input type="hidden" name="format" value="{{ $qe['f'] }}">
                        @if($qe['r']==='today')
                            <input type="hidden" name="from_date" value="{{ now()->toDateString() }}">
                            <input type="hidden" name="to_date"   value="{{ now()->toDateString() }}">
                        @elseif($qe['r']==='month')
                            <input type="hidden" name="from_date" value="{{ now()->startOfMonth()->toDateString() }}">
                            <input type="hidden" name="to_date"   value="{{ now()->toDateString() }}">
                        @endif
                        <button type="submit" class="qe-btn w-100">
                            <i class="bi {{ $qe['icon'] }} text-primary me-2"></i>
                            <span>{{ $qe['l'] }}</span>
                            <span class="qe-tag">{{ strtoupper($qe['f']) }}</span>
                        </button>
                    </form>
                @endforeach
            </div>
        </div>

        {{-- Presets + History --}}
        <div class="ec mb-4">
            <ul class="nav nav-tabs border-0 mb-3" style="gap:4px;">
                <li class="nav-item">
                    <button class="nav-link active pw-tab" data-tab="presets" style="border-radius:10px;font-size:.82rem;font-weight:600;border:none;">
                        <i class="bi bi-bookmark-star me-1"></i>Presets
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link pw-tab" data-tab="history" style="border-radius:10px;font-size:.82rem;font-weight:600;border:none;">
                        <i class="bi bi-clock-history me-1"></i>History
                    </button>
                </li>
            </ul>

            <div id="tabPresets">
                <div class="d-flex justify-content-end mb-2">
                    <button type="button" class="clr-btn" id="savePresetBtn">
                        <i class="bi bi-plus me-1"></i>Save current
                    </button>
                </div>
                <div id="presetList">
                    <div class="side-empty" id="presetEmpty">No presets saved yet.</div>
                </div>
            </div>

            <div id="tabHistory" style="display:none;">
                <div id="historyList">
                    <div class="side-empty" id="historyEmpty">No exports this session.</div>
                </div>
            </div>
        </div>

        {{-- Format guide --}}
        <div class="ec">
            <div class="ec-head mb-3">
                <div class="step-num" style="background:linear-gradient(135deg,#64748b,#94a3b8);">
                    <i class="bi bi-info" style="font-size:.75rem;"></i>
                </div>
                <div><div class="ec-title">Format Guide</div></div>
            </div>
            <div id="fmtGuide">
                @foreach([
                    'csv'  => ['#6d5efc','bi-filetype-csv',            'CSV',   'Best for importing into other apps or spreadsheets. Smallest file size.'],
                    'excel'=> ['#10b981','bi-file-earmark-excel-fill',  'Excel', 'Formatted spreadsheet with colours and auto-widths. Best for analysis.'],
                    'pdf'  => ['#ef4444','bi-file-earmark-pdf-fill',    'PDF',   'Branded printable report with summary stats and charts.'],
                    'json' => ['#f59e0b','bi-braces',                   'JSON',  'Full nested data with all relationships. For developers or backups.'],
                ] as $fk => [$fc,$fi,$fl,$fd])
                <div class="fmtg-item {{ $fk!=='csv'?'d-none':'' }}" id="fmtg_{{ $fk }}">
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <i class="bi {{ $fi }} fs-5" style="color:{{ $fc }};"></i>
                        <strong style="font-size:.85rem;">{{ $fl }}</strong>
                    </div>
                    <p class="text-muted mb-0" style="font-size:.78rem;line-height:1.6;">{{ $fd }}</p>
                </div>
                @endforeach
            </div>
        </div>

    </div>
</div>
</div>

{{-- ════════════════════════════════════════════════
     LOADING OVERLAY
════════════════════════════════════════════════════ --}}
<div class="ex-overlay" id="exOverlay">
    <div class="ex-overlay-box">
        <div class="ex-ring"></div>
        <div class="fw-bold mb-1" style="color:#1c1c28;">Preparing export…</div>
        <div style="font-size:.82rem;color:#8a8a9a;">This usually takes a few seconds.</div>
        <div class="mt-3" style="font-size:.78rem;color:#6d5efc;" id="overlayDetail"></div>
    </div>
</div>

<style>
/*══════════════════════════════════════════════════════
  EXPORT CENTER — Premium v2
══════════════════════════════════════════════════════*/

.export-page { padding: 0; }

/* ── Hero ──────────────────────────────────────────*/
.export-hero {
    position: relative; overflow: hidden; border-radius: 22px;
    padding: 40px 44px 44px; margin-bottom: 28px;
    background: linear-gradient(135deg, #3d31cc 0%, #6d5efc 45%, #a06dfc 80%, #c084fc 100%);
    box-shadow: 0 24px 60px rgba(109,94,252,.32);
}
.hero-glow {
    position: absolute; border-radius: 50%;
    pointer-events: none;
}
.hero-glow-1 { width:360px;height:360px;top:-120px;right:-100px;
    background:radial-gradient(circle,rgba(255,255,255,.14),transparent 70%); }
.hero-glow-2 { width:200px;height:200px;bottom:-60px;left:15%;
    background:radial-gradient(circle,rgba(255,255,255,.07),transparent 70%); }
.hero-glow-3 { width:140px;height:140px;top:20px;left:40%;
    background:radial-gradient(circle,rgba(255,255,255,.06),transparent 70%); }

.hero-badge {
    display:inline-flex;align-items:center;gap:8px;
    padding:6px 16px;border-radius:999px;margin-bottom:14px;
    background:rgba(255,255,255,.18);color:#fff;
    font-size:.76rem;font-weight:700;letter-spacing:.04em;
    backdrop-filter:blur(6px);
}
.hero-title {
    color:#fff;font-weight:900;font-size:2.1rem;
    letter-spacing:-.03em;margin-bottom:8px;line-height:1.15;
}
.hero-subtitle { color:rgba(255,255,255,.72);font-size:.92rem;margin-bottom:0; }

.hero-pill {
    display:inline-flex;align-items:center;gap:6px;
    padding:7px 14px;border-radius:999px;
    background:rgba(255,255,255,.14);border:1px solid rgba(255,255,255,.2);
    color:#fff;font-size:.78rem;
}
.hero-pill strong { font-weight:800; }

.hero-ring-wrap { position:relative;width:120px;height:120px; }
.hero-ring-inner {
    position:absolute;inset:0;
    display:flex;flex-direction:column;align-items:center;justify-content:center;
}
.hero-ring-num   { font-size:1.9rem;font-weight:900;color:#fff;line-height:1; }
.hero-ring-label { font-size:.62rem;font-weight:700;color:rgba(255,255,255,.6);
                   text-transform:uppercase;letter-spacing:.06em; }

.hero-back-btn {
    position:absolute;top:20px;right:24px;
    display:inline-flex;align-items:center;gap:7px;
    padding:9px 16px;border-radius:12px;
    background:rgba(255,255,255,.14);color:#fff;
    text-decoration:none;font-weight:600;font-size:.82rem;
    backdrop-filter:blur(6px);border:1px solid rgba(255,255,255,.2);
    transition:.2s;
}
.hero-back-btn:hover { background:rgba(255,255,255,.24);color:#fff;transform:translateY(-1px); }

/* ── Export card ───────────────────────────────────*/
.ec {
    background:#fff;border-radius:18px;padding:26px 28px;
    border:1px solid rgba(17,12,46,.06);
    box-shadow:0 6px 24px rgba(17,12,46,.05);
    margin-bottom:20px;
}
.ec-head { display:flex;align-items:flex-start;gap:14px;margin-bottom:22px; }
.ec-title { font-weight:700;color:#1c1c28;font-size:.95rem; }
.ec-sub   { font-size:.78rem;color:#8a8a9a;margin-top:1px; }
.step-num {
    width:30px;height:30px;border-radius:9px;flex-shrink:0;
    background:linear-gradient(135deg,#6d5efc,#a06dfc);
    color:#fff;font-weight:800;font-size:.82rem;
    display:flex;align-items:center;justify-content:center;
    box-shadow:0 6px 14px rgba(109,94,252,.32);margin-top:1px;
}
.clr-btn {
    border:1.5px solid #e2e8f0;background:#fff;border-radius:8px;
    padding:5px 12px;font-size:.75rem;font-weight:600;color:#64748b;
    transition:.15s;cursor:pointer;
}
.clr-btn:hover { border-color:#6d5efc;color:#6d5efc; }

/* ── Type cards ────────────────────────────────────*/
.type-grid { display:grid;grid-template-columns:repeat(5,1fr);gap:12px; }
.type-card {
    position:relative;border:2px solid rgba(17,12,46,.07);
    background:#fbfbfe;border-radius:14px;padding:16px 12px;
    text-align:center;cursor:pointer;transition:.2s;
}
.type-card:hover { border-color:rgba(109,94,252,.35);transform:translateY(-2px);
                   box-shadow:0 8px 20px rgba(109,94,252,.12); }
.type-card.active { border-color:#6d5efc;
    background:linear-gradient(160deg,rgba(109,94,252,.08),rgba(160,109,252,.02));
    box-shadow:0 8px 22px rgba(109,94,252,.16); }
.type-badge {
    position:absolute;top:8px;right:8px;
    background:linear-gradient(135deg,#6d5efc,#a06dfc);
    color:#fff;font-size:.55rem;font-weight:800;
    padding:2px 7px;border-radius:999px;letter-spacing:.04em;
}
.type-icon {
    width:40px;height:40px;border-radius:12px;
    display:flex;align-items:center;justify-content:center;
    color:#fff;font-size:1.1rem;margin:0 auto 10px;
}
.type-label { font-weight:700;font-size:.82rem;color:#1c1c28;margin-bottom:2px; }
.type-desc  { font-size:.68rem;color:#a0a0b0; }

/* ── Format cards ──────────────────────────────────*/
.format-grid { display:grid;grid-template-columns:repeat(4,1fr);gap:14px; }
.format-card {
    position:relative;border:2px solid rgba(17,12,46,.07);
    background:#fbfbfe;border-radius:14px;padding:18px 14px;
    text-align:center;cursor:pointer;transition:.2s;display:block;
}
.format-card:hover { border-color:rgba(109,94,252,.35);transform:translateY(-2px); }
.format-card.selected {
    border-color:#6d5efc;
    background:linear-gradient(160deg,rgba(109,94,252,.08),rgba(160,109,252,.02));
    box-shadow:0 8px 22px rgba(109,94,252,.16);
}
.fmt-top { display:flex;justify-content:center;position:relative;margin-bottom:10px; }
.fmt-icon {
    width:46px;height:46px;border-radius:14px;
    display:flex;align-items:center;justify-content:center;
    color:#fff;font-size:1.25rem;
}
.fmt-check {
    position:absolute;top:-4px;right:-4px;
    color:#6d5efc;font-size:.95rem;
    opacity:0;transform:scale(.5);
    transition:.2s;
}
.format-card.selected .fmt-check { opacity:1;transform:scale(1); }
.fmt-label { font-weight:700;font-size:.88rem;color:#1c1c28;margin-bottom:2px; }
.fmt-tag   { font-size:.68rem;font-weight:700;color:#6d5efc;margin-bottom:8px; }
.fmt-pros  {
    list-style:none;padding:0;margin:0;text-align:left;
    font-size:.7rem;color:#64748b;line-height:1.7;
}

/* ── Filters ───────────────────────────────────────*/
.preset-row { display:flex;flex-wrap:wrap;gap:8px; }
.pchip {
    padding:6px 14px;border-radius:999px;
    border:1.5px solid rgba(17,12,46,.08);
    background:#fbfbfe;color:#5b5b6b;
    font-size:.76rem;font-weight:600;transition:.15s;cursor:pointer;
}
.pchip:hover { border-color:#6d5efc;color:#6d5efc; }
.pchip.active { background:linear-gradient(135deg,#6d5efc,#a06dfc);border-color:transparent;color:#fff; }

.ex-label { font-size:.78rem;font-weight:600;color:#4b4b5a;margin-bottom:6px;display:block; }
.ex-inp-w { position:relative;display:flex;align-items:center; }
.ex-inp-w i { position:absolute;left:13px;color:#a0a0b0;font-size:.85rem;pointer-events:none; }
.ex-inp {
    width:100%;padding:10px 13px 10px 38px;
    border-radius:11px;border:1.5px solid rgba(17,12,46,.08);
    background:#f8f8fc;font-size:.85rem;color:#1c1c28;
    transition:.2s;appearance:none;
}
.ex-inp:focus { outline:none;border-color:#6d5efc;background:#fff;
                box-shadow:0 0 0 4px rgba(109,94,252,.1); }

/* ── Columns ───────────────────────────────────────*/
.col-chips { display:flex;flex-wrap:wrap;gap:8px; }
.col-chip {
    display:inline-flex;align-items:center;gap:6px;
    padding:6px 12px;border-radius:999px;
    border:1.5px solid rgba(17,12,46,.08);
    background:#fbfbfe;font-size:.76rem;font-weight:600;
    color:#64748b;cursor:pointer;transition:.15s;
    user-select:none;
}
.col-chip:hover { border-color:#6d5efc;color:#6d5efc; }
.col-chip.on    { border-color:#6d5efc;background:rgba(109,94,252,.08);color:#4f46e5; }
.drag-h { color:#cbd5e1;font-size:.8rem;cursor:grab; }

/* ── Submit bar ────────────────────────────────────*/
.submit-bar { display:flex;align-items:center;justify-content:space-between;
              flex-wrap:wrap;gap:14px;padding:20px 28px; }
.submit-summary {
    display:inline-flex;align-items:center;gap:8px;
    padding:8px 16px;border-radius:999px;
    background:rgba(109,94,252,.08);color:#6d5efc;font-size:.82rem;
}
.export-btn {
    display:inline-flex;align-items:center;
    padding:13px 32px;border:none;border-radius:13px;
    background:linear-gradient(135deg,#6d5efc,#a06dfc);
    color:#fff;font-weight:800;font-size:.92rem;
    box-shadow:0 10px 28px rgba(109,94,252,.38);
    transition:.22s;cursor:pointer;
}
.export-btn:hover { transform:translateY(-2px);box-shadow:0 16px 36px rgba(109,94,252,.48);color:#fff; }

/* ── Preview ───────────────────────────────────────*/
.preview-file-pill {
    display:flex;align-items:center;gap:10px;
    padding:10px 14px;border-radius:12px;
    background:#f8fafc;border:1px solid #e2e8f0;
}

/* ── Quick export buttons ──────────────────────────*/
.qe-btn {
    display:flex;align-items:center;padding:10px 14px;
    border:1.5px solid #e2e8f0;border-radius:11px;background:#fff;
    font-size:.8rem;font-weight:600;color:#334155;
    transition:.15s;text-align:left;cursor:pointer;
}
.qe-btn:hover { border-color:#6d5efc;background:rgba(109,94,252,.04);color:#4f46e5; }
.qe-tag {
    margin-left:auto;background:#f1f5f9;color:#64748b;
    font-size:.65rem;font-weight:700;padding:2px 8px;border-radius:999px;
}

/* ── Side panels ───────────────────────────────────*/
.side-empty { text-align:center;color:#a0a0b0;font-size:.78rem;padding:20px 0; }
.side-item  {
    display:flex;align-items:center;gap:10px;
    padding:10px 12px;border-radius:11px;
    background:#fbfbfe;border:1px solid rgba(17,12,46,.05);
    margin-bottom:8px;
}
.side-item-title { font-size:.8rem;font-weight:600;color:#1c1c28; }
.side-item-meta  { font-size:.68rem;color:#a0a0b0; }
.si-btn {
    width:28px;height:28px;border:none;border-radius:8px;
    background:rgba(109,94,252,.08);color:#6d5efc;
    font-size:.75rem;cursor:pointer;transition:.15s;
    display:inline-flex;align-items:center;justify-content:center;
}
.si-btn:hover       { background:rgba(109,94,252,.18); }
.si-btn.si-del      { background:rgba(239,68,68,.08);color:#ef4444; }
.si-btn.si-del:hover{ background:rgba(239,68,68,.18); }

/* ── Format guide ──────────────────────────────────*/
.fmtg-item { padding:4px 0; }

/* ── Overlay ───────────────────────────────────────*/
.ex-overlay {
    position:fixed;inset:0;z-index:9999;
    background:rgba(17,12,46,.5);backdrop-filter:blur(5px);
    display:none;align-items:center;justify-content:center;
}
.ex-overlay.show { display:flex; }
.ex-overlay-box {
    background:#fff;border-radius:20px;padding:40px 48px;
    text-align:center;min-width:300px;
    box-shadow:0 24px 60px rgba(0,0,0,.25);
}
.ex-ring {
    width:52px;height:52px;border-radius:50%;margin:0 auto 18px;
    border:5px solid rgba(109,94,252,.15);border-top-color:#6d5efc;
    animation:spin .8s linear infinite;
}
@keyframes spin { to { transform:rotate(360deg); } }

/* ── Responsive ────────────────────────────────────*/
@media(max-width:1199px){ .type-grid{ grid-template-columns:repeat(3,1fr); } }
@media(max-width:767px){
    .type-grid,.format-grid{ grid-template-columns:repeat(2,1fr); }
    .export-hero { padding:28px 22px 32px; }
    .ec { padding:18px; }
    .hero-title { font-size:1.5rem; }
    .submit-bar { flex-direction:column;align-items:stretch; }
    .export-btn { justify-content:center; }
}

/* ── Dark mode ─────────────────────────────────────*/
[data-bs-theme="dark"] .ec,
[data-bs-theme="dark"] .ex-overlay-box { background:#1c1c28;border-color:rgba(255,255,255,.06); }
[data-bs-theme="dark"] .type-card,
[data-bs-theme="dark"] .format-card,
[data-bs-theme="dark"] .qe-btn,
[data-bs-theme="dark"] .side-item,
[data-bs-theme="dark"] .col-chip,
[data-bs-theme="dark"] .pchip { background:#22222f;border-color:rgba(255,255,255,.07); }
[data-bs-theme="dark"] .ex-inp { background:#22222f;border-color:rgba(255,255,255,.08);color:#e4e4ec; }
[data-bs-theme="dark"] .ec-title,
[data-bs-theme="dark"] .type-label,
[data-bs-theme="dark"] .fmt-label,
[data-bs-theme="dark"] .side-item-title,
[data-bs-theme="dark"] .qe-btn { color:#f0f0f5; }
[data-bs-theme="dark"] .preview-file-pill { background:#22222f;border-color:rgba(255,255,255,.08); }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const typeInput   = document.getElementById('typeInput');
    const formatInput = document.getElementById('formatInput');
    const summary     = document.getElementById('submitSummary');

    const typeLabels   = { tasks:'Tasks', focus:'Focus Sessions', remarks:'Remarks', summary:'Summary', full:'Full Export' };
    const formatLabels = { csv:'CSV', excel:'Excel', pdf:'PDF', json:'JSON' };
    const counts       = { tasks:'{{ $taskCount }}', focus:'{{ $focusCount }}', remarks:'{{ $remarkCount }}', summary:'1', full:'all' };
    const exts         = { csv:'csv', excel:'xlsx', pdf:'pdf', json:'json' };

    /*── Update summary + preview ──────────────────────────────────────*/
    function update() {
        const t = typeInput.value, f = formatInput.value;
        const dateLabel = document.querySelector('.pchip.active')?.textContent.trim() || 'All time';
        summary.innerHTML = `Exporting <strong>${typeLabels[t]}</strong> · <strong>${formatLabels[f]}</strong> · ${dateLabel}`;
        document.getElementById('previewName').textContent = `${t}_{{ now()->format('Ymd') }}.${exts[f]||f}`;
        document.getElementById('previewMeta').textContent = `${counts[t]} records · ${f.toUpperCase()}`;
        document.getElementById('previewFmt').textContent  = f.toUpperCase();
        // Show/hide format guide
        document.querySelectorAll('.fmtg-item').forEach(el => el.classList.add('d-none'));
        document.getElementById('fmtg_'+f)?.classList.remove('d-none');
    }

    /*── Type cards ────────────────────────────────────────────────────*/
    document.querySelectorAll('.type-card').forEach(card => {
        card.addEventListener('click', function () {
            document.querySelectorAll('.type-card').forEach(c => c.classList.remove('active'));
            this.classList.add('active');
            typeInput.value = this.dataset.type;
            const isTask = this.dataset.type === 'tasks';
            document.querySelectorAll('.task-only').forEach(el => {
                el.style.display = isTask ? '' : 'none';
            });
            update();
        });
    });

    /*── Format cards ──────────────────────────────────────────────────*/
    document.querySelectorAll('.fmt-radio').forEach(radio => {
        radio.addEventListener('change', function () {
            document.querySelectorAll('.format-card').forEach(c => c.classList.remove('selected'));
            this.closest('.format-card').classList.add('selected');
            formatInput.value = this.value;
            update();
        });
    });

    /*── Date presets ──────────────────────────────────────────────────*/
    document.querySelectorAll('.pchip').forEach(btn => {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.pchip').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            const today = new Date(), fmt = d => d.toISOString().split('T')[0];
            let from = new Date(today), to = new Date(today);
            switch(this.dataset.r) {
                case 'today':                                                  break;
                case 'week':  from.setDate(today.getDate()-today.getDay());   break;
                case 'month': from = new Date(today.getFullYear(),today.getMonth(),1); break;
                case '30d':   from.setDate(today.getDate()-30);               break;
                case '90d':   from.setDate(today.getDate()-90);               break;
                case 'year':  from = new Date(today.getFullYear(),0,1);       break;
                case 'all':
                    document.getElementById('fromDate').value = '';
                    document.getElementById('toDate').value   = '';
                    update(); return;
            }
            document.getElementById('fromDate').value = fmt(from);
            document.getElementById('toDate').value   = fmt(to);
            update();
        });
    });

    /*── Clear filters ─────────────────────────────────────────────────*/
    document.getElementById('clearFilters')?.addEventListener('click', function (e) {
        e.preventDefault();
        document.getElementById('fromDate').value = '';
        document.getElementById('toDate').value   = '';
        document.querySelectorAll('[name="status"],[name="priority"],[name="include"]').forEach(s => s.value='');
        document.querySelectorAll('.pchip').forEach(b => b.classList.remove('active'));
        document.querySelector('.pchip[data-r="all"]')?.classList.add('active');
        update();
    });

    /*── Column chips ──────────────────────────────────────────────────*/
    document.querySelectorAll('.col-chip').forEach(chip => {
        chip.addEventListener('click', function () {
            const cb = this.querySelector('input');
            cb.checked = !cb.checked;
            this.classList.toggle('on', cb.checked);
        });
    });
    document.getElementById('allCols')?.addEventListener('click', () => {
        document.querySelectorAll('.col-chip').forEach(c => {
            c.classList.add('on');
            c.querySelector('input').checked = true;
        });
    });
    document.getElementById('noneCols')?.addEventListener('click', () => {
        document.querySelectorAll('.col-chip').forEach(c => {
            c.classList.remove('on');
            c.querySelector('input').checked = false;
        });
    });

    /*── Column drag-to-reorder ────────────────────────────────────────*/
    let dragSrc = null;
    document.querySelectorAll('.col-chip').forEach(chip => {
        chip.addEventListener('dragstart', function (e) {
            dragSrc = this;
            e.dataTransfer.effectAllowed = 'move';
            this.style.opacity = '.4';
        });
        chip.addEventListener('dragend',  function () { this.style.opacity = ''; });
        chip.addEventListener('dragover', function (e) { e.preventDefault(); e.dataTransfer.dropEffect='move'; });
        chip.addEventListener('drop', function (e) {
            e.preventDefault();
            if (dragSrc !== this) {
                const parent = this.parentNode;
                const allChips = [...parent.querySelectorAll('.col-chip')];
                const srcIdx  = allChips.indexOf(dragSrc);
                const dstIdx  = allChips.indexOf(this);
                if (srcIdx < dstIdx) parent.insertBefore(dragSrc, this.nextSibling);
                else parent.insertBefore(dragSrc, this);
            }
        });
    });

    /*── Preset tabs ───────────────────────────────────────────────────*/
    document.querySelectorAll('.pw-tab').forEach(btn => {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.pw-tab').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            document.getElementById('tabPresets').style.display = this.dataset.tab==='presets' ? '' : 'none';
            document.getElementById('tabHistory').style.display = this.dataset.tab==='history' ? '' : 'none';
        });
    });

    /*── Saved presets ─────────────────────────────────────────────────*/
    const PK = 'taskvel_export_presets_v2';
    function getPresets() { return JSON.parse(localStorage.getItem(PK)||'[]'); }
    function renderPresets() {
        const list = document.getElementById('presetList');
        const empty = document.getElementById('presetEmpty');
        list.querySelectorAll('.side-item').forEach(el => el.remove());
        const presets = getPresets();
        empty.style.display = presets.length ? 'none' : 'block';
        presets.forEach((p, i) => {
            const item = document.createElement('div');
            item.className = 'side-item';
            item.innerHTML = `
                <div class="flex-grow-1">
                    <div class="side-item-title">${p.name}</div>
                    <div class="side-item-meta">${typeLabels[p.type]||p.type} · ${formatLabels[p.format]||p.format}</div>
                </div>
                <div class="d-flex gap-1">
                    <button class="si-btn apply-p" data-i="${i}" title="Apply"><i class="bi bi-arrow-return-left"></i></button>
                    <button class="si-btn si-del del-p" data-i="${i}" title="Delete"><i class="bi bi-trash"></i></button>
                </div>`;
            list.appendChild(item);
        });
        list.querySelectorAll('.apply-p').forEach(btn => {
            btn.addEventListener('click', function () {
                const p = getPresets()[this.dataset.i];
                typeInput.value = p.type;
                formatInput.value = p.format;
                document.querySelectorAll('.type-card').forEach(c => c.classList.toggle('active', c.dataset.type===p.type));
                document.querySelectorAll('.fmt-radio').forEach(r => {
                    r.checked = r.value===p.format;
                    r.closest('.format-card').classList.toggle('selected', r.value===p.format);
                });
                document.querySelectorAll('.task-only').forEach(el => { el.style.display = p.type==='tasks' ? '' : 'none'; });
                update();
            });
        });
        list.querySelectorAll('.del-p').forEach(btn => {
            btn.addEventListener('click', function () {
                const presets = getPresets(); presets.splice(this.dataset.i,1);
                localStorage.setItem(PK, JSON.stringify(presets)); renderPresets();
            });
        });
    }

    document.getElementById('savePresetBtn')?.addEventListener('click', () => {
        const name = prompt('Name this preset:', `${typeLabels[typeInput.value]} · ${formatLabels[formatInput.value]}`);
        if (!name) return;
        const presets = getPresets();
        presets.unshift({ name, type:typeInput.value, format:formatInput.value });
        localStorage.setItem(PK, JSON.stringify(presets.slice(0,10)));
        renderPresets();
    });

    /*── Export history ────────────────────────────────────────────────*/
    const HK = 'taskvel_export_history_v2';
    function renderHistory() {
        const list  = document.getElementById('historyList');
        const empty = document.getElementById('historyEmpty');
        list.querySelectorAll('.side-item').forEach(el => el.remove());
        const history = JSON.parse(localStorage.getItem(HK)||'[]');
        empty.style.display = history.length ? 'none' : 'block';
        history.forEach(h => {
            const item = document.createElement('div');
            item.className = 'side-item';
            item.innerHTML = `
                <div class="flex-grow-1">
                    <div class="side-item-title">${typeLabels[h.type]||h.type} · ${(formatLabels[h.format]||h.format).toUpperCase()}</div>
                    <div class="side-item-meta">${h.time}</div>
                </div>
                <i class="bi bi-check-circle-fill text-success"></i>`;
            list.appendChild(item);
        });
    }

    /*── Submit ────────────────────────────────────────────────────────*/
    document.getElementById('exportForm')?.addEventListener('submit', function () {
        const t = typeInput.value, f = formatInput.value;
        const history = JSON.parse(localStorage.getItem(HK)||'[]');
        history.unshift({ type:t, format:f, time:new Date().toLocaleString() });
        localStorage.setItem(HK, JSON.stringify(history.slice(0,8)));

        const overlay = document.getElementById('exOverlay');
        const detail  = document.getElementById('overlayDetail');
        overlay.classList.add('show');
        detail.textContent = `${typeLabels[t]} → ${formatLabels[f].toUpperCase()}`;
        setTimeout(() => overlay.classList.remove('show'), 8000);
    });

    /*── Hero ring count-up ────────────────────────────────────────────*/
    const target = {{ $pct }};
    let cur = 0;
    const step = Math.max(1, Math.ceil(target/50));
    const tick = setInterval(() => {
        cur = Math.min(cur+step, target);
        document.getElementById('heroRingNum').textContent = cur+'%';
        if (cur >= target) clearInterval(tick);
    }, 24);

    update();
    renderPresets();
    renderHistory();
});
</script>

@endsection