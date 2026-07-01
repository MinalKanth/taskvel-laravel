@extends('layouts.app')

@section('title', 'Remarks')

@section('content')

<div class="container-fluid">

    <!-- Page Header -->

    <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">

        <div>

            <h2 class="fw-bold mb-1">
                Task Remarks
            </h2>

            <p class="text-muted mb-0">
                View, search and manage all task remarks.
            </p>

        </div>

        <a href="{{ route('remarks.create') }}"
           class="btn btn-primary">

            <i class="bi bi-plus-circle me-2"></i>

            Add Remark

        </a>

    </div>

    <!-- Filters -->

    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body">

            <form method="GET">

                <div class="row g-3">

                    <div class="col-lg-5">

                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            class="form-control"
                            placeholder="Search remarks...">

                    </div>

                    <div class="col-lg-5">

                        <select
                            name="task_id"
                            class="form-select">

                            <option value="">

                                All Tasks

                            </option>

                            @foreach($tasks as $task)

                                <option
                                    value="{{ $task->id }}"
                                    @selected(request('task_id')==$task->id)>

                                    {{ $task->title }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="col-lg-2 d-grid">

                        <button class="btn btn-primary">

                            <i class="bi bi-search me-2"></i>

                            Filter

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

    <!-- Timeline -->

    <div class="card border-0 shadow-sm">

        <div class="card-body">

            @forelse($remarks as $remark)

                <div class="d-flex mb-4">

                    <!-- Avatar -->

                    <div class="flex-shrink-0">

                        <img
                            src="https://ui-avatars.com/api/?background=0D6EFD&color=fff&name={{ urlencode($remark->user->name) }}"
                            class="rounded-circle"
                            width="55"
                            height="55">

                    </div>

                    <!-- Content -->

                    <div class="ms-3 flex-grow-1">

                        <div class="card border">

                            <div class="card-body">

                                <div class="d-flex justify-content-between align-items-center">

                                    <div>

                                        <h6 class="mb-1">

                                            {{ $remark->user->name }}

                                        </h6>

                                        <small class="text-muted">

                                            {{ $remark->task->title }}

                                        </small>

                                    </div>

                                    <small class="text-muted">

                                        {{ $remark->created_at->diffForHumans() }}

                                    </small>

                                </div>

                                <hr>

                                <p class="mb-3">

                                    {{ $remark->remark }}

                                </p>

                                <div class="d-flex gap-2">

                                    <a
                                        href="{{ route('remarks.edit',$remark) }}"
                                        class="btn btn-sm btn-outline-primary">

                                        <i class="bi bi-pencil-square"></i>

                                        Edit

                                    </a>

                                    <form
                                        method="POST"
                                        action="{{ route('remarks.destroy',$remark) }}"
                                        onsubmit="return confirm('Delete this remark?')">

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            class="btn btn-sm btn-outline-danger">

                                            <i class="bi bi-trash"></i>

                                            Delete

                                        </button>

                                    </form>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            @empty

                <div class="text-center py-5">

                    <i class="bi bi-chat-left-text display-1 text-secondary"></i>

                    <h4 class="mt-3">

                        No Remarks Found

                    </h4>

                    <p class="text-muted">

                        Start adding remarks for your tasks.

                    </p>

                </div>

            @endforelse

        </div>

        @if($remarks->hasPages())

            <div class="card-footer bg-white">

                {{ $remarks->links() }}

            </div>

        @endif

    </div>

</div>

@endsection