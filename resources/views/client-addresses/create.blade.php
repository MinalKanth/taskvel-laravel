@extends('layouts.app')

@section('title', 'Create Client Address')

@section('content')

<div class="container-fluid">

    <!-- Header -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">

                Create Client Address

            </h2>

            <p class="text-muted mb-0">

                Add a new address for a client.

            </p>

        </div>

        <div>

            <a href="{{ route('client-addresses.index') }}"
               class="btn btn-secondary">

                <i class="mdi mdi-arrow-left me-1"></i>

                Back

            </a>

        </div>

    </div>

    <!-- Validation Errors -->

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

    <form action="{{ route('client-addresses.store') }}" method="POST">

        @csrf

        <!-- ===================================================== -->
        <!-- Address Information -->
        <!-- ===================================================== -->

        <div class="card shadow-sm mb-4">

            <div class="card-header">

                <h5 class="mb-0">

                    <i class="mdi mdi-map-marker-outline me-2"></i>

                    Address Information

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

                                        {{ $client->client_code }}
                                        -
                                        {{ $client->company_name }}

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

                    <!-- Address Type -->

                    <div class="col-md-4 mb-3">

                        <label class="form-label">

                            Address Type

                            <span class="text-danger">*</span>

                        </label>

                        <select
                            name="address_type"
                            class="form-select @error('address_type') is-invalid @enderror">

                            <option value="">

                                Select Address Type

                            </option>

                            <option value="Registered Office"
                                @selected(old('address_type')=='Registered Office')>

                                Registered Office

                            </option>

                            <option value="Corporate Office"
                                @selected(old('address_type')=='Corporate Office')>

                                Corporate Office

                            </option>

                            <option value="Branch Office"
                                @selected(old('address_type')=='Branch Office')>

                                Branch Office

                            </option>

                            <option value="Factory"
                                @selected(old('address_type')=='Factory')>

                                Factory

                            </option>

                            <option value="Warehouse"
                                @selected(old('address_type')=='Warehouse')>

                                Warehouse

                            </option>

                            <option value="Billing"
                                @selected(old('address_type')=='Billing')>

                                Billing Address

                            </option>

                            <option value="Shipping"
                                @selected(old('address_type')=='Shipping')>

                                Shipping Address

                            </option>

                            <option value="Other"
                                @selected(old('address_type')=='Other')>

                                Other

                            </option>

                        </select>

                        @error('address_type')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                    <!-- Country -->

                    <div class="col-md-4 mb-3">

                        <label class="form-label">

                            Country

                        </label>

                        <input
                            type="text"
                            name="country"
                            class="form-control @error('country') is-invalid @enderror"
                            value="{{ old('country','India') }}"
                            placeholder="Country">

                        @error('country')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                    <!-- Address Line 1 -->

                    <div class="col-md-12 mb-3">

                        <label class="form-label">

                            Address Line 1

                            <span class="text-danger">*</span>

                        </label>

                        <textarea
                            name="address_line_1"
                            rows="2"
                            class="form-control @error('address_line_1') is-invalid @enderror"
                            placeholder="Building, Street, Area...">{{ old('address_line_1') }}</textarea>

                        @error('address_line_1')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                    <!-- Address Line 2 -->

                    <div class="col-md-12 mb-3">

                        <label class="form-label">

                            Address Line 2

                        </label>

                        <textarea
                            name="address_line_2"
                            rows="2"
                            class="form-control @error('address_line_2') is-invalid @enderror"
                            placeholder="Additional Address Information">{{ old('address_line_2') }}</textarea>

                        @error('address_line_2')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                    <!-- Landmark -->

                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Landmark

                        </label>

                        <input
                            type="text"
                            name="landmark"
                            class="form-control @error('landmark') is-invalid @enderror"
                            value="{{ old('landmark') }}"
                            placeholder="Near Bus Stand, Mall, etc.">

                        @error('landmark')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>
                                        <!-- City -->

                    <div class="col-md-3 mb-3">

                        <label class="form-label">

                            City

                            <span class="text-danger">*</span>

                        </label>

                        <input
                            type="text"
                            name="city"
                            class="form-control @error('city') is-invalid @enderror"
                            value="{{ old('city') }}"
                            placeholder="City">

                        @error('city')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                    <!-- District -->

                    <div class="col-md-3 mb-3">

                        <label class="form-label">

                            District

                        </label>

                        <input
                            type="text"
                            name="district"
                            class="form-control @error('district') is-invalid @enderror"
                            value="{{ old('district') }}"
                            placeholder="District">

                        @error('district')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                    <!-- State -->

                    <div class="col-md-3 mb-3">

                        <label class="form-label">

                            State

                            <span class="text-danger">*</span>

                        </label>

                        <input
                            type="text"
                            name="state"
                            class="form-control @error('state') is-invalid @enderror"
                            value="{{ old('state') }}"
                            placeholder="State">

                        @error('state')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                    <!-- Postal Code -->

                    <div class="col-md-3 mb-3">

                        <label class="form-label">

                            Postal Code

                        </label>

                        <input
                            type="text"
                            name="postal_code"
                            class="form-control @error('postal_code') is-invalid @enderror"
                            value="{{ old('postal_code') }}"
                            placeholder="781001">

                        @error('postal_code')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                    <!-- Latitude -->

                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Latitude

                        </label>

                        <input
                            type="text"
                            name="latitude"
                            class="form-control @error('latitude') is-invalid @enderror"
                            value="{{ old('latitude') }}"
                            placeholder="26.144516">

                        @error('latitude')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                    <!-- Longitude -->

                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Longitude

                        </label>

                        <input
                            type="text"
                            name="longitude"
                            class="form-control @error('longitude') is-invalid @enderror"
                            value="{{ old('longitude') }}"
                            placeholder="91.736237">

                        @error('longitude')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                </div>

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

                    <div class="col-md-4">

                        <div class="form-check form-switch">

                            <input
                                class="form-check-input"
                                type="checkbox"
                                id="is_default"
                                name="is_default"
                                value="1"
                                @checked(old('is_default'))>

                            <label
                                class="form-check-label"
                                for="is_default">

                                Default Address

                            </label>

                        </div>

                    </div>

                    <div class="col-md-4">

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

                                Active Address

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
                    placeholder="Additional information about this address...">{{ old('remarks') }}</textarea>

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

                        Fields marked with
                        <span class="text-danger">*</span>
                        are mandatory.

                    </small>

                    <div>

                        <a
                            href="{{ route('client-addresses.index') }}"
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

                            Save Address

                        </button>

                    </div>

                </div>

            </div>

        </div>

    </form>

</div>

@endsection