<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClientServiceRequest;
use App\Http\Requests\UpdateClientServiceRequest;
use App\Models\Client;
use App\Models\ClientService;
use App\Models\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ClientServiceController extends Controller
{
    /**
     * Display a listing of client services.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', ClientService::class);

        $query = ClientService::query()

            ->with([
                'client',
                'service',
            ]);

        if ($request->filled('client_id')) {

            $query->where(
                'client_id',
                $request->client_id
            );

        }

        if ($request->filled('service_id')) {

            $query->where(
                'service_id',
                $request->service_id
            );

        }

        if ($request->filled('status')) {

            $query->where(
                'status',
                $request->status
            );

        }

        if ($request->filled('search')) {

            $search = trim($request->search);

            $query->where(function ($q) use ($search) {

                $q->whereHas('client', function ($client) use ($search) {

                    $client->where(
                        'company_name',
                        'like',
                        "%{$search}%"
                    );

                })

                ->orWhereHas('service', function ($service) use ($search) {

                    $service->where(
                        'name',
                        'like',
                        "%{$search}%"
                    );

                });

            });

        }

        $clientServices = $query

            ->latest()

            ->paginate(20)

            ->withQueryString();

        return view(
            'client-services.index',
            compact('clientServices')
        );
    }

    /**
     * Show the form for creating a new service assignment.
     */
    public function create()
    {
        $this->authorize('create', ClientService::class);

        $clients = Client::orderBy('company_name')

            ->pluck(
                'company_name',
                'id'
            );

        $services = Service::orderBy('name')

            ->pluck(
                'name',
                'id'
            );

        return view(
            'client-services.create',
            compact(
                'clients',
                'services'
            )
        );
    }
/**
 * Store a newly assigned service.
 */
public function store(StoreClientServiceRequest $request)
{
    $this->authorize('create', ClientService::class);

    DB::beginTransaction();

    try {

        $data = $request->validated();

        /*
        |--------------------------------------------------------------------------
        | Prevent duplicate active service
        |--------------------------------------------------------------------------
        */

        $exists = ClientService::where(
                'client_id',
                $data['client_id']
            )
            ->where(
                'service_id',
                $data['service_id']
            )
            ->where(
                'status',
                'Active'
            )
            ->exists();

        if ($exists) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'This service is already active for the selected client.'
                );

        }

        $clientService = ClientService::create($data);

        DB::commit();

        return redirect()
            ->route(
                'client-services.show',
                $clientService
            )
            ->with(
                'success',
                'Service assigned successfully.'
            );

    } catch (\Throwable $e) {

        DB::rollBack();

        return back()
            ->withInput()
            ->with(
                'error',
                $e->getMessage()
            );

    }
}

/**
 * Display the specified service.
 */
public function show(ClientService $clientService)
{
    $this->authorize('view', $clientService);

    $clientService->load([
        'client',
        'service',
    ]);

    return view(
        'client-services.show',
        compact('clientService')
    );
}

/**
 * Show edit form.
 */
public function edit(ClientService $clientService)
{
    $this->authorize('update', $clientService);

    $clients = Client::orderBy('company_name')
        ->pluck(
            'company_name',
            'id'
        );

    $services = Service::orderBy('name')
        ->pluck(
            'name',
            'id'
        );

    return view(
        'client-services.edit',
        compact(
            'clientService',
            'clients',
            'services'
        )
    );
}

/**
 * Update assigned service.
 */
public function update(
    UpdateClientServiceRequest $request,
    ClientService $clientService
)
{
    $this->authorize(
        'update',
        $clientService
    );

    DB::beginTransaction();

    try {

        $data = $request->validated();

        $exists = ClientService::where(
                'client_id',
                $data['client_id']
            )
            ->where(
                'service_id',
                $data['service_id']
            )
            ->where(
                'id',
                '!=',
                $clientService->id
            )
            ->where(
                'status',
                'Active'
            )
            ->exists();

        if ($exists) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'An active service already exists.'
                );

        }

        $clientService->update($data);

        DB::commit();

        return redirect()
            ->route(
                'client-services.show',
                $clientService
            )
            ->with(
                'success',
                'Service updated successfully.'
            );

    } catch (\Throwable $e) {

        DB::rollBack();

        return back()
            ->withInput()
            ->with(
                'error',
                $e->getMessage()
            );

    }
}

/**
 * Delete assigned service.
 */
public function destroy(
    ClientService $clientService
)
{
    $this->authorize(
        'delete',
        $clientService
    );

    DB::beginTransaction();

    try {

        $clientService->delete();

        DB::commit();

        return redirect()
            ->route(
                'client-services.index'
            )
            ->with(
                'success',
                'Service deleted successfully.'
            );

    } catch (\Throwable $e) {

        DB::rollBack();

        return back()->with(
            'error',
            $e->getMessage()
        );

    }
}
/**
 * Display trashed client services.
 */
