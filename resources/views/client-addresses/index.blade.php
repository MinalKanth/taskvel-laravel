@extends('layouts.app')

@section('title', 'Client Addresses')

@section('content')

<div class="container-fluid">

    <!-- Header -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">
                Client Addresses
            </h2>

            <p class="text-muted mb-0">
                Manage all client addresses from one place.
            </p>

        </div>

        <div>

            <a href="{{ route('client-addresses.create') }}"
               class="btn btn-primary">

                <i class="mdi mdi-plus-circle-outline me-1"></i>

                Add Address

            </a>

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
                                Total Addresses
                            </h6>

                            <h3 class="fw-bold">

                                {{ $addresses->total() }}

                            </h3>

                        </div>

                        <i class="mdi mdi-map-marker-multiple display-5 text-primary"></i>

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

                                {{ $activeAddresses ?? 0 }}

                            </h3>

                        </div>

                        <i class="mdi mdi-check-circle display-5 text-success"></i>

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
                                Default
                            </h6>

                            <h3 class="text-warning fw-bold">

                                {{ $defaultAddresses ?? 0 }}

                            </h3>

                        </div>

                        <i class="mdi mdi-star-circle display-5 text-warning"></i>

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

                                {{ $inactiveAddresses ?? 0 }}

                            </h3>

                        </div>

                        <i class="mdi mdi-close-circle display-5 text-danger"></i>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- Search -->

    <div class="card shadow-sm mb-4">

        <div class="card-header">

            <h5 class="mb-0">

                Search Addresses

            </h5>

        </div>

        <div class="card-body">

            <form method="GET"
                  action="{{ route('client-addresses.index') }}">

                <div class="row">

                    <div class="col-md-4">

                        <input
                            type="text"
                            name="search"
                            class="form-control"
                            placeholder="Search client, city, state..."
                            value="{{ request('search') }}">

                    </div>

                    <div class="col-md-3">

                        <select
                            name="address_type"
                            class="form-select">

                            <option value="">
                                All Types
                            </option>

                            <option value="Registered Office" @selected(request('address_type')=='Registered Office')>Registered Office</option>
                            <option value="Corporate Office" @selected(request('address_type')=='Corporate Office')>Corporate Office</option>
                            <option value="Branch Office" @selected(request('address_type')=='Branch Office')>Branch Office</option>
                            <option value="Factory" @selected(request('address_type')=='Factory')>Factory</option>
                            <option value="Warehouse" @selected(request('address_type')=='Warehouse')>Warehouse</option>
                            <option value="Billing" @selected(request('address_type')=='Billing')>Billing</option>
                            <option value="Shipping" @selected(request('address_type')=='Shipping')>Shipping</option>
                            <option value="Other" @selected(request('address_type')=='Other')>Other</option>

                        </select>

                    </div>

                    <div class="col-md-2">

                        <button class="btn btn-primary w-100">

                            <i class="mdi mdi-magnify"></i>

                            Search

                        </button>

                    </div>

                    <div class="col-md-2">

                        <a href="{{ route('client-addresses.index') }}"
                           class="btn btn-secondary w-100">

                            Reset

                        </a>

                    </div>

                </div>

            </form>

        </div>

    </div>
        <!-- ===================================================== -->
    <!-- Bulk Actions -->
    <!-- ===================================================== -->

    <div class="card shadow-sm mb-4">

        <div class="card-body">

            <form
                id="bulk-action-form"
                method="POST"
                action="{{ route('client-addresses.bulk-action') }}">

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

                            <option value="default">
                                Mark as Default
                            </option>

                            <option value="delete">
                                Delete
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

                        <a
                            href="{{ route('client-addresses.export') }}"
                            class="btn btn-success">

                            <i class="mdi mdi-file-excel"></i>

                            Export

                        </a>

                    </div>

                </div>

            </form>

        </div>

    </div>

    <!-- ===================================================== -->
    <!-- Address Table -->
    <!-- ===================================================== -->

    <div class="card shadow-sm">

        <div class="card-header d-flex justify-content-between align-items-center">

            <h5 class="mb-0">

                Address List

            </h5>

            <span class="badge bg-primary">

                {{ $addresses->total() }}

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
                                Address Type
                            </th>

                            <th>
                                City
                            </th>

                            <th>
                                State
                            </th>

                            <th>
                                Country
                            </th>

                            <th>
                                Default
                            </th>

                            <th>
                                Status
                            </th>

                            <th width="170">
                                Actions
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($addresses as $address)

                            <tr>

                                <td>

                                    <input
                                        type="checkbox"
                                        class="record-checkbox"
                                        form="bulk-action-form"
                                        name="ids[]"
                                        value="{{ $address->id }}">

                                </td>

                                <td>

                                    <strong>

                                        {{ optional($address->client)->company_name }}

                                    </strong>

                                    <br>

                                    <small class="text-muted">

                                        {{ optional($address->client)->client_code }}

                                    </small>

                                </td>

                                <td>

                                    <span class="badge bg-info">

                                        {{ $address->address_type }}

                                    </span>

                                </td>

                                <td>

                                    {{ $address->city ?: '-' }}

                                </td>

                                <td>

                                    {{ $address->state ?: '-' }}

                                </td>

                                <td>

                                    {{ $address->country ?: '-' }}

                                </td>

                                <td>

                                    @if($address->is_default)

                                        <span class="badge bg-warning">

                                            <i class="mdi mdi-star"></i>

                                            Default

                                        </span>

                                    @else

                                        -

                                    @endif

                                </td>

                                <td>

                                    @if($address->is_active)

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

                                    <div class="btn-group">

                                        <a
                                            href="{{ route('client-addresses.show',$address) }}"
                                            class="btn btn-sm btn-info">

                                            <i class="mdi mdi-eye"></i>

                                        </a>

                                        <a
                                            href="{{ route('client-addresses.edit',$address) }}"
                                            class="btn btn-sm btn-warning">

                                            <i class="mdi mdi-pencil"></i>

                                        </a>

                                        <form
                                            action="{{ route('client-addresses.destroy',$address) }}"
                                            method="POST"
                                            class="d-inline">

                                            @csrf

                                            @method('DELETE')

                                            <button
                                                class="btn btn-sm btn-danger"
                                                onclick="return confirm('Delete this address?')">

                                                <i class="mdi mdi-delete"></i>

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="9"
                                    class="text-center py-5">

                                    <i class="mdi mdi-map-marker-off display-4 text-muted"></i>

                                    <h5 class="mt-3">

                                        No Addresses Found

                                    </h5>

                                    <p class="text-muted">

                                        No client addresses available.

                                    </p>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>
                @if($addresses->hasPages())

            <div class="card-footer">

                {{ $addresses->withQueryString()->links() }}

            </div>

        @endif

    </div>

</div>

@endsection

@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {

    // Select All

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

                selectAll.checked = total === checked;

            }

        });

    });

    // Bulk Action Validation

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

                alert('Please select at least one address.');

                return;

            }

            if (action === 'delete') {

                if (!confirm('Are you sure you want to delete the selected addresses?')) {

                    e.preventDefault();

                    return;

                }

            }

        });

    }

});

</script>

@endpush