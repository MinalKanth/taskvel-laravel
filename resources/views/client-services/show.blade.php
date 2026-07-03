@extends('layouts.app')

@section('title', 'Client Service Details')

@section('content')

<div class="container-fluid">

    <!-- ===================================================== -->
    <!-- Header -->
    <!-- ===================================================== -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">

                Client Service Details

            </h2>

            <p class="text-muted mb-0">

                View complete information about the assigned service.

            </p>

        </div>

        <div>

            @can('update', $clientService)

                <a
                    href="{{ route('client-services.edit', $clientService) }}"
                    class="btn btn-primary">

                    <i class="mdi mdi-pencil me-1"></i>

                    Edit

                </a>

            @endcan

            <a
                href="{{ route('client-services.index') }}"
                class="btn btn-secondary ms-2">

                <i class="mdi mdi-arrow-left me-1"></i>

                Back

            </a>

        </div>

    </div>

    <!-- ===================================================== -->
    <!-- Overview -->
    <!-- ===================================================== -->

    <div class="card shadow-sm mb-4">

        <div class="card-header">

            <h5 class="mb-0">

                <i class="mdi mdi-briefcase-check-outline me-2"></i>

                Service Overview

            </h5>

        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-3 mb-4">

                    <small class="text-muted d-block">

                        Client

                    </small>

                    <h6 class="fw-bold mb-0">

                        {{ optional($clientService->client)->company_name }}

                    </h6>

                </div>

                <div class="col-md-3 mb-4">

                    <small class="text-muted d-block">

                        Service

                    </small>

                    <h6 class="fw-bold mb-0">

                        {{ optional($clientService->service)->service_name }}

                    </h6>

                </div>

                <div class="col-md-3 mb-4">

                    <small class="text-muted d-block">

                        Assigned To

                    </small>

                    <h6 class="fw-bold mb-0">

                        {{ optional($clientService->assignedUser)->name ?? '-' }}

                    </h6>

                </div>

                <div class="col-md-3 mb-4">

                    <small class="text-muted d-block">

                        Status

                    </small>

                    @php
                        $badge = match($clientService->status){
                            'Active' => 'success',
                            'Pending' => 'warning',
                            'Completed' => 'primary',
                            'Cancelled' => 'danger',
                            'On Hold' => 'secondary',
                            default => 'dark'
                        };
                    @endphp

                    <span class="badge bg-{{ $badge }} fs-6">

                        {{ $clientService->status }}

                    </span>

                </div>

            </div>

        </div>

    </div>
    <!-- ===================================================== -->
<!-- Service Timeline -->
<!-- ===================================================== -->

<div class="card shadow-sm mb-4">

    <div class="card-header">

        <h5 class="mb-0">

            <i class="mdi mdi-calendar-range me-2"></i>

            Service Timeline

        </h5>

    </div>

    <div class="card-body">

        <div class="row">

            <div class="col-md-3 mb-4">

                <small class="text-muted d-block">

                    Start Date

                </small>

                <h6 class="fw-bold">

                    {{ optional($clientService->start_date)->format('d M Y') ?? '-' }}

                </h6>

            </div>

            <div class="col-md-3 mb-4">

                <small class="text-muted d-block">

                    End Date

                </small>

                <h6 class="fw-bold">

                    {{ optional($clientService->end_date)->format('d M Y') ?? '-' }}

                </h6>

            </div>

            <div class="col-md-3 mb-4">

                <small class="text-muted d-block">

                    Renewal Date

                </small>

                <h6 class="fw-bold">

                    {{ optional($clientService->renewal_date)->format('d M Y') ?? '-' }}

                </h6>

            </div>

            <div class="col-md-3 mb-4">

                <small class="text-muted d-block">

                    Renewable

                </small>

                @if($clientService->renewable)

                    <span class="badge bg-success">

                        Yes

                    </span>

                @else

                    <span class="badge bg-secondary">

                        No

                    </span>

                @endif

            </div>

        </div>

    </div>

</div>
<!-- ===================================================== -->
<!-- Billing Information -->
<!-- ===================================================== -->

<div class="card shadow-sm mb-4">

    <div class="card-header">

        <h5 class="mb-0">

            <i class="mdi mdi-cash-multiple me-2"></i>

            Billing Information

        </h5>

    </div>

    <div class="card-body">

        <div class="row">

            <div class="col-md-3 mb-4">

                <small class="text-muted d-block">

                    Service Fee

                </small>

                <h5 class="fw-bold text-success">

                    ₹ {{ number_format($clientService->service_fee ?? 0, 2) }}

                </h5>

            </div>

            <div class="col-md-3 mb-4">

                <small class="text-muted d-block">

                    Discount

                </small>

                <h5 class="fw-bold text-danger">

                    ₹ {{ number_format($clientService->discount ?? 0, 2) }}

                </h5>

            </div>

            <div class="col-md-3 mb-4">

                <small class="text-muted d-block">

                    Tax Percentage

                </small>

                <h5 class="fw-bold">

                    {{ $clientService->tax_percentage ?? 0 }}%

                </h5>

            </div>

            <div class="col-md-3 mb-4">

                <small class="text-muted d-block">

                    Billing Cycle

                </small>

                <span class="badge bg-primary fs-6">

                    {{ $clientService->billing_cycle ?? '-' }}

                </span>

            </div>

            <div class="col-md-3 mb-4">

                <small class="text-muted d-block">

                    Due Day

                </small>

                <h6 class="fw-bold">

                    {{ $clientService->due_day ?: '-' }}

                </h6>

            </div>

            @php
                $subtotal = ($clientService->service_fee ?? 0) - ($clientService->discount ?? 0);
                $tax = $subtotal * (($clientService->tax_percentage ?? 0) / 100);
                $grandTotal = $subtotal + $tax;
            @endphp

            <div class="col-md-3 mb-4">

                <small class="text-muted d-block">

                    Sub Total

                </small>

                <h5 class="fw-bold">

                    ₹ {{ number_format($subtotal,2) }}

                </h5>

            </div>

            <div class="col-md-3 mb-4">

                <small class="text-muted d-block">

                    Tax Amount

                </small>

                <h5 class="fw-bold text-warning">

                    ₹ {{ number_format($tax,2) }}

                </h5>

            </div>

            <div class="col-md-3 mb-4">

                <small class="text-muted d-block">

                    Grand Total

                </small>

                <h4 class="fw-bold text-primary">

                    ₹ {{ number_format($grandTotal,2) }}

                </h4>

            </div>

        </div>

    </div>

