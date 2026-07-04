@extends('layouts.app')

@section('title', 'Client Contacts')

@section('content')

<div class="container-fluid">

    <!-- ============================================== -->
    <!-- Page Header -->
    <!-- ============================================== -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">

                Client Contacts

            </h2>

            <p class="text-muted mb-0">

                Manage all client contact persons.

            </p>

        </div>

        <div class="d-flex gap-2">

            @can('create', App\Models\ClientContact::class)

                <a
                    href="{{ route('client-contacts.create') }}"
                    class="btn btn-primary">

                    <i class="mdi mdi-plus-circle me-1"></i>

                    Add Contact

                </a>

            @endcan

            @can('restore', App\Models\ClientContact::class)

                <a
                    href="{{ route('client-contacts.trashed') }}"
                    class="btn btn-danger">

                    <i class="mdi mdi-delete-restore me-1"></i>

                    Trash

                </a>

            @endcan

        </div>

    </div>

    <!-- ============================================== -->
    <!-- Flash Messages -->
    <!-- ============================================== -->

    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show">

            {{ session('success') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"></button>

        </div>

    @endif

    @if(session('error'))

        <div class="alert alert-danger alert-dismissible fade show">

            {{ session('error') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"></button>

        </div>

    @endif

    <!-- ============================================== -->
    <!-- Filters -->
    <!-- ============================================== -->

    <div class="card shadow-sm mb-4">

        <div class="card-body">

            <form
                method="GET"
                action="{{ route('client-contacts.index') }}">

                <div class="row">

                    <!-- Client -->

                    <div class="col-md-3 mb-3">

                        <label class="form-label">

                            Client

                        </label>

                        <select
                            name="client_id"
                            class="form-select">

                            <option value="">

                                All Clients

                            </option>

                            @foreach($clients as $client)

                                <option
                                    value="{{ $client->id }}"
                                    @selected(request('client_id') == $client->id)>

                                    {{ $client->client_code }}

                                    -

                                    {{ $client->company_name }}

                                </option>

                            @endforeach

                        </select>

                    </div>
                                        <!-- Status -->

                    <div class="col-md-2 mb-3">

                        <label class="form-label">

                            Status

                        </label>

                        <select
                            name="is_active"
                            class="form-select">

                            <option value="">

                                All

                            </option>

                            <option
                                value="1"
                                @selected(request('is_active') === '1')>

                                Active

                            </option>

                            <option
                                value="0"
                                @selected(request('is_active') === '0')>

                                Inactive

                            </option>

                        </select>

                    </div>

                    <!-- Primary Contact -->

                    <div class="col-md-2 mb-3">

                        <label class="form-label">

                            Contact Type

                        </label>

                        <select
                            name="is_primary"
                            class="form-select">

                            <option value="">

                                All

                            </option>

                            <option
                                value="1"
                                @selected(request('is_primary') === '1')>

                                Primary

                            </option>

                            <option
                                value="0"
                                @selected(request('is_primary') === '0')>

                                Secondary

                            </option>

                        </select>

                    </div>

                    <!-- Search -->

                    <div class="col-md-3 mb-3">

                        <label class="form-label">

                            Search

                        </label>

                        <input
                            type="text"
                            name="search"
                            class="form-control"
                            value="{{ request('search') }}"
                            placeholder="Name, mobile or email">

                    </div>

                    <!-- Buttons -->

                    <div class="col-md-2 mb-3 d-flex align-items-end gap-2">

                        <button
                            type="submit"
                            class="btn btn-primary w-100">

                            <i class="mdi mdi-magnify me-1"></i>

                            Search

                        </button>

                        <a
                            href="{{ route('client-contacts.index') }}"
                            class="btn btn-light border">

                            <i class="mdi mdi-refresh"></i>

                        </a>

                    </div>

                </div>

            </form>

        </div>

    </div>

    <!-- ============================================== -->
    <!-- Contacts Table -->
    <!-- ============================================== -->

    <div class="card shadow-sm">

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">

                        <tr>

                            <th width="40">

                                <input
                                    type="checkbox"
                                    id="selectAll">

                            </th>

                            <th>

                                Client

                            </th>

                            <th>

                                Contact

                            </th>

                            <th>

                                Mobile

                            </th>

                            <th>

                                Email

                            </th>

                            <th>

                                Status

                            </th>

                            <th>

                                Actions

                            </th>

                        </tr>

                    </thead>

                    <tbody>
                                                @forelse($contacts as $contact)

                            <tr>

                                <td>

                                    <input
                                        type="checkbox"
                                        class="row-check"
                                        value="{{ $contact->id }}">

                                </td>

                                <!-- Client -->

                                <td>

                                    <div class="fw-semibold">

                                        {{ optional($contact->client)->company_name }}

                                    </div>

                                    <small class="text-muted">

                                        {{ optional($contact->client)->client_code }}

                                    </small>

                                </td>

                                <!-- Contact -->

                                <td>

                                    <div class="fw-semibold">

                                        {{ $contact->full_name ?: trim($contact->first_name . ' ' . $contact->last_name) }}

                                    </div>

                                    @if($contact->designation)

                                        <small class="text-muted d-block">

                                            {{ $contact->designation }}

                                        </small>

                                    @endif

                                    @if($contact->department)

                                        <small class="text-muted d-block">

                                            {{ $contact->department }}

                                        </small>

                                    @endif

                                    @if($contact->is_primary)

                                        <span class="badge bg-primary mt-1">

                                            Primary

                                        </span>

                                    @endif

                                </td>

                                <!-- Mobile -->

                                <td>

                                    <div>

                                        {{ $contact->mobile ?: '-' }}

                                    </div>

                                    @if($contact->whatsapp_number)

                                        <small class="text-success">

                                            <i class="mdi mdi-whatsapp"></i>

                                            {{ $contact->whatsapp_number }}

                                        </small>

                                    @endif

                                </td>

                                <!-- Email -->

                                <td>

                                    {{ $contact->email ?: '-' }}

                                </td>
                                                                <!-- Status -->

                                <td>

                                    @if($contact->is_active)

                                        <span class="badge bg-success">

                                            Active

                                        </span>

                                    @else

                                        <span class="badge bg-danger">

                                            Inactive

                                        </span>

                                    @endif

                                    <div class="mt-1">

                                        @if($contact->receive_email)

                                            <span class="badge bg-primary">

                                                Email

                                            </span>

                                        @endif

                                        @if($contact->receive_whatsapp)

                                            <span class="badge bg-success">

                                                WhatsApp

                                            </span>

                                        @endif

                                        @if($contact->receive_sms)

                                            <span class="badge bg-warning text-dark">

                                                SMS

                                            </span>

                                        @endif

                                    </div>

                                </td>

                                <!-- Actions -->

                                <td>

                                    <div class="btn-group">

                                        @can('view', $contact)

                                            <a
                                                href="{{ route('client-contacts.show', $contact) }}"
                                                class="btn btn-sm btn-primary"
                                                title="View">

                                                <i class="mdi mdi-eye"></i>

                                            </a>

                                        @endcan

                                        @can('update', $contact)

                                            <a
                                                href="{{ route('client-contacts.edit', $contact) }}"
                                                class="btn btn-sm btn-warning"
                                                title="Edit">

                                                <i class="mdi mdi-pencil"></i>

                                            </a>

                                        @endcan

                                        @can('delete', $contact)

                                            <form
                                                action="{{ route('client-contacts.destroy', $contact) }}"
                                                method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Are you sure you want to delete this contact?');">

                                                @csrf

                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="btn btn-sm btn-danger"
                                                    title="Delete">

                                                    <i class="mdi mdi-delete"></i>

                                                </button>

                                            </form>

                                        @endcan

                                    </div>

                                </td>

                            </tr>
                                                    @empty

                            <tr>

                                <td
                                    colspan="7"
                                    class="text-center py-5">

                                    <div class="text-muted">

                                        <i
                                            class="mdi mdi-account-group-outline"
                                            style="font-size:60px;"></i>

                                        <h5 class="mt-3">

                                            No Contacts Found

                                        </h5>

                                        <p class="mb-3">

                                            There are no client contacts matching your filters.

                                        </p>

                                        @can('create', App\Models\ClientContact::class)

                                            <a
                                                href="{{ route('client-contacts.create') }}"
                                                class="btn btn-primary">

                                                <i class="mdi mdi-plus-circle me-1"></i>

                                                Add First Contact

                                            </a>

                                        @endcan

                                    </div>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

        @if($contacts->hasPages())

            <div class="card-footer">

                <div class="d-flex justify-content-between align-items-center">

                    <div class="text-muted">

                        Showing

                        {{ $contacts->firstItem() }}

                        to

                        {{ $contacts->lastItem() }}

                        of

                        {{ $contacts->total() }}

                        contacts

                    </div>

                    {{ $contacts->links() }}

                </div>

            </div>

        @endif

    </div>

</div>

@endsection

@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {

    const selectAll =
        document.getElementById('selectAll');

    const rowChecks =
        document.querySelectorAll('.row-check');
            /*
    |--------------------------------------------------------------------------
    | Select / Unselect All
    |--------------------------------------------------------------------------
    */

    if (selectAll) {

        selectAll.addEventListener(
            'change',
            function () {

                rowChecks.forEach(function (checkbox) {

                    checkbox.checked = this.checked;

                    const row = checkbox.closest('tr');

                    if (this.checked) {

                        row.classList.add('table-active');

                    } else {

                        row.classList.remove('table-active');

                    }

                }, this);

            }
        );

    }

    /*
    |--------------------------------------------------------------------------
    | Highlight Selected Rows
    |--------------------------------------------------------------------------
    */

    rowChecks.forEach(function (checkbox) {

        checkbox.addEventListener(
            'change',
            function () {

                const row = this.closest('tr');

                if (this.checked) {

                    row.classList.add('table-active');

                } else {

                    row.classList.remove('table-active');

                }

                const checked =
                    document.querySelectorAll(
                        '.row-check:checked'
                    ).length;

                if (selectAll) {

                    selectAll.checked =
                        checked === rowChecks.length &&
                        rowChecks.length > 0;

                }

            }
        );

    });
        /*
    |--------------------------------------------------------------------------
    | Auto Submit Filters
    |--------------------------------------------------------------------------
    */

    document.querySelectorAll(

        'select[name="client_id"], \
         select[name="is_active"], \
         select[name="is_primary"]'

    ).forEach(function (element) {

        element.addEventListener(
            'change',
            function () {

                this.form.submit();

            }
        );

    });

    /*
    |--------------------------------------------------------------------------
    | Search on Enter
    |--------------------------------------------------------------------------
    */

    const searchInput =
        document.querySelector(
            'input[name="search"]'
        );

    if (searchInput) {

        searchInput.addEventListener(
            'keypress',
            function (event) {

                if (event.key === 'Enter') {

                    this.closest('form').submit();

                }

            }
        );

    }

    /*
    |--------------------------------------------------------------------------
    | Auto Hide Alerts
    |--------------------------------------------------------------------------
    */

    document.querySelectorAll('.alert').forEach(function (alert) {

        setTimeout(function () {

            alert.classList.remove('show');

            setTimeout(function () {

                alert.remove();

            }, 300);

        }, 5000);

    });
        /*
    |--------------------------------------------------------------------------
    | Double Click Row To View
    |--------------------------------------------------------------------------
    */

    document.querySelectorAll(
        'tbody tr'
    ).forEach(function (row) {

        const viewButton = row.querySelector(
            'a[href*="/client-contacts/"]'
        );

        if (!viewButton) {

            return;

        }

        row.style.cursor = 'pointer';

        row.addEventListener(
            'dblclick',
            function (event) {

                if (

                    event.target.closest('a') ||

                    event.target.closest('button') ||

                    event.target.closest('input') ||

                    event.target.closest('form')

                ) {

                    return;

                }

                window.location =
                    viewButton.href;

            }
        );

    });

    /*
    |--------------------------------------------------------------------------
    | Enable Bootstrap Tooltips
    |--------------------------------------------------------------------------
    */

    document.querySelectorAll(
        '[data-bs-toggle="tooltip"]'
    ).forEach(function (element) {

        new bootstrap.Tooltip(
            element
        );

    });
        /*
    |--------------------------------------------------------------------------
    | Remember Scroll Position
    |--------------------------------------------------------------------------
    */

    window.addEventListener(
        'beforeunload',
        function () {

            sessionStorage.setItem(
                'clientContactsScroll',
                window.scrollY
            );

        }
    );

    const savedScroll =
        sessionStorage.getItem(
            'clientContactsScroll'
        );

    if (savedScroll !== null) {

        window.scrollTo(
            0,
            parseInt(savedScroll)
        );

    }

    /*
    |--------------------------------------------------------------------------
    | Remove Saved Scroll After Load
    |--------------------------------------------------------------------------
    */

    window.addEventListener(
        'load',
        function () {

            sessionStorage.removeItem(
                'clientContactsScroll'
            );

        }
    );
        /*
    |--------------------------------------------------------------------------
    | Keyboard Shortcut
    |--------------------------------------------------------------------------
    | Press "N" to create a new contact
    |--------------------------------------------------------------------------
    */

    document.addEventListener(
        'keydown',
        function (event) {

            if (

                event.target.tagName === 'INPUT' ||

                event.target.tagName === 'TEXTAREA' ||

                event.target.tagName === 'SELECT'

            ) {

                return;

            }

            if (

                event.key.toLowerCase() === 'n' &&

                !event.ctrlKey &&

                !event.metaKey

            ) {

                window.location =
                    "{{ route('client-contacts.create') }}";

            }

        }
    );

    /*
    |--------------------------------------------------------------------------
    | Bulk Delete Button (Optional)
    |--------------------------------------------------------------------------
    */

    const bulkDeleteButton =
        document.getElementById(
            'bulkDeleteBtn'
        );

    if (bulkDeleteButton) {

        bulkDeleteButton.addEventListener(
            'click',
            function () {

                const ids = [];

                document
                    .querySelectorAll(
                        '.row-check:checked'
                    )
                    .forEach(function (checkbox) {

                        ids.push(
                            checkbox.value
                        );

                    });

                if (ids.length === 0) {

                    alert(
                        'Please select at least one contact.'
                    );

                    return;

                }

                if (
                    !confirm(
                        'Delete selected contacts?'
                    )
                ) {

                    return;

                }

                document.getElementById(
                    'bulkIds'
                ).value =
                    JSON.stringify(ids);

                document.getElementById(
                    'bulkDeleteForm'
                ).submit();

            }
        );

    }
        /*
    |--------------------------------------------------------------------------
    | Export Table (Optional)
    |--------------------------------------------------------------------------
    */

    const exportButton =
        document.getElementById(
            'exportContacts'
        );

    if (exportButton) {

        exportButton.addEventListener(
            'click',
            function () {

                window.print();

            }
        );

    }

    /*
    |--------------------------------------------------------------------------
    | Copy Email Address
    |--------------------------------------------------------------------------
    */

    document.querySelectorAll(
        '.copy-email'
    ).forEach(function (button) {

        button.addEventListener(
            'click',
            function () {

                navigator.clipboard.writeText(

                    this.dataset.email

                );

                this.innerHTML =
                    '<i class="mdi mdi-check"></i>';

                setTimeout(() => {

                    this.innerHTML =
                        '<i class="mdi mdi-content-copy"></i>';

                }, 1500);

            }
        );

    });

    /*
    |--------------------------------------------------------------------------
    | Copy Mobile Number
    |--------------------------------------------------------------------------
    */

    document.querySelectorAll(
        '.copy-mobile'
    ).forEach(function (button) {

        button.addEventListener(
            'click',
            function () {

                navigator.clipboard.writeText(

                    this.dataset.mobile

                );

                this.innerHTML =
                    '<i class="mdi mdi-check"></i>';

                setTimeout(() => {

                    this.innerHTML =
                        '<i class="mdi mdi-cellphone"></i>';

                }, 1500);

            }
        );

    });
        /*
    |--------------------------------------------------------------------------
    | Quick Call
    |--------------------------------------------------------------------------
    */

    document.querySelectorAll(
        '.quick-call'
    ).forEach(function (button) {

        button.addEventListener(
            'click',
            function () {

                const mobile =
                    this.dataset.mobile;

                if (!mobile) {

                    alert(
                        'Mobile number not available.'
                    );

                    return;

                }

                window.location.href =
                    'tel:' + mobile;

            }
        );

    });

    /*
    |--------------------------------------------------------------------------
    | Quick WhatsApp
    |--------------------------------------------------------------------------
    */

    document.querySelectorAll(
        '.quick-whatsapp'
    ).forEach(function (button) {

        button.addEventListener(
            'click',
            function () {

                const number =
                    this.dataset.whatsapp;

                if (!number) {

                    alert(
                        'WhatsApp number not available.'
                    );

                    return;

                }

                window.open(
                    'https://wa.me/' + number,
                    '_blank'
                );

            }
        );

    });

    /*
    |--------------------------------------------------------------------------
    | Quick Email
    |--------------------------------------------------------------------------
    */

    document.querySelectorAll(
        '.quick-email'
    ).forEach(function (button) {

        button.addEventListener(
            'click',
            function () {

                const email =
                    this.dataset.email;

                if (!email) {

                    alert(
                        'Email address not available.'
                    );

                    return;

                }

                window.location.href =
                    'mailto:' + email;

            }
        );

    });
        /*
    |--------------------------------------------------------------------------
    | Refresh Table
    |--------------------------------------------------------------------------
    */

    const refreshButton =
        document.getElementById(
            'refreshTable'
        );

    if (refreshButton) {

        refreshButton.addEventListener(
            'click',
            function () {

                window.location.reload();

            }
        );

    }

    /*
    |--------------------------------------------------------------------------
    | Optional Auto Refresh
    |--------------------------------------------------------------------------
    */

    /*
    setInterval(function () {

        window.location.reload();

    }, 60000);
    */

    /*
    |--------------------------------------------------------------------------
    | Initialize Bootstrap Popovers
    |--------------------------------------------------------------------------
    */

    document.querySelectorAll(
        '[data-bs-toggle="popover"]'
    ).forEach(function (element) {

        new bootstrap.Popover(
            element
        );

    });

    /*
    |--------------------------------------------------------------------------
    | Prevent Empty Search Submit
    |--------------------------------------------------------------------------
    */

    const searchForm =
        document.querySelector('form');

    if (searchForm && searchInput) {

        searchForm.addEventListener(
            'submit',
            function () {

                searchInput.value =
                    searchInput.value.trim();

            }
        );

    }
        /*
    |--------------------------------------------------------------------------
    | Close Script
    |--------------------------------------------------------------------------
    */

});

</script>

@endpush