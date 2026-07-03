@extends('layouts.app')

@section('title', 'Add Remark')

@push('styles')
<style>
.remark-textarea {
    font-size: .93rem;
    line-height: 1.8;
    border-radius: 14px !important;
    resize: vertical;
    min-height: 180px;
    transition: border-color .2s, box-shadow .2s;
}
.remark-textarea:focus {
    border-color: var(--primary, #4f46e5) !important;
    box-shadow: 0 0 0 .2rem rgba(79,70,229,.15) !important;
}

.template-btn {
    border: 1.5px dashed #cbd5e1;
    border-radius: 10px;
    padding: 8px 12px;
    font-size: .78rem;
    font-weight: 600;
    color: #64748b;
    background: #f8fafc;
    cursor: pointer;
    transition: .2s;
    text-align: left;
}
.template-btn:hover {
    border-color: #4f46e5;
    background: rgba(79,70,229,.05);
    color: #4f46e5;
}

.char-bar { height: 4px; border-radius: 20px; background: #e2e8f0; overflow: hidden; }
.char-bar-fill { height: 100%; border-radius: 20px; background: #4f46e5; transition: width .2s, background .2s; }

.preview-box {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    padding: 18px;
    min-height: 80px;
    font-size: .9rem;
    line-height: 1.75;
    white-space: pre-wrap;
    word-break: break-word;
    color: #334155;
}

.task-info-card {
    background: rgba(79,70,229,.05);
    border: 1px solid rgba(79,70,229,.12);
    border-radius: 14px;
    padding: 14px 16px;
}

.mood-btn {
    border: 1.5px solid #e2e8f0;
    border-radius: 10px;
    padding: 6px 10px;
    font-size: 1.1rem;
    background: #fff;
    cursor: pointer;
    transition: .15s;
    line-height: 1;
}
.mood-btn:hover, .mood-btn.active {
    border-color: #4f46e5;
    background: rgba(79,70,229,.08);
    transform: scale(1.15);
}
</style>
@endpush

@section('content')

<div class="container-fluid px-3 px-lg-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Add Remark</h2>
            <p class="text-muted mb-0">Log a note, blocker or progress update for a task.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('remarks.index') }}" class="btn btn-secondary btn-sm">
                <i class="bi bi-list me-1"></i>All Remarks
            </a>
            @if(isset($task))
                <a href="{{ route('tasks.show', $task) }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-arrow-left me-1"></i>Back to Task
                </a>
            @endif
        </div>
    </div>

    @if($errors->any())
        <div class="alert alert-danger border-0 shadow-sm mb-4" style="border-radius:14px;">
            <i class="bi bi-exclamation-circle me-2"></i>
            <strong>Please fix:</strong>
            <ul class="mb-0 mt-1">
                @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('remarks.store') }}" id="remarkForm">
        @csrf

        <div class="row g-4">

            {{-- ── Left — Main Form ──────────────────────────────────── --}}
            <div class="col-lg-8">

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-chat-left-text me-2 text-primary"></i>Write Your Remark
                        </h5>
                    </div>
                    <div class="card-body">

                        {{-- Task selector --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Task <span class="text-danger">*</span></label>
                            @if(isset($task))
                                <input type="hidden" name="task_id" value="{{ $task->id }}">
                                <div class="task-info-card">
                                    <div class="d-flex align-items-center gap-3">
                                        <div style="width:36px;height:36px;border-radius:10px;background:rgba(79,70,229,.1);
                                                    display:flex;align-items:center;justify-content:center;color:#4f46e5;">
                                            <i class="bi bi-tag"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold" style="font-size:.95rem;">{{ $task->title }}</div>
                                            <div class="text-muted" style="font-size:.78rem;">
                                                {{ ucfirst($task->priority) }} priority
                                                · {{ ucwords(str_replace('_',' ',$task->status)) }}
                                                @if($task->due_date) · Due {{ $task->due_date->format('d M Y') }} @endif
                                            </div>
                                        </div>
                                        <div class="ms-auto">
                                            <a href="{{ route('tasks.show', $task) }}"
                                               class="btn btn-sm btn-primary" style="border-radius:8px;">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </div>
                                    </div>
                                    @if(($task->progress ?? 0) > 0)
                                        <div class="mt-3">
                                            <div class="d-flex justify-content-between mb-1">
                                                <small class="text-muted">Task progress</small>
                                                <small class="fw-semibold text-primary">{{ $task->progress }}%</small>
                                            </div>
                                            <div class="progress" style="height:5px;border-radius:20px;">
                                                <div class="progress-bar" style="width:{{ $task->progress }}%;"></div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @else
                                <select name="task_id" class="form-select @error('task_id') is-invalid @enderror" id="taskSelect">
                                    <option value="">Select a task…</option>
                                    @foreach($tasks as $t)
                                        <option value="{{ $t->id }}" @selected(old('task_id')==$t->id)>
                                            {{ $t->title }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('task_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            @endif
                        </div>

                        {{-- Remark textarea --}}
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label class="form-label fw-semibold mb-0">
                                    Remark <span class="text-danger">*</span>
                                </label>
                                <button type="button" class="btn btn-xs btn-secondary btn-sm"
                                        style="border-radius:8px;font-size:.75rem;"
                                        id="previewToggle">
                                    <i class="bi bi-eye me-1"></i>Preview
                                </button>
                            </div>

                            <textarea id="remarkTextarea" name="remark" rows="8" maxlength="1000"
                                      class="form-control remark-textarea @error('remark') is-invalid @enderror"
                                      placeholder="What's the update? Any blockers? Progress notes?…">{{ old('remark') }}</textarea>

                            @error('remark') <div class="invalid-feedback">{{ $message }}</div> @enderror

                            {{-- Char counter --}}
                            <div class="mt-2">
                                <div class="char-bar mb-1">
                                    <div class="char-bar-fill" id="charBarFill" style="width:0%;"></div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <small class="text-muted" id="charHint">Start typing your remark…</small>
                                    <small id="charCounter" class="fw-semibold" style="color:#94a3b8;">0 / 1000</small>
                                </div>
                            </div>
                        </div>

                        {{-- Preview box --}}
                        <div id="previewBox" style="display:none;" class="mb-3">
                            <label class="form-label fw-semibold text-muted" style="font-size:.8rem;">PREVIEW</label>
                            <div class="preview-box" id="previewContent">Your remark will appear here…</div>
                        </div>

                        {{-- Mood / tone tag --}}
                        <div class="mb-0">
                            <label class="form-label fw-semibold" style="font-size:.85rem;">Tone (optional)</label>
                            <input type="hidden" name="tone" id="toneInput" value="">
                            <div class="d-flex gap-2 flex-wrap">
                                @foreach(['✅ Progress','⚠️ Blocker','💡 Idea','🐛 Bug','📌 Note','🚀 Done','❓ Question'] as $mood)
                                    <button type="button" class="mood-btn" data-tone="{{ $mood }}">
                                        {{ $mood }}
                                    </button>
                                @endforeach
                            </div>
                        </div>

                    </div>
                </div>

                {{-- Submit --}}
                <div class="card border-0 shadow-sm">
                    <div class="card-body d-flex gap-3 align-items-center">
                        <button type="submit" class="btn btn-primary btn-lg fw-semibold px-4">
                            <i class="bi bi-send me-2"></i>Save Remark
                        </button>
                        <a href="{{ route('remarks.index') }}" class="btn btn-secondary btn-lg">
                            Cancel
                        </a>
                        <button type="button" id="saveDraftBtn" class="btn btn-secondary ms-auto"
                                style="border-radius:10px;font-size:.85rem;">
                            <i class="bi bi-floppy me-1"></i>Save Draft
                        </button>
                    </div>
                </div>

            </div>

            {{-- ── Right — Templates & Tips ────────────────────────── --}}
            <div class="col-lg-4">

                {{-- Quick Templates --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-lightning me-2 text-primary"></i>Quick Templates
                        </h5>
                    </div>
                    <div class="card-body d-flex flex-column gap-2">
                        @php
                            $templates = [
                                ['icon'=>'✅', 'label'=>'Progress update',
                                 'text'=>"Progress update:\n- Completed: \n- In progress: \n- Next steps: "],
                                ['icon'=>'⚠️', 'label'=>'Blocker',
                                 'text'=>"Blocker identified:\n- Issue: \n- Impact: \n- Possible solutions: "],
                                ['icon'=>'🐛', 'label'=>'Bug found',
                                 'text'=>"Bug found:\n- Description: \n- Steps to reproduce: \n- Expected vs actual: "],
                                ['icon'=>'💡', 'label'=>'Idea / suggestion',
                                 'text'=>"Suggestion:\n- Idea: \n- Why it helps: \n- Effort estimate: "],
                                ['icon'=>'🚀', 'label'=>'Task completed',
                                 'text'=>"Task completed ✅\n- What was done: \n- Time taken: \n- Notes for future: "],
                                ['icon'=>'📅', 'label'=>'Daily standup',
                                 'text'=>"Standup note:\n- Yesterday: \n- Today: \n- Blockers: "],
                            ];
                        @endphp
                        @foreach($templates as $tpl)
                            <button type="button" class="template-btn"
                                    data-template="{{ $tpl['text'] }}">
                                <span class="me-2">{{ $tpl['icon'] }}</span>{{ $tpl['label'] }}
                            </button>
                        @endforeach
                    </div>
                </div>

                {{-- Draft saved indicator --}}
                <div class="card border-0 shadow-sm mb-4" id="draftCard" style="display:none!important;">
                    <div class="card-body py-3 d-flex align-items-center gap-3">
                        <i class="bi bi-floppy text-success fs-5"></i>
                        <div>
                            <div class="fw-semibold" style="font-size:.88rem;">Draft saved</div>
                            <div class="text-muted" id="draftTime" style="font-size:.75rem;"></div>
                        </div>
                        <button type="button" id="clearDraftBtn" class="btn btn-sm btn-danger ms-auto"
                                style="border-radius:8px;font-size:.72rem;">Discard</button>
                    </div>
                </div>

                {{-- Writing tips --}}
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-lightbulb me-2 text-warning"></i>Tips
                        </h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0" style="font-size:.85rem;line-height:1.9;">
                            <li class="mb-2"><i class="bi bi-check2 text-success me-2"></i>Be specific — mention what changed</li>
                            <li class="mb-2"><i class="bi bi-check2 text-success me-2"></i>Include blockers or dependencies</li>
                            <li class="mb-2"><i class="bi bi-check2 text-success me-2"></i>Note next steps or decisions needed</li>
                            <li class="mb-2"><i class="bi bi-check2 text-success me-2"></i>Use tone tags to classify quickly</li>
                            <li><i class="bi bi-check2 text-success me-2"></i>Drafts auto-save every 30 seconds</li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </form>
</div>

@endsection

@push('scripts')
<script>
const textarea    = document.getElementById('remarkTextarea');
const charCounter = document.getElementById('charCounter');
const charBarFill = document.getElementById('charBarFill');
const charHint    = document.getElementById('charHint');
const previewBox  = document.getElementById('previewBox');
const previewContent = document.getElementById('previewContent');
const toneInput   = document.getElementById('toneInput');
const draftKey    = 'taskvel_remark_draft_{{ optional($task)->id ?? "general" }}';

/*── Character counter ────────────────────────────────────────────────*/
function updateCounter() {
    const len = textarea.value.length;
    const pct = (len / 1000) * 100;
    charCounter.textContent = len + ' / 1000';
    charBarFill.style.width = pct + '%';
    charBarFill.style.background = pct > 90 ? '#ef4444' : pct > 70 ? '#f59e0b' : '#4f46e5';
    charHint.textContent = len === 0 ? 'Start typing your remark…'
        : len < 20 ? 'Keep going…'
        : len < 100 ? 'Good start — add more detail'
        : 'Looking good ✓';
    charHint.style.color = len > 900 ? '#ef4444' : '#94a3b8';
    if (previewBox.style.display !== 'none') {
        previewContent.textContent = textarea.value || 'Your remark will appear here…';
    }
}
textarea.addEventListener('input', updateCounter);
updateCounter();

/*── Preview toggle ───────────────────────────────────────────────────*/
document.getElementById('previewToggle')?.addEventListener('click', function () {
    const showing = previewBox.style.display !== 'none';
    previewBox.style.display = showing ? 'none' : 'block';
    this.innerHTML = showing
        ? '<i class="bi bi-eye me-1"></i>Preview'
        : '<i class="bi bi-eye-slash me-1"></i>Hide';
    if (!showing) previewContent.textContent = textarea.value || 'Your remark will appear here…';
});

/*── Templates ────────────────────────────────────────────────────────*/
document.querySelectorAll('.template-btn').forEach(btn => {
    btn.addEventListener('click', function () {
        textarea.value = this.dataset.template;
        textarea.focus();
        updateCounter();
    });
});

/*── Mood / tone ─────────────────────────────────────────────────────*/
document.querySelectorAll('.mood-btn').forEach(btn => {
    btn.addEventListener('click', function () {
        document.querySelectorAll('.mood-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        toneInput.value = this.dataset.tone;
    });
});

/*── Draft auto-save ─────────────────────────────────────────────────*/
function saveDraft() {
    if (!textarea.value.trim()) return;
    sessionStorage.setItem(draftKey, textarea.value);
    sessionStorage.setItem(draftKey + '_time', new Date().toLocaleTimeString());
    showDraftCard();
}

function showDraftCard() {
    const card = document.getElementById('draftCard');
    const time = document.getElementById('draftTime');
    if (card) {
        card.style.setProperty('display', 'block', 'important');
        if (time) time.textContent = 'Saved at ' + (sessionStorage.getItem(draftKey + '_time') || '');
    }
}

function loadDraft() {
    const draft = sessionStorage.getItem(draftKey);
    if (draft && !textarea.value.trim()) {
        textarea.value = draft;
        updateCounter();
        showDraftCard();
    }
}

document.getElementById('saveDraftBtn')?.addEventListener('click', saveDraft);

document.getElementById('clearDraftBtn')?.addEventListener('click', function () {
    sessionStorage.removeItem(draftKey);
    sessionStorage.removeItem(draftKey + '_time');
    document.getElementById('draftCard').style.setProperty('display', 'none', 'important');
});

// Auto-save every 30 seconds
setInterval(saveDraft, 30000);
// Auto-save on typing (debounced)
let draftTimer;
textarea.addEventListener('input', function () {
    clearTimeout(draftTimer);
    draftTimer = setTimeout(saveDraft, 3000);
});

// Clear draft on successful submit
document.getElementById('remarkForm')?.addEventListener('submit', function () {
    sessionStorage.removeItem(draftKey);
    sessionStorage.removeItem(draftKey + '_time');
});

// Load draft on page load
window.addEventListener('load', loadDraft);
</script>
@endpush