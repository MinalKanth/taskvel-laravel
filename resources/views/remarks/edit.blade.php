@extends('layouts.app')

@section('title', 'Edit Remark')

@push('styles')
<style>
.remark-textarea {
    font-size: .93rem; line-height: 1.8;
    border-radius: 14px !important; resize: vertical; min-height: 180px;
    transition: border-color .2s, box-shadow .2s;
}
.remark-textarea:focus {
    border-color: var(--primary,#4f46e5)!important;
    box-shadow: 0 0 0 .2rem rgba(79,70,229,.15)!important;
}
.template-btn {
    border: 1.5px dashed #cbd5e1; border-radius: 10px;
    padding: 8px 12px; font-size: .78rem; font-weight: 600;
    color: #64748b; background: #f8fafc; cursor: pointer; transition: .2s; text-align: left;
}
.template-btn:hover { border-color: #4f46e5; background: rgba(79,70,229,.05); color: #4f46e5; }
.char-bar { height: 4px; border-radius: 20px; background: #e2e8f0; overflow: hidden; }
.char-bar-fill { height: 100%; border-radius: 20px; background: #4f46e5; transition: width .2s, background .2s; }
.preview-box {
    background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 14px;
    padding: 18px; min-height: 80px; font-size: .9rem; line-height: 1.75;
    white-space: pre-wrap; word-break: break-word; color: #334155;
}
.original-remark {
    background: #fffbeb; border: 1px solid #fde68a;
    border-radius: 14px; padding: 14px 16px;
    font-size: .85rem; color: #78350f; line-height: 1.7;
}
.mood-btn {
    border: 1.5px solid #e2e8f0; border-radius: 10px;
    padding: 6px 10px; font-size: 1.1rem; background: #fff;
    cursor: pointer; transition: .15s; line-height: 1;
}
.mood-btn:hover, .mood-btn.active {
    border-color: #4f46e5; background: rgba(79,70,229,.08); transform: scale(1.15);
}
.edit-notice {
    background: rgba(79,70,229,.06); border: 1px solid rgba(79,70,229,.15);
    border-radius: 12px; padding: 10px 14px; font-size: .82rem; color: #4f46e5;
}
</style>
@endpush

@section('content')

<div class="container-fluid px-3 px-lg-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Edit Remark</h2>
            <p class="text-muted mb-0">
                Update your note on
                <a href="{{ route('tasks.show', $remark->task) }}" class="text-primary fw-semibold text-decoration-none">
                    {{ $remark->task->title }}
                </a>
            </p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('remarks.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-list me-1"></i>All Remarks
            </a>
            <a href="{{ route('tasks.show', $remark->task) }}" class="btn btn-outline-primary btn-sm">
                <i class="bi bi-arrow-left me-1"></i>Back to Task
            </a>
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

    <form method="POST" action="{{ route('remarks.update', $remark) }}" id="editForm">
        @csrf
        @method('PUT')

        <div class="row g-4">

            {{-- ── Left ────────────────────────────────────────────── --}}
            <div class="col-lg-8">

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-pencil-square me-2 text-primary"></i>Edit Remark
                        </h5>
                        <div class="edit-notice">
                            <i class="bi bi-info-circle me-1"></i>
                            Originally posted {{ $remark->created_at->diffForHumans() }}
                        </div>
                    </div>
                    <div class="card-body">

                        {{-- Task --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Task <span class="text-danger">*</span></label>
                            <select name="task_id" class="form-select @error('task_id') is-invalid @enderror">
                                @foreach($tasks as $task)
                                    <option value="{{ $task->id }}"
                                            @selected(old('task_id', $remark->task_id) == $task->id)>
                                        {{ $task->title }}
                                    </option>
                                @endforeach
                            </select>
                            @error('task_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Original remark (collapsed) --}}
                        <div class="mb-4">
                            <button type="button" class="btn btn-sm btn-outline-secondary mb-2"
                                    style="border-radius:8px;font-size:.78rem;"
                                    data-bs-toggle="collapse" data-bs-target="#originalRemark">
                                <i class="bi bi-clock-history me-1"></i>Show original
                            </button>
                            <div class="collapse" id="originalRemark">
                                <div class="original-remark">
                                    <div class="fw-semibold mb-1" style="font-size:.75rem;text-transform:uppercase;letter-spacing:.05em;">Original</div>
                                    {{ $remark->remark }}
                                </div>
                            </div>
                        </div>

                        {{-- Textarea --}}
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label class="form-label fw-semibold mb-0">
                                    Updated Remark <span class="text-danger">*</span>
                                </label>
                                <button type="button" class="btn btn-sm btn-outline-secondary"
                                        style="border-radius:8px;font-size:.75rem;" id="previewToggle">
                                    <i class="bi bi-eye me-1"></i>Preview
                                </button>
                            </div>

                            <textarea id="remarkTextarea" name="remark" rows="9" maxlength="1000"
                                      class="form-control remark-textarea @error('remark') is-invalid @enderror">{{ old('remark', $remark->remark) }}</textarea>
                            @error('remark') <div class="invalid-feedback">{{ $message }}</div> @enderror

                            <div class="mt-2">
                                <div class="char-bar mb-1">
                                    <div class="char-bar-fill" id="charBarFill" style="width:0%;"></div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <small class="text-muted" id="charHint"></small>
                                    <small id="charCounter" class="fw-semibold" style="color:#94a3b8;">0 / 1000</small>
                                </div>
                            </div>
                        </div>

                        {{-- Preview --}}
                        <div id="previewBox" style="display:none;" class="mb-3">
                            <label class="form-label fw-semibold text-muted" style="font-size:.8rem;">PREVIEW</label>
                            <div class="preview-box" id="previewContent"></div>
                        </div>

                        {{-- Tone --}}
                        <div class="mb-0">
                            <label class="form-label fw-semibold" style="font-size:.85rem;">Tone (optional)</label>
                            <input type="hidden" name="tone" id="toneInput" value="">
                            <div class="d-flex gap-2 flex-wrap">
                                @foreach(['✅ Progress','⚠️ Blocker','💡 Idea','🐛 Bug','📌 Note','🚀 Done','❓ Question'] as $mood)
                                    <button type="button" class="mood-btn" data-tone="{{ $mood }}">{{ $mood }}</button>
                                @endforeach
                            </div>
                        </div>

                    </div>
                </div>

                {{-- Actions --}}
                <div class="card border-0 shadow-sm">
                    <div class="card-body d-flex gap-3 align-items-center flex-wrap">
                        <button type="submit" class="btn btn-success btn-lg fw-semibold px-4">
                            <i class="bi bi-check-circle me-2"></i>Update Remark
                        </button>
                        <a href="{{ route('remarks.index') }}" class="btn btn-outline-secondary btn-lg">Cancel</a>

                        {{-- Delete --}}
                        <form method="POST" action="{{ route('remarks.destroy', $remark) }}"
                              class="ms-auto" onsubmit="return confirm('Delete this remark permanently?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger">
                                <i class="bi bi-trash me-1"></i>Delete
                            </button>
                        </form>
                    </div>
                </div>

            </div>

            {{-- ── Right ───────────────────────────────────────────── --}}
            <div class="col-lg-4">

                {{-- Task info --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold"><i class="bi bi-info-circle me-2 text-primary"></i>Remark Info</h5>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-borderless mb-0" style="font-size:.85rem;">
                            <tr>
                                <th class="ps-4 text-muted fw-normal" style="width:45%;">Created</th>
                                <td class="pe-4 fw-semibold">{{ $remark->created_at->format('d M Y, H:i') }}</td>
                            </tr>
                            <tr>
                                <th class="ps-4 text-muted fw-normal">Last edited</th>
                                <td class="pe-4 fw-semibold">
                                    @if($remark->updated_at->ne($remark->created_at))
                                        {{ $remark->updated_at->format('d M Y, H:i') }}
                                    @else
                                        <span class="text-muted">Never</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th class="ps-4 text-muted fw-normal">Word count</th>
                                <td class="pe-4 fw-semibold" id="wordCountCell">{{ str_word_count($remark->remark) }}</td>
                            </tr>
                            <tr>
                                <th class="ps-4 text-muted fw-normal">Author</th>
                                <td class="pe-4 fw-semibold">{{ $remark->user->name }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                {{-- Quick Templates --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold"><i class="bi bi-lightning me-2 text-primary"></i>Quick Templates</h5>
                    </div>
                    <div class="card-body d-flex flex-column gap-2">
                        @php
                            $templates = [
                                ['icon'=>'✅','label'=>'Progress update','text'=>"Progress update:\n- Completed: \n- In progress: \n- Next steps: "],
                                ['icon'=>'⚠️','label'=>'Blocker','text'=>"Blocker:\n- Issue: \n- Impact: \n- Solutions: "],
                                ['icon'=>'🚀','label'=>'Task completed','text'=>"Task completed ✅\n- What was done: \n- Notes: "],
                                ['icon'=>'📅','label'=>'Daily standup','text'=>"Standup:\n- Yesterday: \n- Today: \n- Blockers: "],
                            ];
                        @endphp
                        @foreach($templates as $tpl)
                            <button type="button" class="template-btn" data-template="{{ $tpl['text'] }}">
                                <span class="me-2">{{ $tpl['icon'] }}</span>{{ $tpl['label'] }}
                            </button>
                        @endforeach
                    </div>
                </div>

                {{-- Danger zone --}}
                <div class="card border-0 shadow-sm" style="border:1px solid #fecaca!important;">
                    <div class="card-body" style="background:#fff5f5;border-radius:18px;">
                        <h6 class="text-danger fw-bold mb-1"><i class="bi bi-exclamation-triangle me-2"></i>Danger Zone</h6>
                        <p class="text-muted mb-3" style="font-size:.82rem;">Deleting a remark is permanent and cannot be undone.</p>
                        <form method="POST" action="{{ route('remarks.destroy', $remark) }}"
                              onsubmit="return confirm('Permanently delete this remark?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger fw-semibold px-3">
                                <i class="bi bi-trash me-1"></i>Delete Remark
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </form>
</div>

@endsection

@push('scripts')
<script>
const textarea       = document.getElementById('remarkTextarea');
const charCounter    = document.getElementById('charCounter');
const charBarFill    = document.getElementById('charBarFill');
const charHint       = document.getElementById('charHint');
const previewBox     = document.getElementById('previewBox');
const previewContent = document.getElementById('previewContent');
const wordCountCell  = document.getElementById('wordCountCell');

function countWords(str) {
    return str.trim() ? str.trim().split(/\s+/).length : 0;
}

function updateCounter() {
    const len = textarea.value.length;
    const pct = (len / 1000) * 100;
    charCounter.textContent = len + ' / 1000';
    charBarFill.style.width = pct + '%';
    charBarFill.style.background = pct > 90 ? '#ef4444' : pct > 70 ? '#f59e0b' : '#4f46e5';
    charHint.textContent = len === 0 ? 'Nothing typed yet…' : len < 20 ? 'Keep going…' : 'Looking good ✓';
    if (wordCountCell) wordCountCell.textContent = countWords(textarea.value);
    if (previewBox.style.display !== 'none') {
        previewContent.textContent = textarea.value || 'Preview will appear here…';
    }
}

textarea.addEventListener('input', updateCounter);
updateCounter();

// Preview toggle
document.getElementById('previewToggle')?.addEventListener('click', function () {
    const showing = previewBox.style.display !== 'none';
    previewBox.style.display = showing ? 'none' : 'block';
    this.innerHTML = showing ? '<i class="bi bi-eye me-1"></i>Preview' : '<i class="bi bi-eye-slash me-1"></i>Hide';
    if (!showing) previewContent.textContent = textarea.value || 'Preview will appear here…';
});

// Templates
document.querySelectorAll('.template-btn').forEach(btn => {
    btn.addEventListener('click', function () {
        if (textarea.value.trim() && !confirm('Replace current text with this template?')) return;
        textarea.value = this.dataset.template;
        textarea.focus();
        updateCounter();
    });
});

// Mood
document.querySelectorAll('.mood-btn').forEach(btn => {
    btn.addEventListener('click', function () {
        document.querySelectorAll('.mood-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        document.getElementById('toneInput').value = this.dataset.tone;
    });
});
</script>
@endpush