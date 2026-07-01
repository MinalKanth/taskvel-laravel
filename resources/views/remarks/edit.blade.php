@extends('layouts.app')

@section('title', 'Edit Remark')

@section('content')

<div class="container">

    <div class="row justify-content-center">

        <div class="col-lg-8">

            <div class="d-flex justify-content-between align-items-center mb-4">

                <div>

                    <h2 class="fw-bold mb-1">
                        Edit Remark
                    </h2>

                    <p class="text-muted mb-0">
                        Update your remark or progress note.
                    </p>

                </div>

                <a href="{{ route('remarks.index') }}"
                   class="btn btn-outline-secondary">

                    <i class="bi bi-arrow-left me-2"></i>

                    Back

                </a>

            </div>

            <div class="card border-0 shadow-sm">

                <div class="card-body p-4">

                    <form method="POST"
                          action="{{ route('remarks.update', $remark) }}">

                        @csrf
                        @method('PUT')

                        <div class="mb-4">

                            <label class="form-label fw-semibold">

                                Task

                            </label>

                            <select
                                name="task_id"
                                class="form-select @error('task_id') is-invalid @enderror">

                                @foreach($tasks as $task)

                                    <option
                                        value="{{ $task->id }}"
                                        @selected(old('task_id', $remark->task_id) == $task->id)>

                                        {{ $task->title }}

                                    </option>

                                @endforeach

                            </select>

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
                                class="form-control @error('remark') is-invalid @enderror">{{ old('remark', $remark->remark) }}</textarea>

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

                                </small>

                            </div>

                        </div>

                        <div class="d-flex justify-content-end gap-2">

                            <a href="{{ route('remarks.index') }}"
                               class="btn btn-light">

                                Cancel

                            </a>

                            <button class="btn btn-primary">

                                <i class="bi bi-check-circle me-2"></i>

                                Update Remark

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

textarea.addEventListener('input', updateCounter);

</script>

@endpush