@extends('layouts.app')

@section('title', 'Address Details')

@section('content')

<div class="container-fluid">

    <!-- ===================================================== -->
    <!-- Header -->
    <!-- ===================================================== -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">

                Address Details

            </h2>

            <p class="text-muted mb-0">

                View complete client address information.

            </p>

        </div>

        <div>

            @can('update', $clientAddress)

                <a
                    href="{{ route('client-addresses.edit', $clientAddress) }}"
                    class="btn btn-warning">

                    <i class="mdi mdi-pencil me-1"></i>

                    Edit Address

                </a>

            @endcan

            <a
                href="{{ route('client-addresses.index') }}"
                class="btn btn-secondary ms-2">

                <i class="mdi mdi-arrow-left me-1"></i>

                Back

            </a>

        </div>

    </div>

    <!-- ===================================================== -->
    <!-- Address Summary -->
    <!-- ===================================================== -->

    <div class="card shadow-sm border-0 mb-4">

        <div class="card-header bg-primary text-white">

            <h5 class="mb-0">

                <i class="mdi mdi-map-marker me-2"></i>

                Address Summary

            </h5>

        </div>

        <div class="card-body">

            <div class="row align-items-center">

                <div class="col-md-8">

                    <h3 class="fw-bold mb-2">

                        {{ $clientAddress->client->company_name ?? '-' }}

                    </h3>

                    <p class="text-muted mb-0">

                        Client Code :
                        <strong>

                            {{ $clientAddress->client->client_code ?? '-' }}

                        </strong>

                    </p>

                </div>

                <div class="col-md-4 text-md-end">

                    @php
                        $badge = [
                            'Registered Office' => 'primary',
                            'Corporate Office'  => 'success',
                            'Branch Office'     => 'warning',
                            'Factory'           => 'danger',
                            'Warehouse'         => 'info',
                            'Billing'           => 'dark',
                            'Shipping'          => 'secondary',
                            'Other'             => 'light'
                        ];
                    @endphp

                    <span class="badge bg-{{ $badge[$clientAddress->address_type] ?? 'secondary' }} fs-6 px-3 py-2">

                        {{ $clientAddress->address_type }}

                    </span>

                    <div class="mt-3">

                        @if($clientAddress->is_default)

                            <span class="badge bg-success">

                                <i class="mdi mdi-check-circle"></i>

                                Default Address

                            </span>

                        @endif

                        @if($clientAddress->is_active)

                            <span class="badge bg-primary">

                                Active

                            </span>

                        @else

                            <span class="badge bg-danger">

                                Inactive

                            </span>

                        @endif

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- ===================================================== -->
    <!-- Address Information -->
    <!-- ===================================================== -->

    <div class="card shadow-sm mb-4">

        <div class="card-header">

            <h5 class="mb-0">

                <i class="mdi mdi-home-city-outline me-2"></i>

                Complete Address

            </h5>

        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-6 mb-4">

                    <label class="text-muted small">

                        Address Line 1

                    </label>

                    <h6 class="fw-semibold">

                        {{ $clientAddress->address_line_1 ?: '-' }}

                    </h6>

                </div>

                <div class="col-md-6 mb-4">

                    <label class="text-muted small">

                        Address Line 2

                    </label>

                    <h6 class="fw-semibold">

                        {{ $clientAddress->address_line_2 ?: '-' }}

                    </h6>

                </div>

                <div class="col-md-12">

                    <label class="text-muted small">

                        Landmark

                    </label>

                    <h6 class="fw-semibold">

                        {{ $clientAddress->landmark ?: '-' }}

                    </h6>

                </div>

            </div>

        </div>

    </div>
        <!-- ===================================================== -->
    <!-- Location Information -->
    <!-- ===================================================== -->

    <div class="card shadow-sm mb-4">

        <div class="card-header">

            <h5 class="mb-0">

                <i class="mdi mdi-earth me-2"></i>

                Location Information

            </h5>

        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-4 mb-4">

                    <label class="text-muted small">

                        City

                    </label>

                    <h6 class="fw-semibold">

                        {{ $clientAddress->city ?: '-' }}

                    </h6>

                </div>

                <div class="col-md-4 mb-4">

                    <label class="text-muted small">

                        District

                    </label>

                    <h6 class="fw-semibold">

                        {{ $clientAddress->district ?: '-' }}

                    </h6>

                </div>

                <div class="col-md-4 mb-4">

                    <label class="text-muted small">

                        State

                    </label>

                    <h6 class="fw-semibold">

                        {{ $clientAddress->state ?: '-' }}

                    </h6>

                </div>

                <div class="col-md-6 mb-4">

                    <label class="text-muted small">

                        Country

                    </label>

                    <h6 class="fw-semibold">

                        {{ $clientAddress->country ?: '-' }}

                    </h6>

                </div>

                <div class="col-md-6 mb-4">

                    <label class="text-muted small">

                        Postal Code

                    </label>

                    <h6 class="fw-semibold">

                        {{ $clientAddress->postal_code ?: '-' }}

                    </h6>

                </div>

            </div>

        </div>

    </div>

    <!-- ===================================================== -->
    <!-- Geo Location -->
    <!-- ===================================================== -->

    <div class="card shadow-sm mb-4">

        <div class="card-header">

            <h5 class="mb-0">

                <i class="mdi mdi-crosshairs-gps me-2"></i>

                Geo Coordinates

            </h5>

        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-6 mb-4">

                    <label class="text-muted small">

                        Latitude

                    </label>

                    <h6 class="fw-semibold">

                        {{ $clientAddress->latitude ?: '-' }}

                    </h6>

                </div>

                <div class="col-md-6 mb-4">

                    <label class="text-muted small">

                        Longitude

                    </label>

                    <h6 class="fw-semibold">

                        {{ $clientAddress->longitude ?: '-' }}

                    </h6>

                </div>

            </div>

            @if($clientAddress->latitude && $clientAddress->longitude)

                <hr>

                <a
                    href="https://maps.google.com/?q={{ $clientAddress->latitude }},{{ $clientAddress->longitude }}"
                    target="_blank"
                    class="btn btn-outline-primary">

                    <i class="mdi mdi-google-maps me-1"></i>

                    View on Google Maps

                </a>

            @endif

        </div>

    </div>
        <!-- ===================================================== -->
    <!-- Address Settings -->
    <!-- ===================================================== -->

    <div class="card shadow-sm mb-4">

        <div class="card-header">

            <h5 class="mb-0">

                <i class="mdi mdi-cog-outline me-2"></i>

                Address Settings

            </h5>

        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-4 mb-3">

                    <label class="text-muted small">

                        Default Address

                    </label>

                    <h6>

                        @if($clientAddress->is_default)

                            <span class="badge bg-success">

                                <i class="mdi mdi-check-circle me-1"></i>

                                Yes

                            </span>

                        @else

                            <span class="badge bg-secondary">

                                No

                            </span>

                        @endif

                    </h6>

                </div>

                <div class="col-md-4 mb-3">

                    <label class="text-muted small">

                        Status

                    </label>

                    <h6>

                        @if($clientAddress->is_active)

                            <span class="badge bg-success">

                                Active

                            </span>

                        @else

                            <span class="badge bg-danger">

                                Inactive

                            </span>

                        @endif

                    </h6>

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

            @if($clientAddress->remarks)

                <p class="mb-0">

                    {!! nl2br(e($clientAddress->remarks)) !!}

                </p>

            @else

                <span class="text-muted">

                    No remarks available.

                </span>

            @endif

        </div>

    </div>

    <!-- ===================================================== -->
    <!-- Audit Information -->
    <!-- ===================================================== -->

    <div class="card shadow-sm mb-4">

        <div class="card-header">

            <h5 class="mb-0">

                <i class="mdi mdi-history me-2"></i>

                Audit Information

            </h5>

        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-6 mb-3">

                    <label class="text-muted small">

                        Created At

                    </label>

                    <h6>

                        {{ optional($clientAddress->created_at)->format('d M Y, h:i A') ?? '-' }}

                    </h6>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="text-muted small">

                        Last Updated

                    </label>

                    <h6>

                        {{ optional($clientAddress->updated_at)->format('d M Y, h:i A') ?? '-' }}

                    </h6>

                </div>

            </div>

        </div>

    </div>

    <!-- ===================================================== -->
    <!-- Actions -->
    <!-- ===================================================== -->

    <div class="card shadow-sm">

        <div class="card-body">

            <div class="d-flex justify-content-between">

                <a
                    href="{{ route('client-addresses.index') }}"
                    class="btn btn-secondary">

                    <i class="mdi mdi-arrow-left me-1"></i>

                    Back to Addresses

                </a>

                @can('update', $clientAddress)

                    <a
                        href="{{ route('client-addresses.edit', $clientAddress) }}"
                        class="btn btn-primary">

                        <i class="mdi mdi-pencil me-1"></i>

                        Edit Address

                    </a>

                @endcan

            </div>

        </div>

    </div>

</div>

@endsection