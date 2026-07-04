@extends('layouts.app')

@section('title', 'View Client Remark')

@section('content')

<div class="container-fluid">

    <!-- ===================================================== -->
    <!-- Page Header -->
    <!-- ===================================================== -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">

                Client Remark Details

            </h2>

            <p class="text-muted mb-0">

                View complete remark information.

            </p>

        </div>

        <div class="d-flex gap-2">

            @can('update', $clientRemark)

                <a
                    href="{{ route('client-remarks.edit', $clientRemark) }}"
                    class="btn btn-warning">

                    <i class="mdi mdi-pencil me-1"></i>

                    Edit

                </a>

            @endcan

            <a
                href="{{ route('client-remarks.index') }}"
                class="btn btn-secondary">

                <i class="mdi mdi-arrow-left me-1"></i>

                Back

            </a>

        </div>

    </div>

    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show">

            {{ session('success') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert">

            </button>

        </div>

    @endif

    <!-- ===================================================== -->
    <!-- Remark Information -->
    <!-- ===================================================== -->

    <div class="card shadow-sm mb-4">

        <div class="card-header">

            <h5 class="mb-0">

                <i class="mdi mdi-note-text-outline me-2"></i>

                Remark Information

            </h5>

        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-6 mb-3">

                    <label class="fw-semibold">

                        Client

                    </label>

                    <div>

                        {{ optional($clientRemark->client)->client_code }}

                        -

                        {{ optional($clientRemark->client)->company_name }}

                    </div>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="fw-semibold">

                        Created By

                    </label>

                    <div>

                        {{ optional($clientRemark->user)->name }}

                    </div>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="fw-semibold">

                        Type

                    </label>

                    <div>

                        <span class="badge bg-info">

                            {{ $clientRemark->type }}

                        </span>

                    </div>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="fw-semibold">

                        Status

                    </label>

                    <div>
                                                @php

                            $statusClass = match($clientRemark->status) {

                                'Open' => 'warning',

                                'In Progress' => 'primary',

                                'Resolved' => 'success',

                                'Closed' => 'secondary',

                                default => 'dark',

                            };

                        @endphp

                        <span class="badge bg-{{ $statusClass }}">

                            {{ $clientRemark->status }}

                        </span>

                    </div>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="fw-semibold">

                        Private

                    </label>

                    <div>

                        @if($clientRemark->is_private)

                            <span class="badge bg-danger">

                                Yes

                            </span>

                        @else

                            <span class="badge bg-success">

                                No

                            </span>

                        @endif

                    </div>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="fw-semibold">

                        Pinned

                    </label>

                    <div>

                        @if($clientRemark->is_pinned)

                            <span class="badge bg-warning text-dark">

                                Yes

                            </span>

                        @else

                            <span class="badge bg-secondary">

                                No

                            </span>

                        @endif

                    </div>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="fw-semibold">

                        Mentioned User

                    </label>

                    <div>

                        {{ optional($clientRemark->mentionedUser)->name ?? '-' }}

                    </div>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="fw-semibold">

                        Reply To

                    </label>

                    <div>

                        @if($clientRemark->parent)

                            #{{ $clientRemark->parent->id }}

                        @else

                            -

                        @endif

                    </div>

                </div>

            </div>

        </div>

    </div>
        <!-- ===================================================== -->
    <!-- Remark Content -->
    <!-- ===================================================== -->

    <div class="card shadow-sm mb-4">

        <div class="card-header">

            <h5 class="mb-0">

                <i class="mdi mdi-text-box-outline me-2"></i>

                Remark

            </h5>

        </div>

        <div class="card-body">

            <div
                class="border rounded p-3 bg-light"
                style="white-space: pre-wrap; min-height:150px;">

                {{ $clientRemark->remark }}

            </div>

        </div>

    </div>

    <!-- ===================================================== -->
    <!-- Attachment -->
    <!-- ===================================================== -->

    <div class="card shadow-sm mb-4">

        <div class="card-header">

            <h5 class="mb-0">

                <i class="mdi mdi-paperclip me-2"></i>

                Attachment

            </h5>

        </div>

        <div class="card-body">

            @if($clientRemark->attachment)

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <i class="mdi mdi-file-document-outline me-2"></i>

                        {{ basename($clientRemark->attachment) }}

                    </div>

                    <div>

                        <a
                            href="{{ asset('storage/'.$clientRemark->attachment) }}"
                            target="_blank"
                            class="btn btn-primary">

                            <i class="mdi mdi-eye me-1"></i>

                            View Attachment

                        </a>

                    </div>

                </div>

            @else

                <div class="text-muted">

                    No attachment uploaded.

                </div>

            @endif

        </div>

    </div>
        <!-- ===================================================== -->
    <!-- Timeline Information -->
    <!-- ===================================================== -->

    <div class="card shadow-sm mb-4">

        <div class="card-header">

            <h5 class="mb-0">

                <i class="mdi mdi-clock-outline me-2"></i>

                Timeline

            </h5>

        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-4 mb-3">

                    <label class="fw-semibold">

                        Created At

                    </label>

                    <div>

                        {{ optional($clientRemark->created_at)->format('d M Y h:i A') }}

                    </div>

                </div>

                <div class="col-md-4 mb-3">

                    <label class="fw-semibold">

                        Updated At

                    </label>

                    <div>

                        {{ optional($clientRemark->updated_at)->format('d M Y h:i A') }}

                    </div>

                </div>

                <div class="col-md-4 mb-3">

                    <label class="fw-semibold">

                        Read At

                    </label>

                    <div>

                        @if($clientRemark->read_at)

                            {{ $clientRemark->read_at->format('d M Y h:i A') }}

                        @else

                            -

                        @endif

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- ===================================================== -->
    <!-- Quick Actions -->
    <!-- ===================================================== -->

    <div class="card shadow-sm mb-4">

        <div class="card-header">

            <h5 class="mb-0">

                <i class="mdi mdi-lightning-bolt-outline me-2"></i>

                Quick Actions

            </h5>

        </div>

        <div class="card-body">

            <div class="d-flex flex-wrap gap-2">
                                @can('update', $clientRemark)

                    <a
                        href="{{ route('client-remarks.edit', $clientRemark) }}"
                        class="btn btn-warning">

                        <i class="mdi mdi-pencil me-1"></i>

                        Edit Remark

                    </a>

                @endcan

                @can('delete', $clientRemark)

                    <form
                        action="{{ route('client-remarks.destroy', $clientRemark) }}"
                        method="POST"
                        class="d-inline"
                        onsubmit="return confirm('Are you sure you want to delete this remark?');">

                        @csrf

                        @method('DELETE')

                        <button
                            type="submit"
                            class="btn btn-danger">

                            <i class="mdi mdi-delete me-1"></i>

                            Delete

                        </button>

                    </form>

                @endcan

                <a
                    href="{{ route('client-remarks.index') }}"
                    class="btn btn-secondary">

                    <i class="mdi mdi-arrow-left me-1"></i>

                    Back to List

                </a>

            </div>

        </div>

    </div>

    <!-- ===================================================== -->
    <!-- Replies -->
    <!-- ===================================================== -->

    <div class="card shadow-sm mb-4">

        <div class="card-header">

            <h5 class="mb-0">

                <i class="mdi mdi-reply-all-outline me-2"></i>

                Replies

            </h5>

        </div>

        <div class="card-body">

            @if($clientRemark->replies->count())

                <div class="list-group">
                                        @foreach($clientRemark->replies as $reply)

                        <div class="list-group-item">

                            <div class="d-flex justify-content-between">

                                <div>

                                    <strong>

                                        {{ optional($reply->user)->name }}

                                    </strong>

                                    <span class="text-muted ms-2">

                                        {{ optional($reply->created_at)->format('d M Y h:i A') }}

                                    </span>

                                </div>

                                <div>

                                    <span class="badge bg-info">

                                        {{ $reply->type }}

                                    </span>

                                </div>

                            </div>

                            <div class="mt-3">

                                {!! nl2br(e($reply->remark)) !!}

                            </div>

                        </div>

                    @endforeach

                </div>

            @else

                <div class="text-center py-4">

                    <i class="mdi mdi-forum-outline display-5 text-muted"></i>

                    <h6 class="mt-3">

                        No Replies Available

                    </h6>

                    <p class="text-muted mb-0">

                        This remark has not received any replies.

                    </p>

                </div>

            @endif

        </div>

    </div>
        <!-- ===================================================== -->
    <!-- Related Information -->
    <!-- ===================================================== -->

    <div class="card shadow-sm mb-4">

        <div class="card-header">

            <h5 class="mb-0">

                <i class="mdi mdi-information-outline me-2"></i>

                Additional Information

            </h5>

        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-6 mb-3">

                    <label class="fw-semibold">

                        Remark ID

                    </label>

                    <div>

                        #{{ $clientRemark->id }}

                    </div>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="fw-semibold">

                        Client ID

                    </label>

                    <div>

                        {{ $clientRemark->client_id }}

                    </div>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="fw-semibold">

                        User ID

                    </label>

                    <div>

                        {{ $clientRemark->user_id }}

                    </div>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="fw-semibold">

                        Mentioned User ID

                    </label>

                    <div>

                        {{ $clientRemark->mentioned_user_id ?? '-' }}

                    </div>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="fw-semibold">

                        Parent Remark ID

                    </label>

                    <div>

                        {{ $clientRemark->parent_id ?? '-' }}

                    </div>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="fw-semibold">

                        Deleted At

                    </label>

                    <div>

                        {{ optional($clientRemark->deleted_at)->format('d M Y h:i A') ?? '-' }}

                    </div>

                </div>

            </div>

        </div>

    </div>
        <!-- ===================================================== -->
    <!-- Activity Summary -->
    <!-- ===================================================== -->

    <div class="card shadow-sm mb-4">

        <div class="card-header">

            <h5 class="mb-0">

                <i class="mdi mdi-chart-timeline-variant me-2"></i>

                Activity Summary

            </h5>

        </div>

        <div class="card-body">

            <div class="row text-center">

                <div class="col-md-3">

                    <div class="border rounded p-3">

                        <h3 class="fw-bold text-primary">

                            {{ $clientRemark->replies->count() }}

                        </h3>

                        <small class="text-muted">

                            Replies

                        </small>

                    </div>

                </div>

                <div class="col-md-3">

                    <div class="border rounded p-3">

                        <h3 class="fw-bold text-success">

                            {{ $clientRemark->created_at?->diffForHumans() }}

                        </h3>

                        <small class="text-muted">

                            Created

                        </small>

                    </div>

                </div>

                <div class="col-md-3">

                    <div class="border rounded p-3">

                        <h3 class="fw-bold text-info">

                            {{ $clientRemark->updated_at?->diffForHumans() }}

                        </h3>

                        <small class="text-muted">

                            Last Updated

                        </small>

                    </div>

                </div>

                <div class="col-md-3">

                    <div class="border rounded p-3">

                        <h3 class="fw-bold text-warning">

                            {{ $clientRemark->status }}

                        </h3>

                        <small class="text-muted">

                            Current Status

                        </small>

                    </div>

                </div>

            </div>

        </div>

    </div>
        <!-- ===================================================== -->
    <!-- Status Management -->
    <!-- ===================================================== -->

    @can('update', $clientRemark)

        <div class="card shadow-sm mb-4">

            <div class="card-header">

                <h5 class="mb-0">

                    <i class="mdi mdi-cog-outline me-2"></i>

                    Status Management

                </h5>

            </div>

            <div class="card-body">

                <div class="d-flex flex-wrap gap-2">

                    @if($clientRemark->status !== 'Resolved')

                        <button
                            type="button"
                            class="btn btn-success"
                            id="resolveRemark">

                            <i class="mdi mdi-check-circle me-1"></i>

                            Mark as Resolved

                        </button>

                    @endif

                    @if($clientRemark->status === 'Resolved')

                        <button
                            type="button"
                            class="btn btn-warning"
                            id="reopenRemark">

                            <i class="mdi mdi-backup-restore me-1"></i>

                            Reopen

                        </button>

                    @endif

                    @if(!$clientRemark->is_pinned)

                        <button
                            type="button"
                            class="btn btn-outline-primary"
                            id="pinRemark">

                            <i class="mdi mdi-pin me-1"></i>

                            Pin

                        </button>

                    @else

                        <button
                            type="button"
                            class="btn btn-outline-secondary"
                            id="unpinRemark">

                            <i class="mdi mdi-pin-off me-1"></i>

                            Unpin

                        </button>

                    @endif

                </div>

            </div>

        </div>

    @endcan

@endsection

@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {

    const csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        ?.getAttribute('content');
            function postAction(url) {

        fetch(url, {

            method: 'POST',

            headers: {

                'X-CSRF-TOKEN': csrfToken,

                'X-Requested-With': 'XMLHttpRequest',

                'Accept': 'application/json'

            }

        })
        .then(response => response.json())
        .then(data => {

            if (data.success) {

                location.reload();

            } else {

                alert('Operation failed.');

            }

        })
        .catch(() => {

            alert('Something went wrong.');

        });

    }

    document.getElementById('resolveRemark')
        ?.addEventListener('click', function () {

            postAction(
                "{{ route('client-remarks.resolve', $clientRemark) }}"
            );

        });

    document.getElementById('reopenRemark')
        ?.addEventListener('click', function () {

            postAction(
                "{{ route('client-remarks.reopen', $clientRemark) }}"
            );

        });

    document.getElementById('pinRemark')
        ?.addEventListener('click', function () {

            postAction(
                "{{ route('client-remarks.pin', $clientRemark) }}"
            );

        });

    document.getElementById('unpinRemark')
        ?.addEventListener('click', function () {

            postAction(
                "{{ route('client-remarks.unpin', $clientRemark) }}"
            );

        });

});

</script>

@endpush