@extends('layouts.app')

@section('title', 'Client Communications')

@section('content')

<div class="container-fluid">

    <!-- ============================================= -->
    <!-- Page Header -->
    <!-- ============================================= -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">

                Client Communications

            </h2>

            <p class="text-muted mb-0">

                Manage all client communications from one place.

            </p>

        </div>

        <div class="d-flex gap-2">

            @can('create', App\Models\ClientCommunication::class)

                <a
                    href="{{ route('client-communications.create') }}"
                    class="btn btn-primary">

                    <i class="mdi mdi-plus-circle me-1"></i>

                    Add Communication

                </a>

            @endcan

            @can('restore', App\Models\ClientCommunication::class)

                <a
                    href="{{ route('client-communications.trashed') }}"
                    class="btn btn-danger">

                    <i class="mdi mdi-delete-restore me-1"></i>

                    Trash

                </a>

            @endcan

        </div>

    </div>

    <!-- ============================================= -->
    <!-- Flash Messages -->
    <!-- ============================================= -->

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

    <!-- ============================================= -->
    <!-- Filters -->
    <!-- ============================================= -->

    <div class="card shadow-sm mb-4">

        <div class="card-body">

            <form
                method="GET"
                action="{{ route('client-communications.index') }}">

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
                                        <!-- Channel -->

                    <div class="col-md-2 mb-3">

                        <label class="form-label">

                            Channel

                        </label>

                        <select
                            name="channel"
                            class="form-select">

                            <option value="">

                                All Channels

                            </option>

                            @foreach([
                                'Email',
                                'Phone',
                                'WhatsApp',
                                'SMS',
                                'Meeting',
                                'Video Call',
                                'Telegram',
                                'Slack',
                                'Microsoft Teams',
                                'In Person',
                                'Other'
                            ] as $channel)

                                <option
                                    value="{{ $channel }}"
                                    @selected(request('channel') == $channel)>

                                    {{ $channel }}

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
                            name="status"
                            class="form-select">

                            <option value="">

                                All Status

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
                                    @selected(request('status') == $status)>

                                    {{ $status }}

                                </option>

                            @endforeach

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
                            placeholder="Subject or message...">

                    </div>

                    <!-- Actions -->

                    <div class="col-md-2 mb-3 d-flex align-items-end gap-2">

                        <button
                            type="submit"
                            class="btn btn-primary w-100">

                            <i class="mdi mdi-magnify me-1"></i>

                            Search

                        </button>

                        <a
                            href="{{ route('client-communications.index') }}"
                            class="btn btn-light border">

                            <i class="mdi mdi-refresh"></i>

                        </a>

                    </div>

                </div>

            </form>

        </div>

    </div>

    <!-- ============================================= -->
    <!-- Communications Table -->
    <!-- ============================================= -->

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

                                Channel

                            </th>

                            <th>

                                Direction

                            </th>

                            <th>

                                Subject

                            </th>

                            <th>

                                Status

                            </th>

                            <th>

                                Date

                            </th>

                            <th width="170">

                                Actions

                            </th>

                        </tr>

                    </thead>

                    <tbody>
                                                @forelse($communications as $communication)

                            <tr>

                                <td>

                                    <input
                                        type="checkbox"
                                        class="row-check"
                                        value="{{ $communication->id }}">

                                </td>

                                <!-- Client -->

                                <td>

                                    <div class="fw-semibold">

                                        {{ optional($communication->client)->company_name }}

                                    </div>

                                    <small class="text-muted">

                                        {{ optional($communication->client)->client_code }}

                                    </small>

                                </td>

                                <!-- Channel -->

                                <td>

                                    @php

                                        $channelClass = match($communication->channel) {

                                            'Email' => 'primary',

                                            'Phone' => 'warning',

                                            'WhatsApp' => 'success',

                                            'SMS' => 'info',

                                            'Meeting' => 'danger',

                                            'Video Call' => 'dark',

                                            'Telegram' => 'secondary',

                                            'Slack' => 'secondary',

                                            'Microsoft Teams' => 'info',

                                            'In Person' => 'warning',

                                            default => 'light text-dark',

                                        };

                                    @endphp

                                    <span class="badge bg-{{ $channelClass }}">

                                        {{ $communication->channel }}

                                    </span>

                                </td>

                                <!-- Direction -->

                                <td>

                                    @if($communication->direction === 'Incoming')

                                        <span class="badge bg-success">

                                            Incoming

                                        </span>

                                    @else

                                        <span class="badge bg-primary">

                                            Outgoing

                                        </span>

                                    @endif

                                </td>

                                <!-- Subject -->

                                <td>

                                    <div class="fw-semibold">

                                        {{ $communication->subject ?: '-' }}

                                    </div>

                                    <small class="text-muted">

                                        {{ \Illuminate\Support\Str::limit(strip_tags($communication->message), 60) }}

                                    </small>

                                </td>
                                                                <!-- Status -->

                                <td>

                                    @php

                                        $statusClass = match($communication->status) {

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

                                        {{ $communication->status }}

                                    </span>

                                </td>

                                <!-- Communication Date -->

                                <td>

                                    @if($communication->communication_at)

                                        <div>

                                            {{ $communication->communication_at->format('d M Y') }}

                                        </div>

                                        <small class="text-muted">

                                            {{ $communication->communication_at->format('h:i A') }}

                                        </small>

                                    @else

                                        <span class="text-muted">

                                            -

                                        </span>

                                    @endif

                                </td>

                                <!-- Actions -->

                                <td>

                                    <div class="btn-group">

                                        @can('view', $communication)

                                            <a
                                                href="{{ route('client-communications.show', $communication) }}"
                                                class="btn btn-sm btn-primary">

                                                <i class="mdi mdi-eye"></i>

                                            </a>

                                        @endcan

                                        @can('update', $communication)

                                            <a
                                                href="{{ route('client-communications.edit', $communication) }}"
                                                class="btn btn-sm btn-warning">

                                                <i class="mdi mdi-pencil"></i>

                                            </a>

                                        @endcan

                                        @can('delete', $communication)

                                            <form
                                                action="{{ route('client-communications.destroy', $communication) }}"
                                                method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Delete this communication?');">

                                                @csrf

                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="btn btn-sm btn-danger">

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
                                    colspan="8"
                                    class="text-center py-5">

                                    <div class="text-muted">

                                        <i
                                            class="mdi mdi-email-outline"
                                            style="font-size:60px;"></i>

                                        <h5 class="mt-3">

                                            No communications found

                                        </h5>

                                        <p class="mb-0">

                                            No client communications match your current filters.

                                        </p>

                                    </div>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

        @if($communications->hasPages())

            <div class="card-footer">

                {{ $communications->links() }}

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

    const checkboxes =
        document.querySelectorAll('.row-check');
            /*
    |--------------------------------------------------------------------------
    | Select / Unselect All
    |--------------------------------------------------------------------------
    */

    if (selectAll) {

        selectAll.addEventListener('change', function () {

            checkboxes.forEach(function (checkbox) {

                checkbox.checked =
                    selectAll.checked;

            });

        });

    }

    /*
    |--------------------------------------------------------------------------
    | Keep header checkbox in sync
    |--------------------------------------------------------------------------
    */

    checkboxes.forEach(function (checkbox) {

        checkbox.addEventListener(
            'change',
            function () {

                const checked =
                    document.querySelectorAll(
                        '.row-check:checked'
                    ).length;

                selectAll.checked =
                    checked === checkboxes.length &&
                    checkboxes.length > 0;

            }
        );

    });
        /*
    |--------------------------------------------------------------------------
    | Bulk Delete
    |--------------------------------------------------------------------------
    */

    const bulkDeleteBtn =
        document.getElementById('bulkDeleteBtn');

    if (bulkDeleteBtn) {

        bulkDeleteBtn.addEventListener(
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
                        'Please select at least one communication.'
                    );

                    return;

                }

                if (
                    !confirm(
                        'Are you sure you want to delete the selected communication(s)?'
                    )
                ) {

                    return;

                }

                document.getElementById(
                    'bulkIds'
                ).value = JSON.stringify(ids);

                document.getElementById(
                    'bulkDeleteForm'
                ).submit();

            }
        );

    }

    /*
    |--------------------------------------------------------------------------
    | Highlight selected rows
    |--------------------------------------------------------------------------
    */

    checkboxes.forEach(function (checkbox) {

        checkbox.addEventListener(
            'change',
            function () {

                const row =
                    this.closest('tr');

                if (this.checked) {

                    row.classList.add(
                        'table-active'
                    );

                } else {

                    row.classList.remove(
                        'table-active'
                    );

                }

            }
        );

    });
        /*
    |--------------------------------------------------------------------------
    | Auto Hide Flash Messages
    |--------------------------------------------------------------------------
    */

    const alerts =
        document.querySelectorAll('.alert');

    alerts.forEach(function (alert) {

        setTimeout(function () {

            alert.classList.remove('show');

            setTimeout(function () {

                alert.remove();

            }, 300);

        }, 5000);

    });

    /*
    |--------------------------------------------------------------------------
    | Table Row Navigation
    |--------------------------------------------------------------------------
    */

    document.querySelectorAll(
        'tbody tr'
    ).forEach(function (row) {

        const viewButton =
            row.querySelector(
                'a[href*="/client-communications/"]'
            );

        if (!viewButton) {

            return;

        }

        row.style.cursor = 'pointer';

        row.addEventListener('dblclick', function (e) {

            if (
                e.target.closest('button') ||
                e.target.closest('a') ||
                e.target.closest('input') ||
                e.target.closest('form')
            ) {

                return;

            }

            window.location =
                viewButton.href;

        });

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
    | Auto Submit Filter Changes
    |--------------------------------------------------------------------------
    */

    document.querySelectorAll(

        'select[name="client_id"], \
         select[name="channel"], \
         select[name="status"]'

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
    | Tooltip Initialization
    |--------------------------------------------------------------------------
    */

    document
        .querySelectorAll(
            '[data-bs-toggle="tooltip"]'
        )
        .forEach(function (element) {

            new bootstrap.Tooltip(element);

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
                'clientCommunicationsScroll',
                window.scrollY
            );

        }
    );

    const scrollPosition =
        sessionStorage.getItem(
            'clientCommunicationsScroll'
        );

    if (scrollPosition !== null) {

        window.scrollTo(
            0,
            parseInt(scrollPosition)
        );

    }
        /*
    |--------------------------------------------------------------------------
    | Clear Saved Scroll After Restore
    |--------------------------------------------------------------------------
    */

    window.addEventListener('load', function () {

        sessionStorage.removeItem(
            'clientCommunicationsScroll'
        );

    });

    /*
    |--------------------------------------------------------------------------
    | Refresh Every 60 Seconds (Optional)
    |--------------------------------------------------------------------------
    */

    // Uncomment if you want automatic refresh.

    /*
    setInterval(function () {

        window.location.reload();

    }, 60000);
    */
       /*
    |--------------------------------------------------------------------------
    | Keyboard Shortcut
    |--------------------------------------------------------------------------
    | Press "N" to create a new communication
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
                    "{{ route('client-communications.create') }}";

            }

        }
    );

});

</script>

@endpush