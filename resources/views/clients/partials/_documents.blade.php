<div class="card shadow-sm mb-4">

    <div class="card-header d-flex justify-content-between align-items-center">

        <h5 class="mb-0">

            <i class="mdi mdi-file-document-outline me-2"></i>

            Client Documents

        </h5>

        @can('create', App\Models\ClientDocument::class)

            <a href="{{ route('client-documents.create', ['client' => $client->id]) }}"
               class="btn btn-primary btn-sm">

                <i class="mdi mdi-plus"></i>

                Upload Document

            </a>

        @endcan

    </div>

    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">

                    <tr>

                        <th>Document</th>

                        <th>Number</th>

                        <th>Type</th>

                        <th>Issue Date</th>

                        <th>Expiry Date</th>

                        <th>Verification</th>

                        <th>Status</th>

                        <th width="220">

                            Actions

                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($client->documents as $document)

                        <tr>

                            <td>

                                <strong>

                                    {{ $document->document_name }}

                                </strong>

                                <br>

                                <small class="text-muted">

                                    {{ $document->original_file_name }}

                                </small>

                            </td>

                            <td>

                                {{ $document->document_number ?: '-' }}

                            </td>

                            <td>

                                {{ $document->document_type }}

                            </td>

                            <td>

                                {{ optional($document->issue_date)?->format('d M Y') }}

                            </td>

                            <td>

                                @if($document->expiry_date)

                                    @if($document->expiry_date->isPast())

                                        <span class="badge bg-danger">

                                            Expired

                                        </span>

                                        <br>

                                    @elseif($document->expiry_date->diffInDays(now()) <= 30)

                                        <span class="badge bg-warning">

                                            Expiring Soon

                                        </span>

                                        <br>

                                    @endif

                                    {{ $document->expiry_date->format('d M Y') }}

                                @else

                                    -

                                @endif

                            </td>

                            <td>

                                @switch($document->verification_status)

                                    @case('Verified')

                                        <span class="badge bg-success">

                                            Verified

                                        </span>

                                        @break

                                    @case('Rejected')

                                        <span class="badge bg-danger">

                                            Rejected

                                        </span>

                                        @break

                                    @default

                                        <span class="badge bg-warning">

                                            Pending

                                        </span>

                                @endswitch

                            </td>

                            <td>

                                @if($document->is_active)

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

                                @can('view', $document)

                                    <a href="{{ route('client-documents.show', $document) }}"
                                       class="btn btn-info btn-sm">

                                        <i class="mdi mdi-eye"></i>

                                    </a>

                                @endcan

                                @if($document->file_path)

                                    <a href="{{ route('client-documents.download', $document) }}"
                                       class="btn btn-success btn-sm">

                                        <i class="mdi mdi-download"></i>

                                    </a>

                                @endif

                                @can('update', $document)

                                    <a href="{{ route('client-documents.edit', $document) }}"
                                       class="btn btn-warning btn-sm">

                                        <i class="mdi mdi-pencil"></i>

                                    </a>

                                @endcan

                                @can('delete', $document)

                                    <form
                                        action="{{ route('client-documents.destroy', $document) }}"
                                        method="POST"
                                        class="d-inline">

                                        @csrf

                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Delete this document?')">

                                            <i class="mdi mdi-delete"></i>

                                        </button>

                                    </form>

                                @endcan

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="8"
                                class="text-center py-5 text-muted">

                                No documents uploaded.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>