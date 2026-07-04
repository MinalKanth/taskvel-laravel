@extends('layouts.app')

@section('title', 'Add Client Communication')

@section('content')

<div class="container-fluid">

    <!-- ===================================================== -->
    <!-- Page Header -->
    <!-- ===================================================== -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">

                Add Client Communication

            </h2>

            <p class="text-muted mb-0">

                Record client communication including emails, calls, meetings, WhatsApp messages and other interactions.

            </p>

        </div>

        <div>

            <a
                href="{{ route('client-communications.index') }}"
                class="btn btn-secondary">

                <i class="mdi mdi-arrow-left me-1"></i>

                Back

            </a>

        </div>

    </div>

    @if ($errors->any())

        <div class="alert alert-danger">

            <ul class="mb-0">

                @foreach ($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif

    <form
        action="{{ route('client-communications.store') }}"
        method="POST">

        @csrf

        <div class="card shadow-sm mb-4">

            <div class="card-header">

                <h5 class="mb-0">

                    Communication Information

                </h5>

            </div>

            <div class="card-body">

                <div class="row">

                    <!-- Client -->

                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Client
                            <span class="text-danger">*</span>

                        </label>

                        <select
                            name="client_id"
                            class="form-select @error('client_id') is-invalid @enderror"
                            required>

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

                        @error('client_id')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                    <!-- User -->

                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            User
                            <span class="text-danger">*</span>

                        </label>

                        <select
                            name="user_id"
                            class="form-select @error('user_id') is-invalid @enderror"
                            required>

                            <option value="">

                                Select User

                            </option>

                            @foreach($users as $user)

                                <option
                                    value="{{ $user->id }}"
                                    @selected(old('user_id', auth()->id()) == $user->id)>

                                    {{ $user->name }}

                                </option>

                            @endforeach

                        </select>

                        @error('user_id')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>
                                        <!-- Channel -->

                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Channel

                            <span class="text-danger">*</span>

                        </label>

                        <select
                            name="channel"
                            class="form-select @error('channel') is-invalid @enderror"
                            required>

                            <option value="">

                                Select Channel

                            </option>

                            @foreach([
                                'Email','WhatsApp','SMS','Phone Call','Meeting','Internal Chat','Push Notification','Other'
                            ] as $channel)

                                <option
                                    value="{{ $channel }}"
                                    @selected(old('channel') == $channel)>

                                    {{ $channel }}

                                </option>

                            @endforeach

                        </select>

                        @error('channel')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                    <!-- Direction -->

                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Direction

                            <span class="text-danger">*</span>

                        </label>

                        <select
                            name="direction"
                            class="form-select @error('direction') is-invalid @enderror"
                            required>

                            <option value="">

                                Select Direction

                            </option>

                            <option
                                value="Incoming"
                                @selected(old('direction') == 'Incoming')>

                                Incoming

                            </option>

                            <option
                                value="Outgoing"
                                @selected(old('direction') == 'Outgoing')>

                                Outgoing

                            </option>

                        </select>

                        @error('direction')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                    <!-- Subject -->

                    <div class="col-md-12 mb-3">

                        <label class="form-label">

                            Subject

                        </label>

                        <input
                            type="text"
                            name="subject"
                            class="form-control @error('subject') is-invalid @enderror"
                            value="{{ old('subject') }}"
                            maxlength="255"
                            placeholder="Enter communication subject">

                        @error('subject')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                    <!-- Message -->

                    <div class="col-md-12 mb-3">

                        <label class="form-label">

                            Message

                            <span class="text-danger">*</span>

                        </label>

                        <textarea
                            name="message"
                            rows="8"
                            class="form-control @error('message') is-invalid @enderror"
                            placeholder="Write communication details..."
                            required>{{ old('message') }}</textarea>

                        @error('message')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>
                                        <!-- ========================================= -->
                    <!-- Sender Information -->
                    <!-- ========================================= -->

                    <div class="col-12">

                        <hr>

                        <h5 class="mb-3">

                            <i class="mdi mdi-account-arrow-right-outline me-2"></i>

                            Sender Information

                        </h5>

                    </div>

                    <!-- Sender Name -->

                    <div class="col-md-4 mb-3">

                        <label class="form-label">

                            Sender Name

                        </label>

                        <input
                            type="text"
                            name="sender_name"
                            class="form-control @error('sender_name') is-invalid @enderror"
                            value="{{ old('sender_name') }}"
                            maxlength="255"
                            placeholder="Enter sender name">

                        @error('sender_name')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                    <!-- Sender Email -->

                    <div class="col-md-4 mb-3">

                        <label class="form-label">

                            Sender Email

                        </label>

                        <input
                            type="email"
                            name="sender_email"
                            class="form-control @error('sender_email') is-invalid @enderror"
                            value="{{ old('sender_email') }}"
                            maxlength="255"
                            placeholder="Enter sender email">

                        @error('sender_email')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                    <!-- Sender Phone -->

                    <div class="col-md-4 mb-3">

                        <label class="form-label">

                            Sender Phone

                        </label>

                        <input
                            type="text"
                            name="sender_phone"
                            class="form-control @error('sender_phone') is-invalid @enderror"
                            value="{{ old('sender_phone') }}"
                            maxlength="20"
                            placeholder="Enter sender phone">

                        @error('sender_phone')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>
                                        <!-- ========================================= -->
                    <!-- Receiver Information -->
                    <!-- ========================================= -->

                    <div class="col-12">

                        <hr>

                        <h5 class="mb-3">

                            <i class="mdi mdi-account-arrow-left-outline me-2"></i>

                            Receiver Information

                        </h5>

                    </div>

                    <!-- Receiver Name -->

                    <div class="col-md-4 mb-3">

                        <label class="form-label">

                            Receiver Name

                        </label>

                        <input
                            type="text"
                            name="receiver_name"
                            class="form-control @error('receiver_name') is-invalid @enderror"
                            value="{{ old('receiver_name') }}"
                            maxlength="255"
                            placeholder="Enter receiver name">

                        @error('receiver_name')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                    <!-- Receiver Email -->

                    <div class="col-md-4 mb-3">

                        <label class="form-label">

                            Receiver Email

                        </label>

                        <input
                            type="email"
                            name="receiver_email"
                            class="form-control @error('receiver_email') is-invalid @enderror"
                            value="{{ old('receiver_email') }}"
                            maxlength="255"
                            placeholder="Enter receiver email">

                        @error('receiver_email')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                    <!-- Receiver Phone -->

                    <div class="col-md-4 mb-3">

                        <label class="form-label">

                            Receiver Phone

                        </label>

                        <input
                            type="text"
                            name="receiver_phone"
                            class="form-control @error('receiver_phone') is-invalid @enderror"
                            value="{{ old('receiver_phone') }}"
                            maxlength="20"
                            placeholder="Enter receiver phone">

                        @error('receiver_phone')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>
                                        <!-- ========================================= -->
                    <!-- Thread & Message Information -->
                    <!-- ========================================= -->

                    <div class="col-12">

                        <hr>

                        <h5 class="mb-3">

                            <i class="mdi mdi-forum-outline me-2"></i>

                            Thread Details

                        </h5>

                    </div>

                    <!-- Thread ID -->

                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Thread ID

                        </label>

                        <input
                            type="text"
                            name="thread_id"
                            class="form-control @error('thread_id') is-invalid @enderror"
                            value="{{ old('thread_id') }}"
                            maxlength="255"
                            placeholder="Enter thread ID">

                        @error('thread_id')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                    <!-- Message ID -->

                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Message ID

                        </label>

                        <input
                            type="text"
                            name="message_id"
                            class="form-control @error('message_id') is-invalid @enderror"
                            value="{{ old('message_id') }}"
                            maxlength="255"
                            placeholder="Enter message ID">

                        @error('message_id')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                    <!-- Communication Date -->

                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Communication Date & Time

                        </label>

                        <input
                            type="datetime-local"
                            name="communication_at"
                            class="form-control @error('communication_at') is-invalid @enderror"
                            value="{{ old('communication_at', now()->format('Y-m-d\TH:i')) }}">

                        @error('communication_at')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                    <!-- Status -->

                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Status

                            <span class="text-danger">*</span>

                        </label>

                        <select
                            name="status"
                            class="form-select @error('status') is-invalid @enderror"
                            required>

                            <option value="">

                                Select Status

                            </option>

                            @foreach([
                                'Draft',
                                'Pending',
                                'Sent',
                                'Delivered',
                                'Read',
                                'Failed'
                            ] as $status)

                                <option
                                    value="{{ $status }}"
                                    @selected(old('status') == $status)>

                                    {{ $status }}

                                </option>

                            @endforeach

                        </select>

                        @error('status')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>
                                        <!-- ========================================= -->
                    <!-- Attachment & Metadata -->
                    <!-- ========================================= -->

                    <div class="col-12">

                        <hr>

                        <h5 class="mb-3">

                            <i class="mdi mdi-paperclip me-2"></i>

                            Attachment & Metadata

                        </h5>

                    </div>

                    <!-- Has Attachment -->

                    <div class="col-md-4 mb-3">

                        <label class="form-label d-block">

                            Attachment

                        </label>

                        <div class="form-check form-switch">

                            <input
                                class="form-check-input"
                                type="checkbox"
                                id="has_attachment"
                                name="has_attachment"
                                value="1"
                                @checked(old('has_attachment'))>

                            <label
                                class="form-check-label"
                                for="has_attachment">

                                Has Attachment

                            </label>

                        </div>

                        @error('has_attachment')

                            <div class="text-danger small">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                    <!-- Metadata -->

                    <div class="col-md-8 mb-3">

                        <label class="form-label">

                            Metadata (JSON)

                        </label>

                        <textarea
                            name="metadata"
                            rows="5"
                            class="form-control @error('metadata') is-invalid @enderror"
                            placeholder='{"key":"value"}'>{{ old('metadata') }}</textarea>

                        <small class="text-muted">

                            Optional JSON data such as API payload,
                            email headers, WhatsApp IDs, etc.

                        </small>

                        @error('metadata')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                </div>

            </div>

        </div>
                <!-- ========================================= -->
        <!-- Submit Buttons -->
        <!-- ========================================= -->

        <div class="card shadow-sm">

            <div class="card-body">

                <div class="d-flex justify-content-end gap-2">

                    <a
                        href="{{ route('client-communications.index') }}"
                        class="btn btn-light border">

                        <i class="mdi mdi-arrow-left me-1"></i>

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

                        Save Communication

                    </button>

                </div>

            </div>

        </div>

    </form>

</div>

@endsection

@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {

    const attachmentCheckbox =
        document.getElementById('has_attachment');

    const metadata =
        document.querySelector(
            'textarea[name="metadata"]'
        );
            function updateAttachmentState() {

        if (!attachmentCheckbox) {

            return;

        }

        if (attachmentCheckbox.checked) {

            metadata.placeholder =
                '{"attachment":"invoice.pdf","size":"2.3 MB"}';

        } else {

            metadata.placeholder =
                '{"key":"value"}';

        }

    }

    if (attachmentCheckbox) {

        attachmentCheckbox.addEventListener(
            'change',
            updateAttachmentState
        );

        updateAttachmentState();

    }

    /*
    |--------------------------------------------------------------------------
    | Auto-fill sender information
    |--------------------------------------------------------------------------
    */

    const direction =
        document.querySelector(
            'select[name="direction"]'
        );

    const senderName =
        document.querySelector(
            'input[name="sender_name"]'
        );

    const receiverName =
        document.querySelector(
            'input[name="receiver_name"]'
        );

    if (direction) {

        direction.addEventListener('change', function () {

            if (this.value === 'Outgoing') {

                senderName.focus();

            } else if (this.value === 'Incoming') {

                receiverName.focus();

            }

        });

    }
        /*
    |--------------------------------------------------------------------------
    | Channel based placeholder
    |--------------------------------------------------------------------------
    */

    const channel =
        document.querySelector(
            'select[name="channel"]'
        );

    const subject =
        document.querySelector(
            'input[name="subject"]'
        );

    const message =
        document.querySelector(
            'textarea[name="message"]'
        );

    if (channel) {

        channel.addEventListener(
            'change',
            function () {

                switch (this.value) {

                    case 'Email':

                        subject.placeholder =
                            'Email subject';

                        message.placeholder =
                            'Write the email content...';

                    break;

                    case 'Phone':

                        subject.placeholder =
                            'Call Summary';

                        message.placeholder =
                            'Discussed topics during the phone call...';

                    break;

                    case 'Meeting':

                        subject.placeholder =
                            'Meeting Agenda';

                        message.placeholder =
                            'Meeting minutes...';

                    break;

                    case 'WhatsApp':

                        subject.placeholder =
                            'WhatsApp Conversation';

                        message.placeholder =
                            'WhatsApp message...';

                    break;

                    default:

                        subject.placeholder =
                            'Enter subject';

                        message.placeholder =
                            'Enter communication details...';

                }

            }
        );

    }
        /*
    |--------------------------------------------------------------------------
    | Validate Metadata JSON
    |--------------------------------------------------------------------------
    */

    const form = document.querySelector('form');

    form.addEventListener('submit', function (e) {

        const metadataField =
            document.querySelector(
                'textarea[name="metadata"]'
            );

        if (
            metadataField.value.trim() === ''
        ) {

            return;

        }

        try {

            JSON.parse(
                metadataField.value
            );

        } catch (error) {

            e.preventDefault();

            alert(
                'Metadata must contain valid JSON.'
            );

            metadataField.focus();

        }

    });
        /*
    |--------------------------------------------------------------------------
    | Auto-trim Inputs
    |--------------------------------------------------------------------------
    */

    document.querySelectorAll(
        'input[type="text"], input[type="email"], textarea'
    ).forEach(function (element) {

        element.addEventListener('blur', function () {

            this.value = this.value.trim();

        });

    });

    /*
    |--------------------------------------------------------------------------
    | Character Counter
    |--------------------------------------------------------------------------
    */

    const messageField =
        document.querySelector(
            'textarea[name="message"]'
        );

    const counter = document.createElement('small');

    counter.className = 'text-muted d-block mt-1';

    messageField.parentNode.appendChild(counter);

    function updateCounter() {

        counter.textContent =
            messageField.value.length +
            ' characters';

    }

    updateCounter();

    messageField.addEventListener(
        'input',
        updateCounter
    );
        /*
    |--------------------------------------------------------------------------
    | Default Communication Date
    |--------------------------------------------------------------------------
    */

    const communicationDate =
        document.querySelector(
            'input[name="communication_at"]'
        );

    if (
        communicationDate &&
        communicationDate.value === ''
    ) {

        const now = new Date();

        const offset =
            now.getTimezoneOffset();

        now.setMinutes(
            now.getMinutes() - offset
        );

        communicationDate.value =
            now.toISOString().slice(0, 16);

    }

});

</script>

@endpush