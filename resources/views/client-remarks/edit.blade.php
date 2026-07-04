@extends('layouts.app')

@section('title', 'Edit Client Remark')

@section('content')

<div class="container-fluid">

    <!-- ===================================================== -->
    <!-- Page Header -->
    <!-- ===================================================== -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">

                Edit Client Remark

            </h2>

            <p class="text-muted mb-0">

                Update the remark details, status, attachment and visibility.

            </p>

        </div>

        <div>

            <a
                href="{{ route('client-remarks.show', $clientRemark) }}"
                class="btn btn-info">

                <i class="mdi mdi-eye me-1"></i>

                View

            </a>

            <a
                href="{{ route('client-remarks.index') }}"
                class="btn btn-secondary">

                <i class="mdi mdi-arrow-left me-1"></i>

                Back

            </a>

        </div>

    </div>

    @if ($errors->any())

        <div class="alert alert-danger">

            <strong>Please fix the following errors:</strong>

            <ul class="mb-0 mt-2">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif

    <form
        action="{{ route('client-remarks.update', $clientRemark) }}"
        method="POST"
        enctype="multipart/form-data">

        @csrf

        @method('PUT')

        <!-- ===================================================== -->
        <!-- Client Information -->
        <!-- ===================================================== -->

        <div class="card shadow-sm mb-4">

            <div class="card-header">

                <h5 class="mb-0">

                    <i class="mdi mdi-domain me-2"></i>

                    Client Information

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
                            class="form-select @error('client_id') is-invalid @enderror">

                            <option value="">

                                Select Client

                            </option>

                            @foreach($clients as $client)

                                <option
                                    value="{{ $client->id }}"
                                    @selected(old('client_id', $clientRemark->client_id) == $client->id)>

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
                            class="form-select @error('user_id') is-invalid @enderror">

                            <option value="">

                                Select User

                            </option>
                                                        @foreach($users as $user)

                                <option
                                    value="{{ $user->id }}"
                                    @selected(old('user_id', $clientRemark->user_id) == $user->id)>

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

                    <!-- Reply To -->

                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Reply To

                        </label>

                        <select
                            name="parent_id"
                            class="form-select @error('parent_id') is-invalid @enderror">

                            <option value="">

                                None

                            </option>

                            @foreach($parentRemarks as $parent)

                                @if($parent->id != $clientRemark->id)

                                    <option
                                        value="{{ $parent->id }}"
                                        @selected(old('parent_id', $clientRemark->parent_id) == $parent->id)>

                                        #{{ $parent->id }}
                                        -
                                        {{ \Illuminate\Support\Str::limit($parent->remark, 60) }}

                                    </option>

                                @endif

                            @endforeach

                        </select>

                        @error('parent_id')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                    <!-- Mention User -->

                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Mention User

                        </label>

                        <select
                            name="mentioned_user_id"
                            class="form-select @error('mentioned_user_id') is-invalid @enderror">

                            <option value="">

                                None

                            </option>

                            @foreach($users as $user)

                                <option
                                    value="{{ $user->id }}"
                                    @selected(old('mentioned_user_id', $clientRemark->mentioned_user_id) == $user->id)>

                                    {{ $user->name }}

                                </option>

                            @endforeach

                        </select>

                        @error('mentioned_user_id')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                </div>

            </div>

        </div>

        <!-- ===================================================== -->
        <!-- Remark Details -->
        <!-- ===================================================== -->

        <div class="card shadow-sm mb-4">

            <div class="card-header">

                <h5 class="mb-0">

                    <i class="mdi mdi-note-edit-outline me-2"></i>

                    Remark Details

                </h5>

            </div>

            <div class="card-body">

                <div class="row">
                                        <!-- Remark Type -->

                    <div class="col-md-4 mb-3">

                        <label class="form-label">

                            Remark Type
                            <span class="text-danger">*</span>

                        </label>

                        <select
                            name="type"
                            class="form-select @error('type') is-invalid @enderror">

                            @foreach([
                                'General',
                                'Follow Up',
                                'Important',
                                'Payment',
                                'Compliance',
                                'Registration',
                                'Document',
                                'Meeting',
                                'Phone Call',
                                'Email',
                                'WhatsApp'
                            ] as $type)

                                <option
                                    value="{{ $type }}"
                                    @selected(old('type', $clientRemark->type) == $type)>

                                    {{ $type }}

                                </option>

                            @endforeach

                        </select>

                        @error('type')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                    <!-- Status -->

                    <div class="col-md-4 mb-3">

                        <label class="form-label">

                            Status
                            <span class="text-danger">*</span>

                        </label>

                        <select
                            name="status"
                            class="form-select @error('status') is-invalid @enderror">

                            @foreach([
                                'Open',
                                'In Progress',
                                'Resolved',
                                'Closed'
                            ] as $status)

                                <option
                                    value="{{ $status }}"
                                    @selected(old('status', $clientRemark->status) == $status)>

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

                    <!-- Read At -->

                    <div class="col-md-4 mb-3">

                        <label class="form-label">

                            Read At

                        </label>

                        <input
                            type="datetime-local"
                            name="read_at"
                            class="form-control @error('read_at') is-invalid @enderror"
                            value="{{ old('read_at', optional($clientRemark->read_at)->format('Y-m-d\TH:i')) }}">

                        @error('read_at')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                    <!-- Remark -->

                    <div class="col-12 mb-3">

                        <label class="form-label">

                            Remark
                            <span class="text-danger">*</span>

                        </label>

                        <textarea
                            name="remark"
                            rows="8"
                            class="form-control @error('remark') is-invalid @enderror"
                            placeholder="Write your remark here...">{{ old('remark', $clientRemark->remark) }}</textarea>

                        @error('remark')

                            <div class="invalid-feedback d-block">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                </div>

            </div>

        </div>
                <!-- ===================================================== -->
        <!-- Attachment & Options -->
        <!-- ===================================================== -->

        <div class="card shadow-sm mb-4">

            <div class="card-header">

                <h5 class="mb-0">

                    <i class="mdi mdi-paperclip me-2"></i>

                    Attachment & Options

                </h5>

            </div>

            <div class="card-body">

                <div class="row">

                    <!-- Current Attachment -->

                    <div class="col-md-12 mb-3">

                        <label class="form-label">

                            Current Attachment

                        </label>

                        @if($clientRemark->attachment)

                            <div class="border rounded p-3 bg-light">

                                <i class="mdi mdi-paperclip me-2"></i>

                                {{ basename($clientRemark->attachment) }}

                                <a
                                    href="{{ asset('storage/'.$clientRemark->attachment) }}"
                                    target="_blank"
                                    class="btn btn-sm btn-outline-primary float-end">

                                    <i class="mdi mdi-eye"></i>

                                    View

                                </a>

                            </div>

                        @else

                            <div class="text-muted">

                                No attachment uploaded.

                            </div>

                        @endif

                    </div>

                    <!-- Upload New Attachment -->

                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Replace Attachment

                        </label>

                        <input
                            type="file"
                            name="attachment"
                            class="form-control @error('attachment') is-invalid @enderror">

                        <small class="text-muted">

                            Leave empty to keep the existing attachment.

                        </small>

                        @error('attachment')

                            <div class="invalid-feedback d-block">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                    <!-- Private -->

                    <div class="col-md-3 mb-3 d-flex align-items-end">

                        <div class="form-check form-switch">

                            <input
                                type="hidden"
                                name="is_private"
                                value="0">

                            <input
                                type="checkbox"
                                class="form-check-input"
                                id="is_private"
                                name="is_private"
                                value="1"
                                @checked(old('is_private', $clientRemark->is_private))>

                            <label
                                class="form-check-label"
                                for="is_private">

                                Private Remark

                            </label>

                        </div>

                    </div>

                    <!-- Pinned -->

                    <div class="col-md-3 mb-3 d-flex align-items-end">

                        <div class="form-check form-switch">

                            <input
                                type="hidden"
                                name="is_pinned"
                                value="0">

                            <input
                                type="checkbox"
                                class="form-check-input"
                                id="is_pinned"
                                name="is_pinned"
                                value="1"
                                @checked(old('is_pinned', $clientRemark->is_pinned))>

                            <label
                                class="form-check-label"
                                for="is_pinned">

                                Pin Remark

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

                <div class="d-flex justify-content-between align-items-center flex-wrap">

                    <div>

                        <small class="text-muted">

                            Remark ID:
                            <strong>#{{ $clientRemark->id }}</strong>

                            &nbsp;|&nbsp;

                            Created:
                            <strong>

                                {{ optional($clientRemark->created_at)->format('d M Y h:i A') }}

                            </strong>

                        </small>

                    </div>

                    <div class="d-flex gap-2">

                        <a
                            href="{{ route('client-remarks.show', $clientRemark) }}"
                            class="btn btn-info">

                            <i class="mdi mdi-eye me-1"></i>

                            View

                        </a>

                        <a
                            href="{{ route('client-remarks.index') }}"
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

                            Update Remark

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

    const attachment = document.querySelector(
        'input[name="attachment"]'
    );

    if (attachment) {

        attachment.addEventListener('change', function () {

            if (!this.files.length) {

                return;

            }

            const file = this.files[0];
                        const maxSize = 10 * 1024 * 1024;

            if (file.size > maxSize) {

                alert('Maximum attachment size is 10 MB.');

                this.value = '';

                return;

            }

            const allowedExtensions = [

                'pdf',
                'jpg',
                'jpeg',
                'png',
                'webp',
                'doc',
                'docx',
                'xls',
                'xlsx',
                'csv',
                'zip'

            ];

            const extension = file.name
                .split('.')
                .pop()
                .toLowerCase();

            if (!allowedExtensions.includes(extension)) {

                alert('Invalid attachment type selected.');

                this.value = '';

                return;

            }

        });

    }

    const remark = document.querySelector(
        'textarea[name="remark"]'
    );

    if (remark) {

        const counter = document.createElement('small');

        counter.className = 'text-muted d-block mt-2';

        remark.parentNode.appendChild(counter);

        const updateCounter = function () {

            counter.textContent =
                remark.value.length +
                ' / 10000 characters';

        };

        remark.addEventListener(
            'input',
            updateCounter
        );

        updateCounter();

    }

});
const typeSelect = document.querySelector(
    'select[name="type"]'
);

