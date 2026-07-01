@extends('layouts.app')

@section('title', 'Notifications')

@section('content')

<div class="container">

    <div class="row justify-content-center">

        <div class="col-lg-10">

            <div class="d-flex justify-content-between align-items-center mb-4">

                <div>

                    <h2 class="fw-bold mb-1">
                        Notification Center
                    </h2>

                    <p class="text-muted mb-0">
                        Stay updated with reminders, task changes and completed focus sessions.
                    </p>

                </div>

                <div class="d-flex gap-2">

                    <form action="{{ route('notifications.readAll') }}" method="POST">

                        @csrf

                        <button class="btn btn-success">

                            <i class="bi bi-check2-all me-2"></i>

                            Mark All Read

                        </button>

                    </form>

                    <a href="{{ route('dashboard') }}"
                       class="btn btn-outline-secondary">

                        <i class="bi bi-arrow-left me-2"></i>

                        Dashboard

                    </a>

                </div>

            </div>

            @if(session('success'))

                <div class="alert alert-success">

                    {{ session('success') }}

                </div>

            @endif

            <div class="card shadow-sm border-0">

                <div class="card-body p-0">

                    @forelse($notifications as $notification)

                        <div class="border-bottom p-4 {{ is_null($notification->read_at) ? 'bg-light' : '' }}">

                            <div class="d-flex justify-content-between">

                                <div class="d-flex">

                                    <div class="me-3">

                                        @switch($notification->type)

                                            @case('task')

                                                <span class="fs-2 text-primary">

                                                    <i class="bi bi-list-check"></i>

                                                </span>

                                                @break

                                            @case('focus')

                                                <span class="fs-2 text-success">

                                                    <i class="bi bi-stopwatch"></i>

                                                </span>

                                                @break

                                            @case('remark')

                                                <span class="fs-2 text-warning">

                                                    <i class="bi bi-chat-left-text"></i>

                                                </span>

                                                @break

                                            @default

                                                <span class="fs-2 text-secondary">

                                                    <i class="bi bi-bell"></i>

                                                </span>

                                        @endswitch

                                    </div>

                                    <div>

                                        <h6 class="mb-1">

                                            {{ $notification->title }}

                                        </h6>

                                        <p class="text-muted mb-2">

                                            {{ $notification->message }}

                                        </p>

                                        <small class="text-secondary">

                                            {{ $notification->created_at->diffForHumans() }}

                                        </small>
                                    </div>

                                </div>

                                <div class="text-end">

                                    @if(is_null($notification->read_at))

                                        <span class="badge bg-danger mb-3">

                                            New

                                        </span>

                                        <br>

                                        <form action="{{ route('notifications.read', $notification) }}"
                                              method="POST">

                                            @csrf
                                            @method('PATCH')

                                            <button class="btn btn-sm btn-primary">

                                                Mark Read

                                            </button>

                                        </form>

                                    @else

                                        <span class="badge bg-success mb-3">

                                            Read

                                        </span>

                                    @endif

                                    <form action="{{ route('notifications.destroy', $notification) }}"
                                          method="POST"
                                          class="mt-2">

                                        @csrf
                                        @method('DELETE')

                                        <button class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('Delete this notification?')">

                                            Delete

                                        </button>

                                    </form>

                                </div>

                            </div>

                        </div>

                    @empty

                        <div class="text-center py-5">

                            <i class="bi bi-bell-slash display-3 text-muted"></i>

                            <h4 class="mt-3">

                                No Notifications

                            </h4>

                            <p class="text-muted">

                                You're all caught up.

                            </p>

                        </div>

                    @endforelse

                </div>

            </div>

            <div class="mt-4">

                {{ $notifications->links() }}

            </div>

        </div>

    </div>

</div>

@endsection