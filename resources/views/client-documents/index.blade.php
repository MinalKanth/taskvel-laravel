@extends('layouts.app')

@section('title', 'Client Documents')

@section('content')

<div class="container-fluid">

    <!-- ===================================================== -->
    <!-- Page Header -->
    <!-- ===================================================== -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">

                Client Documents

            </h2>

            <p class="text-muted mb-0">

                Manage and organize all client documents.

            </p>

        </div>

        <div class="d-flex gap-2">

            @can('create', App\Models\ClientDocument::class)

                <a
                    href="{{ route('client-documents.create') }}"
                    class="btn btn-primary">

                    <i class="mdi mdi-plus-circle me-1"></i>

                    Upload Document

                </a>

            @endcan

            @can('restore', App\Models\ClientDocument::class)

                <a
                    href="{{ route('client-documents.trashed') }}"
                    class="btn btn-danger">

                    <i class="mdi mdi-delete-restore me-1"></i>

                    Trash

                </a>

            @endcan

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

    @if(session('error'))

        <div class="alert alert-danger alert-dismissible fade show">

            {{ session('error') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert">

            </button>

        </div>

    @endif

    <!-- ===================================================== -->
    <!-- Filters -->
    <!-- ===================================================== -->

    <div class="card shadow-sm mb-4">

        <div class="card-header">

            <h5 class="mb-0">

                <i class="mdi mdi-filter-outline me-2"></i>

                Search & Filters

            </h5>

        </div>

        <div class="card-body">

            <form
                method="GET"
                action="{{ route('client-documents.index') }}">

                <div class="row">
                                        <!-- Search -->

                    <div class="col-lg-4 col-md-6 mb-3">

                        <label class="form-label">

                            Search

                        </label>

                        <input
                            type="text"
                            name="search"
                            class="form-control"
                            placeholder="Title, document number..."
                            value="{{ request('search') }}">

                    </div>

                    <!-- Client -->

                    <div class="col-lg-3 col-md-6 mb-3">

                        <label class="form-label">

                            Client

                        </label>

                        <select
                            name="client_id"
                            class="form-select">

                            <option value="">

                                All Clients

                            </option>

                            @foreach($clients as $client)

                                <option
                                    value="{{ $client->id }}"
                                    @selected(request('client_id') == $client->id)>

                                    {{ $client->client_code }}
                                    -
                                    {{ $client->company_name }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    <!-- Category -->

                    <div class="col-lg-3 col-md-6 mb-3">

                        <label class="form-label">

                            Category

                        </label>

                        <select
                            name="category"
                            class="form-select">

                            <option value="">

                                All Categories

                            </option>

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
                                    @selected(request('category') == $category)>

                                    {{ $category }}

                                </option>

                            @endforeach

                        </select>

                    </div>
                                        <!-- Status -->

                    <div class="col-lg-2 col-md-6 mb-3">

                        <label class="form-label">

                            Status

                        </label>

                        <select
                            name="status"
                            class="form-select">

                            <option value="">

                                All Status

                            </option>

                            @foreach([
                                'Pending',
                                'Approved',
                                'Rejected',
                                'Expired',
                                'Archived'
                            ] as $status)

                                <option
                                    value="{{ $status }}"
                                    @selected(request('status') == $status)>

                                    {{ $status }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                </div>

                <div class="d-flex justify-content-end gap-2">

                    <a
                        href="{{ route('client-documents.index') }}"
                        class="btn btn-light">

                        <i class="mdi mdi-refresh me-1"></i>

                        Reset

                    </a>

                    <button
                        type="submit"
                        class="btn btn-primary">

                        <i class="mdi mdi-magnify me-1"></i>

                        Search

                    </button>

                </div>

            </form>

        </div>

    </div>

    <!-- ===================================================== -->
    <!-- Documents Table -->
    <!-- ===================================================== -->

    <div class="card shadow-sm">

        <div class="card-header d-flex justify-content-between align-items-center">

            <h5 class="mb-0">

                <i class="mdi mdi-file-document-multiple-outline me-2"></i>

                Documents

            </h5>

            <span class="badge bg-primary">

                {{ $documents->total() }} Records

            </span>

        </div>

        <div class="card-body p-0">

            <form
                method="POST"
                action="{{ route('client-documents.bulk-delete') }}"
                id="bulkDeleteForm">

                @csrf
                                @method('DELETE')

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-light">

                            <tr>

                                <th width="40">

                                    <input
                                        type="checkbox"
                                        id="selectAll">

                                </th>

                                <th>

                                    Client

                                </th>

                                <th>

                                    Title

                                </th>

                                <th>

                                    Category

                                </th>

                                <th>

                                    Status

                                </th>

                                <th>

                                    Uploaded

                                </th>

                                <th>

                                    Expiry

                                </th>

                                <th class="text-center">

                                    Actions

                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($documents as $document)

                                <tr>

                                    <td>

                                        <input
                                            type="checkbox"
                                            class="document-checkbox"
                                            name="ids[]"
                                            value="{{ $document->id }}">

                                    </td>

                                    <td>

                                        @if($document->client)

                                            <a
                                                href="{{ route('clients.show', $document->client) }}"
                                                class="text-decoration-none fw-semibold">

                                                {{ $document->client->client_code }}

                                                <br>

                                                <small class="text-muted">

                                                    {{ $document->client->company_name }}

                                                </small>

                                            </a>

                                        @else

                                            <span class="text-muted">

                                                N/A

                                            </span>

                                        @endif

                                    </td>

                                    <td>
                                                                                <div class="fw-semibold">

                                            {{ $document->title }}

                                        </div>

                                        @if($document->document_number)

                                            <small class="text-muted">

                                                No:
                                                {{ $document->document_number }}

                                            </small>

                                        @endif

                                    </td>

                                    <td>

                                        <span class="badge bg-info">

                                            {{ $document->category }}

                                        </span>

                                    </td>

                                    <td>

                                        @php

                                            $statusClass = match($document->status) {

                                                'Approved' => 'success',

                                                'Pending' => 'warning',

                                                'Rejected' => 'danger',

                                                'Expired' => 'secondary',

                                                'Archived' => 'dark',

                                                default => 'primary',

                                            };

                                        @endphp

                                        <span class="badge bg-{{ $statusClass }}">

                                            {{ $document->status }}

                                        </span>

                                    </td>

                                    <td>

                                        {{ optional($document->created_at)->format('d M Y') }}

                                    </td>

                                    <td>

                                        {{ optional($document->expiry_date)->format('d M Y') ?? '-' }}

                                    </td>

                                    <td class="text-center">
                                                                                <div
                                            class="btn-group"
                                            role="group">

                                            @can('view', $document)

                                                <a
                                                    href="{{ route('client-documents.show', $document) }}"
                                                    class="btn btn-sm btn-primary"
                                                    title="View">

                                                    <i class="mdi mdi-eye"></i>

                                                </a>

                                            @endcan

                                            @can('update', $document)

                                                <a
                                                    href="{{ route('client-documents.edit', $document) }}"
                                                    class="btn btn-sm btn-warning"
                                                    title="Edit">

                                                    <i class="mdi mdi-pencil"></i>

                                                </a>

                                            @endcan

                                            @if(
                                                $document->is_downloadable &&
                                                $document->file_path
                                            )

                                                <a
                                                    href="{{ route('client-documents.download', $document) }}"
                                                    class="btn btn-sm btn-success"
                                                    title="Download">

                                                    <i class="mdi mdi-download"></i>

                                                </a>

                                            @endif

                                            @can('delete', $document)

                                                <form
                                                    action="{{ route('client-documents.destroy', $document) }}"
                                                    method="POST"
                                                    class="d-inline"
                                                    onsubmit="return confirm('Are you sure you want to delete this document?');">

                                                    @csrf

                                                    @method('DELETE')

                                                    <button
                                                        type="submit"
                                                        class="btn btn-sm btn-danger"
                                                        title="Delete">

                                                        <i class="mdi mdi-delete"></i>

                                                    </button>

                                                </form>

                                            @endcan

                                        </div>

                                    </td>

                                </tr>
                                                            @empty

                                <tr>

                                    <td
                                        colspan="8"
                                        class="text-center py-5">

                                        <i
                                            class="mdi mdi-file-document-outline display-4 text-muted">
                                        </i>

                                        <h5 class="mt-3">

                                            No Documents Found

                                        </h5>

                                        <p class="text-muted mb-3">

                                            No client documents match the selected filters.

                                        </p>

                                        @can('create', App\Models\ClientDocument::class)

                                            <a
                                                href="{{ route('client-documents.create') }}"
                                                class="btn btn-primary">

                                                <i class="mdi mdi-plus-circle me-1"></i>

                                                Upload First Document

                                            </a>

                                        @endcan

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

                @can('delete', App\Models\ClientDocument::class)

                    <div class="card-footer d-flex justify-content-between align-items-center">

                        <div>

                            <button
                                type="submit"
                                class="btn btn-danger"
                                id="bulkDeleteBtn"
                                disabled
                                onclick="return confirm('Delete selected documents?')">

                                <i class="mdi mdi-delete me-1"></i>

                                Delete Selected

                            </button>

                        </div>

                        <div>

                            {{ $documents->links() }}

                        </div>

                    </div>

                @else

                    <div class="card-footer">

                        {{ $documents->links() }}

                    </div>

                @endcan

            </form>

        </div>

    </div>
    </div>

@endsection

@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {

    const selectAll = document.getElementById('selectAll');

    const checkboxes = document.querySelectorAll('.document-checkbox');

    const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');

    function updateBulkButton() {

        if (!bulkDeleteBtn) {
            return;
        }

        const checked = document.querySelectorAll(
            '.document-checkbox:checked'
        ).length;

        bulkDeleteBtn.disabled = checked === 0;

    }

    if (selectAll) {

        selectAll.addEventListener('change', function () {

            checkboxes.forEach(function (checkbox) {

                checkbox.checked = selectAll.checked;

            });

            updateBulkButton();

        });

    }

    checkboxes.forEach(function (checkbox) {

        checkbox.addEventListener('change', function () {

            updateBulkButton();

            if (!this.checked && selectAll) {

                selectAll.checked = false;

            }

        });

    });

    updateBulkButton();

});

</script>

@endpush