@extends('layouts.app')

@section('title', 'Client Remarks')

@section('content')

<div class="container-fluid">

    <!-- ===================================================== -->
    <!-- Page Header -->
    <!-- ===================================================== -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">

                Client Remarks

            </h2>

            <p class="text-muted mb-0">

                Manage client remarks, follow-ups, compliance notes and communications.

            </p>

        </div>

        <div class="d-flex gap-2">

            @can('create', App\Models\ClientRemark::class)

                <a
                    href="{{ route('client-remarks.create') }}"
                    class="btn btn-primary">

                    <i class="mdi mdi-plus-circle me-1"></i>

                    Add Remark

                </a>

            @endcan

            @can('restore', App\Models\ClientRemark::class)

                <a
                    href="{{ route('client-remarks.trashed') }}"
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

                <i class="mdi mdi-filter-variant me-2"></i>

                Filters

            </h5>

        </div>

        <div class="card-body">

            <form
                method="GET"
                action="{{ route('client-remarks.index') }}">

                <div class="row">
                                        <!-- Client -->

                    <div class="col-md-3 mb-3">

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

                    <!-- Type -->

                    <div class="col-md-3 mb-3">

                        <label class="form-label">

                            Type

                        </label>

                        <select
                            name="type"
                            class="form-select">

                            <option value="">

                                All Types

                            </option>

                            @foreach([
                                'General',
                                'Follow Up',
                                'Important',
                                'Payment',
                                'Compliance',
                                'Registration',
                                'Document',
                                'Meeting',
                                'Phone Call',
                                'Email',
                                'WhatsApp'
                            ] as $type)

                                <option
                                    value="{{ $type }}"
                                    @selected(request('type') == $type)>

                                    {{ $type }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    <!-- Status -->

                    <div class="col-md-2 mb-3">

                        <label class="form-label">

                            Status

                        </label>

                        <select
                            name="status"
                            class="form-select">

                            <option value="">

                                All

                            </option>

                            @foreach([
                                'Open',
                                'In Progress',
                                'Resolved',
                                'Closed'
                            ] as $status)

                                <option
                                    value="{{ $status }}"
                                    @selected(request('status') == $status)>

                                    {{ $status }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    <!-- Search -->

                    <div class="col-md-4 mb-3">

                        <label class="form-label">

                            Search

                        </label>

                        <input
                            type="text"
                            name="search"
                            class="form-control"
                            placeholder="Search remark..."
                            value="{{ request('search') }}">

                    </div>
                                        <!-- Buttons -->

                    <div class="col-md-12">

                        <div class="d-flex gap-2">

                            <button
                                type="submit"
                                class="btn btn-primary">

                                <i class="mdi mdi-magnify me-1"></i>

                                Search

                            </button>

                            <a
                                href="{{ route('client-remarks.index') }}"
                                class="btn btn-light border">

                                <i class="mdi mdi-refresh me-1"></i>

                                Reset

                            </a>

                        </div>

                    </div>

                </div>

            </form>

        </div>

    </div>

    <!-- ===================================================== -->
    <!-- Remarks Table -->
    <!-- ===================================================== -->

    <div class="card shadow-sm">

        <form
            method="POST"
            action="{{ route('client-remarks.bulk-delete') }}">

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

                            <th>#</th>

                            <th>Client</th>

                            <th>Type</th>

                            <th>Remark</th>

                            <th>Status</th>

                            <th>Pinned</th>

                            <th>Private</th>

                            <th>Created By</th>

                            <th>Created</th>

                            <th width="180">

                                Actions

                            </th>

                        </tr>

                    </thead>

                    <tbody>
                                                @forelse($remarks as $remark)

                            <tr>

                                <td>

                                    <input
                                        type="checkbox"
                                        class="remark-checkbox"
                                        name="ids[]"
                                        value="{{ $remark->id }}">

                                </td>

                                <td>

                                    {{ $remark->id }}

                                </td>

                                <td>

                                    <div class="fw-semibold">

                                        {{ optional($remark->client)->company_name }}

                                    </div>

                                    <small class="text-muted">

                                        {{ optional($remark->client)->client_code }}

                                    </small>

                                </td>

                                <td>

                                    <span class="badge bg-info">

                                        {{ $remark->type }}

                                    </span>

                                </td>

                                <td style="min-width:300px;">

                                    <strong>

                                        {{ \Illuminate\Support\Str::limit($remark->remark, 120) }}

                                    </strong>

                                </td>

                                <td>

                                    @php

                                        $statusClass = match($remark->status) {

                                            'Open' => 'warning',

                                            'In Progress' => 'primary',

                                            'Resolved' => 'success',

                                            'Closed' => 'secondary',

                                            default => 'dark',

                                        };

                                    @endphp

                                    <span class="badge bg-{{ $statusClass }}">

                                        {{ $remark->status }}

                                    </span>

                                </td>

                                <td>
                                                                        @if($remark->is_pinned)

                                        <span class="badge bg-warning text-dark">

                                            <i class="mdi mdi-pin me-1"></i>

                                            Yes

                                        </span>

                                    @else

                                        <span class="badge bg-light text-dark border">

                                            No

                                        </span>

                                    @endif

                                </td>

                                <td>

                                    @if($remark->is_private)

                                        <span class="badge bg-danger">

                                            Private

                                        </span>

                                    @else

                                        <span class="badge bg-success">

                                            Public

                                        </span>

                                    @endif

                                </td>

                                <td>

                                    {{ optional($remark->user)->name }}

                                </td>

                                <td>

                                    {{ optional($remark->created_at)->format('d M Y') }}

                                    <br>

                                    <small class="text-muted">

                                        {{ optional($remark->created_at)->format('h:i A') }}

                                    </small>

                                </td>

                                <td>

                                    <div class="btn-group">

                                        @can('view', $remark)

                                            <a
                                                href="{{ route('client-remarks.show', $remark) }}"
                                                class="btn btn-sm btn-primary"
                                                title="View">

                                                <i class="mdi mdi-eye"></i>

                                            </a>

                                        @endcan

                                        @can('update', $remark)

                                            <a
                                                href="{{ route('client-remarks.edit', $remark) }}"
                                                class="btn btn-sm btn-warning"
                                                title="Edit">

                                                <i class="mdi mdi-pencil"></i>

                                            </a>

                                        @endcan
                                                                                @can('delete', $remark)

                                            <form
                                                action="{{ route('client-remarks.destroy', $remark) }}"
                                                method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Are you sure you want to delete this remark?');">

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
                                    colspan="11"
                                    class="text-center py-5">

                                    <i class="mdi mdi-note-remove-outline display-4 text-muted"></i>

                                    <h5 class="mt-3">

                                        No Remarks Found

                                    </h5>

                                    <p class="text-muted">

                                        No remarks match the selected filters.

                                    </p>

                                    @can('create', App\Models\ClientRemark::class)

                                        <a
                                            href="{{ route('client-remarks.create') }}"
                                            class="btn btn-primary">

                                            <i class="mdi mdi-plus-circle me-1"></i>

                                            Add First Remark

                                        </a>

                                    @endcan

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>
                        @can('delete', App\Models\ClientRemark::class)

                <div class="card-footer d-flex justify-content-between align-items-center">

                    <div>

                        <button
                            type="submit"
                            class="btn btn-danger"
                            id="bulkDeleteBtn"
                            disabled
                            onclick="return confirm('Delete selected remarks?')">

                            <i class="mdi mdi-delete me-1"></i>

                            Delete Selected

                        </button>

                    </div>

                    <div>

                        {{ $remarks->links() }}

                    </div>

                </div>

            @else

                <div class="card-footer">

                    {{ $remarks->links() }}

                </div>

            @endcan

        </form>

    </div>

</div>

@endsection

@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {

    const selectAll = document.getElementById('selectAll');

    const checkboxes = document.querySelectorAll('.remark-checkbox');

    const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');

    function updateBulkButton() {

        if (!bulkDeleteBtn) {

            return;

        }

        const checked = document.querySelectorAll(
            '.remark-checkbox:checked'
        ).length;

        bulkDeleteBtn.disabled = checked === 0;

    }

    if (selectAll) {

        selectAll.addEventListener('change', function () {

            checkboxes.forEach(function (checkbox) {

                checkbox.checked = this.checked;

            }, this);

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