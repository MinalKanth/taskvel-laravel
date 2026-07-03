@extends('layouts.app')

@section('title', 'Edit Client Contact')

@section('content')

<div class="container-fluid">

    <!-- ===================================================== -->
    <!-- Header -->
    <!-- ===================================================== -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">

                Edit Client Contact

            </h2>

            <p class="text-muted mb-0">

                Update contact information for this client.

            </p>

        </div>

        <div>

            <a
                href="{{ route('client-contacts.show', $clientContact) }}"
                class="btn btn-info">

                <i class="mdi mdi-eye me-1"></i>

                View

            </a>

            <a
                href="{{ route('client-contacts.index') }}"
                class="btn btn-secondary ms-2">

                <i class="mdi mdi-arrow-left me-1"></i>

                Back

            </a>

        </div>

    </div>

    @if ($errors->any())

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
        action="{{ route('client-contacts.update', $clientContact) }}"
        method="POST">

        @csrf
        @method('PUT')

        <!-- ===================================================== -->
        <!-- Contact Information -->
        <!-- ===================================================== -->

        <div class="card shadow-sm mb-4">

            <div class="card-header">

                <h5 class="mb-0">

                    <i class="mdi mdi-account-outline me-2"></i>

                    Contact Information

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
                                    @selected(old('client_id', $clientContact->client_id) == $client->id)>

                                    {{ $client->client_code }} - {{ $client->company_name }}

                                </option>

                            @endforeach

                        </select>

                        @error('client_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    <!-- First Name -->

                    <div class="col-md-4 mb-3">

                        <label class="form-label">

                            First Name
                            <span class="text-danger">*</span>

                        </label>

                        <input
                            type="text"
                            name="first_name"
                            class="form-control @error('first_name') is-invalid @enderror"
                            value="{{ old('first_name', $clientContact->first_name) }}">

                        @error('first_name')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                    <!-- Last Name -->

                    <div class="col-md-4 mb-3">

                        <label class="form-label">

                            Last Name

                        </label>

                        <input
                            type="text"
                            name="last_name"
                            class="form-control"
                            value="{{ old('last_name', $clientContact->last_name) }}">

                    </div>

                    <!-- Full Name -->

                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Full Name

                        </label>

                        <input
                            type="text"
                            name="full_name"
                            class="form-control"
                            value="{{ old('full_name', $clientContact->full_name) }}">

                    </div>

                    <!-- Designation -->

                    <div class="col-md-3 mb-3">

                        <label class="form-label">

                            Designation

                        </label>

                        <input
                            type="text"
                            name="designation"
                            class="form-control"
                            value="{{ old('designation', $clientContact->designation) }}">

                    </div>

                    <!-- Department -->

                    <div class="col-md-3 mb-3">

                        <label class="form-label">

                            Department

                        </label>

                        <input
                            type="text"
                            name="department"
                            class="form-control"
                            value="{{ old('department', $clientContact->department) }}">

                    </div>

                </div>

            </div>

        </div>
                <!-- ===================================================== -->
        <!-- Contact Details -->
        <!-- ===================================================== -->

        <div class="card shadow-sm mb-4">

            <div class="card-header">

                <h5 class="mb-0">

                    <i class="mdi mdi-phone-outline me-2"></i>

                    Contact Details

                </h5>

            </div>

            <div class="card-body">

                <div class="row">

                    <!-- Mobile -->

                    <div class="col-md-4 mb-3">

                        <label class="form-label">

                            Mobile
                            <span class="text-danger">*</span>

                        </label>

                        <input
                            type="text"
                            name="mobile"
                            class="form-control @error('mobile') is-invalid @enderror"
                            value="{{ old('mobile', $clientContact->mobile) }}">

                        @error('mobile')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                    <!-- Alternate Mobile -->

                    <div class="col-md-4 mb-3">

                        <label class="form-label">

                            Alternate Mobile

                        </label>

                        <input
                            type="text"
                            name="alternate_mobile"
                            class="form-control @error('alternate_mobile') is-invalid @enderror"
                            value="{{ old('alternate_mobile', $clientContact->alternate_mobile) }}">

                        @error('alternate_mobile')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                    <!-- WhatsApp -->

                    <div class="col-md-4 mb-3">

                        <label class="form-label">

                            WhatsApp Number

                        </label>

                        <input
                            type="text"
                            name="whatsapp_number"
                            class="form-control @error('whatsapp_number') is-invalid @enderror"
                            value="{{ old('whatsapp_number', $clientContact->whatsapp_number) }}">

                        @error('whatsapp_number')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                    <!-- Email -->

                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Email Address

                        </label>

                        <input
                            type="email"
                            name="email"
                            class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email', $clientContact->email) }}">

                        @error('email')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                </div>

            </div>

        </div>

        <!-- ===================================================== -->
        <!-- Personal Details -->
        <!-- ===================================================== -->

        <div class="card shadow-sm mb-4">

            <div class="card-header">

                <h5 class="mb-0">

                    <i class="mdi mdi-calendar me-2"></i>

                    Personal Details

                </h5>

            </div>

            <div class="card-body">

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Date of Birth

                        </label>

                        <input
                            type="date"
                            name="date_of_birth"
                            class="form-control"
                            value="{{ old('date_of_birth', optional($clientContact->date_of_birth)->format('Y-m-d')) }}">

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Anniversary

                        </label>

                        <input
                            type="date"
                            name="anniversary"
                            class="form-control"
                            value="{{ old('anniversary', optional($clientContact->anniversary)->format('Y-m-d')) }}">

                    </div>

                </div>

            </div>

        </div>
                <!-- ===================================================== -->
        <!-- Communication Preferences -->
        <!-- ===================================================== -->

        <div class="card shadow-sm mb-4">

            <div class="card-header">

                <h5 class="mb-0">

                    <i class="mdi mdi-cog-outline me-2"></i>

                    Communication Preferences

                </h5>

            </div>

            <div class="card-body">

                <div class="row">

                    <div class="col-md-3">

                        <div class="form-check form-switch">

                            <input
                                class="form-check-input"
                                type="checkbox"
                                id="is_primary"
                                name="is_primary"
                                value="1"
                                @checked(old('is_primary', $clientContact->is_primary))>

                            <label
                                class="form-check-label"
                                for="is_primary">

                                Primary Contact

                            </label>

                        </div>

                    </div>

                    <div class="col-md-3">

                        <div class="form-check form-switch">

                            <input
                                class="form-check-input"
                                type="checkbox"
                                id="receive_email"
                                name="receive_email"
                                value="1"
                                @checked(old('receive_email', $clientContact->receive_email))>

                            <label
                                class="form-check-label"
                                for="receive_email">

                                Receive Email

                            </label>

                        </div>

                    </div>

                    <div class="col-md-3">

                        <div class="form-check form-switch">

                            <input
                                class="form-check-input"
                                type="checkbox"
                                id="receive_whatsapp"
                                name="receive_whatsapp"
                                value="1"
                                @checked(old('receive_whatsapp', $clientContact->receive_whatsapp))>

                            <label
                                class="form-check-label"
                                for="receive_whatsapp">

                                Receive WhatsApp

                            </label>

                        </div>

                    </div>

                    <div class="col-md-3">

                        <div class="form-check form-switch">

                            <input
                                class="form-check-input"
                                type="checkbox"
                                id="receive_sms"
                                name="receive_sms"
                                value="1"
                                @checked(old('receive_sms', $clientContact->receive_sms))>

                            <label
                                class="form-check-label"
                                for="receive_sms">

                                Receive SMS

                            </label>

                        </div>

                    </div>

                </div>

                <hr>

                <div class="row">

                    <div class="col-md-3">

                        <div class="form-check form-switch">

                            <input
                                class="form-check-input"
                                type="checkbox"
                                id="is_active"
                                name="is_active"
                                value="1"
                                @checked(old('is_active', $clientContact->is_active))>

                            <label
                                class="form-check-label"
                                for="is_active">

                                Active Contact

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
                    placeholder="Additional remarks...">{{ old('remarks', $clientContact->remarks) }}</textarea>

                @error('remarks')

                    <div class="invalid-feedback">

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

                    <small class="text-muted">

                        Last Updated :
                        <strong>

                            {{ optional($clientContact->updated_at)->format('d M Y, h:i A') }}

                        </strong>

                    </small>

                    <div>

                        <a
                            href="{{ route('client-contacts.show', $clientContact) }}"
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

                            Update Contact

                        </button>

                    </div>

                </div>

            </div>

        </div>

    </form>

</div>

@endsection