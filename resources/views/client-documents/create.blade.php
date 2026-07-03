@extends('layouts.app')

@section('title', 'Upload Client Document')

@section('content')

<div class="container-fluid">

    <!-- ===================================================== -->
    <!-- Header -->
    <!-- ===================================================== -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">

                Upload Client Document

            </h2>

            <p class="text-muted mb-0">

                Upload and manage important client documents.

            </p>

        </div>

        <div>

            <a
                href="{{ route('client-documents.index') }}"
                class="btn btn-secondary">

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
        action="{{ route('client-documents.store') }}"
        method="POST"
        enctype="multipart/form-data">

        @csrf

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

                        @if(isset($selectedClient) && $selectedClient)

                            <input
                                type="hidden"
                                name="client_id"
                                value="{{ $selectedClient->id }}">

                            <input
                                type="text"
                                class="form-control"
                                value="{{ $selectedClient->client_code }} - {{ $selectedClient->company_name }}"
                                readonly>

                        @else

                            <select
                                name="client_id"
                                class="form-select @error('client_id') is-invalid @enderror">

                                <option value="">

                                    Select Client

                                </option>

                                @foreach($clients as $client)

                                    <option
                                        value="{{ $client->id }}"
                                        @selected(old('client_id') == $client->id)>

                                        {{ $client->client_code }} - {{ $client->company_name }}

                                    </option>

                                @endforeach

                            </select>

                        @endif

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

                            <option value="">

                                Select Category

                            </option>

                            @foreach([
                                'GST','EPF','ESIC','Payroll','Registration','Invoice','Agreement','Employee','Bank','Tax','ROC','License','Certificate','Identity','Other'
                            ] as $category)

                                <option
                                    value="{{ $category }}"
                                    @selected(old('category') == $category)>

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
                            value="{{ old('title') }}"
                            placeholder="GST Certificate">

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
                            value="{{ old('document_number') }}"
                            placeholder="Document / Registration Number">

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
                            value="{{ old('version','1.0') }}"
                            placeholder="1.0">

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
                            placeholder="Enter a short description about this document...">{{ old('description') }}</textarea>

                        @error('description')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                </div>

            </div>

        </div>

        <!-- ===================================================== -->
        <!-- File Upload -->
        <!-- ===================================================== -->

        <div class="card shadow-sm mb-4">

            <div class="card-header">

                <h5 class="mb-0">

                    <i class="mdi mdi-upload me-2"></i>

                    Upload Document

                </h5>

            </div>

            <div class="card-body">

                <div class="row">

                    <!-- File -->

                    <div class="col-md-8 mb-3">

                        <label class="form-label">

                            Select File

                            <span class="text-danger">*</span>

                        </label>

                        <input
                            type="file"
                            name="document"
                            class="form-control @error('document') is-invalid @enderror">

                        <small class="text-muted">

                            Allowed: PDF, DOC, DOCX, XLS, XLSX, JPG, JPEG, PNG, ZIP

                        </small>

                        @error('document')

                            <div class="invalid-feedback d-block">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                    <!-- Status -->

                    <div class="col-md-4 mb-3">

                        <label class="form-label">

                            Status

                        </label>

                        <select
                            name="status"
                            class="form-select @error('status') is-invalid @enderror">

                            <option value="Pending"
                                @selected(old('status')=='Pending')>

                                Pending

                            </option>

                            <option value="Approved"
                                @selected(old('status')=='Approved')>

                                Approved

                            </option>

                            <option value="Rejected"
                                @selected(old('status')=='Rejected')>

                                Rejected

                            </option>

                            <option value="Expired"
                                @selected(old('status')=='Expired')>

                                Expired

                            </option>

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
                            value="{{ old('issue_date') }}">

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
                            value="{{ old('expiry_date') }}">

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
                                    @selected(old('uploaded_by', auth()->id()) == $user->id)>

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
                            @selected(old('approved_by') == $user->id)>

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

                    Approved Date & Time

                </label>

                <input
                    type="datetime-local"
                    name="approved_at"
                    class="form-control @error('approved_at') is-invalid @enderror"
                    value="{{ old('approved_at') }}">

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

            <!-- Confidential -->

            <div class="col-md-4 mb-3">

                <div class="form-check form-switch">

                    <input
                        class="form-check-input"
                        type="checkbox"
                        id="is_confidential"
                        name="is_confidential"
                        value="1"
                        @checked(old('is_confidential'))>

                    <label
                        class="form-check-label"
                        for="is_confidential">

                        Confidential Document

                    </label>

                </div>

            </div>

            <!-- Downloadable -->

            <div class="col-md-4 mb-3">

                <div class="form-check form-switch">

                    <input
                        class="form-check-input"
                        type="checkbox"
                        id="is_downloadable"
                        name="is_downloadable"
                        value="1"
                        @checked(old('is_downloadable', true))>

                    <label
                        class="form-check-label"
                        for="is_downloadable">

                        Allow Download

                    </label>

                </div>

            </div>

            <!-- Active -->

            <div class="col-md-4 mb-3">

                <div class="form-check form-switch">

                    <input
                        class="form-check-input"
                        type="checkbox"
                        id="is_active"
                        name="is_active"
                        value="1"
                        @checked(old('is_active', true))>

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
            placeholder="Additional remarks about this document...">{{ old('remarks') }}</textarea>

        @error('remarks')

            <div class="invalid-feedback d-block">

                {{ $message }}

            </div>

        @enderror

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
                    href="{{ route('client-documents.index') }}"
                    class="btn btn-light me-2">

                    <i class="mdi mdi-close"></i>

                    Cancel

                </a>

                <button
                    type="reset"
                    class="btn btn-warning me-2">

                    <i class="mdi mdi-refresh"></i>

                    Reset

                </button>

                <button
                    type="submit"
                    class="btn btn-primary">

                    <i class="mdi mdi-content-save me-1"></i>

                    Upload Document

                </button>

            </div>

        </div>

    </div>

</div>

    </form>

</div>

@endsection