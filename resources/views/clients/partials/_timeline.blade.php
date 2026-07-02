<div class="card shadow-sm mb-4">

    <div class="card-header d-flex justify-content-between align-items-center">

        <h5 class="mb-0">

            <i class="mdi mdi-timeline-clock-outline me-2"></i>

            Client Timeline

        </h5>

        <span class="badge bg-primary">

            {{ $client->timeline->count() }} Events

        </span>

    </div>

    <div class="card-body">

        @forelse($client->timeline()->latest('event_at')->get() as $timeline)

            <div class="d-flex mb-4">

                <div class="flex-shrink-0">

                    @switch($timeline->type)

                        @case('client_created')

                            <span class="badge bg-success rounded-pill p-3">

                                <i class="mdi mdi-account-plus"></i>

                            </span>

                            @break

                        @case('client_updated')

                            <span class="badge bg-primary rounded-pill p-3">

                                <i class="mdi mdi-pencil"></i>

                            </span>

                            @break

                        @case('document_uploaded')

                            <span class="badge bg-info rounded-pill p-3">

                                <i class="mdi mdi-file-document-outline"></i>

                            </span>

                            @break

                        @case('credential_updated')

                            <span class="badge bg-warning rounded-pill p-3">

                                <i class="mdi mdi-shield-key-outline"></i>

                            </span>

                            @break

                        @case('remark_created')

                            <span class="badge bg-secondary rounded-pill p-3">

                                <i class="mdi mdi-note-text-outline"></i>

                            </span>

                            @break

                        @case('communication_sent')

                            <span class="badge bg-dark rounded-pill p-3">

                                <i class="mdi mdi-message-processing-outline"></i>

                            </span>

                            @break

                        @case('client_deleted')

                            <span class="badge bg-danger rounded-pill p-3">

                                <i class="mdi mdi-delete"></i>

                            </span>

                            @break

                        @default

                            <span class="badge bg-light text-dark rounded-pill p-3">

                                <i class="mdi mdi-clock-outline"></i>

                            </span>

                    @endswitch

                </div>

                <div class="ms-3 flex-grow-1">

                    <div class="d-flex justify-content-between">

                        <h6 class="mb-1">

                            {{ $timeline->title }}

                        </h6>

                        <small class="text-muted">

                            {{ optional($timeline->event_at)->diffForHumans() }}

                        </small>

                    </div>

                    <p class="mb-1 text-muted">

                        {{ $timeline->description }}

                    </p>

                    <small class="text-secondary">

                        By

                        <strong>

                            {{ optional($timeline->user)->name ?? 'System' }}

                        </strong>

                        •

                        {{ optional($timeline->event_at)->format('d M Y h:i A') }}

                    </small>

                </div>

            </div>

            @if(!$loop->last)

                <hr>

            @endif

        @empty

            <div class="text-center py-5">

                <i class="mdi mdi-timeline-clock-outline display-4 text-muted"></i>

                <h6 class="mt-3">

                    No Timeline Available

                </h6>

                <p class="text-muted mb-0">

                    Client activities will appear here.

                </p>

            </div>

        @endforelse

    </div>

</div>