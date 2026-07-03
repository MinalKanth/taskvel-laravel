@extends('layouts.app')

@section('title', 'Edit Client Document')

@section('content')

<div class="container-fluid">

    <!-- ===================================================== -->
    <!-- Header -->
    <!-- ===================================================== -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">

                Edit Client Document

            </h2>

            <p class="text-muted mb-0">

                Update document details and replace the uploaded file if required.

            </p>

        </div>

        <div>

            <a
                href="{{ route('client-documents.show', $clientDocument) }}"
                class="btn btn-info">

                <i class="mdi mdi-eye me-1"></i>

                View

            </a>

            <a
                href="{{ route('client-documents.index') }}"
                class="btn btn-secondary ms-2">

                <i class="mdi mdi-arrow-left me-1"></i>

                Back

            </a>

        </div>

    </div>

    @if($errors->any())

        <div class="alert alert-danger">

            <strong>Please correct the following errors:</strong>

            <hr>

            <ul class="mb-0">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif

    <form
        action="{{ route('client-documents.update', $clientDocument) }}"
        method="POST"
        enctype="multipart/form-data">

        @csrf

        @method('PUT')

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

                    <!-- Client -->

                    <div class="col-md-4 mb-3">

                        <label class="form-label">

                            Client

                            <span class="text-danger">*</span>

                        </label>

                        <select
                            name="client_id"
                            class="form-select @error('client_id') is-invalid @enderror">

                            @foreach($clients as $client)

                                <option
                                    value="{{ $client->id }}"
                                    @selected(old('client_id', $clientDocument->client_id) == $client->id)>

                                    {{ $client->client_code }} - {{ $client->company_name }}

                                </option>

                            @endforeach

                        </select>

                        @error('client_id')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>
                                        <!-- Category -->

                    <div class="col-md-4 mb-3">

                        <label class="form-label">

                            Category

                            <span class="text-danger">*</span>

                        </label>

                        <select
                            name="category"
                            class="form-select @error('category') is-invalid @enderror">

                            @foreach([
                                'GST',
                                'EPF',
                                'ESIC',
                                'Payroll',
                                'Registration',
                                'Invoice',
                                'Agreement',
                                'Employee',
                                'Bank',
                                'Tax',
                                'ROC',
                                'License',
                                'Certificate',
                                'Identity',
                                'Other'
                            ] as $category)

                                <option
                                    value="{{ $category }}"
                                    @selected(old('category', $clientDocument->category) == $category)>

                                    {{ $category }}

                                </option>

                            @endforeach

                        </select>

                        @error('category')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                    <!-- Title -->

                    <div class="col-md-4 mb-3">

                        <label class="form-label">

                            Document Title

                            <span class="text-danger">*</span>

                        </label>

                        <input
                            type="text"
                            name="title"
                            class="form-control @error('title') is-invalid @enderror"
                            value="{{ old('title', $clientDocument->title) }}">

                        @error('title')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                    <!-- Document Number -->

                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Document Number

                        </label>

                        <input
                            type="text"
                            name="document_number"
                            class="form-control @error('document_number') is-invalid @enderror"
                            value="{{ old('document_number', $clientDocument->document_number) }}">

                        @error('document_number')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                    <!-- Version -->

                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Version

                        </label>

                        <input
                            type="text"
                            name="version"
                            class="form-control @error('version') is-invalid @enderror"
                            value="{{ old('version', $clientDocument->version) }}">

                        @error('version')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>
                                        <!-- Description -->

                    <div class="col-md-12 mb-3">

                        <label class="form-label">

                            Description

                        </label>

                        <textarea
                            name="description"
                            rows="4"
                            class="form-control @error('description') is-invalid @enderror"
                            placeholder="Enter a short description...">{{ old('description', $clientDocument->description) }}</textarea>

                        @error('description')

                            <div class="invalid-feedback d-block">

                                {{ $message }}

                            </div>

                        @enderror

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

                    <i class="mdi mdi-upload me-2"></i>

                    Replace Uploaded File (Optional)

                </h5>

            </div>

            <div class="card-body">

                <div class="alert alert-info">

                    <strong>Current File:</strong>

                    {{ $clientDocument->original_name }}

                </div>

                <div class="row">

                    <div class="col-md-8 mb-3">

                        <label class="form-label">

                            Upload New File

                        </label>

                        <input
                            type="file"
                            name="document"
                            class="form-control @error('document') is-invalid @enderror">

                        <small class="text-muted">

                            Leave empty to keep the existing file.

                        </small>

                        @error('document')

                            <div class="invalid-feedback d-block">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                    <div class="col-md-4 mb-3">

                        <label class="form-label">

                            Status

                        </label>

                        <select
                            name="status"
                            class="form-select @error('status') is-invalid @enderror">
                                                        @foreach([
                                'Pending',
                                'Approved',
                                'Rejected',
                                'Expired',
                                'Archived'
                            ] as $status)

                                <option
                                    value="{{ $status }}"
                                    @selected(old('status', $clientDocument->status) == $status)>

                                    {{ $status }}

                                </option>

                            @endforeach

                        </select>

                        @error('status')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                    <!-- Issue Date -->

                    <div class="col-md-4 mb-3">

                        <label class="form-label">

                            Issue Date

                        </label>

                        <input
                            type="date"
                            name="issue_date"
                            class="form-control @error('issue_date') is-invalid @enderror"
                            value="{{ old('issue_date', optional($clientDocument->issue_date)->format('Y-m-d')) }}">

                        @error('issue_date')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                    <!-- Expiry Date -->

                    <div class="col-md-4 mb-3">

                        <label class="form-label">

                            Expiry Date

                        </label>

                        <input
                            type="date"
                            name="expiry_date"
                            class="form-control @error('expiry_date') is-invalid @enderror"
                            value="{{ old('expiry_date', optional($clientDocument->expiry_date)->format('Y-m-d')) }}">

                        @error('expiry_date')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                    <!-- Uploaded By -->

                    <div class="col-md-4 mb-3">

                        <label class="form-label">

                            Uploaded By

                        </label>

                        <select
                            name="uploaded_by"
                            class="form-select @error('uploaded_by') is-invalid @enderror">

                            <option value="">

                                Select User

                            </option>
                                                        @foreach($users as $user)

                                <option
                                    value="{{ $user->id }}"
                                    @selected(old('uploaded_by', $clientDocument->uploaded_by) == $user->id)>

                                    {{ $user->name }}

                                </option>

                            @endforeach

                        </select>

                        @error('uploaded_by')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                </div>

            </div>

        </div>

        <!-- ===================================================== -->
        <!-- Approval Information -->
        <!-- ===================================================== -->

        <div class="card shadow-sm mb-4">

            <div class="card-header">

                <h5 class="mb-0">

                    <i class="mdi mdi-check-decagram-outline me-2"></i>

                    Approval Information

                </h5>

            </div>

            <div class="card-body">

                <div class="row">

                    <!-- Approved By -->

                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Approved By

                        </label>

                        <select
                            name="approved_by"
                            class="form-select @error('approved_by') is-invalid @enderror">

                            <option value="">

                                Select Approver

                            </option>

                            @foreach($users as $user)

                                <option
                                    value="{{ $user->id }}"
                                    @selected(old('approved_by', $clientDocument->approved_by) == $user->id)>

                                    {{ $user->name }}

                                </option>

                            @endforeach

                        </select>

                        @error('approved_by')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>
                                        <!-- Approved At -->

                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Approval Date & Time

                        </label>

                        <input
                            type="datetime-local"
                            name="approved_at"
                            class="form-control @error('approved_at') is-invalid @enderror"
                            value="{{ old('approved_at', optional($clientDocument->approved_at)->format('Y-m-d\TH:i')) }}">

                        @error('approved_at')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                </div>

            </div>

        </div>

        <!-- ===================================================== -->
        <!-- Document Settings -->
        <!-- ===================================================== -->

        <div class="card shadow-sm mb-4">

            <div class="card-header">

                <h5 class="mb-0">

                    <i class="mdi mdi-cog-outline me-2"></i>

                    Document Settings

                </h5>

            </div>

            <div class="card-body">

                <div class="row">

                    <div class="col-md-4 mb-3">

                        <div class="form-check form-switch">

                            <input
                                class="form-check-input"
                                type="checkbox"
                                id="is_confidential"
                                name="is_confidential"
                                value="1"
                                @checked(old('is_confidential', $clientDocument->is_confidential))>

                            <label
                                class="form-check-label"
                                for="is_confidential">

                                Confidential Document

                            </label>

                        </div>

                    </div>

                    <div class="col-md-4 mb-3">
                                            <div class="col-md-4 mb-3">

                        <div class="form-check form-switch">

                            <input
                                class="form-check-input"
                                type="checkbox"
                                id="is_downloadable"
                                name="is_downloadable"
                                value="1"
                                @checked(old('is_downloadable', $clientDocument->is_downloadable))>

                            <label
                                class="form-check-label"
                                for="is_downloadable">

                                Allow Download

                            </label>

                        </div>

                    </div>

                    <div class="col-md-4 mb-3">

                        <div class="form-check form-switch">

                            <input
                                class="form-check-input"
                                type="checkbox"
                                id="is_active"
                                name="is_active"
                                value="1"
                                @checked(old('is_active', $clientDocument->is_active))>

                            <label
                                class="form-check-label"
                                for="is_active">

                                Active Document

                            </label>

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

                <textarea
                    name="remarks"
                    rows="5"
                    class="form-control @error('remarks') is-invalid @enderror"
                    placeholder="Additional remarks about this document...">{{ old('remarks', $clientDocument->remarks) }}</textarea>

                @error('remarks')

                    <div class="invalid-feedback d-block">

                        {{ $message }}

                    </div>

                @enderror

            </div>

        </div>
                <!-- ===================================================== -->
        <!-- Current File Information -->
        <!-- ===================================================== -->

        <div class="card shadow-sm mb-4">

            <div class="card-header">

                <h5 class="mb-0">

                    <i class="mdi mdi-file-outline me-2"></i>

                    Current File Information

                </h5>

            </div>

            <div class="card-body">

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label class="form-label fw-semibold">

                            Original File Name

                        </label>

                        <div>

                            {{ $clientDocument->original_name ?: 'N/A' }}

                        </div>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label fw-semibold">

                            Stored File Name

                        </label>

                        <div>

                            {{ $clientDocument->file_name ?: 'N/A' }}

                        </div>

                    </div>

                    <div class="col-md-3 mb-3">

                        <label class="form-label fw-semibold">

                            Extension

                        </label>

                        <div>

                            {{ strtoupper($clientDocument->extension ?? '-') }}

                        </div>

                    </div>

                    <div class="col-md-3 mb-3">

                        <label class="form-label fw-semibold">

                            MIME Type

                        </label>

                        <div>

                            {{ $clientDocument->mime_type ?: 'N/A' }}

                        </div>

                    </div>

                    <div class="col-md-3 mb-3">

                        <label class="form-label fw-semibold">

                            File Size

                        </label>

                        <div>

                            {{ number_format(($clientDocument->file_size ?? 0) / 1024, 2) }} KB

                        </div>

                    </div>

                    <div class="col-md-3 mb-3">

                        <label class="form-label fw-semibold">

                            Storage Disk

                        </label>

                        <div>

                            {{ $clientDocument->disk ?: 'public' }}

                        </div>

                    </div>

                </div>

            </div>

        </div>
                <!-- ===================================================== -->
        <!-- Form Actions -->
        <!-- ===================================================== -->

        <div class="card shadow-sm">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <small class="text-muted">

                            Fields marked with
                            <span class="text-danger">*</span>
                            are mandatory.

                        </small>

                    </div>

                    <div>

                        <a
                            href="{{ route('client-documents.show', $clientDocument) }}"
                            class="btn btn-light me-2">

                            <i class="mdi mdi-eye me-1"></i>

                            View

                        </a>

                        <a
                            href="{{ route('client-documents.index') }}"
                            class="btn btn-secondary me-2">

                            <i class="mdi mdi-close me-1"></i>

                            Cancel

                        </a>

                        <button
                            type="reset"
                            class="btn btn-warning me-2">

                            <i class="mdi mdi-refresh me-1"></i>

                            Reset

                        </button>

                        <button
                            type="submit"
                            class="btn btn-primary">

                            <i class="mdi mdi-content-save me-1"></i>

                            Update Document

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

document.addEventListener('DOMContentLoaded', function () {

    const confidential = document.getElementById('is_confidential');
    const downloadable = document.getElementById('is_downloadable');
    const active = document.getElementById('is_active');

    [confidential, downloadable, active].forEach(function (element) {

        if (!element) {
            return;
        }

        element.addEventListener('change', function () {

            console.log(
                this.name + ' = ' + (this.checked ? 'true' : 'false')
            );

        });

    });

});

</script>

@endpush