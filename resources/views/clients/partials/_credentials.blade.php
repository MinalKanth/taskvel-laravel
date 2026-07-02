<div class="card shadow-sm mb-4">

    <div class="card-header d-flex justify-content-between align-items-center">

        <h5 class="mb-0">

            <i class="mdi mdi-shield-key-outline me-2"></i>

            Client Credentials

        </h5>

        @can('create', App\Models\ClientCredential::class)

            <a href="{{ route('client-credentials.create', ['client' => $client->id]) }}"
               class="btn btn-primary btn-sm">

                <i class="mdi mdi-plus"></i>

                Add Credential

            </a>

        @endcan

    </div>

    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">

                    <tr>

                        <th>Portal</th>

                        <th>Username</th>

                        <th>Email</th>

                        <th>Mobile</th>

                        <th>Expiry</th>

                        <th>Status</th>

                        <th width="220">

                            Actions

                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($client->credentials as $credential)

                        <tr>

                            <td>

                                <strong>

                                    {{ $credential->portal }}

                                </strong>

                                @if($credential->portal_name)

                                    <br>

                                    <small class="text-muted">

                                        {{ $credential->portal_name }}

                                    </small>

                                @endif

                            </td>

                            <td>

                                {{ $credential->username }}

                            </td>

                            <td>

                                {{ $credential->registered_email ?: '-' }}

                            </td>

                            <td>

                                {{ $credential->registered_mobile ?: '-' }}

                            </td>

                            <td>

                                @if($credential->expiry_date)

                                    @if($credential->expiry_date->isPast())

                                        <span class="badge bg-danger">

                                            Expired

                                        </span>

                                        <br>

                                    @elseif($credential->expiry_date->diffInDays(now()) <= 30)

                                        <span class="badge bg-warning">

                                            Expiring Soon

                                        </span>

                                        <br>

                                    @endif

                                    {{ $credential->expiry_date->format('d M Y') }}

                                @else

                                    -

                                @endif

                            </td>

                            <td>

                                @if($credential->is_active)

                                    <span class="badge bg-success">

                                        Active

                                    </span>

                                @else

                                    <span class="badge bg-secondary">

                                        Inactive

                                    </span>

                                @endif

                            </td>

                            <td>

                                @can('view', $credential)

                                    <a href="{{ route('client-credentials.show', $credential) }}"
                                       class="btn btn-info btn-sm">

                                        <i class="mdi mdi-eye"></i>

                                    </a>

                                @endcan

                                @can('update', $credential)

                                    <a href="{{ route('client-credentials.edit', $credential) }}"
                                       class="btn btn-warning btn-sm">

                                        <i class="mdi mdi-pencil"></i>

                                    </a>

                                @endcan

                                @can('delete', $credential)

                                    <form
                                        action="{{ route('client-credentials.destroy', $credential) }}"
                                        method="POST"
                                        class="d-inline">

                                        @csrf

                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Delete this credential?')">

                                            <i class="mdi mdi-delete"></i>

                                        </button>

                                    </form>

                                @endcan

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="7"
                                class="text-center py-5 text-muted">

                                No credentials available.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>