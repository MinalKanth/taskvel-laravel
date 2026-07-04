@extends('layouts.app')

@section('title', 'Client Tags')

@section('content')

<div class="container-fluid">

    <!-- ======================================================= -->
    <!-- Header -->
    <!-- ======================================================= -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">

                Client Tags

            </h2>

            <p class="text-muted mb-0">

                Manage client tags used for categorization and organization.

            </p>

        </div>

        <div class="d-flex gap-2">

            @can('create', App\Models\ClientTag::class)

                <a
                    href="{{ route('client-tags.create') }}"
                    class="btn btn-primary">

                    <i class="mdi mdi-plus-circle me-1"></i>

                    Add Tag

                </a>

            @endcan

            @can('restore', App\Models\ClientTag::class)

                <a
                    href="{{ route('client-tags.trashed') }}"
                    class="btn btn-danger">

                    <i class="mdi mdi-delete-restore me-1"></i>

                    Trash

                </a>

            @endcan

        </div>

    </div>

    <!-- ======================================================= -->
    <!-- Flash Messages -->
    <!-- ======================================================= -->

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

    <!-- ======================================================= -->
    <!-- Filters -->
    <!-- ======================================================= -->

    <div class="card shadow-sm mb-4">

        <div class="card-body">

            <form
                method="GET"
                action="{{ route('client-tags.index') }}">

                <div class="row">

                    <div class="col-md-3 mb-3">

                        <label class="form-label">

                            Status

                        </label>

                        <select
                            name="status"
                            class="form-select">

                            <option value="">

                                All Tags

                            </option>

                            <option
                                value="1"
                                @selected(request('status') === '1')>

                                Active

                            </option>

                            <option
                                value="0"
                                @selected(request('status') === '0')>

                                Inactive

                            </option>

                        </select>

                    </div>
                                        <div class="col-md-5 mb-3">

                        <label class="form-label">

                            Search

                        </label>

                        <input
                            type="text"
                            name="search"
                            class="form-control"
                            value="{{ request('search') }}"
                            placeholder="Search by name, slug or description">

                    </div>

                    <div class="col-md-4 mb-3 d-flex align-items-end gap-2">

                        <button
                            type="submit"
                            class="btn btn-primary">

                            <i class="mdi mdi-magnify me-1"></i>

                            Search

                        </button>

                        <a
                            href="{{ route('client-tags.index') }}"
                            class="btn btn-light border">

                            <i class="mdi mdi-refresh"></i>

                            Reset

                        </a>

                    </div>

                </div>

            </form>

        </div>

    </div>

    <!-- ======================================================= -->
    <!-- Tags Table -->
    <!-- ======================================================= -->

    <div class="card shadow-sm">

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">

                        <tr>

                            <th width="50">

                                #

                            </th>

                            <th>

                                Name

                            </th>

                            <th>

                                Slug

                            </th>

                            <th>

                                Color

                            </th>

                            <th>

                                Icon

                            </th>

                            <th>

                                Clients

                            </th>

                            <th>

                                Order

                            </th>

                            <th>

                                Status

                            </th>

                            <th width="180">

                                Actions

                            </th>

                        </tr>

                    </thead>

                    <tbody>
                                                @forelse($tags as $tag)

                            <tr>

                                <td>

                                    {{ $loop->iteration + (($tags->currentPage() - 1) * $tags->perPage()) }}

                                </td>

                                <td>

                                    <div class="fw-semibold">

                                        {{ $tag->name }}

                                    </div>

                                    @if($tag->description)

                                        <small class="text-muted">

                                            {{ \Illuminate\Support\Str::limit($tag->description, 60) }}

                                        </small>

                                    @endif

                                </td>

                                <td>

                                    <code>

                                        {{ $tag->slug }}

                                    </code>

                                </td>

                                <td>

                                    <span
                                        class="badge"
                                        style="background: {{ $tag->color ?: '#6c757d' }}; color:#fff;">

                                        {{ $tag->color ?: 'Default' }}

                                    </span>

                                </td>

                                <td>

                                    @if($tag->icon)

                                        <i class="{{ $tag->icon }}"></i>

                                        <small class="ms-1 text-muted">

                                            {{ $tag->icon }}

                                        </small>

                                    @else

                                        -

                                    @endif

                                </td>

                                <td>

                                    <span class="badge bg-primary">

                                        {{ $tag->clients_count }}

                                    </span>

                                </td>
                                                                <td>

                                    {{ $tag->sort_order }}

                                </td>

                                <td>

                                    @if($tag->is_active)

                                        <span class="badge bg-success">

                                            Active

                                        </span>

                                    @else

                                        <span class="badge bg-danger">

                                            Inactive

                                        </span>

                                    @endif

                                </td>

                                <td>

                                    <div class="btn-group">

                                        @can('view', $tag)

                                            <a
                                                href="{{ route('client-tags.show', $tag) }}"
                                                class="btn btn-sm btn-primary"
                                                title="View">

                                                <i class="mdi mdi-eye"></i>

                                            </a>

                                        @endcan

                                        @can('update', $tag)

                                            <a
                                                href="{{ route('client-tags.edit', $tag) }}"
                                                class="btn btn-sm btn-warning"
                                                title="Edit">

                                                <i class="mdi mdi-pencil"></i>

                                            </a>

                                        @endcan

                                        @can('delete', $tag)

                                            <form
                                                action="{{ route('client-tags.destroy', $tag) }}"
                                                method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Are you sure you want to delete this tag?');">

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
                                    colspan="9"
                                    class="text-center py-5">

                                    <div class="text-muted">

                                        <i
                                            class="mdi mdi-tag-multiple-outline"
                                            style="font-size:64px;"></i>

                                        <h5 class="mt-3">

                                            No Client Tags Found

                                        </h5>

                                        <p class="mb-3">

                                            There are no client tags matching your search criteria.

                                        </p>

                                        @can('create', App\Models\ClientTag::class)

                                            <a
                                                href="{{ route('client-tags.create') }}"
                                                class="btn btn-primary">

                                                <i class="mdi mdi-plus-circle me-1"></i>

                                                Create First Tag

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

        @if($tags->hasPages())

            <div class="card-footer">

                <div class="d-flex justify-content-between align-items-center">

                    <div class="text-muted">

                        Showing

                        {{ $tags->firstItem() }}

                        to

                        {{ $tags->lastItem() }}

                        of

                        {{ $tags->total() }}

                        tag(s)

                    </div>

                    {{ $tags->links() }}

                </div>

            </div>

        @endif

    </div>

