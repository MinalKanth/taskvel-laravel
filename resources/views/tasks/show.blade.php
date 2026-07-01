@extends('layouts.app')

@section('title', $task->title)

@section('content')

<div class="container-fluid">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">

        <div>

            <h2 class="fw-bold mb-1">
                {{ $task->title }}
            </h2>

            <p class="text-muted mb-0">
                Created {{ $task->created_at->diffForHumans() }}
            </p>

        </div>

        <div class="d-flex gap-2">

            <a href="{{ route('tasks.edit',$task) }}" class="btn btn-warning">
                <i class="bi bi-pencil-square me-2"></i>
                Edit
            </a>

            <a href="{{ route('focus.index',['task'=>$task->id]) }}"
               class="btn btn-success">
                <i class="bi bi-play-circle me-2"></i>
                Start Focus
            </a>

            <form action="{{ route('tasks.destroy',$task) }}"
                  method="POST"
                  onsubmit="return confirm('Delete this task?')">

                @csrf
                @method('DELETE')

                <button class="btn btn-danger">
                    <i class="bi bi-trash"></i>
                </button>

            </form>

        </div>

    </div>

    <div class="row g-4">

        <!-- Left -->

        <div class="col-lg-8">

            <!-- Description -->

            <div class="card border-0 shadow-sm mb-4">

                <div class="card-header bg-white">

                    <h5 class="mb-0">
                        Description
                    </h5>

                </div>

                <div class="card-body">

                    {!! nl2br(e($task->description)) !!}

                </div>

            </div>

            <!-- Checklist -->

            <div class="card border-0 shadow-sm mb-4">

                <div class="card-header bg-white">

                    <h5 class="mb-0">
                        Task Steps
                    </h5>

                </div>

                <div class="card-body">

                    @forelse($task->steps as $step)

                        <div class="form-check mb-3">

                            <input
                                class="form-check-input"
                                type="checkbox"
                                disabled
                                {{ $step->is_completed ? 'checked' : '' }}>

                            <label class="form-check-label">

                                {{ $step->title }}

                            </label>

                        </div>

                    @empty

                        <p class="text-muted mb-0">

                            No steps available.

                        </p>

                    @endforelse

                </div>

            </div>

            <!-- Remarks -->

            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white d-flex justify-content-between">

                    <h5 class="mb-0">
                        Remarks
                    </h5>

                    <a href="{{ route('remarks.create',['task'=>$task->id]) }}"
                       class="btn btn-sm btn-primary">

                        Add Remark

                    </a>

                </div>

                <div class="card-body">

                    @forelse($task->remarks as $remark)

                        <div class="border-bottom pb-3 mb-3">

                            <div class="d-flex justify-content-between">

                                <strong>

                                    {{ $remark->user->name }}

                                </strong>

                                <small class="text-muted">

                                    {{ $remark->created_at->format('d M Y h:i A') }}

                                </small>

                            </div>

                            <p class="mb-0 mt-2">

                                {{ $remark->remark }}

                            </p>

                        </div>

                    @empty

                        <div class="text-center py-4 text-muted">

                            No remarks yet.

                        </div>

                    @endforelse

                </div>

            </div>

        </div>

        <!-- Right Sidebar -->

        <div class="col-lg-4">

            <!-- Information -->

            <div class="card border-0 shadow-sm mb-4">

                <div class="card-header bg-white">

                    <h5 class="mb-0">

                        Task Information

                    </h5>

                </div>

                <div class="card-body">

                    <table class="table table-borderless mb-0">

                        <tr>
                            <th>Priority</th>
                            <td>
                                <span class="badge bg-danger">
                                    {{ ucfirst($task->priority) }}
                                </span>
                            </td>
                        </tr>

                        <tr>
                            <th>Status</th>
                            <td>
                                <span class="badge bg-primary">
                                    {{ ucwords(str_replace('_',' ',$task->status)) }}
                                </span>
                            </td>
                        </tr>

                        <tr>
                            <th>Due Date</th>
                            <td>
                                {{ optional($task->due_date)->format('d M Y') }}
                            </td>
                        </tr>

                        <tr>
                            <th>Estimated</th>
                            <td>
                                {{ $task->estimated_minutes }} mins
                            </td>
                        </tr>

                    </table>

                </div>

            </div>

            <!-- Progress -->

            <div class="card border-0 shadow-sm mb-4">

                <div class="card-header bg-white">

                    <h5 class="mb-0">

                        Progress

                    </h5>

                </div>

                <div class="card-body text-center">

                    <div class="display-4 fw-bold text-primary">

                        {{ $task->progress }}%

                    </div>

                    <div class="progress mt-3" style="height:12px;">

                        <div class="progress-bar"
                             style="width:{{ $task->progress }}%">

                        </div>

                    </div>

                </div>

            </div>

            <!-- Tags -->

            <div class="card border-0 shadow-sm mb-4">

                <div class="card-header bg-white">

                    <h5 class="mb-0">

                        Tags

                    </h5>

                </div>

                <div class="card-body">

                    @forelse($task->tags as $tag)

                        <span class="badge bg-secondary me-2 mb-2">

                            {{ $tag->name }}

                        </span>

                    @empty

                        <span class="text-muted">

                            No tags assigned.

                        </span>

                    @endforelse

                </div>

            </div>

            <!-- Focus Sessions -->

            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white">

                    <h5 class="mb-0">

                        Focus Sessions

                    </h5>

                </div>

                <div class="card-body">

                    @forelse($task->focusSessions as $session)

                        <div class="d-flex justify-content-between border-bottom py-2">

                            <div>

                                {{ $session->actual_minutes ?? 0 }} mins

                            </div>

                            <small class="text-muted">

                                {{ $session->created_at->format('d M') }}

                            </small>

                        </div>

                    @empty

                        <div class="text-muted text-center">

                            No focus sessions.

                        </div>

                    @endforelse

                </div>

            </div>

        </div>

    </div>

</div>

@endsection