const statusSelect = document.querySelector(
    'select[name="status"]'
);

if (typeSelect && statusSelect) {

    typeSelect.addEventListener('change', function () {

        if (
            this.value === 'Follow Up' &&
            statusSelect.value === 'Closed'
        ) {

            statusSelect.value = 'Open';

        }

    });

}

const privateCheckbox = document.getElementById(
    'is_private'
);

const pinnedCheckbox = document.getElementById(
    'is_pinned'
);

if (privateCheckbox && pinnedCheckbox) {

    privateCheckbox.addEventListener('change', function () {

        if (this.checked) {

            pinnedCheckbox.checked = false;

        }

    });

}

const userSelect = document.querySelector(
    'select[name="user_id"]'
);

const mentionSelect = document.querySelector(
    'select[name="mentioned_user_id"]'
);

if (userSelect && mentionSelect) {

    userSelect.addEventListener('change', function () {

        if (
            mentionSelect.value &&
            mentionSelect.value === this.value
        ) {

            mentionSelect.value = '';

        }

    });

}

const parentSelect = document.querySelector(
    'select[name="parent_id"]'
);

if (parentSelect && typeSelect) {

    parentSelect.addEventListener('change', function () {

        if (this.value !== '') {

            typeSelect.value = 'Follow Up';

        }

    });

}
const form = document.querySelector('form');

