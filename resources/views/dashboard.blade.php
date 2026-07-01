@extends('layouts.app')

@section('title','Dashboard')

@section('content')

<div class="container-fluid">

    <div class="mb-4">

        <h2 class="fw-bold">
            Dashboard
        </h2>

        <p class="text-muted">
            Welcome back, {{ auth()->user()->name }}
        </p>

    </div>

    <div class="row g-4">

        <div class="col-md-3">

            <div class="card shadow-sm border-0">

                <div class="card-body">

                    <small class="text-muted">
                        Total Tasks
                    </small>

                    <h2 class="fw-bold mt-2">
                        {{ $stats['total_tasks'] }}
                    </h2>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card shadow-sm border-0">

                <div class="card-body">

                    <small class="text-muted">
                        Pending Tasks
                    </small>

                    <h2 class="fw-bold text-warning mt-2">
                        {{ $stats['pending_tasks'] }}
                    </h2>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card shadow-sm border-0">

                <div class="card-body">

                    <small class="text-muted">
                        Completed Tasks
                    </small>

                    <h2 class="fw-bold text-success mt-2">
                        {{ $stats['completed_tasks'] }}
                    </h2>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card shadow-sm border-0">

                <div class="card-body">

                    <small class="text-muted">
                        Focus Minutes Today
                    </small>

                    <h2 class="fw-bold text-primary mt-2">
                        {{ $stats['today_focus_minutes'] }}
                    </h2>

                </div>

            </div>

        </div>

    </div>

    <div class="row mt-4">

        <div class="col-lg-6">

            <div class="card shadow-sm border-0">

                <div class="card-header bg-white">

                    Today's Tasks

                </div>

                <div class="card-body">

                    @forelse($todayTasks as $task)

                        <div class="border-bottom py-2">

                            <strong>{{ $task->title }}</strong>

                            <div class="small text-muted">

                                {{ ucfirst($task->priority) }}

                            </div>

                        </div>

                    @empty

                        <p class="text-muted mb-0">

                            No tasks due today.

                        </p>

                    @endforelse

                </div>

            </div>

        </div>

        <div class="col-lg-6">

            <div class="card shadow-sm border-0">

                <div class="card-header bg-white">

                    Upcoming Tasks

                </div>

                <div class="card-body">

                    @forelse($upcomingTasks as $task)

                        <div class="border-bottom py-2">

                            <strong>

                                {{ $task->title }}

                            </strong>

                            <div class="small text-muted">

                                {{ optional($task->due_date)->format('d M Y') }}

                            </div>

                        </div>

                    @empty

                        <p class="text-muted">

                            No upcoming tasks.

                        </p>

                    @endforelse

                </div>

            </div>

        </div>

    </div>

    <div class="card shadow-sm border-0 mt-4">

        <div class="card-header bg-white">

            Recent Focus Sessions

        </div>

        <div class="card-body">

            <table class="table align-middle">

                <thead>

                    <tr>

                        <th>Task</th>

                        <th>Minutes</th>

                        <th>Status</th>

                    </tr>

                </thead>

                <tbody>

                @forelse($recentFocusSessions as $session)

                    <tr>

                        <td>

                            {{ optional($session->task)->title ?? 'General Focus' }}

                        </td>

                        <td>

                            {{ $session->actual_minutes }}

                        </td>

                        <td>

                            @if($session->completed)

                                <span class="badge bg-success">

                                    Completed

                                </span>

                            @else

                                <span class="badge bg-warning">

                                    Interrupted

                                </span>

                            @endif

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="3" class="text-center">

                            No focus sessions.

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection