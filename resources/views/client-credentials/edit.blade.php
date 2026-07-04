@extends('layouts.app')

@section('title', 'Edit Client Credential')

@section('content')

<div class="container-fluid">

    <!-- ===================================================== -->
    <!-- Header -->
    <!-- ===================================================== -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">

                Edit Client Credential

            </h2>

            <p class="text-muted mb-0">

                Update portal login credentials and authentication details.

            </p>

        </div>

        <div>

            <a
                href="{{ route('client-credentials.show', $clientCredential) }}"
                class="btn btn-info">

                <i class="mdi mdi-eye me-1"></i>

                View

            </a>

            <a
                href="{{ route('client-credentials.index') }}"
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
        action="{{ route('client-credentials.update', $clientCredential) }}"
        method="POST">

        @csrf

        @method('PUT')

        <!-- ===================================================== -->
        <!-- Client & Portal Information -->
        <!-- ===================================================== -->

        <div class="card shadow-sm mb-4">

            <div class="card-header">

                <h5 class="mb-0">

                    <i class="mdi mdi-domain me-2"></i>

                    Client & Portal Information

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
                                    @selected(old('client_id', $clientCredential->client_id) == $client->id)>

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
                                        <!-- Portal -->

                    <div class="col-md-4 mb-3">

                        <label class="form-label">

                            Portal

                            <span class="text-danger">*</span>

                        </label>

                        <select
                            name="portal"
                            class="form-select @error('portal') is-invalid @enderror">

                            @foreach([
                                'GST','EPFO','ESIC','TRACES','Income Tax','MCA','ICEGATE','FSSAI','UDYAM','DGFT','Professional Tax','Other'
                            ] as $portal)

                                <option
                                    value="{{ $portal }}"
                                    @selected(old('portal', $clientCredential->portal) == $portal)>

                                    {{ $portal }}

                                </option>

                            @endforeach

                        </select>

                        @error('portal')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                    <!-- Portal Name -->

                    <div class="col-md-4 mb-3">

                        <label class="form-label">

                            Portal Name

                        </label>

                        <input
                            type="text"
                            name="portal_name"
                            class="form-control @error('portal_name') is-invalid @enderror"
                            value="{{ old('portal_name', $clientCredential->portal_name) }}"
                            placeholder="Example: GST Portal">

                        @error('portal_name')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                    <!-- Login URL -->

                    <div class="col-md-12 mb-3">

                        <label class="form-label">

                            Login URL

                        </label>

                        <input
                            type="url"
                            name="login_url"
                            class="form-control @error('login_url') is-invalid @enderror"
                            value="{{ old('login_url', $clientCredential->login_url) }}"
                            placeholder="https://">

                        @error('login_url')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                </div>

            </div>

        </div>

        <!-- ===================================================== -->
        <!-- Login Credentials -->
        <!-- ===================================================== -->

        <div class="card shadow-sm mb-4">

            <div class="card-header">

                <h5 class="mb-0">

                    <i class="mdi mdi-lock-outline me-2"></i>

                    Login Credentials

                </h5>

            </div>

            <div class="card-body">

                <div class="row">
                                        <!-- Username -->

                    <div class="col-md-4 mb-3">

                        <label class="form-label">

                            Username

                            <span class="text-danger">*</span>

                        </label>

                        <input
                            type="text"
                            name="username"
                            class="form-control @error('username') is-invalid @enderror"
                            value="{{ old('username', $clientCredential->username) }}">

                        @error('username')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                    <!-- Password -->

                    <div class="col-md-4 mb-3">

                        <label class="form-label">

                            Password

                            <span class="text-danger">*</span>

                        </label>

                        <input
                            type="text"
                            name="password"
                            class="form-control @error('password') is-invalid @enderror"
                            value="{{ old('password', $clientCredential->password) }}">

                        @error('password')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                    <!-- PIN -->

                    <div class="col-md-4 mb-3">

                        <label class="form-label">

                            PIN

                        </label>

                        <input
                            type="text"
                            name="pin"
                            class="form-control @error('pin') is-invalid @enderror"
                            value="{{ old('pin', $clientCredential->pin) }}">

                        @error('pin')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                    <!-- Registered Email -->

                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Registered Email

                        </label>

                        <input
                            type="email"
                            name="registered_email"
                            class="form-control @error('registered_email') is-invalid @enderror"
                            value="{{ old('registered_email', $clientCredential->registered_email) }}">

                        @error('registered_email')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                    <!-- Registered Mobile -->

                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Registered Mobile

                        </label>

                        <input
                            type="text"
                            name="registered_mobile"
                            class="form-control @error('registered_mobile') is-invalid @enderror"
                            value="{{ old('registered_mobile', $clientCredential->registered_mobile) }}">

                        @error('registered_mobile')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>
                                        <!-- Client ID Number -->

                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Client ID / Registration Number

                        </label>

                        <input
                            type="text"
                            name="client_id_number"
                            class="form-control @error('client_id_number') is-invalid @enderror"
                            value="{{ old('client_id_number', $clientCredential->client_id_number) }}"
                            placeholder="GSTIN / PAN / TAN / Registration Number">

                        @error('client_id_number')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                    <!-- Last Password Changed -->

                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Last Password Changed

                        </label>

                        <input
                            type="datetime-local"
                            name="last_password_changed_at"
                            class="form-control @error('last_password_changed_at') is-invalid @enderror"
                            value="{{ old(
                                'last_password_changed_at',
                                optional($clientCredential->last_password_changed_at)->format('Y-m-d\TH:i')
                            ) }}">

                        @error('last_password_changed_at')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                </div>

            </div>

        </div>

        <!-- ===================================================== -->
        <!-- Security Information -->
        <!-- ===================================================== -->

        <div class="card shadow-sm mb-4">

            <div class="card-header">

                <h5 class="mb-0">

                    <i class="mdi mdi-shield-lock-outline me-2"></i>

                    Security Information

                </h5>

            </div>

            <div class="card-body">

                <div class="row">

                    <!-- Security Question -->

                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Security Question

                        </label>

                        <input
                            type="text"
                            name="security_question"
                            class="form-control @error('security_question') is-invalid @enderror"
                            value="{{ old('security_question', $clientCredential->security_question) }}"
                            placeholder="Security Question">

                        @error('security_question')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>
                                        <!-- Security Answer -->

                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Security Answer

                        </label>

                        <input
                            type="text"
                            name="security_answer"
                            class="form-control @error('security_answer') is-invalid @enderror"
                            value="{{ old('security_answer', $clientCredential->security_answer) }}"
                            placeholder="Security Answer">

                        @error('security_answer')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                    <!-- OTP Required -->

                    <div class="col-md-4 mb-3">

                        <div class="form-check form-switch mt-4">

                            <input
                                class="form-check-input"
                                type="checkbox"
                                id="otp_required"
                                name="otp_required"
                                value="1"
                                @checked(old('otp_required', $clientCredential->otp_required))>

                            <label
                                class="form-check-label"
                                for="otp_required">

                                OTP Required

                            </label>

                        </div>

                    </div>

                    <!-- DSC Required -->

                    <div class="col-md-4 mb-3">

                        <div class="form-check form-switch mt-4">

                            <input
                                class="form-check-input"
                                type="checkbox"
                                id="dsc_required"
                                name="dsc_required"
                                value="1"
                                @checked(old('dsc_required', $clientCredential->dsc_required))>

                            <label
                                class="form-check-label"
                                for="dsc_required">

                                DSC Required

                            </label>

                        </div>

                    </div>

                    <!-- Active -->

                    <div class="col-md-4 mb-3">

                        <div class="form-check form-switch mt-4">

                            <input
                                class="form-check-input"
                                type="checkbox"
                                id="is_active"
                                name="is_active"
                                value="1"
                                @checked(old('is_active', $clientCredential->is_active))>

                            <label
                                class="form-check-label"
                                for="is_active">

                                Active Credential

                            </label>

                        </div>

                    </div>

                </div>

            </div>

        </div>
                <!-- ===================================================== -->
        <!-- API & Integration Details -->
        <!-- ===================================================== -->

        <div class="card shadow-sm mb-4">

            <div class="card-header">

                <h5 class="mb-0">

                    <i class="mdi mdi-api me-2"></i>

                    API & Integration Details

                </h5>

            </div>

            <div class="card-body">

                <div class="row">

                    <!-- API Key -->

                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            API Key

                        </label>

                        <input
                            type="text"
                            name="api_key"
                            class="form-control @error('api_key') is-invalid @enderror"
                            value="{{ old('api_key', $clientCredential->api_key) }}">

                        @error('api_key')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                    <!-- API Secret -->

                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            API Secret

                        </label>

                        <input
                            type="text"
                            name="api_secret"
                            class="form-control @error('api_secret') is-invalid @enderror"
                            value="{{ old('api_secret', $clientCredential->api_secret) }}">

                        @error('api_secret')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                </div>

            </div>

        </div>

        <!-- ===================================================== -->
        <!-- Digital Signature Certificate -->
        <!-- ===================================================== -->

        <div class="card shadow-sm mb-4">

            <div class="card-header">

                <h5 class="mb-0">

                    <i class="mdi mdi-card-account-details-outline me-2"></i>

                    Digital Signature Certificate (DSC)

                </h5>

            </div>

            <div class="card-body">

                <div class="row">
                                        <!-- DSC Serial Number -->

                    <div class="col-md-4 mb-3">

                        <label class="form-label">

                            DSC Serial Number

                        </label>

                        <input
                            type="text"
                            name="dsc_serial_number"
                            class="form-control @error('dsc_serial_number') is-invalid @enderror"
                            value="{{ old('dsc_serial_number', $clientCredential->dsc_serial_number) }}">

                        @error('dsc_serial_number')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                    <!-- DSC Owner -->

                    <div class="col-md-4 mb-3">

                        <label class="form-label">

                            DSC Owner

                        </label>

                        <input
                            type="text"
                            name="dsc_owner"
                            class="form-control @error('dsc_owner') is-invalid @enderror"
                            value="{{ old('dsc_owner', $clientCredential->dsc_owner) }}">

                        @error('dsc_owner')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                    <!-- DSC Expiry Date -->

                    <div class="col-md-4 mb-3">

                        <label class="form-label">

                            DSC Expiry Date

                        </label>

                        <input
                            type="date"
                            name="dsc_expiry_date"
                            class="form-control @error('dsc_expiry_date') is-invalid @enderror"
                            value="{{ old(
                                'dsc_expiry_date',
                                optional($clientCredential->dsc_expiry_date)->format('Y-m-d')
                            ) }}">

                        @error('dsc_expiry_date')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                </div>

            </div>

        </div>

        <!-- ===================================================== -->
        <!-- Important Dates -->
        <!-- ===================================================== -->

        <div class="card shadow-sm mb-4">

            <div class="card-header">

                <h5 class="mb-0">

                    <i class="mdi mdi-calendar-month-outline me-2"></i>

                    Important Dates

                </h5>

            </div>

            <div class="card-body">

                <div class="row">
                                        <!-- Credential Expiry Date -->

                    <div class="col-md-4 mb-3">

                        <label class="form-label">

                            Credential Expiry Date

                        </label>

                        <input
                            type="date"
                            name="expiry_date"
                            class="form-control @error('expiry_date') is-invalid @enderror"
                            value="{{ old(
                                'expiry_date',
                                optional($clientCredential->expiry_date)->format('Y-m-d')
                            ) }}">

                        @error('expiry_date')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                    <!-- Last Login -->

                    <div class="col-md-4 mb-3">

                        <label class="form-label">

                            Last Login

                        </label>

                        <input
                            type="datetime-local"
                            name="last_login_at"
                            class="form-control @error('last_login_at') is-invalid @enderror"
                            value="{{ old(
                                'last_login_at',
                                optional($clientCredential->last_login_at)->format('Y-m-d\TH:i')
                            ) }}">

                        @error('last_login_at')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                    <!-- Metadata -->

                    <div class="col-md-4 mb-3">

                        <label class="form-label">

                            Metadata (JSON)

                        </label>

                        <textarea
                            name="metadata"
                            rows="3"
                            class="form-control @error('metadata') is-invalid @enderror"
                            placeholder='{"environment":"production"}'>{{ old('metadata', is_array($clientCredential->metadata) ? json_encode($clientCredential->metadata, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) : $clientCredential->metadata) }}</textarea>

                        @error('metadata')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                    <!-- Remarks -->

                    <div class="col-md-12 mb-3">

                        <label class="form-label">

                            Remarks

                        </label>

                        <textarea
                            name="remarks"
                            rows="5"
                            class="form-control @error('remarks') is-invalid @enderror"
                            placeholder="Additional notes about this credential...">{{ old('remarks', $clientCredential->remarks) }}</textarea>

                        @error('remarks')

                            <div class="invalid-feedback d-block">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                </div>

            </div>

        </div>
                <!-- ===================================================== -->
        <!-- Form Actions -->
        <!-- ===================================================== -->

        <div class="card shadow-sm">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center flex-wrap">

                    <div>

                        <small class="text-muted">

                            Credential ID:
                            <strong>#{{ $clientCredential->id }}</strong>

                        </small>

                    </div>

                    <div class="d-flex gap-2">

                        <a
                            href="{{ route('client-credentials.show', $clientCredential) }}"
                            class="btn btn-info">

                            <i class="mdi mdi-eye me-1"></i>

                            View

                        </a>

                        <a
                            href="{{ route('client-credentials.index') }}"
                            class="btn btn-secondary">

                            <i class="mdi mdi-close me-1"></i>

                            Cancel

                        </a>

                        <button
                            type="reset"
                            class="btn btn-warning">

                            <i class="mdi mdi-refresh me-1"></i>

                            Reset

                        </button>

                        <button
                            type="submit"
                            class="btn btn-primary">

                            <i class="mdi mdi-content-save me-1"></i>

                            Update Credential

                        </button>

                    </div>

                </div>

            </div>

        </div>

    </form>

</div>

@endsection

@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {

    const metadata = document.querySelector('textarea[name="metadata"]');

    if (metadata) {

        metadata.addEventListener('blur', function () {

            if (this.value.trim() === '') {

                return;

            }

            try {

                JSON.parse(this.value);

                this.classList.remove('is-invalid');

            } catch (e) {

                alert('Metadata must be valid JSON.');

                this.classList.add('is-invalid');

            }

        });

    }

});

</script>

@endpush