public function trashed(Request $request)
{
    $this->authorize('restore', ClientService::class);

    $query = ClientService::onlyTrashed()
        ->with([
            'client',
            'service',
        ]);

    if ($request->filled('client_id')) {

        $query->where(
            'client_id',
            $request->client_id
        );

    }

    if ($request->filled('service_id')) {

        $query->where(
            'service_id',
            $request->service_id
        );

    }

    if ($request->filled('status')) {

        $query->where(
            'status',
            $request->status
        );

    }

    if ($request->filled('search')) {

        $search = trim($request->search);

        $query->where(function ($q) use ($search) {

            $q->whereHas('client', function ($client) use ($search) {

                $client->where(
                    'company_name',
                    'like',
                    "%{$search}%"
                );

            })

            ->orWhereHas('service', function ($service) use ($search) {

                $service->where(
                    'name',
                    'like',
                    "%{$search}%"
                );

            });

        });

    }

    $clientServices = $query
        ->latest('deleted_at')
        ->paginate(20)
        ->withQueryString();

    return view(
        'client-services.trashed',
        compact('clientServices')
    );
}

/**
 * Restore service.
 */
public function restore($id)
{
    $clientService = ClientService::onlyTrashed()
        ->findOrFail($id);

    $this->authorize(
        'restore',
        $clientService
    );

    DB::beginTransaction();

    try {

        $exists = ClientService::where(
                'client_id',
                $clientService->client_id
            )
            ->where(
                'service_id',
                $clientService->service_id
            )
            ->where(
                'status',
                'Active'
            )
            ->exists();

        if ($exists) {

            return back()->with(
                'error',
                'An active service already exists for this client.'
            );

        }

        $clientService->restore();

        DB::commit();

        return redirect()
            ->route(
                'client-services.trashed'
            )
            ->with(
                'success',
                'Service restored successfully.'
            );

    } catch (\Throwable $e) {

        DB::rollBack();

        return back()->with(
            'error',
            $e->getMessage()
        );

    }
}

/**
 * Permanently delete service.
 */
public function forceDelete($id)
{
    $clientService = ClientService::onlyTrashed()
        ->findOrFail($id);

    $this->authorize(
        'forceDelete',
        $clientService
    );

    DB::beginTransaction();

    try {

        $clientService->forceDelete();

        DB::commit();

        return redirect()
            ->route(
                'client-services.trashed'
            )
            ->with(
                'success',
                'Service permanently deleted.'
            );

    } catch (\Throwable $e) {

        DB::rollBack();

        return back()->with(
            'error',
            $e->getMessage()
        );

    }
}

/**
 * Bulk delete services.
 */
public function bulkDelete(Request $request)
{
    $this->authorize(
        'delete',
        ClientService::class
    );

    $request->validate([

        'ids' => [
            'required',
            'array',
            'min:1',
        ],

        'ids.*' => [
            'exists:client_services,id',
        ],

    ]);

    DB::beginTransaction();

    try {

        ClientService::whereIn(
            'id',
            $request->ids
        )->delete();

        DB::commit();

        return back()->with(
            'success',
            count($request->ids)
            .' service(s) deleted successfully.'
        );

    } catch (\Throwable $e) {

        DB::rollBack();

        return back()->with(
            'error',
            $e->getMessage()
        );

    }
}

/**
 * Bulk restore services.
 */
public function bulkRestore(Request $request)
{
    $this->authorize(
        'restore',
        ClientService::class
    );

    $request->validate([

        'ids' => [
            'required',
            'array',
        ],

        'ids.*' => [
            'integer',
        ],

    ]);

    DB::beginTransaction();

    try {

        $services = ClientService::onlyTrashed()
            ->whereIn(
                'id',
                $request->ids
            )
            ->get();

        foreach ($services as $service) {

            $exists = ClientService::where(
                    'client_id',
                    $service->client_id
                )
                ->where(
                    'service_id',
                    $service->service_id
                )
                ->where(
                    'status',
                    'Active'
                )
                ->exists();

            if (!$exists) {

                $service->restore();

            }

        }

        DB::commit();

        return back()->with(
            'success',
            count($services)
            .' service(s) restored successfully.'
        );

    } catch (\Throwable $e) {

        DB::rollBack();

        return back()->with(
            'error',
            $e->getMessage()
        );

    }
}

/**
 * Empty service trash.
 */
public function emptyTrash()
{
    $this->authorize(
        'forceDelete',
        ClientService::class
    );

    DB::beginTransaction();

    try {

        ClientService::onlyTrashed()
            ->forceDelete();

        DB::commit();

        return back()->with(
            'success',
            'Trash emptied successfully.'
        );

    } catch (\Throwable $e) {

        DB::rollBack();

        return back()->with(
            'error',
            $e->getMessage()
        );

    }
}
/**
 * AJAX DataTable
 */
