<div class="card shadow-sm mb-4">

    <div class="card-header d-flex justify-content-between align-items-center">

        <h5 class="mb-0">

            <i class="mdi mdi-note-text-outline me-2"></i>

            Client Remarks

        </h5>

        @can('create', App\Models\ClientRemark::class)

            <a href="{{ route('client-remarks.create', ['client' => $client->id]) }}"
               class="btn btn-primary btn-sm">

                <i class="mdi mdi-plus"></i>

                Add Remark

            </a>

        @endcan

    </div>

    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">

                    <tr>

                        <th>Date</th>

                        <th>Title</th>

                        <th>Priority</th>

                        <th>Type</th>

                        <th>Created By</th>

                        <th>Status</th>

                        <th width="220">

                            Actions

                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($client->remarks as $remark)

                        <tr>

                            <td>

                                {{ $remark->created_at?->format('d M Y') }}

                            </td>

                            <td>

                                <strong>

                                    {{ $remark->title }}

                                </strong>

                                <br>

                                <small class="text-muted">

                                    {{ \Illuminate\Support\Str::limit($remark->remark, 60) }}

                                </small>

                            </td>

                            <td>

                                @switch($remark->priority)

                                    @case('High')

                                        <span class="badge bg-danger">

                                            High

                                        </span>

                                        @break

                                    @case('Medium')

                                        <span class="badge bg-warning">

                                            Medium

                                        </span>

                                        @break

                                    @default

                                        <span class="badge bg-success">

                                            Low

                                        </span>

                                @endswitch

                            </td>

                            <td>

                                {{ $remark->type ?? '-' }}

                            </td>

                            <td>

                                {{ optional($remark->creator)->name ?? '-' }}

                            </td>

                            <td>

                                @if($remark->is_active)

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

                                @can('view', $remark)

                                    <a href="{{ route('client-remarks.show', $remark) }}"
                                       class="btn btn-info btn-sm">

                                        <i class="mdi mdi-eye"></i>

                                    </a>

                                @endcan

                                @can('update', $remark)

                                    <a href="{{ route('client-remarks.edit', $remark) }}"
                                       class="btn btn-warning btn-sm">

                                        <i class="mdi mdi-pencil"></i>

                                    </a>

                                @endcan

                                @can('delete', $remark)

                                    <form
                                        action="{{ route('client-remarks.destroy', $remark) }}"
                                        method="POST"
                                        class="d-inline">

                                        @csrf

                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Delete this remark?')">

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

                                No remarks available.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>