@extends('layouts.app')

@section('title', 'Communication Details')

@section('content')

<div class="container-fluid">

    <!-- ============================================= -->
    <!-- Page Header -->
    <!-- ============================================= -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">

                Communication Details

            </h2>

            <p class="text-muted mb-0">

                View complete communication information.

            </p>

        </div>

        <div class="d-flex gap-2">

            <a
                href="{{ route('client-communications.index') }}"
                class="btn btn-secondary">

                <i class="mdi mdi-arrow-left me-1"></i>

                Back

            </a>

            @can('update', $clientCommunication)

                <a
                    href="{{ route('client-communications.edit', $clientCommunication) }}"
                    class="btn btn-warning">

                    <i class="mdi mdi-pencil me-1"></i>

                    Edit

                </a>

            @endcan

            @can('delete', $clientCommunication)

                <form
                    action="{{ route('client-communications.destroy', $clientCommunication) }}"
                    method="POST"
                    onsubmit="return confirm('Delete this communication?');">

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

        </div>

    </div>

    <div class="row">

        <div class="col-lg-12">

            <div class="card shadow-sm">

                <div class="card-header">

                    <h5 class="mb-0">

                        General Information

                    </h5>

                </div>

                <div class="card-body">

                    <div class="row">

                        <!-- Client -->

                        <div class="col-md-6 mb-4">

                            <strong>Client</strong>

                            <div class="mt-1">

                                {{ optional($clientCommunication->client)->client_code }}

                                -

                                {{ optional($clientCommunication->client)->company_name }}

                            </div>

                        </div>

                        <!-- User -->

                        <div class="col-md-6 mb-4">

                            <strong>User</strong>

                            <div class="mt-1">

                                {{ optional($clientCommunication->user)->name }}

                            </div>

                        </div>
                                                <!-- Channel -->

                        <div class="col-md-3 mb-4">

                            <strong>

                                Channel

                            </strong>

                            <div class="mt-2">

                                @php

                                    $channelClass = match($clientCommunication->channel) {

                                        'Email' => 'primary',

                                        'Phone' => 'warning',

                                        'WhatsApp' => 'success',

                                        'SMS' => 'info',

                                        'Meeting' => 'danger',

                                        'Video Call' => 'dark',

                                        'Telegram' => 'primary',

                                        'Slack' => 'secondary',

                                        'Microsoft Teams' => 'info',

                                        'In Person' => 'warning',

                                        default => 'secondary',

                                    };

                                @endphp

                                <span class="badge bg-{{ $channelClass }}">

                                    {{ $clientCommunication->channel }}

                                </span>

                            </div>

                        </div>

                        <!-- Direction -->

                        <div class="col-md-3 mb-4">

                            <strong>

                                Direction

                            </strong>

                            <div class="mt-2">

                                @if($clientCommunication->direction == 'Incoming')

                                    <span class="badge bg-success">

                                        Incoming

                                    </span>

                                @else

                                    <span class="badge bg-primary">

                                        Outgoing

                                    </span>

                                @endif

                            </div>

                        </div>

                        <!-- Status -->

                        <div class="col-md-3 mb-4">

                            <strong>

                                Status

                            </strong>

                            <div class="mt-2">

                                @php

                                    $statusClass = match($clientCommunication->status) {

                                        'Draft' => 'secondary',

                                        'Pending' => 'warning',

                                        'Sent' => 'primary',

                                        'Delivered' => 'success',

                                        'Read' => 'info',

                                        'Failed' => 'danger',

                                        default => 'dark',

                                    };

                                @endphp

                                <span class="badge bg-{{ $statusClass }}">

                                    {{ $clientCommunication->status }}

                                </span>

                            </div>

                        </div>

                        <!-- Attachment -->

                        <div class="col-md-3 mb-4">

                            <strong>

                                Attachment

                            </strong>

                            <div class="mt-2">

                                @if($clientCommunication->has_attachment)

                                    <span class="badge bg-success">

                                        Yes

                                    </span>

                                @else

                                    <span class="badge bg-secondary">

                                        No

                                    </span>

                                @endif

                            </div>

                        </div>
                                                <!-- Subject -->

                        <div class="col-md-12 mb-4">

                            <strong>

                                Subject

                            </strong>

                            <div class="mt-2">

                                {{ $clientCommunication->subject ?: '-' }}

                            </div>

                        </div>

                        <!-- Message -->

                        <div class="col-md-12 mb-4">

                            <strong>

                                Message

                            </strong>

                            <div
                                class="border rounded p-3 bg-light mt-2"
                                style="white-space: pre-wrap; min-height:120px;">

                                {{ $clientCommunication->message }}

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- ====================================================== -->
    <!-- Sender & Receiver -->
    <!-- ====================================================== -->

    <div class="row mt-4">

        <!-- Sender -->

        <div class="col-lg-6">

            <div class="card shadow-sm">

                <div class="card-header">

                    <h5 class="mb-0">

                        Sender Information

                    </h5>

                </div>

                <div class="card-body">

                    <table class="table table-borderless mb-0">

                        <tr>

                            <th width="35%">

                                Name

                            </th>

                            <td>

                                {{ $clientCommunication->sender_name ?: '-' }}

                            </td>

                        </tr>

                        <tr>

                            <th>

                                Email

                            </th>

                            <td>

                                {{ $clientCommunication->sender_email ?: '-' }}

                            </td>

                        </tr>

                        <tr>

                            <th>

                                Phone

                            </th>

                            <td>

                                {{ $clientCommunication->sender_phone ?: '-' }}

                            </td>

                        </tr>

                    </table>

                </div>

            </div>

        </div>
                <!-- Receiver -->

        <div class="col-lg-6">

            <div class="card shadow-sm">

                <div class="card-header">

                    <h5 class="mb-0">

                        Receiver Information

                    </h5>

                </div>

                <div class="card-body">

                    <table class="table table-borderless mb-0">

                        <tr>

                            <th width="35%">

                                Name

                            </th>

                            <td>

                                {{ $clientCommunication->receiver_name ?: '-' }}

                            </td>

                        </tr>

                        <tr>

                            <th>

                                Email

                            </th>

                            <td>

                                {{ $clientCommunication->receiver_email ?: '-' }}

                            </td>

                        </tr>

                        <tr>

                            <th>

                                Phone

                            </th>

                            <td>

                                {{ $clientCommunication->receiver_phone ?: '-' }}

                            </td>

                        </tr>

                    </table>

                </div>

            </div>

        </div>

    </div>

    <!-- ========================================= -->
    <!-- Thread Information -->
    <!-- ========================================= -->

    <div class="row mt-4">

        <div class="col-lg-12">

            <div class="card shadow-sm">

                <div class="card-header">

                    <h5 class="mb-0">

                        Thread Information

                    </h5>

                </div>

                <div class="card-body">

                    <div class="row">

                        <!-- Thread ID -->

                        <div class="col-md-6 mb-3">

                            <strong>

                                Thread ID

                            </strong>

                            <div class="mt-2">

                                {{ $clientCommunication->thread_id ?: '-' }}

                            </div>

                        </div>

                        <!-- Message ID -->

                        <div class="col-md-6 mb-3">

                            <strong>

                                Message ID

                            </strong>

                            <div class="mt-2">

                                {{ $clientCommunication->message_id ?: '-' }}

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>
        <!-- ========================================= -->
    <!-- Communication Details -->
    <!-- ========================================= -->

    <div class="row mt-4">

        <div class="col-lg-12">

            <div class="card shadow-sm">

                <div class="card-header">

                    <h5 class="mb-0">

                        Communication Details

                    </h5>

                </div>

                <div class="card-body">

                    <div class="row">

                        <!-- Communication Date -->

                        <div class="col-md-6 mb-4">

                            <strong>

                                Communication Date & Time

                            </strong>

                            <div class="mt-2">

                                @if($clientCommunication->communication_at)

                                    {{ $clientCommunication->communication_at->format('d M Y h:i A') }}

                                @else

                                    -

                                @endif

                            </div>

                        </div>

                        <!-- Has Attachment -->

                        <div class="col-md-6 mb-4">

                            <strong>

                                Attachment Available

                            </strong>

                            <div class="mt-2">

                                @if($clientCommunication->has_attachment)

                                    <span class="badge bg-success">

                                        Yes

                                    </span>

                                @else

                                    <span class="badge bg-secondary">

                                        No

                                    </span>

                                @endif

                            </div>

                        </div>

                        <!-- Created At -->

                        <div class="col-md-6 mb-4">

                            <strong>

                                Created At

                            </strong>

                            <div class="mt-2">

                                {{ $clientCommunication->created_at?->format('d M Y h:i A') }}

                            </div>

                        </div>

                        <!-- Updated At -->

                        <div class="col-md-6 mb-4">

                            <strong>

                                Last Updated

                            </strong>

                            <div class="mt-2">

                                {{ $clientCommunication->updated_at?->format('d M Y h:i A') }}

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>
        <!-- ========================================= -->
    <!-- Metadata -->
    <!-- ========================================= -->

    <div class="row mt-4">

        <div class="col-lg-12">

            <div class="card shadow-sm">

                <div class="card-header d-flex justify-content-between align-items-center">

                    <h5 class="mb-0">

                        Metadata

                    </h5>

                    @if(!empty($clientCommunication->metadata))

                        <button
                            type="button"
                            class="btn btn-sm btn-outline-primary"
                            id="copyMetadata">

                            <i class="mdi mdi-content-copy me-1"></i>

                            Copy JSON

                        </button>

                    @endif

                </div>

                <div class="card-body">

                    @if(!empty($clientCommunication->metadata))

                        <pre
                            id="metadataContent"
                            class="bg-light border rounded p-3 mb-0"
                            style="max-height:400px;overflow:auto;">{{ json_encode($clientCommunication->metadata, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>

                    @else

                        <div class="text-muted">

                            No metadata available.

                        </div>

                    @endif

                </div>

            </div>

        </div>

    </div>
        <!-- ========================================= -->
    <!-- Record Information -->
    <!-- ========================================= -->

    <div class="row mt-4">

        <div class="col-lg-12">

            <div class="card shadow-sm">

                <div class="card-header">

                    <h5 class="mb-0">

                        Record Information

                    </h5>

                </div>

                <div class="card-body">

                    <div class="row">

                        <!-- Record ID -->

                        <div class="col-md-3 mb-3">

                            <strong>

                                ID

                            </strong>

                            <div class="mt-2">

                                #{{ $clientCommunication->id }}

                            </div>

                        </div>

                        <!-- Client -->

                        <div class="col-md-3 mb-3">

                            <strong>

                                Client

                            </strong>

                            <div class="mt-2">

                                {{ optional($clientCommunication->client)->company_name }}

                            </div>

                        </div>

                        <!-- Created By -->

                        <div class="col-md-3 mb-3">

                            <strong>

                                Created By

                            </strong>

                            <div class="mt-2">

                                {{ optional($clientCommunication->user)->name }}

                            </div>

                        </div>

                        <!-- Deleted -->

                        <div class="col-md-3 mb-3">

                            <strong>

                                Deleted

                            </strong>

                            <div class="mt-2">

                                @if($clientCommunication->deleted_at)

                                    <span class="badge bg-danger">

                                        Yes

                                    </span>

                                @else

                                    <span class="badge bg-success">

                                        No

                                    </span>

                                @endif

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>
    @endsection

@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | Copy Metadata
    |--------------------------------------------------------------------------
    */

    const copyButton =
        document.getElementById('copyMetadata');

    if (copyButton) {

        copyButton.addEventListener('click', function () {

            const metadata =
                document.getElementById(
                    'metadataContent'
                ).innerText;

            navigator.clipboard
                .writeText(metadata)
                .then(function () {

                    copyButton.innerHTML =
                        '<i class="mdi mdi-check me-1"></i>Copied';

                    setTimeout(function () {

                        copyButton.innerHTML =
                            '<i class="mdi mdi-content-copy me-1"></i>Copy JSON';

                    }, 2000);

                });

        });

    }
        /*
    |--------------------------------------------------------------------------
    | Print Communication
    |--------------------------------------------------------------------------
    */

    const printButton =
        document.getElementById('printCommunication');

    if (printButton) {

        printButton.addEventListener('click', function () {

            window.print();

        });

    }

    /*
    |--------------------------------------------------------------------------
    | Copy Subject
    |--------------------------------------------------------------------------
    */

    const subject =
        @json($clientCommunication->subject);

    const copySubject =
        document.getElementById('copySubject');

    if (copySubject && subject) {

        copySubject.addEventListener('click', function () {

            navigator.clipboard
                .writeText(subject)
                .then(function () {

                    copySubject.innerHTML =
                        '<i class="mdi mdi-check"></i>';

                    setTimeout(function () {

                        copySubject.innerHTML =
                            '<i class="mdi mdi-content-copy"></i>';

                    }, 1500);

                });

        });

    }
        /*
    |--------------------------------------------------------------------------
    | Copy Message
    |--------------------------------------------------------------------------
    */

    const message =
        @json($clientCommunication->message);

    const copyMessage =
        document.getElementById('copyMessage');

    if (copyMessage && message) {

        copyMessage.addEventListener('click', function () {

            navigator.clipboard
                .writeText(message)
                .then(function () {

                    copyMessage.innerHTML =
                        '<i class="mdi mdi-check"></i>';

                    setTimeout(function () {

                        copyMessage.innerHTML =
                            '<i class="mdi mdi-content-copy"></i>';

                    }, 1500);

                });

        });

    }

});

</script>

@endpush