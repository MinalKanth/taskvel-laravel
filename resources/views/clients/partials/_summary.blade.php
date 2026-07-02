<div class="row mb-4">

    <!-- Client Information -->

    <div class="col-lg-8">

        <div class="card shadow-sm">

            <div class="card-header d-flex justify-content-between align-items-center">

                <h5 class="mb-0">

                    <i class="mdi mdi-domain me-2"></i>

                    Client Information

                </h5>

                <span class="badge bg-success">

                    {{ $client->status }}

                </span>

            </div>

            <div class="card-body">

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label class="fw-semibold text-muted">

                            Client Code

                        </label>

                        <div>

                            {{ $client->client_code }}

                        </div>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="fw-semibold text-muted">

                            Company Name

                        </label>

                        <div>

                            {{ $client->company_name }}

                        </div>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="fw-semibold text-muted">

                            Business Type

                        </label>

                        <div>

                            {{ $client->business_type }}

                        </div>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="fw-semibold text-muted">

                            Email

                        </label>

                        <div>

                            {{ $client->email ?: '-' }}

                        </div>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="fw-semibold text-muted">

                            Phone

                        </label>

                        <div>

                            {{ $client->phone ?: '-' }}

                        </div>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="fw-semibold text-muted">

                            Website

                        </label>

                        <div>

                            {{ $client->website ?: '-' }}

                        </div>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="fw-semibold text-muted">

                            GSTIN

                        </label>

                        <div>

                            {{ $client->gstin ?: '-' }}

                        </div>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="fw-semibold text-muted">

                            PAN

                        </label>

                        <div>

                            {{ $client->pan ?: '-' }}

                        </div>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="fw-semibold text-muted">

                            TAN

                        </label>

                        <div>

                            {{ $client->tan ?: '-' }}

                        </div>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="fw-semibold text-muted">

                            CIN

                        </label>

                        <div>

                            {{ $client->cin ?: '-' }}

                        </div>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="fw-semibold text-muted">

                            UDYAM

                        </label>

                        <div>

                            {{ $client->udyam_number ?: '-' }}

                        </div>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="fw-semibold text-muted">

                            FSSAI

                        </label>

                        <div>

                            {{ $client->fssai_number ?: '-' }}

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- Statistics -->

    <div class="col-lg-4">

        <div class="card shadow-sm">

            <div class="card-header">

                <h5 class="mb-0">

                    <i class="mdi mdi-chart-box-outline me-2"></i>

                    Statistics

                </h5>

            </div>

            <div class="card-body">

                <div class="d-flex justify-content-between mb-3">

                    <span>Contacts</span>

                    <strong>{{ $client->contacts->count() }}</strong>

                </div>

                <div class="d-flex justify-content-between mb-3">

                    <span>Addresses</span>

                    <strong>{{ $client->addresses->count() }}</strong>

                </div>

                <div class="d-flex justify-content-between mb-3">

                    <span>Services</span>

                    <strong>{{ $client->services->count() }}</strong>

                </div>

                <div class="d-flex justify-content-between mb-3">

                    <span>Documents</span>

                    <strong>{{ $client->documents->count() }}</strong>

                </div>

                <div class="d-flex justify-content-between mb-3">

                    <span>Credentials</span>

                    <strong>{{ $client->credentials->count() }}</strong>

                </div>

                <div class="d-flex justify-content-between mb-3">

                    <span>Remarks</span>

                    <strong>{{ $client->remarks->count() }}</strong>

                </div>

                <div class="d-flex justify-content-between">

                    <span>Communications</span>

                    <strong>{{ $client->communications->count() }}</strong>

                </div>

            </div>

        </div>

    </div>

</div>