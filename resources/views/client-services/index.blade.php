@extends('layouts.app')

@section('title', 'Client Services')

@section('content')

<div class="container-fluid">

    <!-- ===================================================== -->
    <!-- Header -->
    <!-- ===================================================== -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">

                Client Services

            </h2>

            <p class="text-muted mb-0">

                Manage all client service assignments and subscriptions.

            </p>

        </div>

        <div>

            @can('create', App\Models\ClientService::class)

                <a
                    href="{{ route('client-services.create') }}"
                    class="btn btn-primary">

                    <i class="mdi mdi-plus-circle me-1"></i>

                    Assign Service

                </a>

            @endcan

        </div>

    </div>

    <!-- ===================================================== -->
    <!-- Success Message -->
    <!-- ===================================================== -->

    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show">

            <i class="mdi mdi-check-circle me-2"></i>

            {{ session('success') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"></button>

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
                action="{{ route('client-services.index') }}"
                method="GET">

                <div class="row">

                    <div class="col-md-3 mb-3">

                        <label class="form-label">

                            Search

                        </label>

                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            class="form-control"
                            placeholder="Client / Service...">

                    </div>

                    <div class="col-md-3 mb-3">

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
                                'Active',
                                'On Hold',
                                'Completed',
                                'Cancelled'
                            ] as $status)

                                <option
                                    value="{{ $status }}"
                                    @selected(request('status')==$status)>

                                    {{ $status }}

                                </option>

                            @endforeach

                        </select>

                    </div>
                                        <div class="col-md-3 mb-3">

                        <label class="form-label">

                            Billing Cycle

                        </label>

                        <select
                            name="billing_cycle"
                            class="form-select">

                            <option value="">

                                All Billing Cycles

                            </option>

                            @foreach([
                                'One Time',
                                'Weekly',
                                'Monthly',
                                'Quarterly',
                                'Half Yearly',
                                'Yearly'
                            ] as $cycle)

                                <option
                                    value="{{ $cycle }}"
                                    @selected(request('billing_cycle') == $cycle)>

                                    {{ $cycle }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="col-md-3 mb-3">

                        <label class="form-label">

                            Active Status

                        </label>

                        <select
                            name="is_active"
                            class="form-select">

                            <option value="">

                                All

                            </option>

                            <option
                                value="1"
                                @selected(request('is_active') === '1')>

                                Active

                            </option>

                            <option
                                value="0"
                                @selected(request('is_active') === '0')>

                                Inactive

                            </option>

                        </select>

                    </div>

                    <div class="col-12">

                        <button
                            type="submit"
                            class="btn btn-primary">

                            <i class="mdi mdi-magnify me-1"></i>

                            Search

                        </button>

                        <a
                            href="{{ route('client-services.index') }}"
                            class="btn btn-light">

                            <i class="mdi mdi-refresh me-1"></i>

                            Reset

                        </a>

                    </div>

                </div>

            </form>

        </div>

    </div>

    <!-- ===================================================== -->
    <!-- Client Services Table -->
    <!-- ===================================================== -->

    <div class="card shadow-sm">

        <div class="card-header d-flex justify-content-between align-items-center">

            <h5 class="mb-0">

                Client Services List

            </h5>

            <span class="badge bg-primary">

                Total :
                {{ $clientServices->total() }}

            </span>

        </div>

        <div class="card-body p-0">
                        <div class="table-responsive">

                <table class="table table-hover table-striped align-middle mb-0">

                    <thead class="table-light">

                        <tr>

                            <th width="40">

                                <input
                                    type="checkbox"
                                    id="checkAll"
                                    class="form-check-input">

                            </th>

                            <th>ID</th>

                            <th>Client</th>

                            <th>Service</th>

                            <th>Assigned To</th>

                            <th>Billing</th>

                            <th>Fee</th>

                            <th>Status</th>

                            <th>Renewal</th>

                            <th>Active</th>

                            <th width="180">

                                Actions

                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($clientServices as $clientService)

                        <tr>

                            <td>

                                <input
                                    type="checkbox"
                                    name="ids[]"
                                    value="{{ $clientService->id }}"
                                    class="form-check-input row-checkbox">

                            </td>

                            <td>

                                #{{ $clientService->id }}

                            </td>

                            <td>

                                <strong>

                                    {{ optional($clientService->client)->company_name }}

                                </strong>

                                <br>

                                <small class="text-muted">

                                    {{ optional($clientService->client)->client_code }}

                                </small>

                            </td>

                            <td>

                                {{ optional($clientService->service)->name }}

                            </td>

                            <td>

                                {{ optional($clientService->assignedUser)->name ?? '-' }}

                            </td>
                                                        <td>

                                <span class="badge bg-info">

                                    {{ $clientService->billing_cycle }}

                                </span>

                                <br>

                                <small class="text-muted">

                                    Due :
                                    {{ $clientService->due_day ?: '-' }}

                                </small>

                            </td>

                            <td>

                                <strong>

                                    ₹ {{ number_format($clientService->service_fee, 2) }}

                                </strong>

                                @if($clientService->discount > 0)

                                    <br>

                                    <small class="text-danger">

                                        Discount :
                                        ₹ {{ number_format($clientService->discount,2) }}

                                    </small>

                                @endif

                            </td>

                            <td>

                                @php

                                    $statusClass = match($clientService->status) {

                                        'Active' => 'success',

                                        'Pending' => 'warning',

                                        'On Hold' => 'secondary',

                                        'Completed' => 'primary',

                                        'Cancelled' => 'danger',

                                        default => 'dark'

                                    };

                                @endphp

                                <span class="badge bg-{{ $statusClass }}">

                                    {{ $clientService->status }}

                                </span>

                            </td>

                            <td>

                                @if($clientService->renewable)

                                    <span class="badge bg-success">

                                        Yes

                                    </span>

                                    <br>

                                    <small class="text-muted">

                                        {{ optional($clientService->renewal_date)->format('d M Y') }}

                                    </small>

                                @else

                                    <span class="badge bg-secondary">

                                        No

                                    </span>

                                @endif

                            </td>

                            <td>

                                @if($clientService->is_active)

                                    <span class="badge bg-success">

                                        Active

                                    </span>

                                @else

                                    <span class="badge bg-danger">

                                        Inactive

                                    </span>

                                @endif

                            </td>
                                                        <td>

                                <div class="btn-group btn-group-sm">

                                    @can('view', $clientService)

                                        <a
                                            href="{{ route('client-services.show', $clientService) }}"
                                            class="btn btn-info"
                                            title="View">

                                            <i class="mdi mdi-eye"></i>

                                        </a>

                                    @endcan

                                    @can('update', $clientService)

                                        <a
                                            href="{{ route('client-services.edit', $clientService) }}"
                                            class="btn btn-primary"
                                            title="Edit">

                                            <i class="mdi mdi-pencil"></i>

                                        </a>

                                    @endcan

                                    @can('delete', $clientService)

                                        <form
                                            action="{{ route('client-services.destroy', $clientService) }}"
                                            method="POST"
                                            class="d-inline">

                                            @csrf

                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="btn btn-danger"
                                                onclick="return confirm('Delete this client service?')"
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

                                <i class="mdi mdi-briefcase-remove-outline display-5 text-muted"></i>

                                <h5 class="mt-3">

                                    No Client Services Found

                                </h5>

                                <p class="text-muted">

                                    There are no service assignments matching your filters.

                                </p>

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>
                    <div class="card-footer">

            <div class="d-flex justify-content-between align-items-center flex-wrap">

                <div>

                    <small class="text-muted">

                        Showing

                        {{ $clientServices->firstItem() ?? 0 }}

                        to

                        {{ $clientServices->lastItem() ?? 0 }}

                        of

                        {{ $clientServices->total() }}

                        records

                    </small>

                </div>

                <div>

                    {{ $clientServices->withQueryString()->links() }}

                </div>

            </div>

        </div>

    </div>

</div>

@endsection

@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {

    const checkAll = document.getElementById('checkAll');

    if (checkAll) {

        checkAll.addEventListener('change', function () {

            document.querySelectorAll('.row-checkbox').forEach(function (checkbox) {

                checkbox.checked = checkAll.checked;

            });

        });

    }

});

</script>

@endpush