if (form) {

    form.addEventListener('submit', function (event) {

        const client = document.querySelector(
            'select[name="client_id"]'
        );

        const user = document.querySelector(
            'select[name="user_id"]'
        );

        const type = document.querySelector(
            'select[name="type"]'
        );

        const status = document.querySelector(
            'select[name="status"]'
        );

        const remark = document.querySelector(
            'textarea[name="remark"]'
        );

        if (
            !client.value ||
            !user.value ||
            !type.value ||
            !status.value ||
            remark.value.trim() === ''
        ) {

            event.preventDefault();

            alert(
                'Please complete all required fields before submitting.'
            );

            return false;

        }

        if (remark.value.trim().length < 3) {

            event.preventDefault();

            alert(
                'Remark must contain at least 3 characters.'
            );

            remark.focus();

            return false;

        }

    });

}
const clientSelect = document.querySelector(
    'select[name="client_id"]'
);

if (clientSelect) {

    clientSelect.addEventListener('change', function () {

        if (!this.value) {

            return;

        }

        document.title =
            'Edit Remark - Client #' + this.value;

    });

}

const readAtInput = document.querySelector(
    'input[name="read_at"]'
);

if (readAtInput) {

    readAtInput.addEventListener('change', function () {

        if (!this.value) {

            return;

        }

        const selectedDate = new Date(this.value);

        const currentDate = new Date();

        if (selectedDate > currentDate) {

            alert(
                'Read time cannot be a future date.'
            );

            this.value = '';

        }

    });

}

const attachmentInput = document.querySelector(
    'input[name="attachment"]'
);

