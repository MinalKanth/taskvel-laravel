@extends('layouts.app')

@section('title', 'Edit Client Service')

@section('content')

<div class="container-fluid">

    <!-- ===================================================== -->
    <!-- Header -->
    <!-- ===================================================== -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">

                Edit Client Service

            </h2>

            <p class="text-muted mb-0">

                Update the assigned service details.

            </p>

        </div>

        <div>

            <a
                href="{{ route('client-services.show', $clientService) }}"
                class="btn btn-info">

                <i class="mdi mdi-eye me-1"></i>

                View

            </a>

            <a
                href="{{ route('client-services.index') }}"
                class="btn btn-secondary ms-2">

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
        action="{{ route('client-services.update', $clientService) }}"
        method="POST">

        @csrf

        @method('PUT')

        <!-- ===================================================== -->
        <!-- Service Assignment -->
        <!-- ===================================================== -->

        <div class="card shadow-sm mb-4">

            <div class="card-header">

                <h5 class="mb-0">

                    <i class="mdi mdi-briefcase-check-outline me-2"></i>

                    Service Assignment

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

                        <select
                            name="client_id"
                            class="form-select @error('client_id') is-invalid @enderror">

                            @foreach($clients as $client)

                                <option
                                    value="{{ $client->id }}"
                                    @selected(old('client_id', $clientService->client_id) == $client->id)>

                                    {{ $client->client_code }}
                                    -
                                    {{ $client->company_name }}

                                </option>

                            @endforeach

                        </select>

                        @error('client_id')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                    <!-- Service -->

                    <div class="col-md-4 mb-3">

                        <label class="form-label">

                            Service
                            <span class="text-danger">*</span>

                        </label>

                        <select
                            name="service_id"
                            class="form-select @error('service_id') is-invalid @enderror">

                            @foreach($services as $service)

                                <option
                                    value="{{ $service->id }}"
                                    @selected(old('service_id', $clientService->service_id) == $service->id)>

                                    {{ $service->name }}

                                </option>

                            @endforeach

                        </select>

                        @error('service_id')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                    <!-- Assigned To -->

                    <div class="col-md-4 mb-3">

                        <label class="form-label">

                            Assigned To

                        </label>

                        <select
                            name="assigned_to"
                            class="form-select @error('assigned_to') is-invalid @enderror">

                            <option value="">

                                Select Employee

                            </option>

                            @foreach($users as $user)

                                <option
                                    value="{{ $user->id }}"
                                    @selected(old('assigned_to', $clientService->assigned_to) == $user->id)>

                                    {{ $user->name }}

                                </option>

                            @endforeach

                        </select>

                        @error('assigned_to')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>
                                        <!-- Start Date -->

                    <div class="col-md-4 mb-3">

                        <label class="form-label">

                            Start Date
                            <span class="text-danger">*</span>

                        </label>

                        <input
                            type="date"
                            name="start_date"
                            class="form-control @error('start_date') is-invalid @enderror"
                            value="{{ old('start_date', optional($clientService->start_date)->format('Y-m-d')) }}">

                        @error('start_date')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                    <!-- End Date -->

                    <div class="col-md-4 mb-3">

                        <label class="form-label">

                            End Date

                        </label>

                        <input
                            type="date"
                            name="end_date"
                            class="form-control @error('end_date') is-invalid @enderror"
                            value="{{ old('end_date', optional($clientService->end_date)->format('Y-m-d')) }}">

                        @error('end_date')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                    <!-- Renewal Date -->

                    <div class="col-md-4 mb-3">

                        <label class="form-label">

                            Renewal Date

                        </label>

                        <input
                            type="date"
                            name="renewal_date"
                            class="form-control @error('renewal_date') is-invalid @enderror"
                            value="{{ old('renewal_date', optional($clientService->renewal_date)->format('Y-m-d')) }}">

                        @error('renewal_date')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

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

            <!-- Service Fee -->

            <div class="col-md-3 mb-3">

                <label class="form-label">

                    Service Fee

                    <span class="text-danger">*</span>

                </label>

                <div class="input-group">

                    <span class="input-group-text">

                        ₹

                    </span>

                    <input
                        type="number"
                        step="0.01"
                        name="service_fee"
                        class="form-control @error('service_fee') is-invalid @enderror"
                        value="{{ old('service_fee', $clientService->service_fee) }}">

                </div>

                @error('service_fee')

                    <div class="text-danger small mt-1">

                        {{ $message }}

                    </div>

                @enderror

            </div>

            <!-- Discount -->

            <div class="col-md-3 mb-3">

                <label class="form-label">

                    Discount

                </label>

                <div class="input-group">

                    <span class="input-group-text">

                        ₹

                    </span>

                    <input
                        type="number"
                        step="0.01"
                        name="discount"
                        class="form-control @error('discount') is-invalid @enderror"
                        value="{{ old('discount', $clientService->discount) }}">

                </div>

                @error('discount')

                    <div class="text-danger small mt-1">

                        {{ $message }}

                    </div>

                @enderror

            </div>

            <!-- Tax Percentage -->

            <div class="col-md-3 mb-3">

                <label class="form-label">

                    Tax %

                </label>

                <div class="input-group">

                    <input
                        type="number"
                        step="0.01"
                        name="tax_percentage"
                        class="form-control @error('tax_percentage') is-invalid @enderror"
                        value="{{ old('tax_percentage', $clientService->tax_percentage) }}">

                    <span class="input-group-text">

                        %

                    </span>

                </div>

                @error('tax_percentage')

                    <div class="text-danger small mt-1">

                        {{ $message }}

                    </div>

                @enderror

            </div>
                        <!-- Billing Cycle -->

            <div class="col-md-3 mb-3">

                <label class="form-label">

                    Billing Cycle
                    <span class="text-danger">*</span>

                </label>

                <select
                    name="billing_cycle"
                    class="form-select @error('billing_cycle') is-invalid @enderror">

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
                            @selected(old('billing_cycle', $clientService->billing_cycle) == $cycle)>

                            {{ $cycle }}

                        </option>

                    @endforeach

                </select>

                @error('billing_cycle')

                    <div class="invalid-feedback">

                        {{ $message }}

                    </div>

                @enderror

            </div>

            <!-- Due Day -->

            <div class="col-md-3 mb-3">

                <label class="form-label">

                    Due Day

                </label>

                <input
                    type="number"
                    min="1"
                    max="31"
                    name="due_day"
                    class="form-control @error('due_day') is-invalid @enderror"
                    value="{{ old('due_day', $clientService->due_day) }}">

                @error('due_day')

                    <div class="invalid-feedback">

                        {{ $message }}

                    </div>

                @enderror

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

            <!-- Status -->

            <div class="col-md-4 mb-3">

                <label class="form-label">

                    Status

                </label>

                <select
                    name="status"
                    class="form-select @error('status') is-invalid @enderror">

                    @foreach([
                        'Pending',
                        'Active',
                        'Completed',
                        'Cancelled'
                    ] as $status)

                        <option
                            value="{{ $status }}"
                            @selected(old('status', $clientService->status) == $status)>

                            {{ $status }}

                        </option>

                    @endforeach

                </select>

                @error('status')

                    <div class="invalid-feedback">

                        {{ $message }}

                    </div>

                @enderror

            </div>

            <!-- Auto Generate Tasks -->

            <div class="col-md-4 d-flex align-items-end mb-3">

                <div class="form-check form-switch">

                    <input
                        class="form-check-input"
                        type="checkbox"
                        id="auto_generate_tasks"
                        name="auto_generate_tasks"
                        value="1"
                        @checked(old('auto_generate_tasks', $clientService->auto_generate_tasks))>

                    <label
                        class="form-check-label"
                        for="auto_generate_tasks">

                        Auto Generate Tasks

                    </label>

                </div>

            </div>

            <!-- Renewable -->

            <div class="col-md-4 d-flex align-items-end mb-3">

                <div class="form-check form-switch">

                    <input
                        class="form-check-input"
                        type="checkbox"
                        id="renewable"
                        name="renewable"
                        value="1"
                        @checked(old('renewable', $clientService->renewable))>

                    <label
                        class="form-check-label"
                        for="renewable">

                        Renewable Service

                    </label>

                </div>

            </div>
                        <!-- Active -->

            <div class="col-md-4 d-flex align-items-end mb-3">

                <div class="form-check form-switch">

                    <input
                        class="form-check-input"
                        type="checkbox"
                        id="is_active"
                        name="is_active"
                        value="1"
                        @checked(old('is_active', $clientService->is_active))>

                    <label
                        class="form-check-label"
                        for="is_active">

                        Active Service

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
            placeholder="Additional remarks about this service assignment...">{{ old('remarks', $clientService->remarks) }}</textarea>

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

                    Last Updated :
                    <strong>

                        {{ optional($clientService->updated_at)->format('d M Y, h:i A') }}

                    </strong>

                </small>

            </div>

            <div>

                <a
                    href="{{ route('client-services.show', $clientService) }}"
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

                    Update Service

                </button>

            </div>

        </div>

    </div>

</div>

    </form>

</div>

@endsection