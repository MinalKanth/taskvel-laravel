<div class="card shadow-sm mb-4">

    <div class="card-header d-flex justify-content-between align-items-center">

        <h5 class="mb-0">

            <i class="mdi mdi-briefcase-check-outline me-2"></i>

            Client Services

        </h5>

        @can('create', App\Models\ClientService::class)

            <a href="{{ route('client-services.create', ['client' => $client->id]) }}"
               class="btn btn-primary btn-sm">

                <i class="mdi mdi-plus"></i>

                Assign Service

            </a>

        @endcan

    </div>

    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">

                    <tr>

                        <th>Service</th>

                        <th>Category</th>

                        <th>Assigned To</th>

                        <th>Start Date</th>

                        <th>Renewal</th>

                        <th>Billing</th>

                        <th>Fee</th>

                        <th>Status</th>

                        <th width="180">
                            Action
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($client->services as $service)

                        <tr>

                            <td>

                                <strong>

                                    {{ optional($service->service)->name }}

                                </strong>

                                <br>

                                <small class="text-muted">

                                    {{ optional($service->service)->service_code }}

                                </small>

                            </td>

                            <td>

                                {{ optional($service->service)->category }}

                            </td>

                            <td>

                                {{ optional($service->assignedUser)->name ?? '-' }}

                            </td>

                            <td>

                                {{ optional($service->start_date)?->format('d M Y') }}

                            </td>

                            <td>

                                @if($service->renewable)

                                    {{ optional($service->renewal_date)?->format('d M Y') }}

                                @else

                                    -

                                @endif

                            </td>

                            <td>

                                {{ $service->billing_cycle }}

                            </td>

                            <td>

                                ₹ {{ number_format($service->final_amount, 2) }}

                            </td>

                            <td>

                                @if($service->status == 'Active')

                                    <span class="badge bg-success">

                                        Active

                                    </span>

                                @elseif($service->status == 'Completed')

                                    <span class="badge bg-primary">

                                        Completed

                                    </span>

                                @elseif($service->status == 'Paused')

                                    <span class="badge bg-warning">

                                        Paused

                                    </span>

                                @else

                                    <span class="badge bg-danger">

                                        {{ $service->status }}

                                    </span>

                                @endif

                            </td>

                            <td>

                                @can('view', $service)

                                    <a href="{{ route('client-services.show', $service) }}"
                                       class="btn btn-info btn-sm">

                                        <i class="mdi mdi-eye"></i>

                                    </a>

                                @endcan

                                @can('update', $service)

                                    <a href="{{ route('client-services.edit', $service) }}"
                                       class="btn btn-warning btn-sm">

                                        <i class="mdi mdi-pencil"></i>

                                    </a>

                                @endcan

                                @can('delete', $service)

                                    <form
                                        action="{{ route('client-services.destroy', $service) }}"
                                        method="POST"
                                        class="d-inline">

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Delete this service?')">

                                            <i class="mdi mdi-delete"></i>

                                        </button>

                                    </form>

                                @endcan

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="9"
                                class="text-center py-5 text-muted">

                                No services assigned.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>