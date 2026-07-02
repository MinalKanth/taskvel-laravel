<div class="card shadow-sm mb-4">

    <div class="card-header d-flex justify-content-between align-items-center">

        <h5 class="mb-0">
            <i class="mdi mdi-account-group-outline me-2"></i>
            Client Contacts
        </h5>

        @can('create', App\Models\ClientContact::class)
            <a href="{{ route('client-contacts.create', ['client' => $client->id]) }}"
               class="btn btn-primary btn-sm">

                <i class="mdi mdi-plus"></i>

                Add Contact
            </a>
        @endcan

    </div>

    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">

                    <tr>

                        <th>Name</th>

                        <th>Designation</th>

                        <th>Email</th>

                        <th>Mobile</th>

                        <th>Department</th>

                        <th>Primary</th>

                        <th>Status</th>

                        <th width="180">Actions</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($client->contacts as $contact)

                        <tr>

                            <td>

                                <strong>{{ $contact->name }}</strong>

                                @if($contact->designation)

                                    <br>

                                    <small class="text-muted">

                                        {{ $contact->designation }}

                                    </small>

                                @endif

                            </td>

                            <td>

                                {{ $contact->designation ?? '-' }}

                            </td>

                            <td>

                                @if($contact->email)

                                    <a href="mailto:{{ $contact->email }}">

                                        {{ $contact->email }}

                                    </a>

                                @else

                                    -

                                @endif

                            </td>

                            <td>

                                @if($contact->mobile)

                                    <a href="tel:{{ $contact->mobile }}">

                                        {{ $contact->mobile }}

                                    </a>

                                @else

                                    -

                                @endif

                            </td>

                            <td>

                                {{ $contact->department ?? '-' }}

                            </td>

                            <td>

                                @if($contact->is_primary)

                                    <span class="badge bg-success">

                                        Primary

                                    </span>

                                @else

                                    <span class="badge bg-secondary">

                                        No

                                    </span>

                                @endif

                            </td>

                            <td>

                                @if($contact->is_active)

                                    <span class="badge bg-success">

                                        Active

                                    </span>

                                @else

                                    <span class="badge bg-danger">

                                        Inactive

                                    </span>

                                @endif

                            </td>

                            <td>

                                @can('view', $contact)

                                    <a href="{{ route('client-contacts.show', $contact) }}"
                                       class="btn btn-sm btn-info"
                                       title="View">

                                        <i class="mdi mdi-eye"></i>

                                    </a>

                                @endcan

                                @can('update', $contact)

                                    <a href="{{ route('client-contacts.edit', $contact) }}"
                                       class="btn btn-sm btn-warning"
                                       title="Edit">

                                        <i class="mdi mdi-pencil"></i>

                                    </a>

                                @endcan

                                @can('delete', $contact)

                                    <form action="{{ route('client-contacts.destroy', $contact) }}"
                                          method="POST"
                                          class="d-inline">

                                        @csrf

                                        @method('DELETE')

                                        <button type="submit"
                                                class="btn btn-sm btn-danger"
                                                title="Delete"
                                                onclick="return confirm('Are you sure you want to delete this contact?')">

                                            <i class="mdi mdi-delete"></i>

                                        </button>

                                    </form>

                                @endcan

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="8" class="text-center py-5">

                                <i class="mdi mdi-account-off-outline display-6 text-muted"></i>

                                <p class="text-muted mt-2 mb-0">

                                    No contacts found for this client.

                                </p>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>