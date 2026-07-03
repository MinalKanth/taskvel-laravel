@extends('layouts.app')

@section('title', 'Edit Client Address')

@section('content')

<div class="container-fluid">

    <!-- ===================================================== -->
    <!-- Header -->
    <!-- ===================================================== -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">

                Edit Client Address

            </h2>

            <p class="text-muted mb-0">

                Update client address information.

            </p>

        </div>

        <div>

            <a
                href="{{ route('client-addresses.show', $clientAddress) }}"
                class="btn btn-info">

                <i class="mdi mdi-eye me-1"></i>

                View

            </a>

            <a
                href="{{ route('client-addresses.index') }}"
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
        action="{{ route('client-addresses.update', $clientAddress) }}"
        method="POST">

        @csrf
        @method('PUT')

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

                        <select
                            name="client_id"
                            class="form-select @error('client_id') is-invalid @enderror">

                            @foreach($clients as $client)

                                <option
                                    value="{{ $client->id }}"
                                    @selected(old('client_id', $clientAddress->client_id) == $client->id)>

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

                    <!-- Address Type -->

                    <div class="col-md-4 mb-3">

                        <label class="form-label">

                            Address Type

                            <span class="text-danger">*</span>

                        </label>

                        <select
                            name="address_type"
                            class="form-select">

                            @foreach([
                                'Registered Office',
                                'Corporate Office',
                                'Branch Office',
                                'Factory',
                                'Warehouse',
                                'Billing',
                                'Shipping',
                                'Other'
                            ] as $type)

                                <option
                                    value="{{ $type }}"
                                    @selected(old('address_type', $clientAddress->address_type) == $type)>

                                    {{ $type }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    <!-- Country -->

                    <div class="col-md-4 mb-3">

                        <label class="form-label">

                            Country

                        </label>

                        <input
                            type="text"
                            name="country"
                            class="form-control"
                            value="{{ old('country', $clientAddress->country) }}">

                    </div>

                    <!-- Address Line 1 -->

                    <div class="col-md-12 mb-3">

                        <label class="form-label">

                            Address Line 1

                            <span class="text-danger">*</span>

                        </label>

                        <input
                            type="text"
                            name="address_line_1"
                            class="form-control"
                            value="{{ old('address_line_1', $clientAddress->address_line_1) }}">

                    </div>

                    <!-- Address Line 2 -->

                    <div class="col-md-12 mb-3">

                        <label class="form-label">

                            Address Line 2

                        </label>

                        <input
                            type="text"
                            name="address_line_2"
                            class="form-control"
                            value="{{ old('address_line_2', $clientAddress->address_line_2) }}">

                    </div>

                    <!-- Landmark -->

                    <div class="col-md-12 mb-3">

                        <label class="form-label">

                            Landmark

                        </label>

                        <input
                            type="text"
                            name="landmark"
                            class="form-control"
                            value="{{ old('landmark', $clientAddress->landmark) }}">

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
                            value="{{ old('city', $clientAddress->city) }}"
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
                            value="{{ old('district', $clientAddress->district) }}"
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
                            value="{{ old('state', $clientAddress->state) }}"
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
                            value="{{ old('postal_code', $clientAddress->postal_code) }}"
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
                            value="{{ old('latitude', $clientAddress->latitude) }}"
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
                            value="{{ old('longitude', $clientAddress->longitude) }}"
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
                                @checked(old('is_default', $clientAddress->is_default))>

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
                                @checked(old('is_active', $clientAddress->is_active))>

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
                    placeholder="Additional information about this address...">{{ old('remarks', $clientAddress->remarks) }}</textarea>

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

                            {{ optional($clientAddress->updated_at)->format('d M Y, h:i A') }}

                        </strong>

                    </small>

                    <div>

                        <a
                            href="{{ route('client-addresses.show', $clientAddress) }}"
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

                            Update Address

                        </button>

                    </div>

                </div>

            </div>

        </div>

    </form>

</div>

@endsection