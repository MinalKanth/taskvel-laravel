@extends('layouts.app')

@section('title', '404 - Page Not Found')

@section('content')

<div class="container py-5">

    <div class="row justify-content-center align-items-center">

        <div class="col-lg-8">

            <div class="card border-0 shadow-lg text-center">

                <div class="card-body p-5">

                    <div class="display-1 fw-bold text-primary mb-3">

                        404

                    </div>

                    <div class="mb-4">

                        <i class="bi bi-exclamation-triangle display-2 text-warning"></i>

                    </div>

                    <h2 class="fw-bold mb-3">

                        Oops! Page Not Found

                    </h2>

                    <p class="text-muted mb-4">

                        The page you are looking for doesn't exist, may have been moved,
                        or the URL may be incorrect.

                    </p>

                    <div class="d-flex justify-content-center gap-3 flex-wrap">

                        <a href="{{ route('dashboard') }}"
                           class="btn btn-primary btn-lg">

                            <i class="bi bi-house-door me-2"></i>

                            Go to Dashboard

                        </a>

                        <button
                            onclick="history.back()"
                            class="btn btn-secondary btn-lg">

                            <i class="bi bi-arrow-left me-2"></i>

                            Go Back

                        </button>

                    </div>

                    <hr class="my-5">

                    <div class="row text-center">

                        <div class="col-md-4">

                            <i class="bi bi-search fs-2 text-primary"></i>

                            <h6 class="mt-3">

                                Check URL

                            </h6>

                            <small class="text-muted">

                                Verify the address you entered.

                            </small>

                        </div>

                        <div class="col-md-4">

                            <i class="bi bi-house fs-2 text-success"></i>

                            <h6 class="mt-3">

                                Visit Dashboard

                            </h6>

                            <small class="text-muted">

                                Return to your workspace.

                            </small>

                        </div>

                        <div class="col-md-4">

                            <i class="bi bi-life-preserver fs-2 text-danger"></i>

                            <h6 class="mt-3">

                                Need Help?

                            </h6>

                            <small class="text-muted">

                                Contact the administrator.

                            </small>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection