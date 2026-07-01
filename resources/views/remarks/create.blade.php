@extends('layouts.app')

@section('title', 'Add Remark')

@section('content')

<div class="container">

    <div class="row justify-content-center">

        <div class="col-lg-8">

            <div class="d-flex justify-content-between align-items-center mb-4">

                <div>

                    <h2 class="fw-bold mb-1">
                        Add New Remark
                    </h2>

                    <p class="text-muted mb-0">
                        Add notes, updates or progress to a task.
                    </p>

                </div>

                <a href="{{ route('remarks.index') }}"
                   class="btn btn-outline-secondary">

                    <i class="bi bi-arrow-left me-2"></i>

                    Back

                </a>

            </div>

            <div class="card shadow-sm border-0">

                <div class="card-body p-4">

                    <form method="POST"
                          action="{{ route('remarks.store') }}">

                        @csrf

                        <div class="mb-4">

                            <label class="form-label fw-semibold">

                                Task

                            </label>

                            <input
    type="hidden"
    name="task_id"
    value="{{ $task->id }}">

<input
    type="text"
    class="form-control"
    value="{{ $task->title }}"
    readonly>

                            @error('task_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        <div class="mb-4">

                            <label class="form-label fw-semibold">

                                Remark

                            </label>

                            <textarea
                                id="remark"
                                name="remark"
                                rows="8"
                                maxlength="1000"
                                class="form-control @error('remark') is-invalid @enderror"
                                placeholder="Write your remark...">{{ old('remark') }}</textarea>

                            @error('remark')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                            <div class="d-flex justify-content-between mt-2">

                                <small class="text-muted">
                                    Maximum 1000 characters
                                </small>

                                <small id="counter"
                                       class="text-muted">

                                    0 / 1000

                                </small>

                            </div>

                        </div>

                        <div class="d-flex justify-content-end gap-2">

                            <a href="{{ route('remarks.index') }}"
                               class="btn btn-light">

                                Cancel

                            </a>

                            <button class="btn btn-primary">

                                <i class="bi bi-save me-2"></i>

                                Save Remark

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection

@push('scripts')

<script>

const textarea = document.getElementById('remark');
const counter = document.getElementById('counter');

function updateCounter() {
    counter.innerText = textarea.value.length + ' / 1000';
}

updateCounter();

textarea.addEventListener('input', function () {

    updateCounter();

    localStorage.setItem(
        'remark_draft',
        textarea.value
    );

});

window.addEventListener('load', function () {

    if (!textarea.value) {

        const draft = localStorage.getItem('remark_draft');

        if (draft) {

            textarea.value = draft;

            updateCounter();

        }

    }

});

document.querySelector('form').addEventListener('submit', function () {

    localStorage.removeItem('remark_draft');

});

</script>

@endpush