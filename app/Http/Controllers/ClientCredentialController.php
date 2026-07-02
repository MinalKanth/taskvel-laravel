<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClientCredentialRequest;
use App\Http\Requests\UpdateClientCredentialRequest;
use App\Models\Client;
use App\Models\ClientCredential;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class ClientCredentialController extends Controller
{
    /**
     * Display all credentials.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', ClientCredential::class);

        $query = ClientCredential::query()
            ->with('client');

        if ($request->filled('client_id')) {

            $query->where(
                'client_id',
                $request->client_id
            );

        }

        if ($request->filled('credential_type')) {

            $query->where(
                'credential_type',
                $request->credential_type
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
                    'portal_name',
                    'like',
                    "%{$search}%"
                )

                ->orWhere(
                    'username',
                    'like',
                    "%{$search}%"
                )

                ->orWhere(
                    'email',
                    'like',
                    "%{$search}%"
                );

            });

        }

        $credentials = $query
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view(
            'client-credentials.index',
            compact('credentials')
        );
    }

    /**
     * Create credential.
     */
    public function create()
    {
        $this->authorize(
            'create',
            ClientCredential::class
        );

        $clients = Client::orderBy('company_name')
            ->pluck(
                'company_name',
                'id'
            );

        return view(
            'client-credentials.create',
            compact('clients')
        );
    }

    /**
 * Store credential.
 */
public function store(StoreClientCredentialRequest $request)
{
    $this->authorize(
        'create',
        ClientCredential::class
    );

    DB::beginTransaction();

    try {

        $data = $request->validated();

        /*
        |--------------------------------------------------------------------------
        | Encrypt Sensitive Data
        |--------------------------------------------------------------------------
        */

        if (!empty($data['password'])) {

            $data['password'] = Crypt::encryptString(
                $data['password']
            );

        }

        if (!empty($data['security_pin'])) {

            $data['security_pin'] = Crypt::encryptString(
                $data['security_pin']
            );

        }

        if (!empty($data['api_key'])) {

            $data['api_key'] = Crypt::encryptString(
                $data['api_key']
            );

        }

        if (!empty($data['api_secret'])) {

            $data['api_secret'] = Crypt::encryptString(
                $data['api_secret']
            );

        }

        if (!empty($data['access_token'])) {

            $data['access_token'] = Crypt::encryptString(
                $data['access_token']
            );

        }

        if (!empty($data['refresh_token'])) {

            $data['refresh_token'] = Crypt::encryptString(
                $data['refresh_token']
            );

        }

        $credential = ClientCredential::create($data);

        DB::commit();

        return redirect()
            ->route(
                'client-credentials.show',
                $credential
            )
            ->with(
                'success',
                'Credential created successfully.'
            );

    }

    catch (\Throwable $e) {

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
 * Show credential.
 */
public function show(
    ClientCredential $clientCredential
)
{
    $this->authorize(
        'view',
        $clientCredential
    );

    $clientCredential->load([
        'client',
    ]);

    return view(
        'client-credentials.show',
        compact(
            'clientCredential'
        )
    );
}

/**
 * Edit credential.
 */
public function edit(
    ClientCredential $clientCredential
)
{
    $this->authorize(
        'update',
        $clientCredential
    );

    $clients = Client::orderBy(
            'company_name'
        )
        ->pluck(
            'company_name',
            'id'
        );

    return view(
        'client-credentials.edit',
        compact(
            'clientCredential',
            'clients'
        )
    );
}

/**
 * Update credential.
 */
public function update(
    UpdateClientCredentialRequest $request,
    ClientCredential $clientCredential
)
{
    $this->authorize(
        'update',
        $clientCredential
    );

    DB::beginTransaction();

    try {

        $data = $request->validated();

        /*
        |--------------------------------------------------------------------------
        | Encrypt Updated Values
        |--------------------------------------------------------------------------
        */

        foreach ([
            'password',
            'security_pin',
            'api_key',
            'api_secret',
            'access_token',
            'refresh_token'
        ] as $field) {

            if (
                !empty($data[$field])
            ) {

                $data[$field] = Crypt::encryptString(
                    $data[$field]
                );

            } else {

                unset(
                    $data[$field]
                );

            }

        }

        $clientCredential->update($data);

        DB::commit();

        return redirect()
            ->route(
                'client-credentials.show',
                $clientCredential
            )
            ->with(
                'success',
                'Credential updated successfully.'
            );

    }

    catch (\Throwable $e) {

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
 * Delete credential.
 */
public function destroy(
    ClientCredential $clientCredential
)
{
    $this->authorize(
        'delete',
        $clientCredential
    );

    DB::beginTransaction();

    try {

        $clientCredential->delete();

        DB::commit();

        return redirect()
            ->route(
                'client-credentials.index'
            )
            ->with(
                'success',
                'Credential deleted successfully.'
            );

    }

    catch (\Throwable $e) {

        DB::rollBack();

        return back()->with(
            'error',
            $e->getMessage()
        );

    }
}
/**
 * Display trashed credentials.
 */
public function trashed(Request $request)
{
    $this->authorize('restore', ClientCredential::class);

    $query = ClientCredential::onlyTrashed()
        ->with('client');

    if ($request->filled('client_id')) {

        $query->where(
            'client_id',
            $request->client_id
        );

    }

    if ($request->filled('credential_type')) {

        $query->where(
            'credential_type',
            $request->credential_type
        );

    }

    if ($request->filled('search')) {

        $search = trim($request->search);

        $query->where(function ($q) use ($search) {

            $q->where(
                'portal_name',
                'like',
                "%{$search}%"
            )

            ->orWhere(
                'username',
                'like',
                "%{$search}%"
            )

            ->orWhere(
                'email',
                'like',
                "%{$search}%"
            );

        });

    }

    $credentials = $query
        ->latest('deleted_at')
        ->paginate(20)
        ->withQueryString();

    return view(
        'client-credentials.trashed',
        compact('credentials')
    );
}

/**
 * Restore credential.
 */
public function restore($id)
{
    $credential = ClientCredential::onlyTrashed()
        ->findOrFail($id);

    $this->authorize(
        'restore',
        $credential
    );

    DB::beginTransaction();

    try {

        $credential->restore();

        DB::commit();

        return redirect()
            ->route('client-credentials.trashed')
            ->with(
                'success',
                'Credential restored successfully.'
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
 * Permanently delete credential.
 */
public function forceDelete($id)
{
    $credential = ClientCredential::onlyTrashed()
        ->findOrFail($id);

    $this->authorize(
        'forceDelete',
        $credential
    );

    DB::beginTransaction();

    try {

        $credential->forceDelete();

        DB::commit();

        return redirect()
            ->route('client-credentials.trashed')
            ->with(
                'success',
                'Credential permanently deleted.'
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
 * Bulk delete credentials.
 */
public function bulkDelete(Request $request)
{
    $this->authorize(
        'delete',
        ClientCredential::class
    );

    $request->validate([

        'ids' => [
            'required',
            'array',
            'min:1',
        ],

        'ids.*' => [
            'exists:client_credentials,id',
        ],

    ]);

    DB::beginTransaction();

    try {

        ClientCredential::whereIn(
            'id',
            $request->ids
        )->delete();

        DB::commit();

        return back()->with(
            'success',
            count($request->ids)
            .' credential(s) deleted successfully.'
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
 * Bulk restore credentials.
 */
public function bulkRestore(Request $request)
{
    $this->authorize(
        'restore',
        ClientCredential::class
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

        ClientCredential::onlyTrashed()
            ->whereIn(
                'id',
                $request->ids
            )
            ->restore();

        DB::commit();

        return back()->with(
            'success',
            count($request->ids)
            .' credential(s) restored successfully.'
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
 * Empty credential trash.
 */
public function emptyTrash()
{
    $this->authorize(
        'forceDelete',
        ClientCredential::class
    );

    DB::beginTransaction();

    try {

        ClientCredential::onlyTrashed()
            ->forceDelete();

        DB::commit();

        return back()->with(
            'success',
            'Credential trash emptied successfully.'
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
    $this->authorize('viewAny', ClientCredential::class);

    $query = ClientCredential::query()
        ->with('client');

    return DataTables::eloquent($query)

        ->addIndexColumn()

        ->addColumn('company', function ($row) {

            return optional($row->client)->company_name;

        })

        ->editColumn('portal_name', function ($row) {

            return '<strong>'.e($row->portal_name).'</strong>';

        })

        ->editColumn('username', function ($row) {

            return e($row->username);

        })

        ->editColumn('status', function ($row) {

            $class = match ($row->status) {

                'Active' => 'success',

                'Inactive' => 'secondary',

                'Expired' => 'danger',

                'Locked' => 'warning',

                default => 'dark',

            };

            return '<span class="badge bg-'.$class.'">'.
                    e($row->status).
                   '</span>';

        })

        ->editColumn('expiry_date', function ($row) {

            return $row->expiry_date
                ? $row->expiry_date->format('d M Y')
                : '-';

        })

        ->addColumn('actions', function ($row) {

            return view(
                'client-credentials.partials.actions',
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

            if ($request->filled('credential_type')) {

                $query->where(
                    'credential_type',
                    $request->credential_type
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
            'portal_name',
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
        ClientCredential::class
    );

    $term = trim($request->q);

    $credentials = ClientCredential::query()

        ->when($term, function ($query) use ($term) {

            $query->where(function ($q) use ($term) {

                $q->where(
                    'portal_name',
                    'like',
                    "%{$term}%"
                )

                ->orWhere(
                    'username',
                    'like',
                    "%{$term}%"
                )

                ->orWhere(
                    'email',
                    'like',
                    "%{$term}%"
                );

            });

        })

        ->limit(20)

        ->get([
            'id',
            'portal_name',
            'username',
        ]);

    return response()->json(

        $credentials->map(function ($credential) {

            return [

                'id' => $credential->id,

                'text' =>
                    $credential->portal_name.
                    ' - '.
                    $credential->username,

            ];

        })

    );
}

/**
 * AJAX Delete
 */
public function ajaxDelete(
    ClientCredential $clientCredential
): JsonResponse
{
    $this->authorize(
        'delete',
        $clientCredential
    );

    $clientCredential->delete();

    return response()->json([

        'success' => true,

        'message' => 'Credential deleted successfully.',

    ]);
}

/**
 * Toggle Active Status
 */
public function toggleStatus(
    ClientCredential $clientCredential
): JsonResponse
{
    $this->authorize(
        'update',
        $clientCredential
    );

    $status = $clientCredential->status === 'Active'
        ? 'Inactive'
        : 'Active';

    $clientCredential->update([

        'status' => $status,

    ]);

    return response()->json([

        'success' => true,

        'status' => $status,

    ]);
}

/**
 * Check Expiry
 */
public function checkExpiry(
    ClientCredential $clientCredential
): JsonResponse
{
    $this->authorize(
        'view',
        $clientCredential
    );

    $expired = false;
    $days = null;

    if ($clientCredential->expiry_date) {

        $days = now()->diffInDays(
            $clientCredential->expiry_date,
            false
        );

        $expired = $days < 0;

    }

    return response()->json([

        'expired' => $expired,

        'days_remaining' => $days,

    ]);
}
}