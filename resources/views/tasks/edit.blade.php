@extends('layouts.app')

@section('title', 'Edit Task')

@section('content')

<div class="container-fluid">

    <!-- Header -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">

                Edit Task

            </h2>

            <p class="text-muted">

                Update task information and progress.

            </p>

        </div>

        <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary">

            <i class="bi bi-arrow-left"></i>

            Back

        </a>

    </div>

    <form method="POST" action="{{ route('tasks.update',$task) }}">

        @csrf
        @method('PUT')

        <div class="row g-4">

            <!-- Left -->

            <div class="col-lg-8">

                <div class="card shadow-sm border-0">

                    <div class="card-header bg-white">

                        <h5 class="mb-0">

                            Task Details

                        </h5>

                    </div>

                    <div class="card-body">

                        <div class="mb-3">

                            <label class="form-label">

                                Title

                            </label>

                            <input
                                type="text"
                                name="title"
                                class="form-control @error('title') is-invalid @enderror"
                                value="{{ old('title',$task->title) }}">

                            @error('title')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        <div class="mb-3">

                            <label class="form-label">

                                Description

                            </label>

                            <textarea
                                rows="8"
                                name="description"
                                class="form-control">{{ old('description',$task->description) }}</textarea>

                        </div>

                        <div class="row">

                            <div class="col-md-6">

                                <div class="mb-3">

                                    <label class="form-label">

                                        Due Date

                                    </label>

                                    <input
                                        type="text"
                                        id="due_date"
                                        name="due_date"
                                        value="{{ old('due_date',optional($task->due_date)->format('Y-m-d H:i')) }}"
                                        class="form-control">

                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="mb-3">

                                    <label class="form-label">

                                        Estimated Minutes

                                    </label>

                                    <input
                                        type="number"
                                        name="estimated_minutes"
                                        value="{{ old('estimated_minutes',$task->estimated_minutes) }}"
                                        class="form-control">

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                <!-- Steps -->

                <div class="card shadow-sm border-0 mt-4">

                    <div class="card-header bg-white d-flex justify-content-between">

                        <h5 class="mb-0">

                            Task Steps

                        </h5>

                        <button
                            type="button"
                            class="btn btn-primary btn-sm"
                            id="addStep">

                            <i class="bi bi-plus"></i>

                            Add Step

                        </button>

                    </div>

                    <div class="card-body">

                        <div id="stepsContainer">

                            @foreach($task->steps as $index=>$step)

                                <div class="input-group mb-3 step-item">

                                    <span class="input-group-text">

                                        {{ $index+1 }}

                                    </span>

                                    <input
                                        type="text"
                                        name="steps[]"
                                        class="form-control"
                                        value="{{ $step->title }}">

                                    <button
                                        type="button"
                                        class="btn btn-outline-danger remove-step">

                                        <i class="bi bi-trash"></i>

                                    </button>

                                </div>

                            @endforeach

                        </div>

                    </div>

                </div>

            </div>

            <!-- Right -->

            <div class="col-lg-4">

                <div class="card shadow-sm border-0">

                    <div class="card-header bg-white">

                        <h5 class="mb-0">

                            Task Settings

                        </h5>

                    </div>

                    <div class="card-body">

                        <div class="mb-3">

                            <label class="form-label">

                                Priority

                            </label>

                            <select name="priority" class="form-select">

                                @foreach(['low','medium','high','urgent'] as $priority)

                                    <option
                                        value="{{ $priority }}"
                                        @selected($task->priority==$priority)>

                                        {{ ucfirst($priority) }}

                                    </option>

                                @endforeach

                            </select>

                        </div>

                        <div class="mb-3">

                            <label class="form-label">

                                Status

                            </label>

                            <select name="status" class="form-select">

                                @foreach(['pending','in_progress','completed'] as $status)

                                    <option
                                        value="{{ $status }}"
                                        @selected($task->status==$status)>

                                        {{ ucwords(str_replace('_',' ',$status)) }}

                                    </option>

                                @endforeach

                            </select>

                        </div>

                        <div class="mb-3">

                            <label class="form-label">

                                Progress

                            </label>

                            <input
                                id="progress"
                                type="range"
                                class="form-range"
                                min="0"
                                max="100"
                                name="progress"
                                value="{{ $task->progress }}">

                            <div class="text-center fw-bold">

                                <span id="progressValue">

                                    {{ $task->progress }}

                                </span>%

                            </div>

                        </div>

                        <div class="mb-3">

                            <label class="form-label">

                                Tags

                            </label>

                            <select
                                name="tags[]"
                                id="tags"
                                class="form-select"
                                multiple>

                                @foreach($tags as $tag)

                                    <option
                                        value="{{ $tag->id }}"
                                        @selected($task->tags->contains($tag->id))>

                                        {{ $tag->name }}

                                    </option>

                                @endforeach

                            </select>

                        </div>

                    </div>

                </div>

                <div class="card shadow-sm border-0 mt-4">

                    <div class="card-body d-grid">

                        <button class="btn btn-success btn-lg">

                            <i class="bi bi-check-circle me-2"></i>

                            Update Task

                        </button>

                    </div>

                </div>

            </div>

        </div>

    </form>

</div>

@endsection

@push('scripts')

<script>

flatpickr("#due_date",{
    enableTime:true,
    dateFormat:"Y-m-d H:i"
});

new TomSelect("#tags");

const progress=document.getElementById('progress');
const value=document.getElementById('progressValue');

progress.oninput=function(){
    value.innerText=this.value;
}

let stepCount={{ $task->steps->count() }};

document.getElementById('addStep').onclick=function(){

    stepCount++;

    document.getElementById('stepsContainer').insertAdjacentHTML('beforeend',`

    <div class="input-group mb-3 step-item">

        <span class="input-group-text">${stepCount}</span>

        <input
            type="text"
            name="steps[]"
            class="form-control">

        <button
            type="button"
            class="btn btn-outline-danger remove-step">

            <i class="bi bi-trash"></i>

        </button>

    </div>

    `);

};

document.addEventListener('click',function(e){

    if(e.target.closest('.remove-step')){

        e.target.closest('.step-item').remove();

    }

});

</script>

@endpush