@extends('layouts.app')

@section('title', 'Client Details')

@section('content')

<div class="container-fluid">

    <!-- ===================================================== -->
    <!-- Page Header -->
    <!-- ===================================================== -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">

                {{ $client->company_name }}

            </h2>

            <p class="text-muted mb-0">

                Client Code :
                <strong>{{ $client->client_code }}</strong>

            </p>

        </div>

        <div>

            @can('update', $client)

                <a
                    href="{{ route('clients.edit', $client) }}"
                    class="btn btn-warning">

                    <i class="mdi mdi-pencil"></i>

                    Edit

                </a>

            @endcan

            @can('delete', $client)

                <button
                    class="btn btn-danger"
                    onclick="deleteClient()">

                    <i class="mdi mdi-delete"></i>

                    Delete

                </button>

            @endcan

            <a
                href="{{ route('clients.index') }}"
                class="btn btn-secondary">

                <i class="mdi mdi-arrow-left"></i>

                Back

            </a>

        </div>

    </div>

    <!-- ===================================================== -->
    <!-- Summary Cards -->
    <!-- ===================================================== -->

    <div class="row mb-4">

        <div class="col-lg-3">

            <div class="card border-start border-success border-4 shadow-sm">

                <div class="card-body">

                    <h6 class="text-muted">

                        Status

                    </h6>

                    <h5>

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

                            @default

                                <span class="badge bg-dark">

                                    {{ $client->status }}

                                </span>

                        @endswitch

                    </h5>

                </div>

            </div>

        </div>

        <div class="col-lg-3">

            <div class="card border-start border-primary border-4 shadow-sm">

                <div class="card-body">

                    <h6 class="text-muted">

                        Priority

                    </h6>

                    <h5>

                        {{ $client->priority }}

                    </h5>

                </div>

            </div>

        </div>

        <div class="col-lg-3">

            <div class="card border-start border-warning border-4 shadow-sm">

                <div class="card-body">

                    <h6 class="text-muted">

                        Assigned To

                    </h6>

                    <h5>

                        {{ optional($client->assignedUser)->name ?? '-' }}

                    </h5>

                </div>

            </div>

        </div>

        <div class="col-lg-3">

            <div class="card border-start border-info border-4 shadow-sm">

                <div class="card-body">

                    <h6 class="text-muted">

                        Created On

                    </h6>

                    <h6>

                        {{ $client->created_at->format('d M Y') }}

                    </h6>

                </div>

            </div>

        </div>

    </div>

    <!-- ===================================================== -->
    <!-- Main Content -->
    <!-- ===================================================== -->

    <div class="row">

        <div class="col-lg-8">
                        <!-- ===================================================== -->
            <!-- Client Information -->
            <!-- ===================================================== -->

            <div class="card shadow-sm mb-4">

                <div class="card-header">

                    <h5 class="mb-0">

                        <i class="mdi mdi-domain me-2"></i>

                        Client Information

                    </h5>

                </div>

                <div class="card-body">

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label class="fw-semibold text-muted">

                                Client Code

                            </label>

                            <div>

                                {{ $client->client_code }}

                            </div>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="fw-semibold text-muted">

                                Company Name

                            </label>

                            <div>

                                {{ $client->company_name }}

                            </div>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="fw-semibold text-muted">

                                Legal Name

                            </label>

                            <div>

                                {{ $client->legal_name ?: '-' }}

                            </div>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="fw-semibold text-muted">

                                Business Type

                            </label>

                            <div>

                                {{ $client->business_type ?: '-' }}

                            </div>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="fw-semibold text-muted">

                                Constitution

                            </label>

                            <div>

                                {{ $client->constitution ?: '-' }}

                            </div>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="fw-semibold text-muted">

                                Incorporation Date

                            </label>

                            <div>

                                {{ optional($client->incorporation_date)?->format('d M Y') ?: '-' }}

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <!-- ===================================================== -->
            <!-- Registration Details -->
            <!-- ===================================================== -->

            <div class="card shadow-sm mb-4">

                <div class="card-header">

                    <h5 class="mb-0">

                        <i class="mdi mdi-file-document-outline me-2"></i>

                        Registration & Tax Details

                    </h5>

                </div>

                <div class="card-body">

                    <div class="row">

                        <div class="col-md-4 mb-3">

                            <label class="fw-semibold text-muted">

                                GSTIN

                            </label>

                            <div>

                                {{ $client->gstin ?: '-' }}

                            </div>

                        </div>

                        <div class="col-md-4 mb-3">

                            <label class="fw-semibold text-muted">

                                PAN

                            </label>

                            <div>

                                {{ $client->pan ?: '-' }}

                            </div>

                        </div>

                        <div class="col-md-4 mb-3">

                            <label class="fw-semibold text-muted">

                                TAN

                            </label>

                            <div>

                                {{ $client->tan ?: '-' }}

                            </div>

                        </div>

                        <div class="col-md-4 mb-3">

                            <label class="fw-semibold text-muted">

                                CIN

                            </label>

                            <div>

                                {{ $client->cin ?: '-' }}

                            </div>

                        </div>

                        <div class="col-md-4 mb-3">

                            <label class="fw-semibold text-muted">

                                UDYAM Number

                            </label>

                            <div>

                                {{ $client->udyam_number ?: '-' }}

                            </div>

                        </div>

                        <div class="col-md-4 mb-3">

                            <label class="fw-semibold text-muted">

                                ESIC Code

                            </label>

                            <div>

                                {{ $client->esic_code ?: '-' }}

                            </div>

                        </div>

                        <div class="col-md-4 mb-3">

                            <label class="fw-semibold text-muted">

                                EPF Code

                            </label>

                            <div>

                                {{ $client->epf_code ?: '-' }}

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <!-- ===================================================== -->
            <!-- Contact Information -->
            <!-- ===================================================== -->

            <div class="card shadow-sm mb-4">

                <div class="card-header">

                    <h5 class="mb-0">

                        <i class="mdi mdi-phone-outline me-2"></i>

                        Contact Information

                    </h5>

                </div>

                <div class="card-body">

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label class="fw-semibold text-muted">

                                Email

                            </label>

                            <div>

                                @if($client->email)

                                    <a href="mailto:{{ $client->email }}">

                                        {{ $client->email }}

                                    </a>

                                @else

                                    -

                                @endif

                            </div>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="fw-semibold text-muted">

                                Website

                            </label>

                            <div>

                                @if($client->website)

                                    <a
                                        href="{{ $client->website }}"
                                        target="_blank">

                                        {{ $client->website }}

                                    </a>

                                @else

                                    -

                                @endif

                            </div>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="fw-semibold text-muted">

                                Phone

                            </label>

                            <div>

                                {{ $client->phone ?: '-' }}

                            </div>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="fw-semibold text-muted">

                                Alternate Phone

                            </label>

                            <div>

                                {{ $client->alternate_phone ?: '-' }}

                            </div>

                        </div>

                    </div>

                </div>

            </div>
                        <!-- ===================================================== -->
            <!-- Financial Information -->
            <!-- ===================================================== -->

            <div class="card shadow-sm mb-4">

                <div class="card-header">

                    <h5 class="mb-0">

                        <i class="mdi mdi-cash-multiple me-2"></i>

                        Financial Information

                    </h5>

                </div>

                <div class="card-body">

                    <div class="row">

                        <div class="col-md-4 mb-3">

                            <label class="fw-semibold text-muted">

                                Opening Balance

                            </label>

                            <div>

                                ₹ {{ number_format($client->opening_balance ?? 0, 2) }}

                            </div>

                        </div>

                        <div class="col-md-4 mb-3">

                            <label class="fw-semibold text-muted">

                                Credit Limit

                            </label>

                            <div>

                                ₹ {{ number_format($client->credit_limit ?? 0, 2) }}

                            </div>

                        </div>

                        <div class="col-md-4 mb-3">

                            <label class="fw-semibold text-muted">

                                Payment Terms

                            </label>

                            <div>

                                {{ $client->payment_terms ?? 0 }} Days

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <!-- ===================================================== -->
            <!-- Notes -->
            <!-- ===================================================== -->

            <div class="card shadow-sm mb-4">

                <div class="card-header">

                    <h5 class="mb-0">

                        <i class="mdi mdi-note-text-outline me-2"></i>

                        Notes

                    </h5>

                </div>

                <div class="card-body">

                    @if($client->notes)

                        {!! nl2br(e($client->notes)) !!}

                    @else

                        <p class="text-muted mb-0">

                            No notes available.

                        </p>

                    @endif

                </div>

            </div>

            <!-- ===================================================== -->
            <!-- Client Contacts -->
            <!-- ===================================================== -->

            @include('clients.partials._contacts')

            <!-- ===================================================== -->
            <!-- Client Addresses -->
            <!-- ===================================================== -->

            @include('clients.partials._addresses')

            <!-- ===================================================== -->
            <!-- Client Services -->
            <!-- ===================================================== -->

            @include('clients.partials._services')

            <!-- ===================================================== -->
            <!-- Client Documents -->
            <!-- ===================================================== -->

            @include('clients.partials._documents')

        </div>

        <!-- ===================================================== -->
        <!-- Right Sidebar -->
        <!-- ===================================================== -->

        <div class="col-lg-4">
                        <!-- ===================================================== -->
            <!-- Quick Information -->
            <!-- ===================================================== -->

            <div class="card shadow-sm mb-4">

                <div class="card-header">

                    <h5 class="mb-0">

                        <i class="mdi mdi-information-outline me-2"></i>

                        Quick Information

                    </h5>

                </div>

                <div class="card-body">

                    <table class="table table-borderless mb-0">

                        <tr>

                            <th width="45%">

                                Status

                            </th>

                            <td>

                                {{ $client->status }}

                            </td>

                        </tr>

                        <tr>

                            <th>

                                Priority

                            </th>

                            <td>

                                {{ $client->priority }}

                            </td>

                        </tr>

                        <tr>

                            <th>

                                Active

                            </th>

                            <td>

                                @if($client->is_active)

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

                                Assigned To

                            </th>

                            <td>

                                {{ optional($client->assignedUser)->name ?? '-' }}

                            </td>

                        </tr>

                        <tr>

                            <th>

                                Created By

                            </th>

                            <td>

                                {{ optional($client->creator)->name ?? '-' }}

                            </td>

                        </tr>

                        <tr>

                            <th>

                                Updated By

                            </th>

                            <td>

                                {{ optional($client->updater)->name ?? '-' }}

                            </td>

                        </tr>

                        <tr>

                            <th>

                                Created At

                            </th>

                            <td>

                                {{ $client->created_at?->format('d M Y h:i A') }}

                            </td>

                        </tr>

                        <tr>

                            <th>

                                Last Updated

                            </th>

                            <td>

                                {{ $client->updated_at?->format('d M Y h:i A') }}

                            </td>

                        </tr>

                    </table>

                </div>

            </div>

            <!-- ===================================================== -->
            <!-- Statistics -->
            <!-- ===================================================== -->

            <div class="card shadow-sm mb-4">

                <div class="card-header">

                    <h5 class="mb-0">

                        <i class="mdi mdi-chart-box-outline me-2"></i>

                        Statistics

                    </h5>

                </div>

                <div class="card-body">

                    <div class="row text-center">

                        <div class="col-6 mb-3">

                            <h3 class="fw-bold text-primary">

                                {{ $client->contacts->count() }}

                            </h3>

                            <small class="text-muted">

                                Contacts

                            </small>

                        </div>

                        <div class="col-6 mb-3">

                            <h3 class="fw-bold text-success">

                                {{ $client->addresses->count() }}

                            </h3>

                            <small class="text-muted">

                                Addresses

                            </small>

                        </div>

                        <div class="col-6">

                            <h3 class="fw-bold text-warning">

                                {{ $client->services->count() }}

                            </h3>

                            <small class="text-muted">

                                Services

                            </small>

                        </div>

                        <div class="col-6">

                            <h3 class="fw-bold text-info">

                                {{ $client->documents->count() }}

                            </h3>

                            <small class="text-muted">

                                Documents

                            </small>

                        </div>

                    </div>

                </div>

            </div>

            <!-- ===================================================== -->
            <!-- Tags -->
            <!-- ===================================================== -->

            <div class="card shadow-sm mb-4">

                <div class="card-header">

                    <h5 class="mb-0">

                        <i class="mdi mdi-tag-multiple-outline me-2"></i>

                        Client Tags

                    </h5>

                </div>

                <div class="card-body">

                    @forelse($client->tags as $tag)

                        <span
                            class="badge me-1 mb-1"
                            style="background-color: {{ $tag->color }};">

                            {{ $tag->name }}

                        </span>

                    @empty

                        <span class="text-muted">

                            No tags assigned.

                        </span>

                    @endforelse

                </div>

            </div>

            <!-- ===================================================== -->
            <!-- Credentials -->
            <!-- ===================================================== -->

            @include('clients.partials._credentials')

            <!-- ===================================================== -->
            <!-- Remarks -->
            <!-- ===================================================== -->

            @include('clients.partials._remarks')
                        <!-- ===================================================== -->
            <!-- Communications -->
            <!-- ===================================================== -->

            @include('clients.partials._communications')

            <!-- ===================================================== -->
            <!-- Timeline -->
            <!-- ===================================================== -->

            @include('clients.partials._timeline')

        </div>

    </div>

    @can('delete', $client)

        <form
            id="delete-client-form"
            action="{{ route('clients.destroy', $client) }}"
            method="POST"
            class="d-none">

            @csrf

            @method('DELETE')

        </form>

    @endcan

</div>

@endsection

@push('scripts')

<script>

function deleteClient()
{
    if (confirm('Are you sure you want to delete this client?'))
    {
        document
            .getElementById('delete-client-form')
            .submit();
    }
}

</script>

@endpush