@extends('layouts.app')

@section('title', 'Focus Mode')

@section('content')

<div class="container-fluid px-3 px-lg-4">

    {{-- ── Header ──────────────────────────────────────────────────────────── --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Focus Mode</h2>
            <p class="text-muted mb-0">Deep work, on your terms.</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#settingsModal">
                <i class="bi bi-gear me-1"></i>Settings
            </button>
            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i>Dashboard
            </a>
        </div>
    </div>

    {{-- ── Today Stats Strip ───────────────────────────────────────────────── --}}
    <div class="row g-3 mb-4">
        @php
            $strips = [
                ['id'=>'statTodayMin',  'val'=>$todayMinutes ?? 0,  'label'=>'Minutes today',   'icon'=>'bi-clock-fill',        'color'=>'primary'],
                ['id'=>'statSessions',  'val'=>$todaySessions ?? 0, 'label'=>'Sessions today',  'icon'=>'bi-check-circle-fill', 'color'=>'success'],
                ['id'=>'statStreak',    'val'=>'—',                 'label'=>'Streak',           'icon'=>'bi-lightning-fill',    'color'=>'warning'],
                ['id'=>'statGoal',      'val'=>'—',                 'label'=>'Daily goal',       'icon'=>'bi-trophy-fill',       'color'=>'info'],
            ];
        @endphp
        @foreach($strips as $s)
        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-3 d-flex align-items-center gap-3">
                    <div class="stats-icon stats-{{ $s['color'] }}" style="width:42px;height:42px;font-size:1rem;border-radius:12px;flex-shrink:0;">
                        <i class="bi {{ $s['icon'] }}"></i>
                    </div>
                    <div>
                        <div class="fw-bold fs-5 lh-1" id="{{ $s['id'] }}">{{ $s['val'] }}</div>
                        <div class="text-muted" style="font-size:.76rem;">{{ $s['label'] }}</div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="row g-4">

        {{-- ══════════════════════════════════════════════════
             LEFT — Main Timer Panel
        ══════════════════════════════════════════════════════ --}}
        <div class="col-xl-8">

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4 p-lg-5">

                    {{-- Active task label --}}
                    <div class="text-center mb-3">
                        <div id="activeTaskLabel" class="d-inline-flex align-items-center gap-2 px-3 py-2 rounded-pill"
                             style="background:rgba(79,70,229,.08);font-size:.88rem;">
                            <i class="bi bi-lightning-charge-fill text-primary"></i>
                            <span class="fw-semibold text-primary">
                                {{ optional($task)->title ?? 'No task selected' }}
                            </span>
                            @if($task)
                                <a href="{{ route('tasks.index') }}" class="text-muted ms-1" style="font-size:.75rem;">change</a>
                            @endif
                        </div>
                    </div>

                    {{-- ── Mode Tabs ─────────────────────────────────────── --}}
                    <div class="d-flex justify-content-center gap-2 flex-wrap mb-4" id="modeTabs">
                        <button class="mode-btn active" data-mode="focus"       data-minutes="25">🎯 Focus</button>
                        <button class="mode-btn"        data-mode="short"       data-minutes="5" >☕ Short Break</button>
                        <button class="mode-btn"        data-mode="long"        data-minutes="15">🌿 Long Break</button>
                        <button class="mode-btn"        data-mode="deep"        data-minutes="50">🔥 Deep Work</button>
                        <button class="mode-btn"        data-mode="custom"      data-minutes="0" >⚙️ Custom</button>
                    </div>

                    {{-- Custom duration picker (hidden by default) --}}
                    <div id="customDurationRow" class="text-center mb-4" style="display:none!important;">
                        <div class="d-inline-flex align-items-center gap-2 p-3 rounded-3"
                             style="background:var(--gray-100,#f8fafc);">
                            <label class="fw-semibold text-muted mb-0">Duration:</label>
                            <input type="number" id="customMinutes" class="form-control text-center fw-bold"
                                   min="1" max="180" value="45"
                                   style="width:80px;font-size:1.2rem;border-radius:10px;">
                            <span class="text-muted fw-semibold">min</span>
                            <button class="btn btn-primary btn-sm" id="applyCustom">Apply</button>
                        </div>
                    </div>

                    {{-- ── Circular Timer ────────────────────────────────── --}}
                    <div class="timer-circle mx-auto mb-2" id="timerCircle">
                        <svg width="100%" viewBox="0 0 320 320">
                            <defs>
                                <linearGradient id="ringGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%"   stop-color="#4f46e5"/>
                                    <stop offset="100%" stop-color="#7c3aed"/>
                                </linearGradient>
                            </defs>
                            {{-- Track --}}
                            <circle cx="160" cy="160" r="135" stroke="#e9ecef" stroke-width="14" fill="none"/>
                            {{-- Progress ring --}}
                            <circle id="progressRing"
                                    cx="160" cy="160" r="135"
                                    stroke="url(#ringGrad)"
                                    stroke-width="14"
                                    stroke-linecap="round"
                                    fill="none"
                                    stroke-dasharray="848"
                                    stroke-dashoffset="0"
                                    transform="rotate(-90 160 160)"
                                    style="transition:stroke-dashoffset .8s linear;"/>
                        </svg>
                        <div class="timer-content">
                            <div id="timerDisplay" class="timer-time">25:00</div>
                            <div id="timerModeLabel" class="timer-label">Focus Session</div>
                            <div id="timerStatus" class="mt-1" style="font-size:.75rem;color:#94a3b8;">Ready</div>
                        </div>
                    </div>

                    {{-- Round dots --}}
                    <div class="d-flex justify-content-center gap-2 mb-4" id="roundDots">
                        @for($i=0;$i<4;$i++)
                            <div class="round-dot" data-round="{{ $i }}"></div>
                        @endfor
                    </div>

                    {{-- ── Controls ─────────────────────────────────────── --}}
                    <div class="timer-actions">
                        <button id="startBtn"  class="btn btn-success btn-lg px-4 fw-semibold">
                            <i class="bi bi-play-fill me-2"></i>Start
                        </button>
                        <button id="pauseBtn"  class="btn btn-warning btn-lg px-4 fw-semibold">
                            <i class="bi bi-pause-fill me-2"></i>Pause
                        </button>
                        <button id="resetBtn"  class="btn btn-outline-secondary btn-lg px-4">
                            <i class="bi bi-arrow-counterclockwise me-2"></i>Reset
                        </button>
                        <button id="skipBtn"   class="btn btn-outline-primary btn-lg px-4" title="Skip to next">
                            <i class="bi bi-skip-forward-fill me-2"></i>Skip
                        </button>
                    </div>

                    {{-- ── Quick presets ────────────────────────────────── --}}
                    <div class="text-center mt-4">
                        <small class="text-muted d-block mb-2 fw-semibold">QUICK PRESETS</small>
                        <div class="d-flex justify-content-center gap-2 flex-wrap">
                            @foreach([15,20,25,30,45,60,90] as $min)
                                <button class="btn btn-sm btn-light preset-btn fw-semibold"
                                        data-minutes="{{ $min }}">{{ $min }}m</button>
                            @endforeach
                        </div>
                    </div>

                    {{-- ── Session Notes ─────────────────────────────────── --}}
                    <div class="mt-4 pt-4" style="border-top:1px solid var(--gray-200,#e2e8f0);">
                        <label class="form-label fw-semibold text-muted" style="font-size:.82rem;text-transform:uppercase;letter-spacing:.05em;">
                            Session Note
                        </label>
                        <textarea id="sessionNotes" class="form-control" rows="2"
                                  placeholder="What are you working on? Any blockers?…"
                                  style="resize:none;font-size:.9rem;border-radius:12px;"></textarea>
                    </div>

                </div>
            </div>

            {{-- ── Stopwatch Card ─────────────────────────────────────────── --}}
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-stopwatch me-2 text-primary"></i>Stopwatch</h5>
                    <span class="badge bg-light text-secondary border" id="stopwatchLapCount">0 laps</span>
                </div>
                <div class="card-body py-4">
                    <div class="stopwatch text-center">
                        <div id="stopwatchDisplay" class="stopwatch-display fw-bold"
                             style="font-size:3.2rem;letter-spacing:3px;font-variant-numeric:tabular-nums;">
                            00:00:00
                        </div>
                        <div id="stopwatchMs" class="text-muted mb-3" style="font-size:1.1rem;letter-spacing:2px;">
                            .00
                        </div>
                        <div class="stopwatch-actions mb-4">
                            <button id="startStopwatch"  class="btn btn-success px-4 fw-semibold">
                                <i class="bi bi-play-fill me-1"></i>Start
                            </button>
                            <button id="stopStopwatch"   class="btn btn-warning px-4 fw-semibold">
                                <i class="bi bi-pause-fill me-1"></i>Pause
                            </button>
                            <button id="lapStopwatch"    class="btn btn-outline-primary px-4">
                                <i class="bi bi-flag me-1"></i>Lap
                            </button>
                            <button id="resetStopwatch"  class="btn btn-outline-secondary px-4">
                                <i class="bi bi-arrow-counterclockwise me-1"></i>Reset
                            </button>
                        </div>
                        <div id="lapList" class="text-start" style="max-height:160px;overflow-y:auto;"></div>
                    </div>
                </div>
            </div>

        </div>

        {{-- ══════════════════════════════════════════════════
             RIGHT — Sidebar
        ══════════════════════════════════════════════════════ --}}
        <div class="col-xl-4">

            {{-- Ambient Sound --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-music-note-beamed me-2 text-primary"></i>Ambient Sound</h5>
                </div>
                <div class="card-body">
                    <div class="row g-2" id="soundGrid">
                        @php
                            $sounds = [
                                ['id'=>'rain',    'emoji'=>'🌧',  'label'=>'Rain'],
                                ['id'=>'forest',  'emoji'=>'🌲',  'label'=>'Forest'],
                                ['id'=>'coffee',  'emoji'=>'☕',  'label'=>'Café'],
                                ['id'=>'waves',   'emoji'=>'🌊',  'label'=>'Ocean'],
                                ['id'=>'white',   'emoji'=>'🎧',  'label'=>'White'],
                                ['id'=>'fire',    'emoji'=>'🔥',  'label'=>'Fire'],
                                ['id'=>'thunder', 'emoji'=>'⛈',  'label'=>'Storm'],
                                ['id'=>'birds',   'emoji'=>'🐦',  'label'=>'Birds'],
                            ];
                        @endphp
                        @foreach($sounds as $sound)
                            <div class="col-3">
                                <button class="sound-btn w-100 btn btn-light p-2 d-flex flex-column align-items-center gap-1"
                                        data-sound="{{ $sound['id'] }}" style="border-radius:12px;font-size:.75rem;">
                                    <span style="font-size:1.4rem;">{{ $sound['emoji'] }}</span>
                                    <span class="fw-semibold">{{ $sound['label'] }}</span>
                                </button>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-3 d-flex align-items-center gap-3">
                        <i class="bi bi-volume-down text-muted"></i>
                        <input type="range" id="soundVolume" class="form-range flex-grow-1" min="0" max="100" value="50">
                        <i class="bi bi-volume-up text-muted"></i>
                    </div>
                </div>
            </div>

            {{-- Daily Goal --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-trophy me-2 text-primary"></i>Daily Goal</h5>
                    <button class="btn btn-sm btn-outline-secondary" id="editGoalBtn">Edit</button>
                </div>
                <div class="card-body">
                    <div class="goal-label d-flex justify-content-between mb-2">
                        <span class="text-muted fw-semibold" style="font-size:.85rem;">
                            <span id="goalCompleted">0</span> / <span id="goalTarget">8</span> sessions
                        </span>
                        <span id="goalPercent" class="text-primary fw-bold" style="font-size:.85rem;">0%</span>
                    </div>
                    <div class="progress" style="height:12px;border-radius:20px;">
                        <div id="goalProgressBar" class="progress-bar" style="width:0%;border-radius:20px;transition:width .5s;"></div>
                    </div>
                    <div id="goalEditRow" class="mt-3" style="display:none;">
                        <div class="input-group input-group-sm">
                            <input type="number" id="goalInput" class="form-control" min="1" max="20" value="8" placeholder="Sessions goal">
                            <button class="btn btn-primary" id="saveGoalBtn">Save</button>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div id="completedSessions" class="d-none">0</div>
                        <div class="d-flex gap-1 flex-wrap" id="sessionBoxes">
                            @for($i=0;$i<8;$i++)
                                <div class="session-box" data-box="{{ $i }}"></div>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>

            {{-- Focus Streak --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-lightning me-2 text-primary"></i>Focus Streak</h5>
                </div>
                <div class="card-body text-center py-4">
                    <div style="font-size:3rem;">🔥</div>
                    <div class="display-5 fw-bold text-primary" id="focusStreak">0</div>
                    <div class="text-muted">sessions streak</div>
                    <div class="mt-3 p-2 rounded" style="background:rgba(79,70,229,.06);font-size:.82rem;">
                        <i class="bi bi-info-circle me-1 text-primary"></i>
                        Complete sessions without skipping to build your streak.
                    </div>
                </div>
            </div>

            {{-- Recent Sessions --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-clock-history me-2 text-primary"></i>Recent Sessions</h5>
                    <span class="badge bg-primary rounded-pill">{{ $sessions->total() }}</span>
                </div>
                <div class="card-body p-0">
                    @forelse($sessions as $session)
                        @php
                            $typeColors = ['focus'=>'primary','short_break'=>'success','long_break'=>'info'];
                            $typeLabels = ['focus'=>'Focus','short_break'=>'Short Break','long_break'=>'Long Break'];
                        @endphp
                        <div class="d-flex justify-content-between align-items-center px-4 py-3 border-bottom">
                            <div class="d-flex align-items-center gap-3">
                                <div class="stats-icon stats-{{ $typeColors[$session->session_type] ?? 'primary' }}"
                                     style="width:34px;height:34px;font-size:.8rem;border-radius:8px;flex-shrink:0;">
                                    <i class="bi bi-stopwatch"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold" style="font-size:.88rem;">
                                        {{ $session->task?->title ?? 'General Focus' }}
                                    </div>
                                    <small class="text-muted">
                                        {{ $typeLabels[$session->session_type] ?? 'Focus' }}
                                        @if($session->completed)
                                            · <span class="text-success">✓ Done</span>
                                        @endif
                                    </small>
                                </div>
                            </div>
                            <div class="text-end">
                                <div class="fw-bold text-primary">{{ $session->actual_minutes ?? $session->planned_minutes }}m</div>
                                <small class="text-muted">{{ $session->started_at?->diffForHumans() }}</small>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5 text-muted">
                            <i class="bi bi-clock-history d-block mb-2" style="font-size:2rem;"></i>
                            No sessions yet. Start your first!
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Auto Start Toggle --}}
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="fw-semibold">Auto-start breaks</span>
                        <div class="form-check form-switch mb-0">
                            <input class="form-check-input" type="checkbox" id="autoStartBreaks" style="width:2.2rem;height:1.1rem;">
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="fw-semibold">Auto-start focus</span>
                        <div class="form-check form-switch mb-0">
                            <input class="form-check-input" type="checkbox" id="autoStart" style="width:2.2rem;height:1.1rem;">
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="fw-semibold">Idle auto-pause</span>
                        <div class="form-check form-switch mb-0">
                            <input class="form-check-input" type="checkbox" id="idlePause" checked style="width:2.2rem;height:1.1rem;">
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-semibold">Browser notifications</span>
                        <div class="form-check form-switch mb-0">
                            <input class="form-check-input" type="checkbox" id="notifToggle" checked style="width:2.2rem;height:1.1rem;">
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>

{{-- ════════════════════════════════════════════════════════════════════
     Settings Modal
═══════════════════════════════════════════════════════════════════════ --}}
<div class="modal fade" id="settingsModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius:20px;">
            <div class="modal-header border-bottom">
                <h5 class="modal-title fw-bold"><i class="bi bi-gear me-2 text-primary"></i>Timer Settings</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">

                <h6 class="fw-bold text-muted mb-3" style="font-size:.8rem;text-transform:uppercase;letter-spacing:.06em;">Duration Presets (minutes)</h6>

                <div class="row g-3 mb-4">
                    <div class="col-6">
                        <label class="form-label fw-semibold">🎯 Focus</label>
                        <div class="input-group">
                            <input type="number" id="setting_focus"      class="form-control" min="1" max="120" value="25">
                            <span class="input-group-text">min</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-semibold">☕ Short Break</label>
                        <div class="input-group">
                            <input type="number" id="setting_short"      class="form-control" min="1" max="30"  value="5">
                            <span class="input-group-text">min</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-semibold">🌿 Long Break</label>
                        <div class="input-group">
                            <input type="number" id="setting_long"       class="form-control" min="1" max="60"  value="15">
                            <span class="input-group-text">min</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-semibold">🔥 Deep Work</label>
                        <div class="input-group">
                            <input type="number" id="setting_deep"       class="form-control" min="1" max="180" value="50">
                            <span class="input-group-text">min</span>
                        </div>
                    </div>
                </div>

                <hr>
                <h6 class="fw-bold text-muted mb-3" style="font-size:.8rem;text-transform:uppercase;letter-spacing:.06em;">Pomodoro Cycle</h6>
                <div class="row g-3 mb-4">
                    <div class="col-6">
                        <label class="form-label fw-semibold">Sessions before long break</label>
                        <input type="number" id="setting_longBreakInterval" class="form-control" min="1" max="10" value="4">
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-semibold">Daily session goal</label>
                        <input type="number" id="setting_dailyGoal" class="form-control" min="1" max="20" value="8">
                    </div>
                </div>

                <hr>
                <h6 class="fw-bold text-muted mb-3" style="font-size:.8rem;text-transform:uppercase;letter-spacing:.06em;">Alerts</h6>
                <div class="row g-3">
                    <div class="col-6">
                        <label class="form-label fw-semibold">Alert sound</label>
                        <select id="setting_alertSound" class="form-select">
                            <option value="bell">🔔 Bell</option>
                            <option value="chime">🎵 Chime</option>
                            <option value="ding">✨ Ding</option>
                            <option value="none">🔇 Silent</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-semibold">Alert volume</label>
                        <input type="range" id="setting_alertVolume" class="form-range mt-2" min="0" max="100" value="80">
                    </div>
                </div>

            </div>
            <div class="modal-footer border-top">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary fw-semibold" id="saveSettings">
                    <i class="bi bi-check-circle me-1"></i>Save Settings
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
/*─── Timer circle ─────────────────────────────────────────────────────*/
.timer-circle{
    position:relative;
    width:300px;
    height:300px;
}
.timer-content{
    position:absolute;
    inset:0;
    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:center;
}
.timer-time{
    font-size:3.8rem;
    font-weight:800;
    letter-spacing:2px;
    font-variant-numeric:tabular-nums;
    line-height:1;
}
.timer-label{
    margin-top:8px;
    color:var(--gray-500,#64748b);
    font-size:.9rem;
    font-weight:600;
}
/*─── Mode buttons ─────────────────────────────────────────────────────*/
.mode-btn{
    border:none;
    background:#f1f5f9;
    color:#64748b;
    padding:8px 16px;
    border-radius:999px;
    font-weight:600;
    font-size:.85rem;
    transition:.2s;
    cursor:pointer;
}
.mode-btn:hover{ background:#e2e8f0; color:#334155; }
.mode-btn.active{ background:var(--primary,#4f46e5); color:#fff; box-shadow:0 4px 12px rgba(79,70,229,.3); }
/*─── Preset buttons ───────────────────────────────────────────────────*/
.preset-btn{
    border-radius:999px!important;
    font-size:.8rem!important;
    padding:4px 12px!important;
    transition:.2s!important;
}
.preset-btn:hover,.preset-btn.active{
    background:var(--primary,#4f46e5)!important;
    color:#fff!important;
    border-color:var(--primary,#4f46e5)!important;
}
/*─── Round dots ───────────────────────────────────────────────────────*/
.round-dot{
    width:12px;height:12px;
    border-radius:50%;
    background:#e2e8f0;
    transition:.3s;
}
.round-dot.done{ background:var(--success,#10b981); }
.round-dot.current{ background:var(--primary,#4f46e5); transform:scale(1.3); }
/*─── Session boxes ────────────────────────────────────────────────────*/
.session-box{
    width:24px;height:24px;
    border-radius:6px;
    background:#e2e8f0;
    transition:.3s;
}
.session-box.done{ background:var(--success,#10b981); }
/*─── Timer modes ──────────────────────────────────────────────────────*/
#timerCircle.mode-short  #progressRing{ stroke:url(#ringGradShort); }
#timerCircle.mode-long   #progressRing{ stroke:url(#ringGradLong); }
#timerCircle.mode-deep   #progressRing{ stroke:url(#ringGradDeep); }
/*─── Sound buttons ────────────────────────────────────────────────────*/
.sound-btn{ transition:.2s!important; }
.sound-btn.active{
    background:rgba(79,70,229,.12)!important;
    border:2px solid var(--primary,#4f46e5)!important;
    color:var(--primary,#4f46e5)!important;
}
/*─── Lap list ─────────────────────────────────────────────────────────*/
.lap-item{
    display:flex;
    justify-content:space-between;
    padding:6px 0;
    border-bottom:1px solid #f1f5f9;
    font-size:.85rem;
}
.lap-item:last-child{ border-bottom:none; }
/*─── Running pulse ────────────────────────────────────────────────────*/
@keyframes timerPulse{
    0%,100%{ box-shadow:0 0 0 0 rgba(79,70,229,.25); }
    50%     { box-shadow:0 0 0 18px rgba(79,70,229,0); }
}
.timer-running-pulse{ animation:timerPulse 2s infinite; border-radius:50%; }
@media(max-width:768px){
    .timer-circle{ width:240px;height:240px; }
    .timer-time{ font-size:2.8rem; }
}
</style>
@endpush

@push('scripts')
<script>
'use strict';

/*─────────────────────────────────────────────────────────────────────
  STATE
─────────────────────────────────────────────────────────────────────*/
let timer         = null;
let timerRunning  = false;
let totalSeconds  = 25 * 60;
let remainingSeconds = totalSeconds;
let currentMode   = 'focus';
let completedRounds = 0;

// Stopwatch
let sw = null, swRunning = false, swMs = 0, swTotal = 0;
let laps = [];

// Settings (loaded from sessionStorage)
let settings = {
    focus: 25, short: 5, long: 15, deep: 50,
    longBreakInterval: 4, dailyGoal: 8,
    alertSound: 'bell', alertVolume: 80,
};

const STORAGE_KEY = 'taskvel_pomodoro';

/*─────────────────────────────────────────────────────────────────────
  INIT
─────────────────────────────────────────────────────────────────────*/
document.addEventListener('DOMContentLoaded', function() {
    loadSettings();
    restorePomodoro();
    wireButtons();
    wireStopwatch();
    wireSounds();
    wireGoal();
    wireToggles();
    wirePresets();
    wireCustomMode();
    wireSettingsModal();
    initBrowserNotifications();
    updateSessionBoxes();
    updateStreak();
    // Persist every 10s
    if (document.getElementById('timerDisplay')) {
        setInterval(savePomodoro, 10000);
    }
});

/*─────────────────────────────────────────────────────────────────────
  SETTINGS
─────────────────────────────────────────────────────────────────────*/
function loadSettings() {
    const saved = sessionStorage.getItem('taskvel_settings');
    if (saved) {
        try { settings = { ...settings, ...JSON.parse(saved) }; } catch(e) {}
    }
    // Populate modal inputs
    Object.keys(settings).forEach(k => {
        const el = document.getElementById('setting_' + k);
        if (el) el.value = settings[k];
    });
    applyModeMinutes();
}

function saveSettings() {
    ['focus','short','long','deep','longBreakInterval','dailyGoal','alertSound','alertVolume'].forEach(k => {
        const el = document.getElementById('setting_' + k);
        if (el) settings[k] = isNaN(el.value) ? el.value : parseInt(el.value);
    });
    sessionStorage.setItem('taskvel_settings', JSON.stringify(settings));
    // Update active mode duration if it changed
    applyModeMinutes();
    // Rebuild session boxes
    updateSessionBoxes();
    bootstrap.Modal.getInstance(document.getElementById('settingsModal'))?.hide();
    if (typeof showToast === 'function') showToast('Settings', 'Timer settings saved.', 'success');
}

function applyModeMinutes() {
    document.querySelectorAll('.mode-btn').forEach(btn => {
        const mode = btn.dataset.mode;
        if (settings[mode] !== undefined) {
            btn.dataset.minutes = settings[mode];
        }
    });
}

function wireSettingsModal() {
    document.getElementById('saveSettings')?.addEventListener('click', saveSettings);
}

/*─────────────────────────────────────────────────────────────────────
  TIMER CORE
─────────────────────────────────────────────────────────────────────*/
function startPomodoro() {
    if (timerRunning) return;
    clearInterval(timer);
    timerRunning = true;
    setStatus('Running…');
    document.getElementById('timerCircle')?.classList.add('timer-running-pulse');
    savePomodoro();
    updateFloatingWidget();

    timer = setInterval(() => {
        remainingSeconds = Math.max(remainingSeconds - 1, 0);
        updateTimerDisplay();
        updateCircleProgress();
        updateFloatingWidget();
        if (remainingSeconds === 0) completePomodoro();
    }, 1000);
}

function pausePomodoro() {
    timerRunning = false;
    clearInterval(timer);
    setStatus('Paused');
    document.getElementById('timerCircle')?.classList.remove('timer-running-pulse');
    savePomodoro();
    updateFloatingWidget();
}

function resetPomodoro() {
    pausePomodoro();
    remainingSeconds = totalSeconds;
    updateTimerDisplay();
    updateCircleProgress();
    setStatus('Ready');
    savePomodoro();
    updateFloatingWidget();
}

function skipPomodoro() {
    pausePomodoro();
    advanceMode();
}

function completePomodoro() {
    pausePomodoro();
    completedRounds++;
    updateRoundDots();
    incrementCompletedSessions();
    calculateFocusStreak();
    updateGoalProgress();
    savePomodoro();
    playAlert();
    sendNotification('Session Complete 🎉', 'Great work! Time for a break.');
    setStatus('Complete ✓');
    if (typeof showToast === 'function') showToast('Session Complete', 'Excellent work! 🎉', 'success');

    // Auto-advance
    const autoBreak = document.getElementById('autoStartBreaks')?.checked;
    const autoFocus = document.getElementById('autoStart')?.checked;
    if ((currentMode === 'focus' || currentMode === 'deep') && autoBreak) {
        setTimeout(() => advanceMode(true), 1500);
    } else if ((currentMode === 'short' || currentMode === 'long') && autoFocus) {
        setTimeout(() => { setMode('focus'); startPomodoro(); }, 1500);
    }
}

function advanceMode(autoStart = false) {
    if (currentMode === 'focus' || currentMode === 'deep') {
        const goLong = completedRounds > 0 && completedRounds % settings.longBreakInterval === 0;
        setMode(goLong ? 'long' : 'short');
    } else {
        setMode('focus');
    }
    if (autoStart) startPomodoro();
}

function setMode(mode, minutes = null) {
    currentMode = mode;
    if (minutes) {
        totalSeconds = minutes * 60;
    } else {
        const map = { focus: settings.focus, short: settings.short, long: settings.long, deep: settings.deep };
        totalSeconds = (map[mode] ?? 25) * 60;
    }
    remainingSeconds = totalSeconds;

    document.querySelectorAll('.mode-btn').forEach(b => b.classList.toggle('active', b.dataset.mode === mode));

    const modeLabels = { focus:'Focus Session', short:'Short Break', long:'Long Break', deep:'Deep Work', custom:'Custom Timer' };
    document.getElementById('timerModeLabel').textContent = modeLabels[mode] ?? 'Timer';

    // Ring color
    const ring = document.getElementById('progressRing');
    if (ring) {
        const colors = { focus:'url(#ringGrad)', short:'#10b981', long:'#0ea5e9', deep:'#f59e0b', custom:'#ec4899' };
        ring.setAttribute('stroke', colors[mode] ?? 'url(#ringGrad)');
    }

    updateTimerDisplay();
    updateCircleProgress();
    setStatus('Ready');
    savePomodoro();
}

/*─────────────────────────────────────────────────────────────────────
  DISPLAY HELPERS
─────────────────────────────────────────────────────────────────────*/
function updateTimerDisplay() {
    const el = document.getElementById('timerDisplay');
    if (!el) return;
    const m = Math.floor(remainingSeconds / 60);
    const s = remainingSeconds % 60;
    el.textContent = String(m).padStart(2,'0') + ':' + String(s).padStart(2,'0');
    // Update page title
    document.title = (timerRunning ? '▶ ' : '') + el.textContent + ' · Taskvel Focus';
}

function updateCircleProgress() {
    const circle = document.getElementById('progressRing');
    if (!circle) return;
    const circ = 848;
    const ratio = totalSeconds > 0 ? remainingSeconds / totalSeconds : 0;
    circle.style.strokeDashoffset = circ - (circ * ratio);
}

function setStatus(text) {
    const el = document.getElementById('timerStatus');
    if (el) el.textContent = text;
}

function updateRoundDots() {
    document.querySelectorAll('.round-dot').forEach((dot, i) => {
        dot.classList.remove('done','current');
        if (i < completedRounds % 4) dot.classList.add('done');
        if (i === completedRounds % 4 && timerRunning) dot.classList.add('current');
    });
}

/*─────────────────────────────────────────────────────────────────────
  WIRE BUTTONS
─────────────────────────────────────────────────────────────────────*/
function wireButtons() {
    document.getElementById('startBtn')?.addEventListener('click', startPomodoro);
    document.getElementById('pauseBtn')?.addEventListener('click', pausePomodoro);
    document.getElementById('resetBtn')?.addEventListener('click', resetPomodoro);
    document.getElementById('skipBtn')?.addEventListener('click',  skipPomodoro);

    document.querySelectorAll('.mode-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const mode = this.dataset.mode;
            if (mode === 'custom') {
                document.getElementById('customDurationRow').style.setProperty('display','flex','important');
                document.querySelectorAll('.mode-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                currentMode = 'custom';
                return;
            }
            document.getElementById('customDurationRow').style.removeProperty('display');
            setMode(mode);
        });
    });

    // Keyboard
    document.addEventListener('keydown', function(e) {
        if (e.repeat) return;
        if (['INPUT','TEXTAREA','SELECT'].includes(document.activeElement.tagName)) return;
        if (e.code === 'Space') { e.preventDefault(); timerRunning ? pausePomodoro() : startPomodoro(); }
        if (e.key.toLowerCase() === 'r') resetPomodoro();
        if (e.key.toLowerCase() === 's') skipPomodoro();
    });
}

function wirePresets() {
    document.querySelectorAll('.preset-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.preset-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            const mins = parseInt(this.dataset.minutes);
            setMode('custom', mins);
            // Highlight custom mode btn
            document.querySelectorAll('.mode-btn').forEach(b => b.classList.toggle('active', b.dataset.mode === 'custom'));
        });
    });
}

function wireCustomMode() {
    document.getElementById('applyCustom')?.addEventListener('click', function() {
        const mins = parseInt(document.getElementById('customMinutes')?.value || 25);
        if (mins < 1 || mins > 180) { alert('Enter 1–180 minutes'); return; }
        setMode('custom', mins);
        document.getElementById('customDurationRow').style.removeProperty('display');
    });
}

/*─────────────────────────────────────────────────────────────────────
  SESSION STORAGE PERSISTENCE
─────────────────────────────────────────────────────────────────────*/
function savePomodoro() {
    const data = {
        mode: currentMode,
        total: totalSeconds,
        remaining: remainingSeconds,
        timerRunning,
        startedAt: timerRunning ? Date.now() - ((totalSeconds - remainingSeconds) * 1000) : null,
        completedRounds,
        completed: document.getElementById('completedSessions')?.textContent || 0,
    };
    sessionStorage.setItem(STORAGE_KEY, JSON.stringify(data));
}

function restorePomodoro() {
    const raw = sessionStorage.getItem(STORAGE_KEY);
    if (!raw) { updateTimerDisplay(); updateCircleProgress(); return; }
    try {
        const s = JSON.parse(raw);
        currentMode      = s.mode || 'focus';
        totalSeconds     = Number(s.total) || 1500;
        completedRounds  = Number(s.completedRounds) || 0;

        if (s.timerRunning && s.startedAt) {
            const elapsed = Math.floor((Date.now() - s.startedAt) / 1000);
            remainingSeconds = Math.max(totalSeconds - elapsed, 0);
        } else {
            remainingSeconds = Number(s.remaining) || totalSeconds;
        }

        updateTimerDisplay();
        updateCircleProgress();
        updateRoundDots();

        const el = document.getElementById('completedSessions');
        if (el) el.textContent = s.completed || 0;

        document.querySelectorAll('.mode-btn').forEach(b => {
            b.classList.toggle('active', b.dataset.mode === currentMode);
        });

        if (s.timerRunning && remainingSeconds > 0) {
            timerRunning = false;
            startPomodoro();
        }
    } catch(e) { console.error('Restore failed', e); }
}

/*─────────────────────────────────────────────────────────────────────
  FLOATING WIDGET
─────────────────────────────────────────────────────────────────────*/
function injectFloatingWidget() {
    if (document.getElementById('tvFloatWidget')) return;
    const w = document.createElement('div');
    w.id = 'tvFloatWidget';
    w.innerHTML = `
        <span id="tvFloatTime" style="font-variant-numeric:tabular-nums;">--:--</span>
        <button id="tvFloatPause" title="Pause/Resume" style="background:rgba(255,255,255,.2);border:none;color:#fff;width:28px;height:28px;border-radius:50%;cursor:pointer;">⏸</button>
        <a id="tvFloatLink" href="/focus" style="color:rgba(255,255,255,.85);font-size:.75rem;font-weight:600;text-decoration:none;">Focus</a>
    `;
    w.style.cssText='position:fixed;bottom:24px;right:24px;display:none;align-items:center;gap:10px;background:var(--primary,#4f46e5);color:#fff;padding:10px 16px;border-radius:999px;box-shadow:0 8px 24px rgba(79,70,229,.35);font-weight:700;font-size:.95rem;z-index:9999;';
    w.querySelector('#tvFloatPause').addEventListener('click', () => {
        timerRunning ? pausePomodoro() : startPomodoro();
    });
    document.body.appendChild(w);
}

function updateFloatingWidget() {
    let w = document.getElementById('tvFloatWidget');
    if (!w) { injectFloatingWidget(); w = document.getElementById('tvFloatWidget'); }
    if (!w) return;
    const active = remainingSeconds > 0 && remainingSeconds < totalSeconds;
    w.style.display = active ? 'flex' : 'none';
    const t = document.getElementById('tvFloatTime');
    const b = document.getElementById('tvFloatPause');
    if (t) t.textContent = String(Math.floor(remainingSeconds/60)).padStart(2,'0') + ':' + String(remainingSeconds%60).padStart(2,'0');
    if (b) b.textContent = timerRunning ? '⏸' : '▶';
}

/*─────────────────────────────────────────────────────────────────────
  COMPLETED SESSIONS & STREAK
─────────────────────────────────────────────────────────────────────*/
function incrementCompletedSessions() {
    const el = document.getElementById('completedSessions');
    if (!el) return;
    let v = parseInt(el.textContent) || 0;
    el.textContent = ++v;
    updateGoalProgress();
}

function calculateFocusStreak() {
    let streak = parseInt(sessionStorage.getItem('focus_streak') || 0) + 1;
    sessionStorage.setItem('focus_streak', streak);
    const el = document.getElementById('focusStreak');
    if (el) el.textContent = streak;
    const stat = document.getElementById('statStreak');
    if (stat) stat.textContent = streak;
}

function updateStreak() {
    const s = parseInt(sessionStorage.getItem('focus_streak') || 0);
    const el = document.getElementById('focusStreak');
    if (el) el.textContent = s;
    const stat = document.getElementById('statStreak');
    if (stat) stat.textContent = s;
}

/*─────────────────────────────────────────────────────────────────────
  GOAL
─────────────────────────────────────────────────────────────────────*/
function wireGoal() {
    document.getElementById('editGoalBtn')?.addEventListener('click', () => {
        const row = document.getElementById('goalEditRow');
        row.style.display = row.style.display === 'none' ? 'block' : 'none';
    });
    document.getElementById('saveGoalBtn')?.addEventListener('click', () => {
        settings.dailyGoal = parseInt(document.getElementById('goalInput')?.value || 8);
        sessionStorage.setItem('taskvel_settings', JSON.stringify(settings));
        document.getElementById('goalEditRow').style.display = 'none';
        updateSessionBoxes();
        updateGoalProgress();
    });
    updateGoalProgress();
}

function updateSessionBoxes() {
    const goal = settings.dailyGoal || 8;
    const container = document.getElementById('sessionBoxes');
    if (!container) return;
    container.innerHTML = '';
    for (let i = 0; i < goal; i++) {
        const d = document.createElement('div');
        d.className = 'session-box';
        d.dataset.box = i;
        container.appendChild(d);
    }
    document.getElementById('goalTarget').textContent = goal;
    document.getElementById('goalInput').value        = goal;
    const setting = document.getElementById('setting_dailyGoal');
    if (setting) setting.value = goal;
    updateGoalProgress();
}

function updateGoalProgress() {
    const completed = parseInt(document.getElementById('completedSessions')?.textContent || 0);
    const goal      = settings.dailyGoal || 8;
    const pct       = Math.min(Math.round((completed / goal) * 100), 100);

    document.getElementById('goalCompleted').textContent = completed;
    document.getElementById('goalTarget').textContent    = goal;
    document.getElementById('goalPercent').textContent   = pct + '%';
    const bar = document.getElementById('goalProgressBar');
    if (bar) { bar.style.width = pct + '%'; bar.className = 'progress-bar' + (pct >= 100 ? ' bg-success' : ''); }

    document.querySelectorAll('.session-box').forEach((box, i) => {
        box.classList.toggle('done', i < completed);
    });

    const stat = document.getElementById('statGoal');
    if (stat) stat.textContent = pct + '%';
}

function initializeDailyGoal() { updateGoalProgress(); }

/*─────────────────────────────────────────────────────────────────────
  TOGGLES
─────────────────────────────────────────────────────────────────────*/
function wireToggles() {
    const load = (id, key) => {
        const el = document.getElementById(id);
        if (!el) return;
        el.checked = sessionStorage.getItem(key) === '1';
        el.addEventListener('change', () => sessionStorage.setItem(key, el.checked ? '1' : '0'));
    };
    load('autoStart',       'auto_start');
    load('autoStartBreaks', 'auto_start_breaks');
    load('idlePause',       'idle_pause');
    load('notifToggle',     'notif_enabled');

    // Idle detection
    let idleTimer = null;
    const resetIdle = () => {
        clearTimeout(idleTimer);
        const enabled = sessionStorage.getItem('idle_pause') !== '0';
        if (!enabled) return;
        idleTimer = setTimeout(() => {
            if (!timerRunning) return;
            pausePomodoro();
            if (typeof showToast === 'function') showToast('Paused', 'Auto-paused due to inactivity.', 'warning');
        }, 300000);
    };
    ['mousemove','keydown','scroll','click'].forEach(e => document.addEventListener(e, resetIdle));
}

/*─────────────────────────────────────────────────────────────────────
  STOPWATCH (with lap + milliseconds)
─────────────────────────────────────────────────────────────────────*/
function wireStopwatch() {
    document.getElementById('startStopwatch')?.addEventListener('click', startSW);
    document.getElementById('stopStopwatch')?.addEventListener('click',  stopSW);
    document.getElementById('lapStopwatch')?.addEventListener('click',   lapSW);
    document.getElementById('resetStopwatch')?.addEventListener('click', resetSW);
}

function startSW() {
    if (swRunning) return;
    swRunning = true;
    const start = Date.now() - swTotal;
    sw = setInterval(() => {
        swTotal = Date.now() - start;
        renderSW();
    }, 50);
}
function stopSW()  { swRunning = false; clearInterval(sw); }
function resetSW() { stopSW(); swTotal = 0; laps = []; renderSW(); renderLaps(); }
function lapSW() {
    if (!swRunning) return;
    laps.push(swTotal);
    renderLaps();
    document.getElementById('stopwatchLapCount').textContent = laps.length + ' lap' + (laps.length!==1?'s':'');
}
function renderSW() {
    const ms   = swTotal;
    const h    = Math.floor(ms / 3600000);
    const m    = Math.floor((ms % 3600000) / 60000);
    const s    = Math.floor((ms % 60000)   / 1000);
    const cs   = Math.floor((ms % 1000) / 10);
    document.getElementById('stopwatchDisplay').textContent =
        String(h).padStart(2,'0') + ':' + String(m).padStart(2,'0') + ':' + String(s).padStart(2,'0');
    document.getElementById('stopwatchMs').textContent = '.' + String(cs).padStart(2,'0');
}
function renderLaps() {
    const el = document.getElementById('lapList');
    if (!el) return;
    if (!laps.length) { el.innerHTML=''; return; }
    el.innerHTML = laps.map((t, i) => {
        const split = i > 0 ? t - laps[i-1] : t;
        return `<div class="lap-item">
            <span class="text-muted">Lap ${i+1}</span>
            <span class="fw-semibold">${fmtMs(t)}</span>
            <span class="text-muted">+${fmtMs(split)}</span>
        </div>`;
    }).reverse().join('');
}
function fmtMs(ms) {
    const m = Math.floor(ms/60000);
    const s = Math.floor((ms%60000)/1000);
    const c = Math.floor((ms%1000)/10);
    return String(m).padStart(2,'0')+':'+String(s).padStart(2,'0')+'.'+String(c).padStart(2,'0');
}

/*─────────────────────────────────────────────────────────────────────
  AMBIENT SOUNDS (Web Audio API tone generation)
─────────────────────────────────────────────────────────────────────*/
let audioCtx = null, gainNode = null, activeSound = null, noiseNode = null;

function wireSounds() {
    document.querySelectorAll('.sound-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.sound;
            if (this.classList.contains('active')) {
                stopSound(); this.classList.remove('active'); return;
            }
            document.querySelectorAll('.sound-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            playSound(id);
        });
    });
    document.getElementById('soundVolume')?.addEventListener('input', function() {
        if (gainNode) gainNode.gain.value = parseInt(this.value) / 100;
    });
}

function getAudioCtx() {
    if (!audioCtx) audioCtx = new (window.AudioContext || window.webkitAudioContext)();
    return audioCtx;
}

function stopSound() {
    try { noiseNode?.stop(); } catch(e) {}
    try { activeSound?.stop(); } catch(e) {}
    noiseNode = null; activeSound = null;
}

function playSound(type) {
    stopSound();
    try {
        const ctx  = getAudioCtx();
        gainNode   = ctx.createGain();
        const vol  = parseInt(document.getElementById('soundVolume')?.value || 50) / 100;
        gainNode.gain.value = vol;
        gainNode.connect(ctx.destination);

        // White/pink noise base
        const bufSize = ctx.sampleRate * 3;
        const buffer  = ctx.createBuffer(1, bufSize, ctx.sampleRate);
        const data    = buffer.getChannelData(0);

        for (let i = 0; i < bufSize; i++) {
            data[i] = (Math.random() * 2 - 1);
        }

        // Apply character per sound type
        const filter = ctx.createBiquadFilter();
        switch(type) {
            case 'rain':    filter.type='bandpass'; filter.frequency.value=800;  filter.Q.value=0.5; break;
            case 'forest':  filter.type='bandpass'; filter.frequency.value=600;  filter.Q.value=0.8; break;
            case 'coffee':  filter.type='lowpass';  filter.frequency.value=1200; break;
            case 'waves':   filter.type='lowpass';  filter.frequency.value=400;  break;
            case 'white':   filter.type='allpass';  break;
            case 'fire':    filter.type='lowpass';  filter.frequency.value=300;  break;
            case 'thunder': filter.type='lowpass';  filter.frequency.value=200;  break;
            case 'birds':   filter.type='highpass'; filter.frequency.value=1500; break;
            default:        filter.type='allpass';
        }

        noiseNode = ctx.createBufferSource();
        noiseNode.buffer = buffer;
        noiseNode.loop   = true;
        noiseNode.connect(filter);
        filter.connect(gainNode);
        noiseNode.start();
    } catch(e) { console.warn('Audio not available', e); }
}

/*─────────────────────────────────────────────────────────────────────
  ALERT SOUND (on completion)
─────────────────────────────────────────────────────────────────────*/
function playAlert() {
    try {
        const ctx  = getAudioCtx();
        const vol  = (settings.alertVolume || 80) / 100;
        const gain = ctx.createGain();
        gain.gain.value = vol;
        gain.connect(ctx.destination);

        // Simple bell tone
        const osc = ctx.createOscillator();
        osc.type = 'sine';
        osc.frequency.setValueAtTime(880, ctx.currentTime);
        osc.frequency.exponentialRampToValueAtTime(440, ctx.currentTime + 1);
        osc.connect(gain);
        gain.gain.setValueAtTime(vol, ctx.currentTime);
        gain.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + 1.5);
        osc.start();
        osc.stop(ctx.currentTime + 1.5);
    } catch(e) {}
}

/*─────────────────────────────────────────────────────────────────────
  BROWSER NOTIFICATIONS
─────────────────────────────────────────────────────────────────────*/
function initBrowserNotifications() {
    if (typeof Notification === 'undefined') return;
    const btn = document.getElementById('notifToggle');
    if (Notification.permission === 'default') {
        btn?.addEventListener('change', function() {
            if (this.checked) Notification.requestPermission();
        });
    }
}

function sendNotification(title, body) {
    if (typeof Notification === 'undefined') return;
    if (Notification.permission !== 'granted') return;
    if (sessionStorage.getItem('notif_enabled') === '0') return;
    new Notification(title, { body, icon: '/favicon.ico' });
}

// Expose for focus.js compat
window.showToast = window.showToast || function(t, m) { console.log(t, m); };
</script>
@endpush