if (attachmentInput) {

    attachmentInput.addEventListener('change', function () {

        if (!this.files.length) {

            return;

        }

        const file = this.files[0];

        const info = document.createElement('div');

        info.className = 'small text-success mt-2';

        info.innerHTML =
            '<strong>Selected:</strong> ' +
            file.name +
            ' (' +
            Math.round(file.size / 1024) +
            ' KB)';

        const oldInfo = this.parentNode.querySelector(
            '.text-success'
        );

        if (oldInfo) {

            oldInfo.remove();

        }

        this.parentNode.appendChild(info);

    });

}
const remarkTextarea = document.querySelector(
    'textarea[name="remark"]'
);

if (remarkTextarea) {

    remarkTextarea.addEventListener('paste', function () {

        setTimeout(function () {

            if (remarkTextarea.value.length > 10000) {

                remarkTextarea.value = remarkTextarea.value.substring(
                    0,
                    10000
                );

                alert(
                    'Maximum remark length is 10000 characters.'
                );

            }

        }, 10);

    });

}

const resetButton = document.querySelector(
    'button[type="reset"]'
);

if (resetButton) {

    resetButton.addEventListener('click', function () {

        setTimeout(function () {

            const info = document.querySelector(
                '.text-success'
            );

            if (info) {

                info.remove();

            }

            if (remarkTextarea) {

                remarkTextarea.dispatchEvent(
                    new Event('input')
                );

            }

        }, 50);

    });

}

window.addEventListener('beforeunload', function (event) {

    if (
        remarkTextarea &&
        remarkTextarea.value.trim().length > 0
    ) {

        event.preventDefault();

        event.returnValue = '';

    }

});
const autoResize = function (element) {

    element.style.height = 'auto';

    element.style.height = element.scrollHeight + 'px';

};

if (remarkTextarea) {

    autoResize(remarkTextarea);

    remarkTextarea.addEventListener('input', function () {

        autoResize(this);

    });

}

const statusBadge = document.createElement('span');

statusBadge.className = 'badge bg-primary ms-2';

if (statusSelect) {

    statusSelect.parentNode.querySelector('label')
        .appendChild(statusBadge);

    const updateStatusBadge = function () {

        statusBadge.textContent = statusSelect.value || 'Not Selected';

        statusBadge.classList.remove(
            'bg-primary',
            'bg-warning',
            'bg-success',
            'bg-secondary'
        );

        switch (statusSelect.value) {

            case 'Open':

                statusBadge.classList.add('bg-warning');

                break;

            case 'In Progress':

                statusBadge.classList.add('bg-primary');

                break;

            case 'Resolved':

                statusBadge.classList.add('bg-success');

                break;

            case 'Closed':

                statusBadge.classList.add('bg-secondary');

                break;

            default:

                statusBadge.classList.add('bg-primary');

        }

    };

    statusSelect.addEventListener(
        'change',
        updateStatusBadge
    );

    updateStatusBadge();

}

const typeBadge = document.createElement('span');

typeBadge.className = 'badge bg-info ms-2';

if (typeSelect) {

    typeSelect.parentNode.querySelector('label')
        .appendChild(typeBadge);

    const updateTypeBadge = function () {

        typeBadge.textContent =
            typeSelect.value || 'None';

    };

    typeSelect.addEventListener(
        'change',
        updateTypeBadge
    );

    updateTypeBadge();

}
const privateLabel = document.querySelector(
    'label[for="is_private"]'
);

const pinnedLabel = document.querySelector(
    'label[for="is_pinned"]'
);

if (privateCheckbox && privateLabel) {

    privateCheckbox.addEventListener('change', function () {

        privateLabel.innerHTML = this.checked
            ? '<span class="text-danger">Private Remark</span>'
            : 'Private Remark';

    });

}

if (pinnedCheckbox && pinnedLabel) {

    pinnedCheckbox.addEventListener('change', function () {

        pinnedLabel.innerHTML = this.checked
            ? '<span class="text-warning">Pinned Remark</span>'
            : 'Pin Remark';

    });

}

const today = new Date();

if (readAtInput && !readAtInput.value) {

    const yyyy = today.getFullYear();

    const mm = String(today.getMonth() + 1).padStart(2, '0');

    const dd = String(today.getDate()).padStart(2, '0');

    const hh = String(today.getHours()).padStart(2, '0');

    const ii = String(today.getMinutes()).padStart(2, '0');

    readAtInput.value =
        `${yyyy}-${mm}-${dd}T${hh}:${ii}`;

}

});

</script>

@endpush