</div>
<!-- ===================================================== -->
<!-- Service Configuration -->
<!-- ===================================================== -->

<div class="card shadow-sm mb-4">

    <div class="card-header">

        <h5 class="mb-0">

            <i class="mdi mdi-cog-outline me-2"></i>

            Service Configuration

        </h5>

    </div>

    <div class="card-body">

        <div class="row">

            <div class="col-md-4 mb-4">

                <small class="text-muted d-block">

                    Auto Generate Tasks

                </small>

                @if($clientService->auto_generate_tasks)

                    <span class="badge bg-success">

                        Enabled

                    </span>

                @else

                    <span class="badge bg-secondary">

                        Disabled

                    </span>

                @endif

            </div>

            <div class="col-md-4 mb-4">

                <small class="text-muted d-block">

                    Renewable

                </small>

                @if($clientService->renewable)

                    <span class="badge bg-success">

                        Yes

                    </span>

                @else

                    <span class="badge bg-danger">

                        No

                    </span>

                @endif

            </div>

            <div class="col-md-4 mb-4">

                <small class="text-muted d-block">

                    Active Status

                </small>

                @if($clientService->is_active)

                    <span class="badge bg-success">

                        Active

                    </span>

                @else

                    <span class="badge bg-danger">

                        Inactive

                    </span>

                @endif

            </div>

            <div class="col-md-3 mb-4">

                <small class="text-muted d-block">

                    Created On

                </small>

                <h6 class="fw-bold">

                    {{ optional($clientService->created_at)->format('d M Y') }}

                </h6>

            </div>

            <div class="col-md-3 mb-4">

                <small class="text-muted d-block">

                    Last Updated

                </small>

                <h6 class="fw-bold">

                    {{ optional($clientService->updated_at)->format('d M Y h:i A') }}

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

        @if(!empty($clientService->remarks))

            <div class="border rounded p-3 bg-light">

                {!! nl2br(e($clientService->remarks)) !!}

            </div>

        @else

            <div class="text-center py-4">

                <i class="mdi mdi-note-remove-outline display-5 text-muted"></i>

                <p class="text-muted mt-3 mb-0">

                    No remarks have been added for this service.

                </p>

            </div>

        @endif

    </div>

</div>

<!-- ===================================================== -->
<!-- Quick Summary -->
<!-- ===================================================== -->

<div class="card shadow-sm mb-4">

    <div class="card-header">

        <h5 class="mb-0">

            <i class="mdi mdi-information-outline me-2"></i>

            Quick Summary

        </h5>

    </div>

    <div class="card-body">

        <div class="row text-center">

            <div class="col-md-3">

                <h3 class="fw-bold text-primary">

                    ₹ {{ number_format($clientService->service_fee ?? 0,2) }}

                </h3>

                <small class="text-muted">

                    Service Fee

                </small>

            </div>

            <div class="col-md-3">

                <h3 class="fw-bold text-success">

                    {{ $clientService->billing_cycle }}

                </h3>

                <small class="text-muted">

                    Billing Cycle

                </small>

            </div>

            <div class="col-md-3">

                <h3 class="fw-bold text-warning">

                    {{ optional($clientService->renewal_date)->format('d M Y') ?? '-' }}

                </h3>

                <small class="text-muted">

                    Renewal Date

                </small>

            </div>

            <div class="col-md-3">

                @if($clientService->is_active)

                    <h3 class="fw-bold text-success">

                        Active

                    </h3>

                @else

                    <h3 class="fw-bold text-danger">

                        Inactive

                    </h3>

                @endif

                <small class="text-muted">

                    Current Status

                </small>

            </div>

        </div>

    </div>

</div>
<!-- ===================================================== -->
<!-- Action Buttons -->
<!-- ===================================================== -->

<div class="card shadow-sm">

    <div class="card-body">

        <div class="d-flex justify-content-between align-items-center">

            <div>

                <small class="text-muted">

                    Service ID :
                    <strong>

                        #{{ $clientService->id }}

                    </strong>

                </small>

            </div>

            <div>

                <a
                    href="{{ route('client-services.index') }}"
                    class="btn btn-secondary">

                    <i class="mdi mdi-arrow-left me-1"></i>

                    Back

                </a>

                @can('update', $clientService)

                    <a
                        href="{{ route('client-services.edit', $clientService) }}"
                        class="btn btn-primary ms-2">

                        <i class="mdi mdi-pencil me-1"></i>

                        Edit

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
                            class="btn btn-danger ms-2"
                            onclick="return confirm('Are you sure you want to delete this service assignment?')">

                            <i class="mdi mdi-delete me-1"></i>

                            Delete

                        </button>

                    </form>

                @endcan

            </div>

        </div>

    </div>

</div>

</div>

@endsection