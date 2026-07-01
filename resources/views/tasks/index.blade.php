@extends('layouts.app')

@section('title', 'Tasks')

@section('content')

<div class="container-fluid">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">

        <div>

            <h2 class="fw-bold mb-1">
                Task Management
            </h2>

            <p class="text-muted mb-0">
                Organize, prioritize and track your work efficiently.
            </p>

        </div>

        <a href="{{ route('tasks.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>
            Create Task
        </a>

    </div>

    <!-- Filters -->
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body">

            <form method="GET">

                <div class="row g-3">

                    <div class="col-lg-4">

                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            class="form-control"
                            placeholder="Search task...">

                    </div>

                    <div class="col-lg-2">

                        <select name="status" class="form-select">

                            <option value="">All Status</option>

                            <option value="pending"
                                @selected(request('status')=='pending')>
                                Pending
                            </option>

                            <option value="in_progress"
                                @selected(request('status')=='in_progress')>
                                In Progress
                            </option>

                            <option value="completed"
                                @selected(request('status')=='completed')>
                                Completed
                            </option>

                        </select>

                    </div>

                    <div class="col-lg-2">

                        <select name="priority" class="form-select">

                            <option value="">Priority</option>

                            <option value="low">Low</option>

                            <option value="medium">Medium</option>

                            <option value="high">High</option>

                            <option value="urgent">Urgent</option>

                        </select>

                    </div>

                    <div class="col-lg-2">

                        <button class="btn btn-primary w-100">

                            <i class="bi bi-search"></i>

                            Filter

                        </button>

                    </div>

                    <div class="col-lg-2">

                        <a href="{{ route('tasks.index') }}"
                           class="btn btn-outline-secondary w-100">

                            Reset

                        </a>

                    </div>

                </div>

            </form>

        </div>

    </div>

    <!-- Task Table -->

    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white d-flex justify-content-between align-items-center">

            <h5 class="mb-0">

                All Tasks

            </h5>

            <span class="badge bg-primary">

                {{ $tasks->total() }} Tasks

            </span>

        </div>

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead>

                <tr>

                    <th>#</th>

                    <th>Title</th>

                    <th>Priority</th>

                    <th>Status</th>

                    <th>Progress</th>

                    <th>Due Date</th>

                    <th>Actions</th>

                </tr>

                </thead>

                <tbody>

                @forelse($tasks as $task)

                    <tr>

                        <td>

                            {{ $task->id }}

                        </td>

                        <td>

                            <strong>

                                {{ $task->title }}

                            </strong>

                            <br>

                            <small class="text-muted">

                                {{ Str::limit($task->description,70) }}

                            </small>

                        </td>

                        <td>

                            @php

                                $priorityColor=[
                                    'low'=>'secondary',
                                    'medium'=>'info',
                                    'high'=>'warning',
                                    'urgent'=>'danger'
                                ];

                            @endphp

                            <span class="badge bg-{{ $priorityColor[$task->priority] ?? 'secondary' }}">

                                {{ ucfirst($task->priority) }}

                            </span>

                        </td>

                        <td>

                            @php

                                $statusColor=[
                                    'pending'=>'warning',
                                    'in_progress'=>'primary',
                                    'completed'=>'success',
                                    'cancelled'=>'danger'
                                ];

                            @endphp

                            <span class="badge bg-{{ $statusColor[$task->status] ?? 'secondary' }}">

                                {{ ucwords(str_replace('_',' ',$task->status)) }}

                            </span>

                        </td>

                        <td width="180">

                            <div class="progress" style="height:8px;">

                                <div
                                    class="progress-bar"
                                    style="width:{{ $task->progress }}%">
                                </div>

                            </div>

                            <small>

                                {{ $task->progress }}%

                            </small>

                        </td>

                        <td>

                            @if($task->due_date)

                                {{ $task->due_date->format('d M Y') }}

                            @else

                                —

                            @endif

                        </td>

                        <td>

                            <div class="btn-group">

                                <a href="{{ route('tasks.show',$task) }}"
                                   class="btn btn-sm btn-outline-primary">

                                    <i class="bi bi-eye"></i>

                                </a>

                                <a href="{{ route('tasks.edit',$task) }}"
                                   class="btn btn-sm btn-outline-warning">

                                    <i class="bi bi-pencil"></i>

                                </a>

                                <form
                                    method="POST"
                                    action="{{ route('tasks.destroy',$task) }}"
                                    class="d-inline">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('Delete this task?')">

                                        <i class="bi bi-trash"></i>

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="7" class="text-center py-5">

                            <i class="bi bi-inbox display-4 d-block mb-3"></i>

                            No tasks found.

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

        <div class="card-footer bg-white">

            {{ $tasks->links() }}

        </div>

    </div>

</div>

@endsection