@extends('layouts.app')

@section('title', 'Create Task')

@section('content')

<div class="container-fluid">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">
                Create New Task
            </h2>

            <p class="text-muted mb-0">
                Add a new task and organize your workflow efficiently.
            </p>

        </div>

        <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>
            Back
        </a>

    </div>

    <form action="{{ route('tasks.store') }}" method="POST">

        @csrf

        <div class="row g-4">

            <!-- Left Column -->
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
                                Task Title
                            </label>

                            <input
                                type="text"
                                name="title"
                                class="form-control @error('title') is-invalid @enderror"
                                value="{{ old('title') }}"
                                placeholder="Enter task title">

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
                                name="description"
                                rows="8"
                                class="form-control @error('description') is-invalid @enderror"
                                placeholder="Describe your task...">{{ old('description') }}</textarea>

                            @error('description')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

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
                                        class="form-control"
                                        value="{{ old('due_date') }}">

                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="mb-3">

                                    <label class="form-label">
                                        Estimated Time (Minutes)
                                    </label>

                                    <input
                                        type="number"
                                        name="estimated_minutes"
                                        class="form-control"
                                        value="{{ old('estimated_minutes') }}"
                                        min="1">

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
                            class="btn btn-sm btn-primary"
                            id="addStep">

                            <i class="bi bi-plus"></i>

                            Add Step

                        </button>

                    </div>

                    <div class="card-body">

                        <div id="stepsContainer">

                            <div class="input-group mb-3">

                                <span class="input-group-text">
                                    1
                                </span>

                                <input
                                    type="text"
                                    name="steps[]"
                                    class="form-control"
                                    placeholder="Step description">

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <!-- Right Column -->

            <div class="col-lg-4">

                <div class="card shadow-sm border-0">

                    <div class="card-header bg-white">

                        <h5 class="mb-0">
                            Settings
                        </h5>

                    </div>

                    <div class="card-body">

                        <div class="mb-3">

                            <label class="form-label">
                                Priority
                            </label>

                            <select name="priority" class="form-select">

                                <option value="low">Low</option>

                                <option value="medium" selected>Medium</option>

                                <option value="high">High</option>

                                <option value="urgent">Urgent</option>

                            </select>

                        </div>

                        <div class="mb-3">

                            <label class="form-label">
                                Status
                            </label>

                            <select name="status" class="form-select">

                                <option value="pending">Pending</option>

                                <option value="in_progress">In Progress</option>

                                <option value="completed">Completed</option>

                            </select>

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

                                    <option value="{{ $tag->id }}">

                                        {{ $tag->name }}

                                    </option>

                                @endforeach

                            </select>

                        </div>

                    </div>

                </div>

                <!-- Submit -->

                <div class="card shadow-sm border-0 mt-4">

                    <div class="card-body d-grid">

                        <button class="btn btn-primary btn-lg">

                            <i class="bi bi-check-circle me-2"></i>

                            Save Task

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

let counter=1;

document.getElementById('addStep').onclick=function(){

    counter++;

    let html=`

    <div class="input-group mb-3">

        <span class="input-group-text">${counter}</span>

        <input
            type="text"
            name="steps[]"
            class="form-control"
            placeholder="Step description">

    </div>`;

    document
        .getElementById('stepsContainer')
        .insertAdjacentHTML('beforeend',html);

};

</script>

@endpush