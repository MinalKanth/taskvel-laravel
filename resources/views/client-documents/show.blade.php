@extends('layouts.app')

@section('title', 'Client Document Details')

@section('content')

<div class="container-fluid">

    <!-- ===================================================== -->
    <!-- Page Header -->
    <!-- ===================================================== -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">

                Client Document Details

            </h2>

            <p class="text-muted mb-0">

                View complete information about the selected client document.

            </p>

        </div>

        <div class="d-flex gap-2">

            @can('update', $clientDocument)

                <a
                    href="{{ route('client-documents.edit', $clientDocument) }}"
                    class="btn btn-primary">

                    <i class="mdi mdi-pencil me-1"></i>

                    Edit

                </a>

            @endcan

            @can('view', $clientDocument)

                @if($clientDocument->file_path)

                    <a
                        href="{{ route('client-documents.download', $clientDocument) }}"
                        class="btn btn-success">

                        <i class="mdi mdi-download me-1"></i>

                        Download

                    </a>

                @endif

            @endcan

            <a
                href="{{ route('client-documents.index') }}"
                class="btn btn-secondary">

                <i class="mdi mdi-arrow-left me-1"></i>

                Back

            </a>

        </div>

    </div>

    @if(session('success'))

        <div class="alert alert-success">

            {{ session('success') }}

        </div>

    @endif

    @if(session('error'))

        <div class="alert alert-danger">

            {{ session('error') }}

        </div>

    @endif

    <div class="row">

        <!-- ===================================================== -->
        <!-- Left Column -->
        <!-- ===================================================== -->

        <div class="col-lg-8">
                        <!-- ===================================================== -->
            <!-- Document Information -->
            <!-- ===================================================== -->

            <div class="card shadow-sm mb-4">

                <div class="card-header">

                    <h5 class="mb-0">

                        <i class="mdi mdi-file-document-outline me-2"></i>

                        Document Information

                    </h5>

                </div>

                <div class="card-body">

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label class="fw-semibold text-muted">

                                Client

                            </label>

                            <div>

                                @if($clientDocument->client)

                                    <a
                                        href="{{ route('clients.show', $clientDocument->client) }}"
                                        class="text-decoration-none">

                                        {{ $clientDocument->client->client_code }}
                                        -
                                        {{ $clientDocument->client->company_name }}

                                    </a>

                                @else

                                    <span class="text-muted">

                                        N/A

                                    </span>

                                @endif

                            </div>

                        </div>

                        <div class="col-md-3 mb-3">

                            <label class="fw-semibold text-muted">

                                Category

                            </label>

                            <div>

                                <span class="badge bg-primary">

                                    {{ $clientDocument->category }}

                                </span>

                            </div>

                        </div>

                        <div class="col-md-3 mb-3">

                            <label class="fw-semibold text-muted">

                                Version

                            </label>

                            <div>

                                {{ $clientDocument->version ?? '1.0' }}

                            </div>

                        </div>

                        <div class="col-md-12 mb-3">

                            <label class="fw-semibold text-muted">

                                Title

                            </label>

                            <div class="fw-bold">

                                {{ $clientDocument->title }}

                            </div>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="fw-semibold text-muted">

                                Document Number

                            </label>

                            <div>

                                {{ $clientDocument->document_number ?: 'N/A' }}

                            </div>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="fw-semibold text-muted">

                                Status

                            </label>

                            <div>
                                                                @php

                                    $statusClass = match($clientDocument->status) {

                                        'Approved' => 'success',

                                        'Pending' => 'warning',

                                        'Rejected' => 'danger',

                                        'Expired' => 'secondary',

                                        'Archived' => 'dark',

                                        default => 'info',

                                    };

                                @endphp

                                <span class="badge bg-{{ $statusClass }}">

                                    {{ $clientDocument->status }}

                                </span>

                            </div>

                        </div>

                        <div class="col-md-12">

                            <label class="fw-semibold text-muted">

                                Description

                            </label>

                            <div class="border rounded p-3 bg-light">

                                {!! nl2br(e($clientDocument->description ?: 'No description available.')) !!}

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <!-- ===================================================== -->
            <!-- File Information -->
            <!-- ===================================================== -->

            <div class="card shadow-sm mb-4">

                <div class="card-header">

                    <h5 class="mb-0">

                        <i class="mdi mdi-folder-outline me-2"></i>

                        File Information

                    </h5>

                </div>

                <div class="card-body">

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label class="fw-semibold text-muted">

                                Original File Name

                            </label>

                            <div>

                                {{ $clientDocument->original_name }}

                            </div>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="fw-semibold text-muted">

                                Stored File Name

                            </label>

                            <div>

                                {{ $clientDocument->file_name }}

                            </div>

                        </div>
                                                <div class="col-md-3 mb-3">

                            <label class="fw-semibold text-muted">

                                Extension

                            </label>

                            <div>

                                {{ strtoupper($clientDocument->extension ?? '-') }}

                            </div>

                        </div>

                        <div class="col-md-3 mb-3">

                            <label class="fw-semibold text-muted">

                                MIME Type

                            </label>

                            <div>

                                {{ $clientDocument->mime_type }}

                            </div>

                        </div>

                        <div class="col-md-3 mb-3">

                            <label class="fw-semibold text-muted">

                                File Size

                            </label>

                            <div>

                                {{ number_format(($clientDocument->file_size ?? 0) / 1024, 2) }} KB

                            </div>

                        </div>

                        <div class="col-md-3 mb-3">

                            <label class="fw-semibold text-muted">

                                Storage Disk

                            </label>

                            <div>

                                {{ $clientDocument->disk }}

                            </div>

                        </div>

                        <div class="col-md-12">

                            <label class="fw-semibold text-muted">

                                File Path

                            </label>

                            <div class="text-break">

                                <code>

                                    {{ $clientDocument->file_path }}

                                </code>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <!-- ===================================================== -->
            <!-- Dates -->
            <!-- ===================================================== -->

            <div class="card shadow-sm mb-4">

                <div class="card-header">

                    <h5 class="mb-0">

                        <i class="mdi mdi-calendar-month-outline me-2"></i>

                        Document Dates

                    </h5>

                </div>

                <div class="card-body">

                    <div class="row">
                                                <div class="col-md-4 mb-3">

                            <label class="fw-semibold text-muted">

                                Issue Date

                            </label>

                            <div>

                                {{ optional($clientDocument->issue_date)->format('d M Y') ?: 'N/A' }}

                            </div>

                        </div>

                        <div class="col-md-4 mb-3">

                            <label class="fw-semibold text-muted">

                                Expiry Date

                            </label>

                            <div>

                                {{ optional($clientDocument->expiry_date)->format('d M Y') ?: 'N/A' }}

                            </div>

                        </div>

                        <div class="col-md-4 mb-3">

                            <label class="fw-semibold text-muted">

                                Approval Date

                            </label>

                            <div>

                                {{ optional($clientDocument->approved_at)->format('d M Y, h:i A') ?: 'N/A' }}

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <!-- ===================================================== -->
            <!-- Remarks -->
            <!-- ===================================================== -->

            <div class="card shadow-sm mb-4">

                <div class="card-header">

                    <h5 class="mb-0">

                        <i class="mdi mdi-note-text-outline me-2"></i>

                        Remarks

                    </h5>

                </div>

                <div class="card-body">

                    <div class="border rounded p-3 bg-light">

                        {!! nl2br(e($clientDocument->remarks ?: 'No remarks available.')) !!}

                    </div>

                </div>

            </div>

        </div>

        <!-- ===================================================== -->
        <!-- Right Sidebar -->
        <!-- ===================================================== -->

        <div class="col-lg-4">
                        <!-- ===================================================== -->
            <!-- Status & Visibility -->
            <!-- ===================================================== -->

            <div class="card shadow-sm mb-4">

                <div class="card-header">

                    <h5 class="mb-0">

                        <i class="mdi mdi-shield-check-outline me-2"></i>

                        Status & Visibility

                    </h5>

                </div>

                <div class="card-body">

                    <table class="table table-borderless mb-0">

                        <tbody>

                            <tr>

                                <th width="45%">

                                    Status

                                </th>

                                <td>

                                    <span class="badge bg-{{ $statusClass }}">

                                        {{ $clientDocument->status }}

                                    </span>

                                </td>

                            </tr>

                            <tr>

                                <th>

                                    Active

                                </th>

                                <td>

                                    @if($clientDocument->is_active)

                                        <span class="badge bg-success">

                                            Yes

                                        </span>

                                    @else

                                        <span class="badge bg-danger">

                                            No

                                        </span>

                                    @endif

                                </td>

                            </tr>

                            <tr>

                                <th>

                                    Confidential

                                </th>

                                <td>

                                    @if($clientDocument->is_confidential)

                                        <span class="badge bg-warning text-dark">

                                            Confidential

                                        </span>

                                    @else

                                        <span class="badge bg-secondary">

                                            No

                                        </span>

                                    @endif

                                </td>

                            </tr>

                            <tr>

                                <th>

                                    Download Allowed

                                </th>

                                <td>

                                    @if($clientDocument->is_downloadable)

                                        <span class="badge bg-success">

                                            Enabled

                                        </span>

                                    @else

                                        <span class="badge bg-danger">

                                            Disabled

                                        </span>

                                    @endif

                                </td>

                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>
                        <!-- ===================================================== -->
            <!-- Users -->
            <!-- ===================================================== -->

            <div class="card shadow-sm mb-4">

                <div class="card-header">

                    <h5 class="mb-0">

                        <i class="mdi mdi-account-group-outline me-2"></i>

                        User Information

                    </h5>

                </div>

                <div class="card-body">

                    <table class="table table-borderless mb-0">

                        <tbody>

                            <tr>

                                <th width="45%">

                                    Uploaded By

                                </th>

                                <td>

                                    {{ optional($clientDocument->uploader)->name ?? 'N/A' }}

                                </td>

                            </tr>

                            <tr>

                                <th>

                                    Approved By

                                </th>

                                <td>

                                    {{ optional($clientDocument->approver)->name ?? 'N/A' }}

                                </td>

                            </tr>

                            <tr>

                                <th>

                                    Created At

                                </th>

                                <td>

                                    {{ optional($clientDocument->created_at)->format('d M Y, h:i A') }}

                                </td>

                            </tr>

                            <tr>

                                <th>

                                    Last Updated

                                </th>

                                <td>

                                    {{ optional($clientDocument->updated_at)->format('d M Y, h:i A') }}

                                </td>

                            </tr>

                        </tbody>

                    </table>

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

                <div class="card-body d-grid gap-2">
                                        @can('view', $clientDocument)

                        @if($clientDocument->is_downloadable && $clientDocument->file_path)

                            <a
                                href="{{ route('client-documents.download', $clientDocument) }}"
                                class="btn btn-success">

                                <i class="mdi mdi-download me-1"></i>

                                Download Document

                            </a>

                        @endif

                    @endcan

                    @can('update', $clientDocument)

                        <a
                            href="{{ route('client-documents.edit', $clientDocument) }}"
                            class="btn btn-primary">

                            <i class="mdi mdi-pencil me-1"></i>

                            Edit Document

                        </a>

                        <button
                            type="button"
                            class="btn btn-warning"
                            data-bs-toggle="modal"
                            data-bs-target="#replaceDocumentModal">

                            <i class="mdi mdi-file-replace-outline me-1"></i>

                            Replace File

                        </button>

                    @endcan

                    @if(
                        $clientDocument->file_path &&
                        str_contains($clientDocument->mime_type, 'pdf')
                    )

                        <a
                            href="{{ route('client-documents.view-pdf', $clientDocument) }}"
                            target="_blank"
                            class="btn btn-info">

                            <i class="mdi mdi-file-pdf-box me-1"></i>

                            View PDF

                        </a>

                    @elseif(
                        $clientDocument->file_path &&
                        str_contains($clientDocument->mime_type, 'image')
                    )

                        <a
                            href="{{ route('client-documents.preview', $clientDocument) }}"
                            target="_blank"
                            class="btn btn-info">

                            <i class="mdi mdi-image-outline me-1"></i>

                            Preview Image

                        </a>

                    @endif
                                        @can('delete', $clientDocument)

                        <form
                            action="{{ route('client-documents.destroy', $clientDocument) }}"
                            method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this document?');">

                            @csrf

                            @method('DELETE')

                            <button
                                type="submit"
                                class="btn btn-danger w-100">

                                <i class="mdi mdi-delete me-1"></i>

                                Delete Document

                            </button>

                        </form>

                    @endcan

                </div>

            </div>

        </div>

    </div>

    <!-- ===================================================== -->
    <!-- Replace Document Modal -->
    <!-- ===================================================== -->

    @can('update', $clientDocument)

        <div
            class="modal fade"
            id="replaceDocumentModal"
            tabindex="-1"
            aria-labelledby="replaceDocumentModalLabel"
            aria-hidden="true">

            <div class="modal-dialog">

                <div class="modal-content">

                    <form
                        action="{{ route('client-documents.replace', $clientDocument) }}"
                        method="POST"
                        enctype="multipart/form-data">

                        @csrf
                                                <div class="modal-header">

                            <h5
                                class="modal-title"
                                id="replaceDocumentModalLabel">

                                Replace Document

                            </h5>

                            <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="modal"
                                aria-label="Close">

                            </button>

                        </div>

                        <div class="modal-body">

                            <div class="mb-3">

                                <label class="form-label">

                                    Select New File

                                </label>

                                <input
                                    type="file"
                                    name="document"
                                    class="form-control"
                                    required>

                                <small class="text-muted">

                                    The existing file will be permanently replaced.

                                </small>

                            </div>

                        </div>

                        <div class="modal-footer">

                            <button
                                type="button"
                                class="btn btn-secondary"
                                data-bs-dismiss="modal">

                                Cancel

                            </button>

                            <button
                                type="submit"
                                class="btn btn-primary">

                                <i class="mdi mdi-upload me-1"></i>

                                Replace Document

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    @endcan
    @endsection

@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {

    const modal = document.getElementById('replaceDocumentModal');

    if (!modal) {
        return;
    }

    modal.addEventListener('shown.bs.modal', function () {

        const input = modal.querySelector('input[type="file"]');

        if (input) {
            input.focus();
        }

    });

});

</script>

@endpush