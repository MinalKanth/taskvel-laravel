<div class="card shadow-sm mb-4">

    <div class="card-header d-flex justify-content-between align-items-center">

        <h5 class="mb-0">

            <i class="mdi mdi-message-processing-outline me-2"></i>

            Communications

        </h5>

        @can('create', App\Models\ClientCommunication::class)

            <a href="{{ route('client-communications.create', ['client' => $client->id]) }}"
               class="btn btn-primary btn-sm">

                <i class="mdi mdi-plus"></i>

                Add Communication

            </a>

        @endcan

    </div>

    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">

                    <tr>

                        <th>Date</th>

                        <th>Type</th>

                        <th>Subject</th>

                        <th>Sent By</th>

                        <th>Status</th>

                        <th width="220">

                            Actions

                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($client->communications as $communication)

                        <tr>

                            <td>

                                {{ optional($communication->communication_at)->format('d M Y h:i A') }}

                            </td>

                            <td>

                                @switch($communication->communication_type)

                                    @case('Email')

                                        <span class="badge bg-primary">

                                            Email

                                        </span>

                                        @break

                                    @case('Phone')

                                        <span class="badge bg-success">

                                            Phone

                                        </span>

                                        @break

                                    @case('WhatsApp')

                                        <span class="badge bg-success">

                                            WhatsApp

                                        </span>

                                        @break

                                    @case('SMS')

                                        <span class="badge bg-warning">

                                            SMS

                                        </span>

                                        @break

                                    @case('Meeting')

                                        <span class="badge bg-info">

                                            Meeting

                                        </span>

                                        @break

                                    @default

                                        <span class="badge bg-secondary">

                                            {{ $communication->communication_type }}

                                        </span>

                                @endswitch

                            </td>

                            <td>

                                <strong>

                                    {{ $communication->subject }}

                                </strong>

                                <br>

                                <small class="text-muted">

                                    {{ \Illuminate\Support\Str::limit($communication->message, 70) }}

                                </small>

                            </td>

                            <td>

                                {{ optional($communication->creator)->name ?? '-' }}

                            </td>

                            <td>

                                @switch($communication->status)

                                    @case('Draft')

                                        <span class="badge bg-secondary">

                                            Draft

                                        </span>

                                        @break

                                    @case('Sent')

                                        <span class="badge bg-primary">

                                            Sent

                                        </span>

                                        @break

                                    @case('Delivered')

                                        <span class="badge bg-success">

                                            Delivered

                                        </span>

                                        @break

                                    @case('Failed')

                                        <span class="badge bg-danger">

                                            Failed

                                        </span>

                                        @break

                                    @default

                                        <span class="badge bg-warning">

                                            {{ $communication->status }}

                                        </span>

                                @endswitch

                            </td>

                            <td>

                                @can('view', $communication)

                                    <a href="{{ route('client-communications.show', $communication) }}"
                                       class="btn btn-info btn-sm">

                                        <i class="mdi mdi-eye"></i>

                                    </a>

                                @endcan

                                @can('update', $communication)

                                    <a href="{{ route('client-communications.edit', $communication) }}"
                                       class="btn btn-warning btn-sm">

                                        <i class="mdi mdi-pencil"></i>

                                    </a>

                                @endcan

                                @can('delete', $communication)

                                    <form
                                        action="{{ route('client-communications.destroy', $communication) }}"
                                        method="POST"
                                        class="d-inline">

                                        @csrf

                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Delete this communication?')">

                                            <i class="mdi mdi-delete"></i>

                                        </button>

                                    </form>

                                @endcan

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6"
                                class="text-center py-5 text-muted">

                                No communications found.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>