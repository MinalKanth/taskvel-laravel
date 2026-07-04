@extends('layouts.app')

@section('title', 'Client Credential Details')

@section('content')

<div class="container-fluid">

    <!-- ===================================================== -->
    <!-- Header -->
    <!-- ===================================================== -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">

                Client Credential Details

            </h2>

            <p class="text-muted mb-0">

                View complete portal login information for this client.

            </p>

        </div>

        <div>

            @can('update', $clientCredential)

                <a
                    href="{{ route('client-credentials.edit', $clientCredential) }}"
                    class="btn btn-warning">

                    <i class="mdi mdi-pencil me-1"></i>

                    Edit

                </a>

            @endcan

            <a
                href="{{ route('client-credentials.index') }}"
                class="btn btn-secondary">

                <i class="mdi mdi-arrow-left me-1"></i>

                Back

            </a>

        </div>

    </div>

    @if(session('success'))

        <div class="alert alert-success">

            {{ session('success') }}

        </div>

    @endif

    <!-- ===================================================== -->
    <!-- Client Information -->
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

                <div class="col-md-4 mb-3">

                    <strong>Client</strong>

                    <p class="mb-0">

                        {{ $clientCredential->client->client_code }}

                        -

                        {{ $clientCredential->client->company_name }}

                    </p>

                </div>

                <div class="col-md-4 mb-3">

                    <strong>Portal</strong>

                    <p class="mb-0">

                        {{ $clientCredential->portal }}

                    </p>

                </div>

                <div class="col-md-4 mb-3">

                    <strong>Portal Name</strong>

                    <p class="mb-0">

                        {{ $clientCredential->portal_name ?: '-' }}

                    </p>

                </div>

                <div class="col-md-12 mb-3">

                    <strong>Login URL</strong>

                    <p class="mb-0">

                        @if($clientCredential->login_url)

                            <a
                                href="{{ $clientCredential->login_url }}"
                                target="_blank">

                                {{ $clientCredential->login_url }}

                            </a>

                        @else

                            -

                        @endif

                    </p>

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

                <div class="col-md-4 mb-3">

                    <strong>Username</strong>

                    <p class="mb-0">

                        {{ $clientCredential->username ?: '-' }}

                    </p>

                </div>

                <div class="col-md-4 mb-3">

                    <strong>Password</strong>

                    <p class="mb-0">

                        <span
                            class="badge bg-secondary"
                            id="passwordText">

                            ••••••••••••

                        </span>

                        <button
                            type="button"
                            class="btn btn-sm btn-outline-primary ms-2"
                            id="togglePassword">

                            Show

                        </button>

                        <span
                            id="realPassword"
                            class="d-none">

                            {{ $clientCredential->password }}

                        </span>

                    </p>

                </div>

                <div class="col-md-4 mb-3">

                    <strong>PIN</strong>

                    <p class="mb-0">

                        {{ $clientCredential->pin ?: '-' }}

                    </p>

                </div>

                <div class="col-md-6 mb-3">

                    <strong>Registered Email</strong>

                    <p class="mb-0">

                        {{ $clientCredential->registered_email ?: '-' }}

                    </p>

                </div>

                <div class="col-md-6 mb-3">

                    <strong>Registered Mobile</strong>

                    <p class="mb-0">

                        {{ $clientCredential->registered_mobile ?: '-' }}

                    </p>

                </div>

                <div class="col-md-6 mb-3">

                    <strong>Client ID Number</strong>

                    <p class="mb-0">

                        {{ $clientCredential->client_id_number ?: '-' }}

                    </p>

                </div>

                <div class="col-md-6 mb-3">

                    <strong>Last Password Changed</strong>

                    <p class="mb-0">

                        {{ optional($clientCredential->last_password_changed_at)->format('d M Y h:i A') ?: '-' }}

                    </p>

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

                <div class="col-md-6 mb-3">

                    <strong>Security Question</strong>

                    <p class="mb-0">

                        {{ $clientCredential->security_question ?: '-' }}

                    </p>

                </div>

                <div class="col-md-6 mb-3">

                    <strong>Security Answer</strong>

                    <p class="mb-0">

                        {{ $clientCredential->security_answer ?: '-' }}

                    </p>

                </div>

                <div class="col-md-4 mb-3">

                    <strong>OTP Required</strong>

                    <p class="mb-0">

                        @if($clientCredential->otp_required)

                            <span class="badge bg-success">

                                Yes

                            </span>

                        @else

                            <span class="badge bg-secondary">

                                No

                            </span>

                        @endif

                    </p>

                </div>

                <div class="col-md-4 mb-3">

                    <strong>DSC Required</strong>

                    <p class="mb-0">

                        @if($clientCredential->dsc_required)

                            <span class="badge bg-success">

                                Yes

                            </span>

                        @else

                            <span class="badge bg-secondary">

                                No

                            </span>

                        @endif

                    </p>

                </div>

                <div class="col-md-4 mb-3">

                    <strong>Status</strong>

                    <p class="mb-0">

                        @if($clientCredential->is_active)

                            <span class="badge bg-success">

                                Active

                            </span>

                        @else

                            <span class="badge bg-danger">

                                Inactive

                            </span>

                        @endif

                    </p>

                </div>

            </div>

        </div>

    </div>
        <!-- ===================================================== -->
    <!-- API Credentials -->
    <!-- ===================================================== -->

    <div class="card shadow-sm mb-4">

        <div class="card-header">

            <h5 class="mb-0">

                <i class="mdi mdi-api me-2"></i>

                API Credentials

            </h5>

        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-6 mb-3">

                    <strong>API Key</strong>

                    <p class="mb-0">

                        {{ $clientCredential->api_key ?: '-' }}

                    </p>

                </div>

                <div class="col-md-6 mb-3">

                    <strong>API Secret</strong>

                    <p class="mb-0">

                        {{ $clientCredential->api_secret ?: '-' }}

                    </p>

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

                <div class="col-md-4 mb-3">

                    <strong>DSC Serial Number</strong>

                    <p class="mb-0">

                        {{ $clientCredential->dsc_serial_number ?: '-' }}

                    </p>

                </div>

                <div class="col-md-4 mb-3">

                    <strong>DSC Owner</strong>

                    <p class="mb-0">

                        {{ $clientCredential->dsc_owner ?: '-' }}

                    </p>

                </div>

                <div class="col-md-4 mb-3">

                    <strong>DSC Expiry Date</strong>

                    <p class="mb-0">

                        {{ optional($clientCredential->dsc_expiry_date)->format('d M Y') ?: '-' }}

                    </p>

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

                <div class="col-md-4 mb-3">

                    <strong>Credential Expiry Date</strong>

                    <p class="mb-0">

                        {{ optional($clientCredential->expiry_date)->format('d M Y') ?: '-' }}

                    </p>

                </div>

                <div class="col-md-4 mb-3">

                    <strong>Last Login</strong>

                    <p class="mb-0">

                        {{ optional($clientCredential->last_login_at)->format('d M Y h:i A') ?: '-' }}

                    </p>

                </div>

                <div class="col-md-4 mb-3">

                    <strong>Created At</strong>

                    <p class="mb-0">

                        {{ optional($clientCredential->created_at)->format('d M Y h:i A') }}

                    </p>

                </div>

                <div class="col-md-6 mb-3">

                    <strong>Updated At</strong>

                    <p class="mb-0">

                        {{ optional($clientCredential->updated_at)->format('d M Y h:i A') }}

                    </p>

                </div>

                <div class="col-md-6 mb-3">

                    <strong>Metadata</strong>

                    <pre class="bg-light border rounded p-3 mb-0 small">{{ $clientCredential->metadata ? json_encode($clientCredential->metadata, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) : 'No metadata available.' }}</pre>

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

            @if($clientCredential->remarks)

                <p class="mb-0">

                    {!! nl2br(e($clientCredential->remarks)) !!}

                </p>

            @else

                <p class="text-muted mb-0">

                    No remarks available.

                </p>

            @endif

        </div>

    </div>
        <!-- ===================================================== -->
    <!-- Actions -->
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

                    @can('update', $clientCredential)

                        <a
                            href="{{ route('client-credentials.edit', $clientCredential) }}"
                            class="btn btn-warning">

                            <i class="mdi mdi-pencil me-1"></i>

                            Edit

                        </a>

                    @endcan

                    @can('delete', $clientCredential)

                        <form
                            action="{{ route('client-credentials.destroy', $clientCredential) }}"
                            method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this credential?');">

                            @csrf

                            @method('DELETE')

                            <button
                                type="submit"
                                class="btn btn-danger">

                                <i class="mdi mdi-delete me-1"></i>

                                Delete

                            </button>

                        </form>

                    @endcan

                    <a
                        href="{{ route('client-credentials.index') }}"
                        class="btn btn-secondary">

                        <i class="mdi mdi-arrow-left me-1"></i>

                        Back to List

                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection

@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {

    const button = document.getElementById('togglePassword');

    const passwordText = document.getElementById('passwordText');

    const realPassword = document.getElementById('realPassword');

    if (button && passwordText && realPassword) {

        let visible = false;

        button.addEventListener('click', function () {

            visible = !visible;

            if (visible) {

                passwordText.textContent = realPassword.textContent;

                button.textContent = 'Hide';

            } else {

                passwordText.textContent = '••••••••••••';

                button.textContent = 'Show';

            }

        });

    }

});

</script>

@endpush