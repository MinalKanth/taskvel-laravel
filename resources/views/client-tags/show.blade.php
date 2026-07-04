@extends('layouts.app')

@section('title', 'View Client Tag')

@section('content')

<div class="container-fluid">

    <!-- ======================================================= -->
    <!-- Header -->
    <!-- ======================================================= -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">

                {{ $clientTag->name }}

            </h2>

            <p class="text-muted mb-0">

                Client Tag Details

            </p>

        </div>

        <div class="d-flex gap-2">

            <a
                href="{{ route('client-tags.index') }}"
                class="btn btn-secondary">

                <i class="mdi mdi-arrow-left me-1"></i>

                Back

            </a>

            @can('update', $clientTag)

                <a
                    href="{{ route('client-tags.edit', $clientTag) }}"
                    class="btn btn-warning">

                    <i class="mdi mdi-pencil me-1"></i>

                    Edit

                </a>

            @endcan

        </div>

    </div>

    <!-- ======================================================= -->
    <!-- Details Card -->
    <!-- ======================================================= -->

    <div class="card shadow-sm mb-4">

        <div class="card-body">

            <div class="row">

                <!-- Name -->
                <div class="col-md-6 mb-3">

                    <label class="text-muted">Name</label>

                    <div class="fw-semibold">

                        {{ $clientTag->name }}

                    </div>

                </div>

                <!-- Slug -->
                <div class="col-md-6 mb-3">

                    <label class="text-muted">Slug</label>

                    <div>

                        <code>{{ $clientTag->slug }}</code>

                    </div>

                </div>

                <!-- Color -->
                <div class="col-md-4 mb-3">

                    <label class="text-muted">Color</label>

                    <div>

                        <span
                            class="badge"
                            style="background: {{ $clientTag->color ?: '#6c757d' }}; color:#fff;">

                            {{ $clientTag->color ?: 'Default' }}

                        </span>

                    </div>

                </div>

                <!-- Icon -->
                <div class="col-md-4 mb-3">

                    <label class="text-muted">Icon</label>

                    <div>

                        @if($clientTag->icon)

                            <i class="{{ $clientTag->icon }}"></i>

                            <span class="ms-1">{{ $clientTag->icon }}</span>

                        @else

                            -

                        @endif

                    </div>

                </div>

                <!-- Status -->
                <div class="col-md-4 mb-3">

                    <label class="text-muted">Status</label>

                    <div>

                        @if($clientTag->is_active)

                            <span class="badge bg-success">Active</span>

                        @else

                            <span class="badge bg-danger">Inactive</span>

                        @endif

                    </div>

                </div>

                <!-- Sort Order -->
                <div class="col-md-4 mb-3">

                    <label class="text-muted">Sort Order</label>

                    <div>

                        {{ $clientTag->sort_order }}

                    </div>

                </div>

                <!-- Created -->
                <div class="col-md-4 mb-3">

                    <label class="text-muted">Created At</label>

                    <div>

                        {{ $clientTag->created_at?->format('d M Y H:i') }}

                    </div>

                </div>

                <!-- Updated -->
                <div class="col-md-4 mb-3">

                    <label class="text-muted">Updated At</label>

                    <div>

                        {{ $clientTag->updated_at?->format('d M Y H:i') }}

                    </div>

                </div>

                <!-- Description -->
                <div class="col-md-12 mb-3">

                    <label class="text-muted">Description</label>

                    <div>

                        {{ $clientTag->description ?: '-' }}

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- ======================================================= -->
    <!-- Related Clients -->
    <!-- ======================================================= -->

    <div class="card shadow-sm">

        <div class="card-header">

            <h5 class="mb-0">

                Clients using this tag

            </h5>

        </div>

        <div class="card-body">

            @if($clientTag->clients->count())

                <ul class="list-group">

                    @foreach($clientTag->clients as $client)

                        <li class="list-group-item d-flex justify-content-between">

                            <span>

                                {{ $client->company_name }}

                            </span>

                            <span class="text-muted">

                                {{ $client->client_code }}

                            </span>

                        </li>

                    @endforeach

                </ul>

            @else

                <p class="text-muted mb-0">

                    No clients assigned to this tag.

                </p>

            @endif

        </div>

    </div>

</div>

@endsection