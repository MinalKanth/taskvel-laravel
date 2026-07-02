<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClientRemarkRequest;
use App\Http\Requests\UpdateClientRemarkRequest;
use App\Models\Client;
use App\Models\ClientRemark;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ClientRemarkController extends Controller
{
    /**
     * Display remarks.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', ClientRemark::class);

        $query = ClientRemark::query()

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

        if ($request->filled('priority')) {

            $query->where(
                'priority',
                $request->priority
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
                    'title',
                    'like',
                    "%{$search}%"
                )

                ->orWhere(
                    'remark',
                    'like',
                    "%{$search}%"
                );

            });

        }

        $remarks = $query

            ->latest()

            ->paginate(20)

            ->withQueryString();

        return view(
            'client-remarks.index',
            compact('remarks')
        );
    }

    /**
     * Create remark.
     */
    public function create()
    {
        $this->authorize(
            'create',
            ClientRemark::class
        );

        $clients = Client::orderBy(
                'company_name'
            )
            ->pluck(
                'company_name',
                'id'
            );

        return view(
            'client-remarks.create',
            compact('clients')
        );
    }
/**
 * Store a newly created remark.
 */
public function store(StoreClientRemarkRequest $request)
{
    $this->authorize('create', ClientRemark::class);

    DB::beginTransaction();

    try {

        $data = $request->validated();

        $data['created_by'] = auth()->id();

        $remark = ClientRemark::create($data);

        DB::commit();

        return redirect()
            ->route(
                'client-remarks.show',
                $remark
            )
            ->with(
                'success',
                'Remark added successfully.'
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
 * Display the specified remark.
 */
public function show(ClientRemark $clientRemark)
{
    $this->authorize('view', $clientRemark);

    $clientRemark->load([
        'client',
        'user',
    ]);

    return view(
        'client-remarks.show',
        compact('clientRemark')
    );
}

/**
 * Show the form for editing the specified remark.
 */
public function edit(ClientRemark $clientRemark)
{
    $this->authorize('update', $clientRemark);

    $clients = Client::orderBy('company_name')
        ->pluck(
            'company_name',
            'id'
        );

    return view(
        'client-remarks.edit',
        compact(
            'clientRemark',
            'clients'
        )
    );
}

/**
 * Update the specified remark.
 */
public function update(
    UpdateClientRemarkRequest $request,
    ClientRemark $clientRemark
)
{
    $this->authorize('update', $clientRemark);

    DB::beginTransaction();

    try {

        $clientRemark->update(
            $request->validated()
        );

        DB::commit();

        return redirect()
            ->route(
                'client-remarks.show',
                $clientRemark
            )
            ->with(
                'success',
                'Remark updated successfully.'
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
 * Remove the specified remark.
 */
public function destroy(
    ClientRemark $clientRemark
)
{
    $this->authorize('delete', $clientRemark);

    DB::beginTransaction();

    try {

        $clientRemark->delete();

        DB::commit();

        return redirect()
            ->route(
                'client-remarks.index'
            )
            ->with(
                'success',
                'Remark deleted successfully.'
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
 * Display trashed remarks.
 */
public function trashed(Request $request)
{
    $this->authorize('restore', ClientRemark::class);

    $query = ClientRemark::onlyTrashed()
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

    if ($request->filled('priority')) {

        $query->where(
            'priority',
            $request->priority
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
                'title',
                'like',
                "%{$search}%"
            )

            ->orWhere(
                'remark',
                'like',
                "%{$search}%"
            );

        });

    }

    $remarks = $query
        ->latest('deleted_at')
        ->paginate(20)
        ->withQueryString();

    return view(
        'client-remarks.trashed',
        compact('remarks')
    );
}

/**
 * Restore remark.
 */
public function restore($id)
{
    $remark = ClientRemark::onlyTrashed()
        ->findOrFail($id);

    $this->authorize(
        'restore',
        $remark
    );

    DB::beginTransaction();

    try {

        $remark->restore();

        DB::commit();

        return redirect()
            ->route(
                'client-remarks.trashed'
            )
            ->with(
                'success',
                'Remark restored successfully.'
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
 * Permanently delete remark.
 */
public function forceDelete($id)
{
    $remark = ClientRemark::onlyTrashed()
        ->findOrFail($id);

    $this->authorize(
        'forceDelete',
        $remark
    );

    DB::beginTransaction();

    try {

        $remark->forceDelete();

        DB::commit();

        return redirect()
            ->route(
                'client-remarks.trashed'
            )
            ->with(
                'success',
                'Remark permanently deleted.'
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
 * Bulk delete remarks.
 */
public function bulkDelete(Request $request)
{
    $this->authorize(
        'delete',
        ClientRemark::class
    );

    $request->validate([

        'ids' => [
            'required',
            'array',
            'min:1',
        ],

        'ids.*' => [
            'exists:client_remarks,id',
        ],

    ]);

    DB::beginTransaction();

    try {

        ClientRemark::whereIn(
            'id',
            $request->ids
        )->delete();

        DB::commit();

        return back()->with(
            'success',
            count($request->ids)
            .' remark(s) deleted successfully.'
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
 * Bulk restore remarks.
 */
public function bulkRestore(Request $request)
{
    $this->authorize(
        'restore',
        ClientRemark::class
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

        ClientRemark::onlyTrashed()
            ->whereIn(
                'id',
                $request->ids
            )
            ->restore();

        DB::commit();

        return back()->with(
            'success',
            count($request->ids)
            .' remark(s) restored successfully.'
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
 * Empty remark trash.
 */
public function emptyTrash()
{
    $this->authorize(
        'forceDelete',
        ClientRemark::class
    );

    DB::beginTransaction();

    try {

        ClientRemark::onlyTrashed()
            ->forceDelete();

        DB::commit();

        return back()->with(
            'success',
            'Remark trash emptied successfully.'
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
    $this->authorize('viewAny', ClientRemark::class);

    $query = ClientRemark::query()
        ->with([
            'client',
            'user',
        ]);

    return DataTables::eloquent($query)

        ->addIndexColumn()

        ->addColumn('company', function ($remark) {

            return optional(
                $remark->client
            )->company_name;

        })

        ->editColumn('title', function ($remark) {

            return '<strong>'.
                    e($remark->title).
                    '</strong>';

        })

        ->editColumn('priority', function ($remark) {

            $class = match ($remark->priority) {

                'Low' => 'secondary',

                'Medium' => 'primary',

                'High' => 'warning',

                'Critical' => 'danger',

                default => 'dark',

            };

            return '<span class="badge bg-'.$class.'">'.
                    e($remark->priority).
                   '</span>';

        })

        ->editColumn('status', function ($remark) {

            $class = match ($remark->status) {

                'Open' => 'warning',

                'Resolved' => 'success',

                'Closed' => 'secondary',

                default => 'dark',

            };

            return '<span class="badge bg-'.$class.'">'.
                    e($remark->status).
                   '</span>';

        })

        ->addColumn('created_by', function ($remark) {

            return optional(
                $remark->user
            )->name;

        })

        ->addColumn('actions', function ($remark) {

            return view(
                'client-remarks.partials.actions',
                compact('remark')
            )->render();

        })

        ->filter(function ($query) use ($request) {

            if ($request->filled('client_id')) {

                $query->where(
                    'client_id',
                    $request->client_id
                );

            }

            if ($request->filled('priority')) {

                $query->where(
                    'priority',
                    $request->priority
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
            'title',
            'priority',
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
        ClientRemark::class
    );

    $term = trim($request->q);

    $remarks = ClientRemark::query()

        ->when($term,function($query) use($term){

            $query->where(function($q) use($term){

                $q->where(
                    'title',
                    'like',
                    "%{$term}%"
                )

                ->orWhere(
                    'remark',
                    'like',
                    "%{$term}%"
                );

            });

        })

        ->limit(20)

        ->get([
            'id',
            'title'
        ]);

    return response()->json(

        $remarks->map(function($remark){

            return [

                'id'=>$remark->id,

                'text'=>$remark->title,

            ];

        })

    );

}

/**
 * AJAX Delete
 */
public function ajaxDelete(
    ClientRemark $clientRemark
): JsonResponse
{
    $this->authorize(
        'delete',
        $clientRemark
    );

    $clientRemark->delete();

    return response()->json([

        'success'=>true,

        'message'=>'Remark deleted successfully.'

    ]);
}

/**
 * Pin Remark
 */
public function pin(
    ClientRemark $clientRemark
): JsonResponse
{
    $this->authorize(
        'update',
        $clientRemark
    );

    $clientRemark->update([

        'is_pinned'=>true,

    ]);

    return response()->json([

        'success'=>true,

    ]);
}

/**
 * Unpin Remark
 */
public function unpin(
    ClientRemark $clientRemark
): JsonResponse
{
    $this->authorize(
        'update',
        $clientRemark
    );

    $clientRemark->update([

        'is_pinned'=>false,

    ]);

    return response()->json([

        'success'=>true,

    ]);
}

/**
 * Resolve Remark
 */
public function resolve(
    ClientRemark $clientRemark
): JsonResponse
{
    $this->authorize(
        'update',
        $clientRemark
    );

    $clientRemark->update([

        'status'=>'Resolved',

        'resolved_at'=>now(),

    ]);

    return response()->json([

        'success'=>true,

    ]);
}

/**
 * Reopen Remark
 */
public function reopen(
    ClientRemark $clientRemark
): JsonResponse
{
    $this->authorize(
        'update',
        $clientRemark
    );

    $clientRemark->update([

        'status'=>'Open',

        'resolved_at'=>null,

    ]);

    return response()->json([

        'success'=>true,

    ]);
}

/**
 * Change Priority
 */
public function changePriority(
    Request $request,
    ClientRemark $clientRemark
): JsonResponse
{
    $this->authorize(
        'update',
        $clientRemark
    );

    $request->validate([

        'priority'=>[
            'required',
            'in:Low,Medium,High,Critical'
        ],

    ]);

    $clientRemark->update([

        'priority'=>$request->priority,

    ]);

    return response()->json([

        'success'=>true,

    ]);
}
}