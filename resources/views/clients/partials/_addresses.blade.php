<div class="card shadow-sm mb-4">

    <div class="card-header d-flex justify-content-between align-items-center">

        <h5 class="mb-0">

            <i class="mdi mdi-map-marker me-2"></i>

            Client Addresses

        </h5>

        @can('create', App\Models\ClientAddress::class)

            <a href="{{ route('client-addresses.create', ['client' => $client->id]) }}"
               class="btn btn-primary btn-sm">

                <i class="mdi mdi-plus"></i>

                Add Address

            </a>

        @endcan

    </div>

    <div class="card-body">

        <div class="row">

            @forelse($client->addresses as $address)

                <div class="col-lg-6 mb-4">

                    <div class="card border h-100">

                        <div class="card-header d-flex justify-content-between align-items-center">

                            <strong>

                                {{ $address->address_type }}

                            </strong>

                            @if($address->is_default)

                                <span class="badge bg-success">

                                    Default

                                </span>

                            @endif

                        </div>

                        <div class="card-body">

                            <p class="mb-2">

                                {{ $address->address_line_1 }}

                            </p>

                            @if($address->address_line_2)

                                <p class="mb-2">

                                    {{ $address->address_line_2 }}

                                </p>

                            @endif

                            <p class="mb-1">

                                <strong>City:</strong>

                                {{ $address->city }}

                            </p>

                            <p class="mb-1">

                                <strong>State:</strong>

                                {{ $address->state }}

                            </p>

                            <p class="mb-1">

                                <strong>Country:</strong>

                                {{ $address->country }}

                            </p>

                            <p class="mb-1">

                                <strong>Pincode:</strong>

                                {{ $address->postal_code }}

                            </p>

                            <p class="mb-0">

                                <strong>Status:</strong>

                                @if($address->is_active)

                                    <span class="badge bg-success">

                                        Active

                                    </span>

                                @else

                                    <span class="badge bg-danger">

                                        Inactive

                                    </span>

                                @endif

                            </p>

                        </div>

                        <div class="card-footer bg-white">

                            @can('view', $address)

                                <a href="{{ route('client-addresses.show', $address) }}"
                                   class="btn btn-info btn-sm">

                                    <i class="mdi mdi-eye"></i>

                                    View

                                </a>

                            @endcan

                            @can('update', $address)

                                <a href="{{ route('client-addresses.edit', $address) }}"
                                   class="btn btn-warning btn-sm">

                                    <i class="mdi mdi-pencil"></i>

                                    Edit

                                </a>

                            @endcan

                            @can('delete', $address)

                                <form
                                    action="{{ route('client-addresses.destroy', $address) }}"
                                    method="POST"
                                    class="d-inline">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Delete this address?')">

                                        <i class="mdi mdi-delete"></i>

                                        Delete

                                    </button>

                                </form>

                            @endcan

                        </div>

                    </div>

                </div>

            @empty

                <div class="col-12">

                    <div class="alert alert-info mb-0">

                        No addresses available.

                    </div>

                </div>

            @endforelse

        </div>

    </div>

</div>