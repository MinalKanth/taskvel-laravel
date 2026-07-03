@extends('layouts.app')

@section('title', 'Create Client Contact')

@section('content')

<div class="container-fluid">

    <!-- Header -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">
                Create Client Contact
            </h2>

            <p class="text-muted mb-0">
                Add a contact person for this client.
            </p>

        </div>

        <div>

            <a href="{{ route('client-contacts.index') }}"
               class="btn btn-secondary">

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

    <form action="{{ route('client-contacts.store') }}" method="POST">

        @csrf

        <!-- Basic Information -->

        <div class="card shadow-sm mb-4">

            <div class="card-header">

                <h5 class="mb-0">

                    <i class="mdi mdi-account-outline me-2"></i>

                    Contact Information

                </h5>

            </div>

            <div class="card-body">

                <div class="row">

                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Client
                            <span class="text-danger">*</span>
                        </label>

                        <select
                            name="client_id"
                            class="form-select @error('client_id') is-invalid @enderror">

                            <option value="">
                                Select Client
                            </option>

                            @foreach($clients as $client)

                                <option
                                    value="{{ $client->id }}"
                                    @selected(old('client_id', $selectedClient) == $client->id)>

                                    {{ $client->client_code }} - {{ $client->company_name }}

                                </option>

                            @endforeach

                        </select>

                        @error('client_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror

                            @error('client_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror

                    </div>

                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            First Name *
                        </label>

                        <input
                            type="text"
                            name="first_name"
                            value="{{ old('first_name') }}"
                            class="form-control @error('first_name') is-invalid @enderror">

                        @error('first_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                    </div>

                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Last Name
                        </label>

                        <input
                            type="text"
                            name="last_name"
                            value="{{ old('last_name') }}"
                            class="form-control">

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Full Name
                        </label>

                        <input
                            type="text"
                            name="full_name"
                            value="{{ old('full_name') }}"
                            class="form-control"
                            placeholder="Automatically if left blank">

                    </div>

                    <div class="col-md-3 mb-3">

                        <label class="form-label">
                            Designation
                        </label>

                        <input
                            type="text"
                            name="designation"
                            value="{{ old('designation') }}"
                            class="form-control"
                            placeholder="Director">

                    </div>

                    <div class="col-md-3 mb-3">

                        <label class="form-label">
                            Department
                        </label>

                        <input
                            type="text"
                            name="department"
                            value="{{ old('department') }}"
                            class="form-control"
                            placeholder="Accounts">

                    </div>

                </div>

            </div>

        </div>

        <!-- Contact Details -->

        <div class="card shadow-sm mb-4">

            <div class="card-header">

                <h5 class="mb-0">

                    <i class="mdi mdi-phone-outline me-2"></i>

                    Contact Details

                </h5>

            </div>

            <div class="card-body">

                <div class="row">

                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Mobile *
                        </label>

                        <input
                            type="text"
                            name="mobile"
                            value="{{ old('mobile') }}"
                            class="form-control">

                    </div>

                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Alternate Mobile
                        </label>

                        <input
                            type="text"
                            name="alternate_mobile"
                            value="{{ old('alternate_mobile') }}"
                            class="form-control">

                    </div>

                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            WhatsApp Number
                        </label>

                        <input
                            type="text"
                            name="whatsapp_number"
                            value="{{ old('whatsapp_number') }}"
                            class="form-control">

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Email
                        </label>

                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            class="form-control">

                    </div>

                </div>

            </div>

        </div>

        <!-- Personal Details -->

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
                            value="{{ old('date_of_birth') }}"
                            class="form-control">

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Anniversary
                        </label>

                        <input
                            type="date"
                            name="anniversary"
                            value="{{ old('anniversary') }}"
                            class="form-control">

                    </div>

                </div>

            </div>

        </div>

        <!-- Preferences -->

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
                                name="is_primary"
                                value="1"
                                @checked(old('is_primary'))>

                            <label class="form-check-label">
                                Primary Contact
                            </label>

                        </div>

                    </div>

                    <div class="col-md-3">

                        <div class="form-check form-switch">

                            <input
                                class="form-check-input"
                                type="checkbox"
                                name="receive_email"
                                value="1"
                                @checked(old('receive_email',true))>

                            <label class="form-check-label">
                                Receive Email
                            </label>

                        </div>

                    </div>

                    <div class="col-md-3">

                        <div class="form-check form-switch">

                            <input
                                class="form-check-input"
                                type="checkbox"
                                name="receive_whatsapp"
                                value="1"
                                @checked(old('receive_whatsapp',true))>

                            <label class="form-check-label">
                                Receive WhatsApp
                            </label>

                        </div>

                    </div>

                    <div class="col-md-3">

                        <div class="form-check form-switch">

                            <input
                                class="form-check-input"
                                type="checkbox"
                                name="receive_sms"
                                value="1"
                                @checked(old('receive_sms',true))>

                            <label class="form-check-label">
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
                                name="is_active"
                                value="1"
                                @checked(old('is_active',true))>

                            <label class="form-check-label">
                                Active Contact
                            </label>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- Remarks -->

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
                    class="form-control"
                    placeholder="Additional remarks...">{{ old('remarks') }}</textarea>

            </div>

        </div>

        <!-- Buttons -->

        <div class="card shadow-sm">

            <div class="card-body">

                <div class="text-end">

                    <a
                        href="{{ route('client-contacts.index') }}"
                        class="btn btn-light">

                        Cancel

                    </a>

                    <button
                        type="reset"
                        class="btn btn-warning">

                        Reset

                    </button>

                    <button
                        type="submit"
                        class="btn btn-primary">

                        <i class="mdi mdi-content-save me-1"></i>

                        Save Contact

                    </button>

                </div>

            </div>

        </div>

    </form>

</div>

@endsection