@extends('layouts.app')

@section('title', 'View Client Contact')

@section('content')

<div class="container-fluid">

    <!-- Page Header -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">
                Client Contact Details
            </h2>

            <p class="text-muted mb-0">
                View complete information about this client contact.
            </p>

        </div>

        <div>

            @can('update', $clientContact)

                <a href="{{ route('client-contacts.edit', $clientContact) }}"
                   class="btn btn-warning">

                    <i class="mdi mdi-pencil me-1"></i>

                    Edit

                </a>

            @endcan

            <a href="{{ route('client-contacts.index') }}"
               class="btn btn-secondary ms-2">

                <i class="mdi mdi-arrow-left me-1"></i>

                Back

            </a>

        </div>

    </div>

    <!-- Contact Information -->

    <div class="card shadow-sm mb-4">

        <div class="card-header">

            <h5 class="mb-0">

                <i class="mdi mdi-account-circle-outline me-2"></i>

                Contact Information

            </h5>

        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-4 mb-4">

                    <small class="text-muted d-block">
                        Client
                    </small>

                    <h5 class="fw-bold text-primary mb-0">

                        {{ $clientContact->client->company_name ?? '-' }}

                    </h5>

                    <small class="text-muted">

                        {{ $clientContact->client->client_code ?? '' }}

                    </small>

                </div>

                <div class="col-md-4 mb-4">

                    <small class="text-muted d-block">
                        First Name
                    </small>

                    <h6 class="fw-semibold">

                        {{ $clientContact->first_name ?: '-' }}

                    </h6>

                </div>

                <div class="col-md-4 mb-4">

                    <small class="text-muted d-block">
                        Last Name
                    </small>

                    <h6 class="fw-semibold">

                        {{ $clientContact->last_name ?: '-' }}

                    </h6>

                </div>

                <div class="col-md-6 mb-4">

                    <small class="text-muted d-block">
                        Full Name
                    </small>

                    <h4 class="fw-bold text-dark">

                        {{ $clientContact->full_name ?: '-' }}

                    </h4>

                </div>

                <div class="col-md-3 mb-4">

                    <small class="text-muted d-block">
                        Designation
                    </small>

                    <h6>

                        {{ $clientContact->designation ?: '-' }}

                    </h6>

                </div>

                <div class="col-md-3 mb-4">

                    <small class="text-muted d-block">
                        Department
                    </small>

                    <h6>

                        {{ $clientContact->department ?: '-' }}

                    </h6>

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

                <div class="col-md-3 mb-4">

                    <small class="text-muted d-block">
                        Mobile Number
                    </small>

                    <h6 class="fw-semibold">

                        @if($clientContact->mobile)

                            <a href="tel:{{ $clientContact->mobile }}" class="text-decoration-none">
                                {{ $clientContact->mobile }}
                            </a>

                        @else

                            -

                        @endif

                    </h6>

                </div>

                <div class="col-md-3 mb-4">

                    <small class="text-muted d-block">
                        Alternate Mobile
                    </small>

                    <h6 class="fw-semibold">

                        @if($clientContact->alternate_mobile)

                            <a href="tel:{{ $clientContact->alternate_mobile }}" class="text-decoration-none">
                                {{ $clientContact->alternate_mobile }}
                            </a>

                        @else

                            -

                        @endif

                    </h6>

                </div>

                <div class="col-md-3 mb-4">

                    <small class="text-muted d-block">
                        WhatsApp Number
                    </small>

                    <h6 class="fw-semibold">

                        @if($clientContact->whatsapp_number)

                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $clientContact->whatsapp_number) }}"
                               target="_blank"
                               class="text-success text-decoration-none">

                                {{ $clientContact->whatsapp_number }}

                            </a>

                        @else

                            -

                        @endif

                    </h6>

                </div>

                <div class="col-md-3 mb-4">

                    <small class="text-muted d-block">
                        Email Address
                    </small>

                    <h6 class="fw-semibold">

                        @if($clientContact->email)

                            <a href="mailto:{{ $clientContact->email }}" class="text-decoration-none">

                                {{ $clientContact->email }}

                            </a>

                        @else

                            -

                        @endif

                    </h6>

                </div>

            </div>

        </div>

    </div>

    <!-- Personal Information -->

    <div class="card shadow-sm mb-4">

        <div class="card-header">

            <h5 class="mb-0">

                <i class="mdi mdi-calendar-account-outline me-2"></i>

                Personal Information

            </h5>

        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-6 mb-4">

                    <small class="text-muted d-block">

                        Date of Birth

                    </small>

                    <h6 class="fw-semibold">

                        @if($clientContact->date_of_birth)

                            {{ \Carbon\Carbon::parse($clientContact->date_of_birth)->format('d M Y') }}

                        @else

                            -

                        @endif

                    </h6>

                </div>

                <div class="col-md-6 mb-4">

                    <small class="text-muted d-block">

                        Anniversary

                    </small>

                    <h6 class="fw-semibold">

                        @if($clientContact->anniversary)

                            {{ \Carbon\Carbon::parse($clientContact->anniversary)->format('d M Y') }}

                        @else

                            -

                        @endif

                    </h6>

                </div>

            </div>

        </div>

    </div>
        <!-- Communication Preferences -->

    <div class="card shadow-sm mb-4">

        <div class="card-header">

            <h5 class="mb-0">

                <i class="mdi mdi-forum-outline me-2"></i>

                Communication Preferences

            </h5>

        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-lg-2 col-md-4 col-sm-6 mb-3">

                    <small class="text-muted d-block mb-2">

                        Primary Contact

                    </small>

                    @if($clientContact->is_primary)

                        <span class="badge bg-primary fs-6">

                            <i class="mdi mdi-star me-1"></i>

                            Yes

                        </span>

                    @else

                        <span class="badge bg-secondary fs-6">

                            <i class="mdi mdi-star-off me-1"></i>

                            No

                        </span>

                    @endif

                </div>

                <div class="col-lg-2 col-md-4 col-sm-6 mb-3">

                    <small class="text-muted d-block mb-2">

                        Email Notifications

                    </small>

                    @if($clientContact->receive_email)

                        <span class="badge bg-success fs-6">

                            <i class="mdi mdi-email-check me-1"></i>

                            Enabled

                        </span>

                    @else

                        <span class="badge bg-danger fs-6">

                            <i class="mdi mdi-email-off me-1"></i>

                            Disabled

                        </span>

                    @endif

                </div>

                <div class="col-lg-2 col-md-4 col-sm-6 mb-3">

                    <small class="text-muted d-block mb-2">

                        WhatsApp

                    </small>

                    @if($clientContact->receive_whatsapp)

                        <span class="badge bg-success fs-6">

                            <i class="mdi mdi-whatsapp me-1"></i>

                            Enabled

                        </span>

                    @else

                        <span class="badge bg-danger fs-6">

                            <i class="mdi mdi-whatsapp me-1"></i>

                            Disabled

                        </span>

                    @endif

                </div>

                <div class="col-lg-2 col-md-4 col-sm-6 mb-3">

                    <small class="text-muted d-block mb-2">

                        SMS

                    </small>

                    @if($clientContact->receive_sms)

                        <span class="badge bg-success fs-6">

                            <i class="mdi mdi-message-processing me-1"></i>

                            Enabled

                        </span>

                    @else

                        <span class="badge bg-danger fs-6">

                            <i class="mdi mdi-message-off me-1"></i>

                            Disabled

                        </span>

                    @endif

                </div>

                <div class="col-lg-2 col-md-4 col-sm-6 mb-3">

                    <small class="text-muted d-block mb-2">

                        Status

                    </small>

                    @if($clientContact->is_active)

                        <span class="badge bg-success fs-6">

                            <i class="mdi mdi-check-circle me-1"></i>

                            Active

                        </span>

                    @else

                        <span class="badge bg-danger fs-6">

                            <i class="mdi mdi-close-circle me-1"></i>

                            Inactive

                        </span>

                    @endif

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

            @if($clientContact->remarks)

                <div class="border rounded p-3 bg-light">

                    {!! nl2br(e($clientContact->remarks)) !!}

                </div>

            @else

                <div class="text-center py-4">

                    <i class="mdi mdi-note-remove-outline display-5 text-muted"></i>

                    <p class="text-muted mt-2 mb-0">

                        No remarks available for this contact.

                    </p>

                </div>

            @endif

        </div>

    </div>
        <!-- Audit Information -->

    <div class="card shadow-sm mb-4">

        <div class="card-header">

            <h5 class="mb-0">

                <i class="mdi mdi-history me-2"></i>

                Audit Information

            </h5>

        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-3 mb-4">

                    <small class="text-muted d-block">
                        Created On
                    </small>

                    <h6 class="fw-semibold">

                        {{ $clientContact->created_at?->format('d M Y') ?? '-' }}

                    </h6>

                    <small class="text-muted">

                        {{ $clientContact->created_at?->format('h:i A') }}

                    </small>

                </div>

                <div class="col-md-3 mb-4">

                    <small class="text-muted d-block">
                        Last Updated
                    </small>

                    <h6 class="fw-semibold">

                        {{ $clientContact->updated_at?->format('d M Y') ?? '-' }}

                    </h6>

                    <small class="text-muted">

                        {{ $clientContact->updated_at?->format('h:i A') }}

                    </small>

                </div>

                @if(isset($clientContact->creator))

                    <div class="col-md-3 mb-4">

                        <small class="text-muted d-block">

                            Created By

                        </small>

                        <h6 class="fw-semibold">

                            {{ optional($clientContact->creator)->name ?: '-' }}

                        </h6>

                    </div>

                @endif

                @if(isset($clientContact->updater))

                    <div class="col-md-3 mb-4">

                        <small class="text-muted d-block">

                            Updated By

                        </small>

                        <h6 class="fw-semibold">

                            {{ optional($clientContact->updater)->name ?: '-' }}

                        </h6>

                    </div>

                @endif

            </div>

        </div>

    </div>

    <!-- Action Buttons -->

    <div class="card shadow-sm">

        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center">

                <div>

                    @if($clientContact->client)

                        <a href="{{ route('clients.show', $clientContact->client_id) }}"
                           class="btn btn-info">

                            <i class="mdi mdi-domain me-1"></i>

                            View Client

                        </a>

                    @endif

                </div>

                <div>

                    <a href="{{ route('client-contacts.index') }}"
                       class="btn btn-light">

                        <i class="mdi mdi-arrow-left me-1"></i>

                        Back

                    </a>

                    @can('update', $clientContact)

                        <a href="{{ route('client-contacts.edit', $clientContact) }}"
                           class="btn btn-warning">

                            <i class="mdi mdi-pencil me-1"></i>

                            Edit Contact

                        </a>

                    @endcan

                    @can('delete', $clientContact)

                        <form
                            action="{{ route('client-contacts.destroy', $clientContact) }}"
                            method="POST"
                            class="d-inline">

                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="btn btn-danger"
                                onclick="return confirm('Are you sure you want to delete this contact?')">

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

@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {

    // Enable Bootstrap tooltips

    const tooltipTriggerList = [].slice.call(
        document.querySelectorAll('[data-bs-toggle="tooltip"]')
    );

    tooltipTriggerList.map(function (tooltipTriggerEl) {

        return new bootstrap.Tooltip(tooltipTriggerEl);

    });

    // Copy text helper

    document.querySelectorAll('.copy-text').forEach(function (element) {

        element.addEventListener('click', function () {

            navigator.clipboard.writeText(this.dataset.copy);

            const original = this.innerHTML;

            this.innerHTML =
                '<i class="mdi mdi-check text-success"></i> Copied';

            setTimeout(() => {

                this.innerHTML = original;

            }, 1500);

        });

    });

});

</script>

@endpush