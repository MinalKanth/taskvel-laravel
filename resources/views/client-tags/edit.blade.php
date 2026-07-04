@extends('layouts.app')

@section('title', 'Edit Client Tag')

@section('content')

<div class="container-fluid">

    <!-- ======================================================= -->
    <!-- Header -->
    <!-- ======================================================= -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">

                Edit Client Tag

            </h2>

            <p class="text-muted mb-0">

                Update tag details

            </p>

        </div>

        <div>

            <a
                href="{{ route('client-tags.index') }}"
                class="btn btn-secondary">

                <i class="mdi mdi-arrow-left me-1"></i>

                Back

            </a>

        </div>

    </div>

    <!-- ======================================================= -->
    <!-- Errors -->
    <!-- ======================================================= -->

    @if ($errors->any())

        <div class="alert alert-danger">

            <strong>Please fix the errors below:</strong>

            <hr>

            <ul class="mb-0">

                @foreach ($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif

    <!-- ======================================================= -->
    <!-- Form -->
    <!-- ======================================================= -->

    <form method="POST" action="{{ route('client-tags.update', $clientTag) }}">

        @csrf
        @method('PUT')

        <div class="card shadow-sm mb-4">

            <div class="card-body">

                <div class="row">

                    <!-- Name -->
                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Name <span class="text-danger">*</span>

                        </label>

                        <input
                            type="text"
                            name="name"
                            value="{{ old('name', $clientTag->name) }}"
                            class="form-control @error('name') is-invalid @enderror">

                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                    </div>

                    <!-- Slug -->
                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Slug

                        </label>

                        <input
                            type="text"
                            name="slug"
                            value="{{ old('slug', $clientTag->slug) }}"
                            class="form-control">

                    </div>

                    <!-- Color -->
                    <div class="col-md-4 mb-3">

                        <label class="form-label">

                            Color

                        </label>

                        <input
                            type="color"
                            name="color"
                            value="{{ old('color', $clientTag->color) }}"
                            class="form-control form-control-color">

                    </div>

                    <!-- Icon -->
                    <div class="col-md-4 mb-3">

                        <label class="form-label">

                            Icon

                        </label>

                        <input
                            type="text"
                            name="icon"
                            value="{{ old('icon', $clientTag->icon) }}"
                            class="form-control"
                            placeholder="mdi-star / fa fa-star">

                    </div>

                    <!-- Sort Order -->
                    <div class="col-md-4 mb-3">

                        <label class="form-label">

                            Sort Order

                        </label>

                        <input
                            type="number"
                            name="sort_order"
                            value="{{ old('sort_order', $clientTag->sort_order) }}"
                            class="form-control">

                    </div>

                    <!-- Description -->
                    <div class="col-md-12 mb-3">

                        <label class="form-label">

                            Description

                        </label>

                        <textarea
                            name="description"
                            rows="4"
                            class="form-control">{{ old('description', $clientTag->description) }}</textarea>

                    </div>

                    <!-- Active -->
                    <div class="col-md-12 mb-3">

                        <div class="form-check form-switch">

                            <input
                                class="form-check-input"
                                type="checkbox"
                                name="is_active"
                                value="1"
                                @checked(old('is_active', $clientTag->is_active))>

                            <label class="form-check-label">

                                Active Tag

                            </label>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- Buttons -->

        <div class="card shadow-sm">

            <div class="card-body text-end">

                <a
                    href="{{ route('client-tags.index') }}"
                    class="btn btn-light">

                    Cancel

                </a>

                <button
                    type="submit"
                    class="btn btn-primary">

                    <i class="mdi mdi-content-save me-1"></i>

                    Update Tag

                </button>

            </div>

        </div>

    </form>

</div>

@endsection