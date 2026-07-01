@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="container-fluid">

    <!-- Page Header -->
    <div class="row mb-4 align-items-center">

        <div class="col-md-8">

            <h2 class="fw-bold mb-1">
                Welcome back, {{ auth()->user()->name }} 👋
            </h2>

            <p class="text-muted mb-0">
                Here's an overview of your productivity today.
            </p>

        </div>

        <div class="col-md-4 text-md-end mt-3 mt-md-0">

            <a href="{{ route('tasks.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>
                New Task
            </a>

        </div>

    </div>

    <!-- Statistics -->
    <div class="row g-4 mb-4">

        <div class="col-lg-3 col-md-6">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <small class="text-muted">
                                Total Tasks
                            </small>

                            <h2 class="fw-bold mt-2">
                                {{ $stats['total_tasks'] }}
                            </h2>

                        </div>

                        <div class="display-6 text-primary">
                            <i class="bi bi-list-check"></i>
                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-lg-3 col-md-6">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <small class="text-muted">
                                Completed
                            </small>

                            <h2 class="fw-bold text-success mt-2">
                                {{ $stats['completed_tasks'] }}
                            </h2>

                        </div>

                        <div class="display-6 text-success">
                            <i class="bi bi-check-circle-fill"></i>
                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-lg-3 col-md-6">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <small class="text-muted">
                                Pending
                            </small>

                            <h2 class="fw-bold text-warning mt-2">
                                {{ $stats['pending_tasks'] }}
                            </h2>

                        </div>

                        <div class="display-6 text-warning">
                            <i class="bi bi-hourglass-split"></i>
                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-lg-3 col-md-6">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <small class="text-muted">
                                Focus Hours
                            </small>

                            <h2 class="fw-bold text-danger mt-2">
                                {{ number_format($stats['focus_hours'],1) }}
                            </h2>

                        </div>

                        <div class="display-6 text-danger">
                            <i class="bi bi-stopwatch-fill"></i>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- Middle Row -->

    <div class="row g-4">

        <!-- Recent Tasks -->

        <div class="col-lg-8">

            <div class="card shadow-sm border-0">

                <div class="card-header bg-white">

                    <h5 class="mb-0">

                        Recent Tasks

                    </h5>

                </div>

                <div class="card-body p-0">

                    <table class="table table-hover align-middle mb-0">

                        <thead>

                        <tr>

                            <th>Title</th>
                            <th>Priority</th>
                            <th>Status</th>
                            <th>Due Date</th>

                        </tr>

                        </thead>

                        <tbody>

                        @forelse($recentTasks as $task)

                            <tr>

                                <td>

                                    <strong>{{ $task->title }}</strong>

                                </td>

                                <td>

                                    <span class="badge bg-info">

                                        {{ ucfirst($task->priority) }}

                                    </span>

                                </td>

                                <td>

                                    @if($task->status=='completed')

                                        <span class="badge bg-success">

                                            Completed

                                        </span>

                                    @elseif($task->status=='in_progress')

                                        <span class="badge bg-primary">

                                            In Progress

                                        </span>

                                    @else

                                        <span class="badge bg-warning">

                                            Pending

                                        </span>

                                    @endif

                                </td>

                                <td>

                                    {{ optional($task->due_date)->format('d M Y') }}

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="4" class="text-center py-5">

                                    No tasks available.

                                </td>

                            </tr>

                        @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

        <!-- Productivity -->

        <div class="col-lg-4">

            <div class="card shadow-sm border-0 mb-4">

                <div class="card-header bg-white">

                    <h5 class="mb-0">

                        Productivity

                    </h5>

                </div>

                <div class="card-body text-center">

                    <div class="display-3 fw-bold text-primary">

                        {{ $stats['productivity'] }}%

                    </div>

                    <div class="progress mt-4" style="height:12px;">

                        <div class="progress-bar"

                             style="width:{{ $stats['productivity'] }}%">

                        </div>

                    </div>

                </div>

            </div>

            <div class="card shadow-sm border-0">

                <div class="card-header bg-white">

                    <h5 class="mb-0">

                        Weekly Progress

                    </h5>

                </div>

                <div class="card-body">

                    <canvas id="weeklyChart"></canvas>

                </div>

            </div>

        </div>

    </div>

    <!-- Remarks -->

    <div class="row mt-4">

        <div class="col-lg-12">

            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white">

                    <h5 class="mb-0">

                        Recent Remarks

                    </h5>

                </div>

                <div class="card-body">

                    @forelse($remarks as $remark)

                        <div class="border-bottom py-3">

                            <h6>

                                {{ $remark->task->title }}

                            </h6>

                            <p class="mb-1">

                                {{ $remark->remark }}

                            </p>

                            <small class="text-muted">

                                {{ $remark->created_at->diffForHumans() }}

                            </small>

                        </div>

                    @empty

                        <div class="text-center py-5 text-muted">

                            No remarks available.

                        </div>

                    @endforelse

                </div>

            </div>

        </div>

    </div>

</div>

@endsection

@push('scripts')

<script>

new Chart(document.getElementById('weeklyChart'),{

    type:'line',

    data:{

        labels:['Mon','Tue','Wed','Thu','Fri','Sat','Sun'],

        datasets:[{

            label:'Completed Tasks',

            data:@json($weeklyChart),

            borderWidth:3,

            fill:true,

            tension:.4

        }]

    },

    options:{

        responsive:true,

        plugins:{

            legend:{

                display:false

            }

        }

    }

});

</script>

@endpush
