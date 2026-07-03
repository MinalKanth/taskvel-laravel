@extends('layouts.app')

@section('title', 'Update Client')

@section('content')

<div class="container-fluid">

    <!-- Page Header -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">
                Update Client
            </h2>

            <p class="text-muted mb-0">
                Register a new client in the CRM.
            </p>

        </div>

        <div>

            <a href="{{ route('clients.index') }}"
               class="btn btn-secondary">

                <i class="mdi mdi-arrow-left me-1"></i>

                Back to Clients

            </a>

        </div>

    </div>

    <!-- Validation Errors -->

    @if ($errors->any())

        <div class="alert alert-danger">

            <strong>Please correct the following errors:</strong>

            <hr>

            <ul class="mb-0">

                @foreach ($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif

    <form
    action="{{ route('clients.update', $client) }}"
    method="POST">

    @csrf
    @method('PUT')

@if(isset($client))
    @method('PUT')
@endif

<!-- ===================================================== -->
<!-- Company Information -->
<!-- ===================================================== -->

<div class="card shadow-sm mb-4">

    <div class="card-header">

        <h5 class="mb-0">

            <i class="mdi mdi-domain me-2"></i>

            Company Information

        </h5>

    </div>

    <div class="card-body">

        <div class="row">

            {{-- Client Code (Optional) --}}
            {{--

            <div class="col-md-4 mb-3">

                <label class="form-label">

                    Client Code

                </label>

                <input
                    type="text"
                    class="form-control"
                    value="{{ $client->client_code }}"
                    readonly>

            </div>

            --}}

            <!-- Company Name -->

            <div class="col-md-8 mb-3">

                <label class="form-label">

                    Company Name

                    <span class="text-danger">*</span>

                </label>

                <input
                    type="text"
                    name="company_name"
                    class="form-control @error('company_name') is-invalid @enderror"
                    value="{{ old('company_name', $client->company_name) }}"
                    placeholder="ABC Private Limited">

                @error('company_name')

                    <div class="invalid-feedback">

                        {{ $message }}

                    </div>

                @enderror

            </div>

            <!-- Legal Name -->

            <div class="col-md-4 mb-3">

                <label class="form-label">

                    Legal Name

                </label>

                <input
                    type="text"
                    name="legal_name"
                    class="form-control @error('legal_name') is-invalid @enderror"
                    value="{{ old('legal_name', $client->legal_name) }}"
                    placeholder="Legal Entity Name">

                @error('legal_name')

                    <div class="invalid-feedback">

                        {{ $message }}

                    </div>

                @enderror

            </div>
                        <!-- Business Type -->

            <div class="col-md-3 mb-3">

                <label class="form-label">

                    Business Type

                </label>

                <select
                    name="business_type"
                    class="form-select @error('business_type') is-invalid @enderror">

                    <option value="">
                        Select Business Type
                    </option>

                    <option value="Proprietorship"
                        @selected(old('business_type', $client->business_type) == 'Proprietorship')>
                        Proprietorship
                    </option>

                    <option value="Partnership"
                        @selected(old('business_type', $client->business_type) == 'Partnership')>
                        Partnership
                    </option>

                    <option value="LLP"
                        @selected(old('business_type', $client->business_type) == 'LLP')>
                        LLP
                    </option>

                    <option value="Private Limited"
                        @selected(old('business_type', $client->business_type) == 'Private Limited')>
                        Private Limited
                    </option>

                    <option value="Public Limited"
                        @selected(old('business_type', $client->business_type) == 'Public Limited')>
                        Public Limited
                    </option>

                    <option value="OPC"
                        @selected(old('business_type', $client->business_type) == 'OPC')>
                        One Person Company (OPC)
                    </option>

                    <option value="Trust"
                        @selected(old('business_type', $client->business_type) == 'Trust')>
                        Trust
                    </option>

                    <option value="Society"
                        @selected(old('business_type', $client->business_type) == 'Society')>
                        Society
                    </option>

                    <option value="NGO"
                        @selected(old('business_type', $client->business_type) == 'NGO')>
                        NGO
                    </option>

                    <option value="Government"
                        @selected(old('business_type', $client->business_type) == 'Government')>
                        Government
                    </option>

                    <option value="Other"
                        @selected(old('business_type', $client->business_type) == 'Other')>
                        Other
                    </option>

                </select>

                @error('business_type')

                    <div class="invalid-feedback">

                        {{ $message }}

                    </div>

                @enderror

            </div>

            <!-- Constitution -->

            <div class="col-md-3 mb-3">

                <label class="form-label">

                    Constitution

                </label>

                <select
                    name="constitution"
                    class="form-select @error('constitution') is-invalid @enderror">

                    <option value="">
                        Select Constitution
                    </option>

                    <option value="Proprietorship"
                        @selected(old('constitution', $client->constitution) == 'Proprietorship')>
                        Proprietorship
                    </option>

                    <option value="Partnership"
                        @selected(old('constitution', $client->constitution) == 'Partnership')>
                        Partnership
                    </option>

                    <option value="LLP"
                        @selected(old('constitution', $client->constitution) == 'LLP')>
                        LLP
                    </option>

                    <option value="Private Limited"
                        @selected(old('constitution', $client->constitution) == 'Private Limited')>
                        Private Limited
                    </option>
                                        <option value="Public Limited"
                        @selected(old('constitution', $client->constitution) == 'Public Limited')>
                        Public Limited
                    </option>

                    <option value="Trust"
                        @selected(old('constitution', $client->constitution) == 'Trust')>
                        Trust
                    </option>

                    <option value="Society"
                        @selected(old('constitution', $client->constitution) == 'Society')>
                        Society
                    </option>

                    <option value="NGO"
                        @selected(old('constitution', $client->constitution) == 'NGO')>
                        NGO
                    </option>

                    <option value="Other"
                        @selected(old('constitution', $client->constitution) == 'Other')>
                        Other
                    </option>

                </select>

                @error('constitution')

                    <div class="invalid-feedback">

                        {{ $message }}

                    </div>

                @enderror

            </div>

        </div>

    </div>

</div>

<!-- ===================================================== -->
<!-- Tax & Registration Details -->
<!-- ===================================================== -->

<div class="card shadow-sm mb-4">

    <div class="card-header">

        <h5 class="mb-0">

            <i class="mdi mdi-file-document-outline me-2"></i>

            Tax & Registration Details

        </h5>

    </div>

    <div class="card-body">

        <div class="row">

            <div class="col-md-4 mb-3">

                <label class="form-label">

                    GSTIN

                </label>

                <input
                    type="text"
                    name="gstin"
                    class="form-control @error('gstin') is-invalid @enderror"
                    value="{{ old('gstin', $client->gstin) }}">

                @error('gstin')

                    <div class="invalid-feedback">

                        {{ $message }}

                    </div>

                @enderror

            </div>

            <div class="col-md-4 mb-3">

                <label class="form-label">

                    PAN

                </label>

                <input
                    type="text"
                    name="pan"
                    class="form-control @error('pan') is-invalid @enderror"
                    value="{{ old('pan', $client->pan) }}">
                                    @error('pan')

                    <div class="invalid-feedback">

                        {{ $message }}

                    </div>

                @enderror

            </div>

            <div class="col-md-4 mb-3">

                <label class="form-label">

                    TAN

                </label>

                <input
                    type="text"
                    name="tan"
                    class="form-control @error('tan') is-invalid @enderror"
                    value="{{ old('tan', $client->tan) }}">

                @error('tan')

                    <div class="invalid-feedback">

                        {{ $message }}

                    </div>

                @enderror

            </div>

            <div class="col-md-4 mb-3">

                <label class="form-label">

                    CIN

                </label>

                <input
                    type="text"
                    name="cin"
                    class="form-control @error('cin') is-invalid @enderror"
                    value="{{ old('cin', $client->cin) }}">

                @error('cin')

                    <div class="invalid-feedback">

                        {{ $message }}

                    </div>

                @enderror

            </div>

            <div class="col-md-4 mb-3">

                <label class="form-label">

                    UDYAM Number

                </label>

                <input
                    type="text"
                    name="udyam_number"
                    class="form-control @error('udyam_number') is-invalid @enderror"
                    value="{{ old('udyam_number', $client->udyam_number) }}">

                @error('udyam_number')

                    <div class="invalid-feedback">

                        {{ $message }}

                    </div>

                @enderror

            </div>

            <div class="col-md-4 mb-3">

                <label class="form-label">

                    ESIC Code

                </label>

                <input
                    type="text"
                    name="esic_code"
                    class="form-control @error('esic_code') is-invalid @enderror"
                    value="{{ old('esic_code', $client->esic_code) }}">

                @error('esic_code')

                    <div class="invalid-feedback">

                        {{ $message }}

                    </div>

                @enderror

            </div>

            <div class="col-md-4 mb-3">

                <label class="form-label">

                    EPF Code

                </label>

                <input
                    type="text"
                    name="epf_code"
                    class="form-control @error('epf_code') is-invalid @enderror"
                    value="{{ old('epf_code', $client->epf_code) }}">

                @error('epf_code')

                    <div class="invalid-feedback">

                        {{ $message }}

                    </div>

                @enderror

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

                <label class="form-label">

                    Email Address

                </label>

                <input
                    type="email"
                    name="email"
                    class="form-control @error('email') is-invalid @enderror"
                    value="{{ old('email', $client->email) }}"
                    placeholder="company@example.com">

                @error('email')

                    <div class="invalid-feedback">

                        {{ $message }}

                    </div>

                @enderror

            </div>

            <div class="col-md-6 mb-3">

                <label class="form-label">

                    Website

                </label>

                <input
                    type="url"
                    name="website"
                    class="form-control @error('website') is-invalid @enderror"
                    value="{{ old('website', $client->website) }}"
                    placeholder="https://example.com">

                @error('website')

                    <div class="invalid-feedback">

                        {{ $message }}

                    </div>

                @enderror

            </div>

            <div class="col-md-6 mb-3">

                <label class="form-label">

                    Phone Number

                </label>

                <input
                    type="text"
                    name="phone"
                    class="form-control @error('phone') is-invalid @enderror"
                    value="{{ old('phone', $client->phone) }}"
                    placeholder="+91XXXXXXXXXX">

                @error('phone')

                    <div class="invalid-feedback">

                        {{ $message }}

                    </div>

                @enderror

            </div>

            <div class="col-md-6 mb-3">

                <label class="form-label">

                    Alternate Phone

                </label>

                <input
                    type="text"
                    name="alternate_phone"
                    class="form-control @error('alternate_phone') is-invalid @enderror"
                    value="{{ old('alternate_phone', $client->alternate_phone) }}"
                    placeholder="+91XXXXXXXXXX">

                @error('alternate_phone')

                    <div class="invalid-feedback">

                        {{ $message }}

                    </div>

                @enderror

            </div>

        </div>

    </div>

</div>
<!-- ===================================================== -->
<!-- Business & Financial Information -->
<!-- ===================================================== -->

<div class="card shadow-sm mb-4">

    <div class="card-header">

        <h5 class="mb-0">

            <i class="mdi mdi-briefcase-account-outline me-2"></i>

            Business & Financial Information

        </h5>

    </div>

    <div class="card-body">

        <div class="row">

            <div class="col-md-3 mb-3">

                <label class="form-label">

                    Status

                    <span class="text-danger">*</span>

                </label>

                <select
                    name="status"
                    class="form-select @error('status') is-invalid @enderror">

                    <option value="Lead"
                        @selected(old('status', $client->status) == 'Lead')>
                        Lead
                    </option>

                    <option value="Prospect"
                        @selected(old('status', $client->status) == 'Prospect')>
                        Prospect
                    </option>

                    <option value="Active"
                        @selected(old('status', $client->status) == 'Active')>
                        Active
                    </option>

                    <option value="Inactive"
                        @selected(old('status', $client->status) == 'Inactive')>
                        Inactive
                    </option>

                    <option value="Suspended"
                        @selected(old('status', $client->status) == 'Suspended')>
                        Suspended
                    </option>

                    <option value="Closed"
                        @selected(old('status', $client->status) == 'Closed')>
                        Closed
                    </option>

                </select>

                @error('status')

                    <div class="invalid-feedback">

                        {{ $message }}

                    </div>

                @enderror

            </div>

            <div class="col-md-3 mb-3">

                <label class="form-label">

                    Priority

                </label>

                <select
                    name="priority"
                    class="form-select @error('priority') is-invalid @enderror">

                    <option value="Low"
                        @selected(old('priority', $client->priority) == 'Low')>
                        Low
                    </option>

                    <option value="Medium"
                        @selected(old('priority', $client->priority) == 'Medium')>
                        Medium
                    </option>

                    <option value="High"
                        @selected(old('priority', $client->priority) == 'High')>
                        High
                    </option>

                    <option value="Critical"
                        @selected(old('priority', $client->priority) == 'Critical')>
                        Critical
                    </option>

                </select>

                @error('priority')

                    <div class="invalid-feedback">

                        {{ $message }}

                    </div>

                @enderror

            </div>
                        <div class="col-md-3 mb-3">

                <label class="form-label">

                    Incorporation Date

                </label>

                <input
                    type="date"
                    name="incorporation_date"
                    class="form-control @error('incorporation_date') is-invalid @enderror"
                    value="{{ old('incorporation_date', optional($client->incorporation_date)->format('Y-m-d')) }}">

                @error('incorporation_date')

                    <div class="invalid-feedback">

                        {{ $message }}

                    </div>

                @enderror

            </div>

            <div class="col-md-3 mb-3">

                <label class="form-label">

                    Payment Terms (Days)

                </label>

                <input
                    type="number"
                    name="payment_terms"
                    class="form-control @error('payment_terms') is-invalid @enderror"
                    value="{{ old('payment_terms', $client->payment_terms) }}">

                @error('payment_terms')

                    <div class="invalid-feedback">

                        {{ $message }}

                    </div>

                @enderror

            </div>

            <div class="col-md-4 mb-3">

                <label class="form-label">

                    Opening Balance

                </label>

                <div class="input-group">

                    <span class="input-group-text">

                        ₹

                    </span>

                    <input
                        type="number"
                        step="0.01"
                        name="opening_balance"
                        class="form-control @error('opening_balance') is-invalid @enderror"
                        value="{{ old('opening_balance', $client->opening_balance) }}">

                </div>

                @error('opening_balance')

                    <div class="text-danger small mt-1">

                        {{ $message }}

                    </div>

                @enderror

            </div>

            <div class="col-md-4 mb-3">

                <label class="form-label">

                    Credit Limit

                </label>

                <div class="input-group">

                    <span class="input-group-text">

                        ₹

                    </span>

                    <input
                        type="number"
                        step="0.01"
                        name="credit_limit"
                        class="form-control @error('credit_limit') is-invalid @enderror"
                        value="{{ old('credit_limit', $client->credit_limit) }}">

                </div>

                @error('credit_limit')

                    <div class="text-danger small mt-1">

                        {{ $message }}

                    </div>

                @enderror

            </div>
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
                            @selected(old('assigned_to', $client->assigned_to) == $user->id)>

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

        </div>

    </div>

</div>

<!-- ===================================================== -->
<!-- Bank Account Information -->
<!-- ===================================================== -->

<div class="card shadow-sm mb-4">

    <div class="card-header">

        <h5 class="mb-0">

            <i class="mdi mdi-bank me-2"></i>

            Bank Account Information

        </h5>

    </div>

    <div class="card-body">

        <div class="row">

            <div class="col-md-6 mb-3">

                <label class="form-label">

                    Bank Name

                </label>

                <input
                    type="text"
                    name="bank_name"
                    class="form-control @error('bank_name') is-invalid @enderror"
                    value="{{ old('bank_name', $client->bank_name) }}"
                    placeholder="State Bank of India">

                @error('bank_name')

                    <div class="invalid-feedback">

                        {{ $message }}

                    </div>

                @enderror

            </div>
                        <div class="col-md-6 mb-3">

                <label class="form-label">

                    Branch Name

                </label>

                <input
                    type="text"
                    name="branch_name"
                    class="form-control @error('branch_name') is-invalid @enderror"
                    value="{{ old('branch_name', $client->branch_name) }}"
                    placeholder="Guwahati Main Branch">

                @error('branch_name')

                    <div class="invalid-feedback">

                        {{ $message }}

                    </div>

                @enderror

            </div>

            <div class="col-md-6 mb-3">

                <label class="form-label">

                    Account Holder Name

                </label>

                <input
                    type="text"
                    name="account_holder_name"
                    class="form-control @error('account_holder_name') is-invalid @enderror"
                    value="{{ old('account_holder_name', $client->account_holder_name) }}"
                    placeholder="ABC Private Limited">

                @error('account_holder_name')

                    <div class="invalid-feedback">

                        {{ $message }}

                    </div>

                @enderror

            </div>

            <div class="col-md-6 mb-3">

                <label class="form-label">

                    Account Number

                </label>

                <input
                    type="text"
                    name="account_number"
                    class="form-control @error('account_number') is-invalid @enderror"
                    value="{{ old('account_number', $client->account_number) }}"
                    placeholder="123456789012">

                @error('account_number')

                    <div class="invalid-feedback">

                        {{ $message }}

                    </div>

                @enderror

            </div>
                        <div class="col-md-4 mb-3">

                <label class="form-label">

                    IFSC Code

                </label>

                <input
                    type="text"
                    name="ifsc_code"
                    class="form-control @error('ifsc_code') is-invalid @enderror"
                    value="{{ old('ifsc_code', $client->ifsc_code) }}"
                    placeholder="SBIN0000123">

                @error('ifsc_code')

                    <div class="invalid-feedback">

                        {{ $message }}

                    </div>

                @enderror

            </div>

            <div class="col-md-4 mb-3">

                <label class="form-label">

                    MICR Code

                </label>

                <input
                    type="text"
                    name="micr_code"
                    class="form-control @error('micr_code') is-invalid @enderror"
                    value="{{ old('micr_code', $client->micr_code) }}"
                    placeholder="781002001">

                @error('micr_code')

                    <div class="invalid-feedback">

                        {{ $message }}

                    </div>

                @enderror

            </div>

            <div class="col-md-4 mb-3">

                <label class="form-label">

                    Account Type

                </label>

                <select
                    name="account_type"
                    class="form-select @error('account_type') is-invalid @enderror">

                    <option value="Savings"
                        @selected(old('account_type', $client->account_type) == 'Savings')>
                        Savings
                    </option>

                    <option value="Current"
                        @selected(old('account_type', $client->account_type) == 'Current')>
                        Current
                    </option>

                    <option value="Cash Credit"
                        @selected(old('account_type', $client->account_type) == 'Cash Credit')>
                        Cash Credit
                    </option>

                    <option value="OD"
                        @selected(old('account_type', $client->account_type) == 'OD')>
                        Overdraft
                    </option>

                </select>

                @error('account_type')

                    <div class="invalid-feedback">

                        {{ $message }}

                    </div>

                @enderror

            </div>
                        <div class="col-md-6 mb-3">

                <label class="form-label">

                    UPI ID

                </label>

                <input
                    type="text"
                    name="upi_id"
                    class="form-control @error('upi_id') is-invalid @enderror"
                    value="{{ old('upi_id', $client->upi_id) }}"
                    placeholder="company@okaxis">

                @error('upi_id')

                    <div class="invalid-feedback">

                        {{ $message }}

                    </div>

                @enderror

            </div>

            <div class="col-md-3 mb-3 d-flex align-items-end">

                <div class="form-check form-switch">

                    <input
                        class="form-check-input"
                        type="checkbox"
                        id="is_primary"
                        name="is_primary"
                        value="1"
                        @checked(old('is_primary', $client->is_primary))

                    >

                    <label
                        class="form-check-label"
                        for="is_primary">

                        Primary Account

                    </label>

                </div>

            </div>

            <div class="col-md-3 mb-3 d-flex align-items-end">

                <div class="form-check form-switch">

                    <input
                        class="form-check-input"
                        type="checkbox"
                        id="bank_is_active"
                        name="bank_is_active"
                        value="1"
                        @checked(old('bank_is_active', $client->bank_is_active))

                    >

                    <label
                        class="form-check-label"
                        for="bank_is_active">

                        Active Account

                    </label>

                </div>

            </div>
                        <div class="col-md-12 mb-3">

                <label class="form-label">

                    Bank Remarks

                </label>

                <textarea
                    name="bank_remarks"
                    rows="3"
                    class="form-control @error('bank_remarks') is-invalid @enderror"
                    placeholder="Additional bank account notes...">{{ old('bank_remarks', $client->bank_remarks) }}</textarea>

                @error('bank_remarks')

                    <div class="invalid-feedback">

                        {{ $message }}

                    </div>

                @enderror

            </div>

        </div>

    </div>

</div>

<!-- ===================================================== -->
<!-- Additional Information -->
<!-- ===================================================== -->

<div class="card shadow-sm mb-4">

    <div class="card-header">

        <h5 class="mb-0">

            <i class="mdi mdi-note-text-outline me-2"></i>

            Additional Information

        </h5>

    </div>

    <div class="card-body">

        <div class="row">

            <div class="col-md-12 mb-3">

                <label class="form-label">

                    Notes

                </label>

                <textarea
                    name="notes"
                    rows="5"
                    class="form-control @error('notes') is-invalid @enderror"
                    placeholder="Enter any additional information about the client...">{{ old('notes', $client->notes) }}</textarea>

                @error('notes')

                    <div class="invalid-feedback">

                        {{ $message }}

                    </div>

                @enderror

            </div>
                        <div class="col-md-12">

                <div class="form-check form-switch">

                    <input
                        type="checkbox"
                        class="form-check-input"
                        id="is_active"
                        name="is_active"
                        value="1"
                        @checked(old('is_active', $client->is_active))

                    >

                    <label
                        class="form-check-label"
                        for="is_active">

                        Client is Active

                    </label>

                </div>

            </div>

        </div>

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

                        {{ optional($client->updated_at)->format('d M Y, h:i A') }}

                    </strong>

                </small>

            </div>

            <div>
                                <a
                    href="{{ route('clients.show', $client) }}"
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

                    Update Client

                </button>

            </div>

        </div>

    </div>

</div>
                <button
                    type="submit"
                    class="btn btn-primary">

                    <i class="mdi mdi-content-save me-1"></i>

                    Update Client

                </button>

            </div>

        </div>

    </div>

</div>
                <button
                    type="submit"
                    class="btn btn-primary">

                    <i class="mdi mdi-content-save me-1"></i>

                    Update Client

                </button>

            </div>

        </div>

    </div>

</div>

    </form>

</div>

@endsection