public function datatable(Request $request): JsonResponse
{
    $this->authorize('viewAny', ClientService::class);

    $query = ClientService::query()
        ->with([
            'client',
            'service',
        ]);

    return DataTables::eloquent($query)

        ->addIndexColumn()

        ->addColumn('company', function ($row) {

            return optional($row->client)->company_name;

        })

        ->addColumn('service_name', function ($row) {

            return optional($row->service)->name;

        })

        ->editColumn('status', function ($row) {

            $class = match ($row->status) {

                'Active' => 'success',

                'Pending' => 'warning',

                'Completed' => 'primary',

                'Suspended' => 'danger',

                'Expired' => 'secondary',

                default => 'dark',
            };

            return '<span class="badge bg-'.$class.'">'.
                e($row->status).
                '</span>';

        })

        ->editColumn('start_date', function ($row) {

            return optional($row->start_date)
                ? date('d M Y', strtotime($row->start_date))
                : '-';

        })

        ->editColumn('end_date', function ($row) {

            return optional($row->end_date)
                ? date('d M Y', strtotime($row->end_date))
                : '-';

        })

        ->addColumn('action', function ($row) {

            return view(
                'client-services.partials.actions',
                compact('row')
            )->render();

        })

        ->filter(function ($query) use ($request) {

            if ($request->filled('client_id')) {

                $query->where(
                    'client_id',
                    $request->client_id
                );

            }

            if ($request->filled('service_id')) {

                $query->where(
                    'service_id',
                    $request->service_id
                );

            }

            if ($request->filled('status')) {

                $query->where(
                    'status',
                    $request->status
                );

            }

        })

        ->rawColumns([
            'status',
            'action',
        ])

        ->make(true);
}
/**
 * AJAX Search
 */
public function search(Request $request): JsonResponse
{
    $this->authorize(
        'viewAny',
        ClientService::class
    );

    $term = trim($request->q);

    $services = ClientService::query()

        ->with([
            'client',
            'service',
        ])

        ->when($term, function ($query) use ($term) {

            $query->whereHas(
                'client',
                function ($q) use ($term) {

                    $q->where(
                        'company_name',
                        'like',
                        "%{$term}%"
                    );

                }
            );

        })

        ->limit(20)

        ->get();

    return response()->json(

        $services->map(function ($service) {

            return [

                'id' => $service->id,

                'text' =>
                    optional($service->client)->company_name .
                    ' - ' .
                    optional($service->service)->name,

            ];

        })

    );
}
/**
 * Activate Service
 */
public function activate(
    ClientService $clientService
): JsonResponse
{
    $this->authorize(
        'update',
        $clientService
    );

    $clientService->update([

        'status' => 'Active',

    ]);

    return response()->json([

        'success' => true,

        'message' => 'Service activated.'

    ]);
}
/**
 * Suspend Service
 */
public function suspend(
    ClientService $clientService
): JsonResponse
{
    $this->authorize(
        'update',
        $clientService
    );

    $clientService->update([

        'status' => 'Suspended',

    ]);

    return response()->json([

        'success' => true,

        'message' => 'Service suspended.'

    ]);
}
/**
 * Mark Completed
 */
public function complete(
    ClientService $clientService
): JsonResponse
{
    $this->authorize(
        'update',
        $clientService
    );

    $clientService->update([

        'status' => 'Completed',

        'completed_at' => now(),

    ]);

    return response()->json([

        'success' => true,

    ]);
}
/**
 * Mark Pending
 */
public function pending(
    ClientService $clientService
): JsonResponse
{
    $this->authorize(
        'update',
        $clientService
    );

    $clientService->update([

        'status' => 'Pending',

    ]);

    return response()->json([

        'success' => true,

    ]);
}
/**
 * Renew Service
 */
public function renew(
    ClientService $clientService
): JsonResponse
{
    $this->authorize(
        'update',
        $clientService
    );

    DB::beginTransaction();

    try {

        $clientService->update([

            'status' => 'Active',

            'start_date' => now(),

            'end_date' => now()->addYear(),

        ]);

        DB::commit();

        return response()->json([

            'success' => true,

            'message' => 'Service renewed.'

        ]);

    } catch (\Throwable $e) {

        DB::rollBack();

        return response()->json([

            'success' => false,

            'message' => $e->getMessage(),

        ], 500);

    }
}
/**
 * AJAX Delete
 */
public function ajaxDelete(
    ClientService $clientService
): JsonResponse
{
    $this->authorize(
        'delete',
        $clientService
    );

    $clientService->delete();

    return response()->json([

        'success' => true,

        'message' => 'Service deleted.'

    ]);
}

}