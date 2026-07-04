@extends('layouts.app')

@section('title', 'Client Credentials')

@section('content')

<div class="container-fluid">

    <!-- ===================================================== -->
    <!-- Page Header -->
    <!-- ===================================================== -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">

                Client Credentials

            </h2>

            <p class="text-muted mb-0">

                Manage portal login credentials, API keys, and digital signature information for all clients.

            </p>

        </div>

        <div class="d-flex gap-2">

            @can('create', App\Models\ClientCredential::class)

                <a
                    href="{{ route('client-credentials.create') }}"
                    class="btn btn-primary">

                    <i class="mdi mdi-plus-circle me-1"></i>

                    Add Credential

                </a>

            @endcan

            @can('restore', App\Models\ClientCredential::class)

                <a
                    href="{{ route('client-credentials.trashed') }}"
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
    <!-- Search & Filters -->
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
                action="{{ route('client-credentials.index') }}">

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
                            placeholder="Portal, username, email..."
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

                    <!-- Portal -->

                    <div class="col-lg-3 col-md-6 mb-3">

                        <label class="form-label">

                            Portal

                        </label>

                        <select
                            name="portal"
                            class="form-select">

                            <option value="">

                                All Portals

                            </option>

                            @foreach([
                                'GST',
                                'Income Tax',
                                'MCA',
                                'EPFO',
                                'ESIC',
                                'TRACES',
                                'ICEGATE',
                                'DGFT',
                                'FSSAI',
                                'UDYAM',
                                'GeM',
                                'NSDL',
                                'PAN',
                                'TAN',
                                'Bank',
                                'Other'
                            ] as $portal)

                                <option
                                    value="{{ $portal }}"
                                    @selected(request('portal') == $portal)>

                                    {{ $portal }}

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

                </div>

                <div class="d-flex justify-content-end gap-2">

                    <a
                        href="{{ route('client-credentials.index') }}"
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
    <!-- Credentials Table -->
    <!-- ===================================================== -->

    <div class="card shadow-sm">

        <div class="card-header d-flex justify-content-between align-items-center">

            <h5 class="mb-0">

                <i class="mdi mdi-key-variant me-2"></i>

                Credentials

            </h5>

            <span class="badge bg-primary">

                {{ $credentials->total() }} Records

            </span>

        </div>

        <div class="card-body p-0">

            <form
                method="POST"
                action="{{ route('client-credentials.bulk-delete') }}"
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

                                    Portal

                                </th>

                                <th>

                                    Username

                                </th>

                                <th>

                                    Email

                                </th>

                                <th>

                                    Status

                                </th>

                                <th class="text-center">

                                    Actions

                                </th>

                            </tr>

                        </thead>

                        <tbody>
                                                        @forelse($credentials as $credential)

                                <tr>

                                    <td>

                                        <input
                                            type="checkbox"
                                            class="credential-checkbox"
                                            name="ids[]"
                                            value="{{ $credential->id }}">

                                    </td>

                                    <td>

                                        @if($credential->client)

                                            <a
                                                href="{{ route('clients.show', $credential->client) }}"
                                                class="text-decoration-none fw-semibold">

                                                {{ $credential->client->client_code }}

                                                <br>

                                                <small class="text-muted">

                                                    {{ $credential->client->company_name }}

                                                </small>

                                            </a>

                                        @else

                                            <span class="text-muted">

                                                -

                                            </span>

                                        @endif

                                    </td>

                                    <td>

                                        <div class="fw-semibold">

                                            {{ $credential->portal }}

                                        </div>

                                        @if($credential->portal_name)

                                            <small class="text-muted">

                                                {{ $credential->portal_name }}

                                            </small>

                                        @endif

                                    </td>

                                    <td>

                                        {{ $credential->username }}

                                    </td>

                                    <td>

                                        {{ $credential->registered_email ?: '-' }}

                                    </td>

                                    <td>

                                        @if($credential->is_active)

                                            <span class="badge bg-success">

                                                Active

                                            </span>

                                        @else

                                            <span class="badge bg-danger">

                                                Inactive

                                            </span>

                                        @endif

                                    </td>

                                    <td class="text-center">

                                        <div
                                            class="btn-group"
                                            role="group">
                                                                                        @can('view', $credential)

                                                <a
                                                    href="{{ route('client-credentials.show', $credential) }}"
                                                    class="btn btn-sm btn-primary"
                                                    title="View">

                                                    <i class="mdi mdi-eye"></i>

                                                </a>

                                            @endcan

                                            @can('update', $credential)

                                                <a
                                                    href="{{ route('client-credentials.edit', $credential) }}"
                                                    class="btn btn-sm btn-warning"
                                                    title="Edit">

                                                    <i class="mdi mdi-pencil"></i>

                                                </a>

                                            @endcan

                                            @can('delete', $credential)

                                                <form
                                                    action="{{ route('client-credentials.destroy', $credential) }}"
                                                    method="POST"
                                                    class="d-inline"
                                                    onsubmit="return confirm('Are you sure you want to delete this credential?');">

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
                                        colspan="7"
                                        class="text-center py-5">

                                        <i class="mdi mdi-key-off display-4 text-muted"></i>

                                        <h5 class="mt-3">

                                            No Credentials Found

                                        </h5>

                                        <p class="text-muted">

                                            No client credentials match the current filters.

                                        </p>

                                        @can('create', App\Models\ClientCredential::class)

                                            <a
                                                href="{{ route('client-credentials.create') }}"
                                                class="btn btn-primary">

                                                <i class="mdi mdi-plus-circle me-1"></i>

                                                Add First Credential

                                            </a>

                                        @endcan

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>
                                @can('delete', App\Models\ClientCredential::class)

                    {{-- <div class="card-footer d-flex justify-content-between align-items-center">

                        <div>

                            <button
                                type="submit"
                                class="btn btn-danger"
                                id="bulkDeleteBtn"
                                disabled
                                onclick="return confirm('Delete selected credentials?')">

                                <i class="mdi mdi-delete me-1"></i>

                                Delete Selected

                            </button>

                        </div>

                        <div>

                            {{ $credentials->links() }}

                        </div>

                    </div> --}}

                @else

                    <div class="card-footer">

                        {{ $credentials->links() }}

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

    const checkboxes = document.querySelectorAll('.credential-checkbox');

    const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');

    function updateBulkButton() {

        if (!bulkDeleteBtn) {

            return;

        }

        const checked = document.querySelectorAll(
            '.credential-checkbox:checked'
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