</div>

@endsection

@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {
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
    | Auto Submit Filter
    |--------------------------------------------------------------------------
    */

    const statusFilter = document.querySelector(
        'select[name="status"]'
    );

    if (statusFilter) {

        statusFilter.addEventListener(
            'change',
            function () {

                this.form.submit();

            }
        );

    }

    /*
    |--------------------------------------------------------------------------
    | Search On Enter
    |--------------------------------------------------------------------------
    */

    const searchInput = document.querySelector(
        'input[name="search"]'
    );

    if (searchInput) {

        searchInput.addEventListener(
            'keypress',
            function (event) {

                if (event.key === 'Enter') {

                    this.form.submit();

                }

            }
        );

    }
        /*
    |--------------------------------------------------------------------------
    | Double Click Row To View
    |--------------------------------------------------------------------------
    */

    document.querySelectorAll(
        'tbody tr'
    ).forEach(function (row) {

        const viewLink = row.querySelector(
            'a[href*="/client-tags/"]'
        );

        if (!viewLink) {

            return;

        }

        row.style.cursor = 'pointer';

        row.addEventListener(
            'dblclick',
            function (event) {

                if (

                    event.target.closest('a') ||

                    event.target.closest('button') ||

                    event.target.closest('form')

                ) {

                    return;

                }

                window.location =
                    viewLink.href;

            }
        );

    });

    /*
    |--------------------------------------------------------------------------
    | Enable Bootstrap Tooltips
    |--------------------------------------------------------------------------
    */

    document.querySelectorAll(
        '[title]'
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
                'clientTagsScroll',
                window.scrollY
            );

        }
    );

    const savedScroll = sessionStorage.getItem(
        'clientTagsScroll'
    );

    if (savedScroll !== null) {

        window.scrollTo(
            0,
            parseInt(savedScroll)
        );

    }

    window.addEventListener(
        'load',
        function () {

            sessionStorage.removeItem(
                'clientTagsScroll'
            );

        }
    );

    /*
    |--------------------------------------------------------------------------
    | Keyboard Shortcut (N = New Tag)
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
                    "{{ route('client-tags.create') }}";

            }

        }
    );
        /*
    |--------------------------------------------------------------------------
    | Refresh Table
    |--------------------------------------------------------------------------
    */

    const refreshButton = document.getElementById(
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
    | Copy Slug
    |--------------------------------------------------------------------------
    */

    document.querySelectorAll(
        '.copy-slug'
    ).forEach(function (button) {

        button.addEventListener(
            'click',
            function () {

                navigator.clipboard.writeText(
                    this.dataset.slug
                );

                const original = this.innerHTML;

                this.innerHTML =
                    '<i class="mdi mdi-check"></i>';

                setTimeout(() => {

                    this.innerHTML = original;

                }, 1500);

            }
        );

    });

    /*
    |--------------------------------------------------------------------------
    | Print Page
    |--------------------------------------------------------------------------
    */

    const printButton = document.getElementById(
        'printTags'
    );

    if (printButton) {

        printButton.addEventListener(
            'click',
            function () {

                window.print();

            }
        );

    }
        /*
    |--------------------------------------------------------------------------
    | Export Button (Placeholder)
    |--------------------------------------------------------------------------
    */

    const exportButton = document.getElementById(
        'exportTags'
    );

    if (exportButton) {

        exportButton.addEventListener(
            'click',
            function () {

                alert(
                    'Export functionality will be available soon.'
                );

            }
        );

    }

    /*
    |--------------------------------------------------------------------------
    | Trim Search Before Submit
    |--------------------------------------------------------------------------
    */

    const filterForm = document.querySelector(
        'form'
    );

    if (filterForm && searchInput) {

        filterForm.addEventListener(
            'submit',
            function () {

                searchInput.value =
                    searchInput.value.trim();

            }
        );

    }

    /*
    |--------------------------------------------------------------------------
    | Highlight Current Search
    |--------------------------------------------------------------------------
    */

    if (

        searchInput &&

        searchInput.value.trim() !== ''

    ) {

        searchInput.classList.add(
            'border-primary'
        );

    }
        /*
    |--------------------------------------------------------------------------
    | Highlight Active Row on Hover
    |--------------------------------------------------------------------------
    */

    document.querySelectorAll(
        'tbody tr'
    ).forEach(function (row) {

        row.addEventListener(
            'mouseenter',
            function () {

                this.classList.add(
                    'table-active'
                );

            }
        );

        row.addEventListener(
            'mouseleave',
            function () {

                this.classList.remove(
                    'table-active'
                );

            }
        );

    });

    /*
    |--------------------------------------------------------------------------
    | Auto Focus Search
    |--------------------------------------------------------------------------
    */

    if (

        searchInput &&

        searchInput.value === ''

    ) {

        searchInput.focus();

    }

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
    | Close Script
    |--------------------------------------------------------------------------
    */

});

</script>

@endpush