@extends('layouts.app')

@section('title', 'Client Management')

@section('content')

<div class="container-fluid">

    <!-- Page Header -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">

                Client Management

            </h2>

            <p class="text-muted mb-0">

                Manage all your clients from one place.

            </p>

        </div>

        <div>

            @can('create', App\Models\Client::class)

                <a
                    href="{{ route('clients.create') }}"
                    class="btn btn-primary">

                    <i class="mdi mdi-plus-circle-outline me-1"></i>

                    Add Client

                </a>

            @endcan

        </div>

    </div>

    <!-- Statistics -->

    <div class="row mb-4">

        <div class="col-xl-3 col-md-6">

            <div class="card shadow-sm border-0">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <h6 class="text-muted">

                                Total Clients

                            </h6>

                            <h3 class="fw-bold">

                                {{ $totalClients ?? $clients->total() }}

                            </h3>

                        </div>

                        <div>

                            <i class="mdi mdi-domain display-5 text-primary"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-xl-3 col-md-6">

            <div class="card shadow-sm border-0">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <h6 class="text-muted">

                                Active

                            </h6>

                            <h3 class="text-success fw-bold">

                                {{ $activeClients ?? 0 }}

                            </h3>

                        </div>

                        <div>

                            <i class="mdi mdi-check-circle display-5 text-success"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-xl-3 col-md-6">

            <div class="card shadow-sm border-0">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <h6 class="text-muted">

                                Leads

                            </h6>

                            <h3 class="text-warning fw-bold">

                                {{ $leadClients ?? 0 }}

                            </h3>

                        </div>

                        <div>

                            <i class="mdi mdi-account-search display-5 text-warning"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-xl-3 col-md-6">

            <div class="card shadow-sm border-0">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <h6 class="text-muted">

                                Inactive

                            </h6>

                            <h3 class="text-danger fw-bold">

                                {{ $inactiveClients ?? 0 }}

                            </h3>

                        </div>

                        <div>

                            <i class="mdi mdi-account-off display-5 text-danger"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- Search & Filters -->

    <div class="card shadow-sm mb-4">

        <div class="card-header">

            <h5 class="mb-0">

                Search Clients

            </h5>

        </div>

        <div class="card-body">

            <form
                action="{{ route('clients.index') }}"
                method="GET">

                <div class="row">

                    <div class="col-md-4">

                        <input
                            type="text"
                            name="search"
                            class="form-control"
                            placeholder="Search by name, GST, PAN..."
                            value="{{ request('search') }}">

                    </div>

                    <div class="col-md-2">

                        <select
                            name="status"
                            class="form-select">

                            <option value="">

                                All Status

                            </option>

                            <option value="Lead"
                                @selected(request('status')=='Lead')>

                                Lead

                            </option>

                            <option value="Prospect"
                                @selected(request('status')=='Prospect')>

                                Prospect

                            </option>

                            <option value="Active"
                                @selected(request('status')=='Active')>

                                Active

                            </option>

                            <option value="Inactive"
                                @selected(request('status')=='Inactive')>

                                Inactive

                            </option>

                            <option value="Suspended"
                                @selected(request('status')=='Suspended')>

                                Suspended

                            </option>

                            <option value="Closed"
                                @selected(request('status')=='Closed')>

                                Closed

                            </option>

                        </select>

                    </div>

                    <div class="col-md-2">

                        <select
                            name="priority"
                            class="form-select">

                            <option value="">

                                All Priority

                            </option>

                            <option value="Low"
                                @selected(request('priority')=='Low')>

                                Low

                            </option>

                            <option value="Medium"
                                @selected(request('priority')=='Medium')>

                                Medium

                            </option>

                            <option value="High"
                                @selected(request('priority')=='High')>

                                High

                            </option>

                            <option value="Critical"
                                @selected(request('priority')=='Critical')>

                                Critical

                            </option>

                        </select>

                    </div>

                    <div class="col-md-2">

                        <button
                            class="btn btn-primary w-100">

                            <i class="mdi mdi-magnify"></i>

                            Search

                        </button>

                    </div>

                    <div class="col-md-2">

                        <a
                            href="{{ route('clients.index') }}"
                            class="btn btn-secondary w-100">

                            Reset

                        </a>

                    </div>

                </div>

            </form>

        </div>

    </div>
        <!-- Bulk Actions -->

    <div class="card shadow-sm mb-4">

        <div class="card-body">

            <form
                id="bulk-action-form"
                action="{{ route('clients.bulk-action') }}"
                method="POST">

                @csrf

                <div class="row align-items-center">

                    <div class="col-md-3">

                        <select
                            name="action"
                            class="form-select">

                            <option value="">

                                Bulk Action

                            </option>

                            <option value="activate">

                                Activate

                            </option>

                            <option value="deactivate">

                                Deactivate

                            </option>

                            <option value="delete">

                                Delete

                            </option>

                            <option value="restore">

                                Restore

                            </option>

                        </select>

                    </div>

                    <div class="col-md-2">

                        <button
                            type="submit"
                            class="btn btn-dark">

                            Apply

                        </button>

                    </div>

                    <div class="col-md-7 text-end">

                        @can('export', App\Models\Client::class)

                            <a
                                href="{{ route('clients.export') }}"
                                class="btn btn-success">

                                <i class="mdi mdi-file-excel"></i>

                                Export

                            </a>

                        @endcan

                        @can('import', App\Models\Client::class)

                            <a
                                href="{{ route('clients.import') }}"
                                class="btn btn-info">

                                <i class="mdi mdi-upload"></i>

                                Import

                            </a>

                        @endcan

                    </div>

                </div>

            </form>

        </div>

    </div>

    <!-- Client Table -->

    <div class="card shadow-sm">

        <div class="card-header d-flex justify-content-between align-items-center">

            <h5 class="mb-0">

                Client List

            </h5>

            <span class="badge bg-primary">

                {{ $clients->total() }}

                Records

            </span>

        </div>

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">

                        <tr>

                            <th width="40">

                                <input
                                    type="checkbox"
                                    id="select-all">

                            </th>

                            <th>

                                Client

                            </th>

                            <th>

                                GSTIN

                            </th>

                            <th>

                                Email

                            </th>

                            <th>

                                Phone

                            </th>

                            <th>

                                Assigned To

                            </th>

                            <th>

                                Status

                            </th>

                            <th>

                                Priority

                            </th>

                            <th width="180">

                                Actions

                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($clients as $client)

                            <tr>

                                <td>

                                    <input
                                        type="checkbox"
                                        class="record-checkbox"
                                        name="ids[]"
                                        form="bulk-action-form"
                                        value="{{ $client->id }}">

                                </td>

                                <td>

                                    <strong>

                                        {{ $client->company_name }}

                                    </strong>

                                    <br>

                                    <small class="text-muted">

                                        {{ $client->client_code }}

                                    </small>

                                </td>

                                <td>

                                    {{ $client->gstin ?: '-' }}

                                </td>

                                <td>

                                    {{ $client->email ?: '-' }}

                                </td>

                                <td>

                                    {{ $client->phone ?: '-' }}

                                </td>

                                <td>

                                    {{ optional($client->assignedUser)->name ?? '-' }}

                                </td>
                                                                <td>

                                    @switch($client->status)

                                        @case('Lead')

                                            <span class="badge bg-secondary">

                                                Lead

                                            </span>

                                            @break

                                        @case('Prospect')

                                            <span class="badge bg-info">

                                                Prospect

                                            </span>

                                            @break

                                        @case('Active')

                                            <span class="badge bg-success">

                                                Active

                                            </span>

                                            @break

                                        @case('Inactive')

                                            <span class="badge bg-warning">

                                                Inactive

                                            </span>

                                            @break

                                        @case('Suspended')

                                            <span class="badge bg-danger">

                                                Suspended

                                            </span>

                                            @break

                                        @case('Closed')

                                            <span class="badge bg-dark">

                                                Closed

                                            </span>

                                            @break

                                        @default

                                            <span class="badge bg-light text-dark">

                                                {{ $client->status }}

                                            </span>

                                    @endswitch

                                </td>

                                <td>

                                    @switch($client->priority)

                                        @case('Critical')

                                            <span class="badge bg-danger">

                                                Critical

                                            </span>

                                            @break

                                        @case('High')

                                            <span class="badge bg-warning">

                                                High

                                            </span>

                                            @break

                                        @case('Medium')

                                            <span class="badge bg-primary">

                                                Medium

                                            </span>

                                            @break

                                        @default

                                            <span class="badge bg-success">

                                                Low

                                            </span>

                                    @endswitch

                                </td>

                                <td>

                                    <div class="btn-group" role="group">

                                        @can('view', $client)

                                            <a
                                                href="{{ route('clients.show', $client) }}"
                                                class="btn btn-sm btn-info"
                                                title="View">

                                                <i class="mdi mdi-eye"></i>

                                            </a>

                                        @endcan

                                        @can('update', $client)

                                            <a
                                                href="{{ route('clients.edit', $client) }}"
                                                class="btn btn-sm btn-warning"
                                                title="Edit">

                                                <i class="mdi mdi-pencil"></i>

                                            </a>

                                        @endcan

                                        @can('delete', $client)

                                            <form
                                                action="{{ route('clients.destroy', $client) }}"
                                                method="POST"
                                                class="d-inline">

                                                @csrf

                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="btn btn-sm btn-danger"
                                                    title="Delete"
                                                    onclick="return confirm('Are you sure you want to delete this client?')">

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
                                    colspan="9"
                                    class="text-center py-5">

                                    <i class="mdi mdi-database-off display-4 text-muted"></i>

                                    <h5 class="mt-3">

                                        No Clients Found

                                    </h5>

                                    <p class="text-muted">

                                        There are no clients matching your search criteria.

                                    </p>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

        @if($clients->hasPages())

            <div class="card-footer">

                {{ $clients->withQueryString()->links() }}

            </div>

        @endif

    </div>
    </div>

@endsection

@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {

    const selectAll = document.getElementById('select-all');

    const checkboxes = document.querySelectorAll('.record-checkbox');

    if (selectAll) {

        selectAll.addEventListener('change', function () {

            checkboxes.forEach(function (checkbox) {

                checkbox.checked = selectAll.checked;

            });

        });

    }

    checkboxes.forEach(function (checkbox) {

        checkbox.addEventListener('change', function () {

            const total = checkboxes.length;

            const checked = document.querySelectorAll('.record-checkbox:checked').length;

            if (selectAll) {

                selectAll.checked = (total === checked);

            }

        });

    });

    const bulkForm = document.getElementById('bulk-action-form');

    if (bulkForm) {

        bulkForm.addEventListener('submit', function (e) {

            const action = bulkForm.querySelector('select[name="action"]').value;

            const checked = document.querySelectorAll('.record-checkbox:checked');

            if (action === '') {

                e.preventDefault();

                alert('Please select a bulk action.');

                return;

            }

            if (checked.length === 0) {

                e.preventDefault();

                alert('Please select at least one client.');

                return;

            }

            if (action === 'delete') {

                if (!confirm('Are you sure you want to delete the selected clients?')) {

                    e.preventDefault();

                    return;

                }

            }

        });

    }

});
</script>

@endpush