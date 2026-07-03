@extends('layouts.app')

@section('title', 'Assign Client Service')

@section('content')

<div class="container-fluid">

    <!-- ===================================================== -->
    <!-- Header -->
    <!-- ===================================================== -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">

                Assign Service

            </h2>

            <p class="text-muted mb-0">

                Assign a service package to a client with billing and renewal details.

            </p>

        </div>

        <div>

            <a
                href="{{ route('client-services.index') }}"
                class="btn btn-secondary">

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
        action="{{ route('client-services.store') }}"
        method="POST">

        @csrf

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

                        @if(isset($selectedClient) && $selectedClient)

                            <input
                                type="hidden"
                                name="client_id"
                                value="{{ $selectedClient->id }}">

                            <input
                                type="text"
                                class="form-control"
                                value="{{ $selectedClient->client_code }} - {{ $selectedClient->company_name }}"
                                readonly>

                        @else

                            <select
                                name="client_id"
                                class="form-select @error('client_id') is-invalid @enderror">

                                <option value="">

                                    Select Client

                                </option>

                                @foreach($clients as $client)

                                    <option
                                        value="{{ $client->id }}"
                                        @selected(old('client_id') == $client->id)>

                                        {{ $client->client_code }} - {{ $client->company_name }}

                                    </option>

                                @endforeach

                            </select>

                        @endif

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

                            <option value="">

                                Select Service

                            </option>

                            @foreach($services as $service)

                                <option
                                    value="{{ $service->id }}"
                                    @selected(old('service_id') == $service->id)>

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
                                    @selected(old('assigned_to') == $user->id)>

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
                            value="{{ old('start_date') }}">

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
                            value="{{ old('end_date') }}">

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
                            value="{{ old('renewal_date') }}">

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

                    <span class="input-group-text">₹</span>

                    <input
                        type="number"
                        step="0.01"
                        name="service_fee"
                        class="form-control @error('service_fee') is-invalid @enderror"
                        value="{{ old('service_fee', 0) }}">

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

                    <span class="input-group-text">₹</span>

                    <input
                        type="number"
                        step="0.01"
                        name="discount"
                        class="form-control @error('discount') is-invalid @enderror"
                        value="{{ old('discount', 0) }}">

                </div>

                @error('discount')

                    <div class="text-danger small mt-1">

                        {{ $message }}

                    </div>

                @enderror

            </div>

            <!-- Tax -->

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
                        value="{{ old('tax_percentage',18) }}">

                    <span class="input-group-text">%</span>

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

                    <option value="One Time"
                        @selected(old('billing_cycle') == 'One Time')>
                        One Time
                    </option>

                    <option value="Weekly"
                        @selected(old('billing_cycle') == 'Weekly')>
                        Weekly
                    </option>

                    <option value="Monthly"
                        @selected(old('billing_cycle','Monthly') == 'Monthly')>
                        Monthly
                    </option>

                    <option value="Quarterly"
                        @selected(old('billing_cycle') == 'Quarterly')>
                        Quarterly
                    </option>

                    <option value="Half Yearly"
                        @selected(old('billing_cycle') == 'Half Yearly')>
                        Half Yearly
                    </option>

                    <option value="Yearly"
                        @selected(old('billing_cycle') == 'Yearly')>
                        Yearly
                    </option>

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
                    value="{{ old('due_day',1) }}"
                    placeholder="1 - 31">

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

                    <option value="Pending"
                        @selected(old('status') == 'Pending')>
                        Pending
                    </option>

                    <option value="Active"
                        @selected(old('status','Active') == 'Active')>
                        Active
                    </option>

                    <option value="Completed"
                        @selected(old('status') == 'Completed')>
                        Completed
                    </option>

                    <option value="Cancelled"
                        @selected(old('status') == 'Cancelled')>
                        Cancelled
                    </option>

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
                        @checked(old('auto_generate_tasks', true))>

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
                        @checked(old('renewable', true))>

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
                        @checked(old('is_active', true))>

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
            placeholder="Additional remarks about this client service...">{{ old('remarks') }}</textarea>

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

                    Fields marked with
                    <span class="text-danger">*</span>
                    are mandatory.

                </small>

            </div>

            <div>

                <a
                    href="{{ route('client-services.index') }}"
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

                    Save Service

                </button>

            </div>

        </div>

    </div>

</div>

    </form>

</div>

@endsection