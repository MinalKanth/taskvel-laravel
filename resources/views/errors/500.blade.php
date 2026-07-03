@extends('layouts.app')

@section('title', '500 - Internal Server Error')

@section('content')

<div class="container py-5">

    <div class="row justify-content-center align-items-center">

        <div class="col-lg-8">

            <div class="card border-0 shadow-lg text-center">

                <div class="card-body p-5">

                    <div class="display-1 fw-bold text-danger mb-3">

                        500

                    </div>

                    <div class="mb-4">

                        <i class="bi bi-server display-2 text-danger"></i>

                    </div>

                    <h2 class="fw-bold mb-3">

                        Internal Server Error

                    </h2>

                    <p class="text-muted mb-4">

                        Something went wrong while processing your request. Please refresh the page or try again later.

                    </p>

                    <div class="d-flex justify-content-center gap-3 flex-wrap">

                        <button
                            onclick="location.reload()"
                            class="btn btn-danger btn-lg">

                            <i class="bi bi-arrow-clockwise me-2"></i>

                            Refresh Page

                        </button>

                        <a href="{{ route('dashboard') }}"
                           class="btn btn-secondary btn-lg">

                            <i class="bi bi-house-door me-2"></i>

                            Dashboard

                        </a>

                    </div>

                    <hr class="my-5">

                    <div class="row text-center">

                        <div class="col-md-4">

                            <i class="bi bi-shield-exclamation fs-2 text-warning"></i>

                            <h6 class="mt-3">

                                Temporary Issue

                            </h6>

                            <small class="text-muted">

                                This error is usually temporary.

                            </small>

                        </div>

                        <div class="col-md-4">

                            <i class="bi bi-arrow-repeat fs-2 text-primary"></i>

                            <h6 class="mt-3">

                                Try Again

                            </h6>

                            <small class="text-muted">

                                Refresh the page after a few moments.

                            </small>

                        </div>

                        <div class="col-md-4">

                            <i class="bi bi-envelope-paper fs-2 text-success"></i>

                            <h6 class="mt-3">

                                Report Issue

                            </h6>

                            <small class="text-muted">

                                Contact support if the problem persists.

                            </small>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection