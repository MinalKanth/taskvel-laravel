<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClientCommunicationRequest;
use App\Http\Requests\UpdateClientCommunicationRequest;
use App\Models\Client;
use App\Models\ClientCommunication;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ClientCommunicationController extends Controller
{
    /**
     * Display communications.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', ClientCommunication::class);

        $query = ClientCommunication::query()

            ->with([
                'client',
                'user',
            ]);

        if ($request->filled('client_id')) {

            $query->where(
                'client_id',
                $request->client_id
            );

        }

        if ($request->filled('type')) {

            $query->where(
                'communication_type',
                $request->type
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

                $q->where(
                    'subject',
                    'like',
                    "%{$search}%"
                )

                ->orWhere(
                    'message',
                    'like',
                    "%{$search}%"
                );

            });

        }

        $communications = $query

            ->latest()

            ->paginate(20)

            ->withQueryString();

        return view(
            'client-communications.index',
            compact('communications')
        );
    }

    /**
     * Create communication.
     */
    public function create()
    {
        $this->authorize(
            'create',
            ClientCommunication::class
        );

        $clients = Client::orderBy(
                'company_name'
            )
            ->pluck(
                'company_name',
                'id'
            );

        return view(
            'client-communications.create',
            compact('clients')
        );
    }
    /**
 * Store a newly created communication.
 */
public function store(StoreClientCommunicationRequest $request)
{
    $this->authorize(
        'create',
        ClientCommunication::class
    );

    DB::beginTransaction();

    try {

        $data = $request->validated();

        $data['user_id'] = auth()->id();

        $data['communication_at'] ??= now();

        $communication = ClientCommunication::create($data);

        DB::commit();

        return redirect()
            ->route(
                'client-communications.show',
                $communication
            )
            ->with(
                'success',
                'Communication saved successfully.'
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
 * Display the specified communication.
 */
public function show(
    ClientCommunication $clientCommunication
)
{
    $this->authorize(
        'view',
        $clientCommunication
    );

    $clientCommunication->load([
        'client',
        'user',
    ]);

    return view(
        'client-communications.show',
        compact(
            'clientCommunication'
        )
    );
}

/**
 * Show the form for editing the specified communication.
 */
public function edit(
    ClientCommunication $clientCommunication
)
{
    $this->authorize(
        'update',
        $clientCommunication
    );

    $clients = Client::orderBy('company_name')
        ->pluck(
            'company_name',
            'id'
        );

    return view(
        'client-communications.edit',
        compact(
            'clientCommunication',
            'clients'
        )
    );
}

/**
 * Update the specified communication.
 */
public function update(
    UpdateClientCommunicationRequest $request,
    ClientCommunication $clientCommunication
)
{
    $this->authorize(
        'update',
        $clientCommunication
    );

    DB::beginTransaction();

    try {

        $clientCommunication->update(
            $request->validated()
        );

        DB::commit();

        return redirect()
            ->route(
                'client-communications.show',
                $clientCommunication
            )
            ->with(
                'success',
                'Communication updated successfully.'
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
 * Remove the specified communication.
 */
public function destroy(
    ClientCommunication $clientCommunication
)
{
    $this->authorize(
        'delete',
        $clientCommunication
    );

    DB::beginTransaction();

    try {

        $clientCommunication->delete();

        DB::commit();

        return redirect()
            ->route(
                'client-communications.index'
            )
            ->with(
                'success',
                'Communication deleted successfully.'
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
 * Display trashed communications.
 */
public function trashed(Request $request)
{
    $this->authorize('restore', ClientCommunication::class);

    $query = ClientCommunication::onlyTrashed()
        ->with([
            'client',
            'user',
        ]);

    if ($request->filled('client_id')) {

        $query->where(
            'client_id',
            $request->client_id
        );

    }

    if ($request->filled('communication_type')) {

        $query->where(
            'communication_type',
            $request->communication_type
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

            $q->where(
                'subject',
                'like',
                "%{$search}%"
            )

            ->orWhere(
                'message',
                'like',
                "%{$search}%"
            );

        });

    }

    $communications = $query
        ->latest('deleted_at')
        ->paginate(20)
        ->withQueryString();

    return view(
        'client-communications.trashed',
        compact('communications')
    );
}

/**
 * Restore communication.
 */
public function restore($id)
{
    $communication = ClientCommunication::onlyTrashed()
        ->findOrFail($id);

    $this->authorize(
        'restore',
        $communication
    );

    DB::beginTransaction();

    try {

        $communication->restore();

        DB::commit();

        return redirect()
            ->route(
                'client-communications.trashed'
            )
            ->with(
                'success',
                'Communication restored successfully.'
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
 * Permanently delete communication.
 */
public function forceDelete($id)
{
    $communication = ClientCommunication::onlyTrashed()
        ->findOrFail($id);

    $this->authorize(
        'forceDelete',
        $communication
    );

    DB::beginTransaction();

    try {

        $communication->forceDelete();

        DB::commit();

        return redirect()
            ->route(
                'client-communications.trashed'
            )
            ->with(
                'success',
                'Communication permanently deleted.'
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
 * Bulk delete communications.
 */
public function bulkDelete(Request $request)
{
    $this->authorize(
        'delete',
        ClientCommunication::class
    );

    $request->validate([

        'ids' => [
            'required',
            'array',
            'min:1',
        ],

        'ids.*' => [
            'exists:client_communications,id',
        ],

    ]);

    DB::beginTransaction();

    try {

        ClientCommunication::whereIn(
            'id',
            $request->ids
        )->delete();

        DB::commit();

        return back()->with(
            'success',
            count($request->ids)
            .' communication(s) deleted successfully.'
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
 * Bulk restore communications.
 */
public function bulkRestore(Request $request)
{
    $this->authorize(
        'restore',
        ClientCommunication::class
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

        ClientCommunication::onlyTrashed()
            ->whereIn(
                'id',
                $request->ids
            )
            ->restore();

        DB::commit();

        return back()->with(
            'success',
            count($request->ids)
            .' communication(s) restored successfully.'
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
 * Empty communication trash.
 */
public function emptyTrash()
{
    $this->authorize(
        'forceDelete',
        ClientCommunication::class
    );

    DB::beginTransaction();

    try {

        ClientCommunication::onlyTrashed()
            ->forceDelete();

        DB::commit();

        return back()->with(
            'success',
            'Communication trash emptied successfully.'
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
    $this->authorize('viewAny', ClientCommunication::class);

    $query = ClientCommunication::query()
        ->with([
            'client',
            'user',
        ]);

    return DataTables::eloquent($query)

        ->addIndexColumn()

        ->addColumn('company', function ($communication) {

            return optional(
                $communication->client
            )->company_name;

        })

        ->addColumn('created_by', function ($communication) {

            return optional(
                $communication->user
            )->name;

        })

        ->editColumn('communication_type', function ($communication) {

            $class = match ($communication->communication_type) {

                'Email' => 'primary',

                'WhatsApp' => 'success',

                'SMS' => 'info',

                'Call' => 'warning',

                'Meeting' => 'danger',

                default => 'secondary',

            };

            return '<span class="badge bg-'.$class.'">'.
                e($communication->communication_type).
                '</span>';

        })

        ->editColumn('status', function ($communication) {

            $class = match ($communication->status) {

                'Draft' => 'secondary',

                'Pending' => 'warning',

                'Sent' => 'success',

                'Delivered' => 'primary',

                'Read' => 'info',

                'Failed' => 'danger',

                default => 'dark',

            };

            return '<span class="badge bg-'.$class.'">'.
                e($communication->status).
                '</span>';

        })

        ->editColumn('communication_at', function ($communication) {

            return optional(
                $communication->communication_at
            )?->format('d M Y H:i');

        })

        ->addColumn('actions', function ($communication) {

            return view(
                'client-communications.partials.actions',
                compact('communication')
            )->render();

        })

        ->filter(function ($query) use ($request) {

            if ($request->filled('client_id')) {

                $query->where(
                    'client_id',
                    $request->client_id
                );

            }

            if ($request->filled('communication_type')) {

                $query->where(
                    'communication_type',
                    $request->communication_type
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
            'communication_type',
            'status',
            'actions',
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
        ClientCommunication::class
    );

    $term = trim($request->q);

    $communications = ClientCommunication::query()

        ->when($term,function($query) use($term){

            $query->where(function($q) use($term){

                $q->where(
                    'subject',
                    'like',
                    "%{$term}%"
                )

                ->orWhere(
                    'message',
                    'like',
                    "%{$term}%"
                );

            });

        })

        ->limit(20)

        ->get([
            'id',
            'subject'
        ]);

    return response()->json(

        $communications->map(function($communication){

            return [

                'id'=>$communication->id,

                'text'=>$communication->subject,

            ];

        })

    );

}

/**
 * AJAX Delete
 */
public function ajaxDelete(
    ClientCommunication $clientCommunication
): JsonResponse
{
    $this->authorize(
        'delete',
        $clientCommunication
    );

    $clientCommunication->delete();

    return response()->json([

        'success'=>true,

        'message'=>'Communication deleted.'

    ]);
}

/**
 * Mark Read
 */
public function markRead(
    ClientCommunication $clientCommunication
): JsonResponse
{
    $this->authorize(
        'update',
        $clientCommunication
    );

    $clientCommunication->update([

        'is_read'=>true,

        'read_at'=>now(),

    ]);

    return response()->json([

        'success'=>true,

    ]);
}

/**
 * Mark Unread
 */
public function markUnread(
    ClientCommunication $clientCommunication
): JsonResponse
{
    $this->authorize(
        'update',
        $clientCommunication
    );

    $clientCommunication->update([

        'is_read'=>false,

        'read_at'=>null,

    ]);

    return response()->json([

        'success'=>true,

    ]);
}

/**
 * Archive Communication
 */
public function archive(
    ClientCommunication $clientCommunication
): JsonResponse
{
    $this->authorize(
        'update',
        $clientCommunication
    );

    $clientCommunication->update([

        'is_archived'=>true,

    ]);

    return response()->json([

        'success'=>true,

    ]);
}

/**
 * Unarchive Communication
 */
public function unarchive(
    ClientCommunication $clientCommunication
): JsonResponse
{
    $this->authorize(
        'update',
        $clientCommunication
    );

    $clientCommunication->update([

        'is_archived'=>false,

    ]);

    return response()->json([

        'success'=>true,

    ]);
}

/**
 * Change Status
 */
public function changeStatus(
    Request $request,
    ClientCommunication $clientCommunication
): JsonResponse
{
    $this->authorize(
        'update',
        $clientCommunication
    );

    $request->validate([

        'status'=>[
            'required',
            'in:Draft,Pending,Sent,Delivered,Read,Failed'
        ],

    ]);

    $clientCommunication->update([

        'status'=>$request->status,

    ]);

    return response()->json([

        'success'=>true,

    ]);
}
}