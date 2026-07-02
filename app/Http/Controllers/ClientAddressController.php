<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClientAddressRequest;
use App\Http\Requests\UpdateClientAddressRequest;
use App\Models\Client;
use App\Models\ClientAddress;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ClientAddressController extends Controller
{
    /**
     * Display a listing of client addresses.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', ClientAddress::class);

        $query = ClientAddress::query()
            ->with('client');

        if ($request->filled('client_id')) {

            $query->where(
                'client_id',
                $request->client_id
            );

        }

        if ($request->filled('type')) {

            $query->where(
                'address_type',
                $request->type
            );

        }

        if ($request->filled('state')) {

            $query->where(
                'state',
                $request->state
            );

        }

        if ($request->filled('search')) {

            $search = trim($request->search);

            $query->where(function ($q) use ($search) {

                $q->where(
                    'address_line_1',
                    'like',
                    "%{$search}%"
                )

                ->orWhere(
                    'address_line_2',
                    'like',
                    "%{$search}%"
                )

                ->orWhere(
                    'city',
                    'like',
                    "%{$search}%"
                )

                ->orWhere(
                    'state',
                    'like',
                    "%{$search}%"
                )

                ->orWhere(
                    'country',
                    'like',
                    "%{$search}%"
                )

                ->orWhere(
                    'postal_code',
                    'like',
                    "%{$search}%"
                );

            });

        }

        $addresses = $query
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view(
            'client-addresses.index',
            compact('addresses')
        );
    }

    /**
     * Show the form for creating a new address.
     */
    public function create()
    {
        $this->authorize('create', ClientAddress::class);

        $clients = Client::orderBy('company_name')
            ->pluck(
                'company_name',
                'id'
            );

        return view(
            'client-addresses.create',
            compact('clients')
        );
    }

        /**
     * Store a newly created address.
     */
    public function store(StoreClientAddressRequest $request)
    {
        $this->authorize('create', ClientAddress::class);

        DB::beginTransaction();

        try {

            $data = $request->validated();

            /*
            |--------------------------------------------------------------------------
            | Maintain single default address
            |--------------------------------------------------------------------------
            */

            if (!empty($data['is_default'])) {

                ClientAddress::where(
                    'client_id',
                    $data['client_id']
                )->update([
                    'is_default' => false,
                ]);

            }

            $address = ClientAddress::create($data);

            DB::commit();

            return redirect()
                ->route('client-addresses.show', $address)
                ->with(
                    'success',
                    'Client address created successfully.'
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
     * Display the specified address.
     */
    public function show(ClientAddress $clientAddress)
    {
        $this->authorize('view', $clientAddress);

        $clientAddress->load('client');

        return view(
            'client-addresses.show',
            compact('clientAddress')
        );
    }

    /**
     * Show the form for editing the specified address.
     */
    public function edit(ClientAddress $clientAddress)
    {
        $this->authorize('update', $clientAddress);

        $clients = Client::orderBy('company_name')
            ->pluck(
                'company_name',
                'id'
            );

        return view(
            'client-addresses.edit',
            compact(
                'clientAddress',
                'clients'
            )
        );
    }

    /**
     * Update the specified address.
     */
    public function update(
        UpdateClientAddressRequest $request,
        ClientAddress $clientAddress
    ) {
        $this->authorize('update', $clientAddress);

        DB::beginTransaction();

        try {

            $data = $request->validated();

            /*
            |--------------------------------------------------------------------------
            | Only one default address
            |--------------------------------------------------------------------------
            */

            if (!empty($data['is_default'])) {

                ClientAddress::where(
                    'client_id',
                    $clientAddress->client_id
                )
                ->where(
                    'id',
                    '!=',
                    $clientAddress->id
                )
                ->update([
                    'is_default' => false,
                ]);

            }

            $clientAddress->update($data);

            DB::commit();

            return redirect()
                ->route(
                    'client-addresses.show',
                    $clientAddress
                )
                ->with(
                    'success',
                    'Client address updated successfully.'
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
     * Remove the specified address.
     */
    public function destroy(ClientAddress $clientAddress)
    {
        $this->authorize('delete', $clientAddress);

        DB::beginTransaction();

        try {

            /*
            |--------------------------------------------------------------------------
            | Prevent deleting the only default address
            |--------------------------------------------------------------------------
            */

            if ($clientAddress->is_default) {

                $replacement = ClientAddress::where(
                        'client_id',
                        $clientAddress->client_id
                    )
                    ->where(
                        'id',
                        '!=',
                        $clientAddress->id
                    )
                    ->first();

                if ($replacement) {

                    $replacement->update([
                        'is_default' => true,
                    ]);

                }

            }

            $clientAddress->delete();

            DB::commit();

            return redirect()
                ->route('client-addresses.index')
                ->with(
                    'success',
                    'Client address deleted successfully.'
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
 * Display trashed addresses.
 */
public function trashed(Request $request)
{
    $this->authorize('restore', ClientAddress::class);

    $query = ClientAddress::onlyTrashed()
        ->with('client');

    if ($request->filled('client_id')) {

        $query->where(
            'client_id',
            $request->client_id
        );

    }

    if ($request->filled('search')) {

        $search = trim($request->search);

        $query->where(function ($q) use ($search) {

            $q->where(
                'address_line_1',
                'like',
                "%{$search}%"
            )

            ->orWhere(
                'city',
                'like',
                "%{$search}%"
            )

            ->orWhere(
                'state',
                'like',
                "%{$search}%"
            )

            ->orWhere(
                'postal_code',
                'like',
                "%{$search}%"
            );

        });

    }

    $addresses = $query
        ->latest('deleted_at')
        ->paginate(20)
        ->withQueryString();

    return view(
        'client-addresses.trashed',
        compact('addresses')
    );
}

/**
 * Restore address.
 */
public function restore($id)
{
    $address = ClientAddress::onlyTrashed()
        ->findOrFail($id);

    $this->authorize('restore', $address);

    DB::beginTransaction();

    try {

        if ($address->is_default) {

            ClientAddress::where(
                'client_id',
                $address->client_id
            )->update([
                'is_default' => false,
            ]);

        }

        $address->restore();

        DB::commit();

        return redirect()
            ->route('client-addresses.trashed')
            ->with(
                'success',
                'Address restored successfully.'
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
 * Permanently delete address.
 */
public function forceDelete($id)
{
    $address = ClientAddress::onlyTrashed()
        ->findOrFail($id);

    $this->authorize(
        'forceDelete',
        $address
    );

    DB::beginTransaction();

    try {

        $address->forceDelete();

        DB::commit();

        return redirect()
            ->route('client-addresses.trashed')
            ->with(
                'success',
                'Address permanently deleted.'
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
 * Bulk delete addresses.
 */
public function bulkDelete(Request $request)
{
    $this->authorize(
        'delete',
        ClientAddress::class
    );

    $request->validate([

        'ids' => [
            'required',
            'array',
            'min:1',
        ],

        'ids.*' => [
            'exists:client_addresses,id',
        ],

    ]);

    DB::beginTransaction();

    try {

        ClientAddress::whereIn(
            'id',
            $request->ids
        )->delete();

        DB::commit();

        return back()->with(
            'success',
            count($request->ids)
            .' address(es) deleted successfully.'
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
 * Bulk restore addresses.
 */
public function bulkRestore(Request $request)
{
    $this->authorize(
        'restore',
        ClientAddress::class
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

        $addresses = ClientAddress::onlyTrashed()

            ->whereIn(
                'id',
                $request->ids
            )

            ->get();

        foreach ($addresses as $address) {

            if ($address->is_default) {

                ClientAddress::where(
                    'client_id',
                    $address->client_id
                )->update([
                    'is_default' => false,
                ]);

            }

            $address->restore();

        }

        DB::commit();

        return back()->with(
            'success',
            count($addresses)
            .' address(es) restored successfully.'
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
 * Empty trash.
 */
public function emptyTrash()
{
    $this->authorize(
        'forceDelete',
        ClientAddress::class
    );

    DB::beginTransaction();

    try {

        ClientAddress::onlyTrashed()
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
    $this->authorize('viewAny', ClientAddress::class);

    $query = ClientAddress::query()
        ->with('client');

    return DataTables::eloquent($query)

        ->addIndexColumn()

        ->addColumn('company', function ($address) {

            return optional($address->client)->company_name;

        })

        ->editColumn('address', function ($address) {

            return '
                <strong>'.$address->address_line_1.'</strong><br>
                '.$address->address_line_2.'<br>
                '.$address->city.', '.$address->state.'
            ';

        })

        ->editColumn('country', function ($address) {

            return $address->country;

        })

        ->editColumn('postal_code', function ($address) {

            return $address->postal_code;

        })

        ->editColumn('address_type', function ($address) {

            return '<span class="badge bg-info">'.
                    e($address->address_type).
                   '</span>';

        })

        ->editColumn('is_default', function ($address) {

            if($address->is_default){

                return '<span class="badge bg-success">
                        Default
                        </span>';

            }

            return '<span class="badge bg-secondary">
                    Secondary
                    </span>';

        })

        ->addColumn('action', function ($address){

            return view(
                'client-addresses.partials.actions',
                compact('address')
            )->render();

        })

        ->filter(function($query) use($request){

            if($request->filled('client_id')){

                $query->where(
                    'client_id',
                    $request->client_id
                );

            }

            if($request->filled('address_type')){

                $query->where(
                    'address_type',
                    $request->address_type
                );

            }

            if($request->filled('state')){

                $query->where(
                    'state',
                    $request->state
                );

            }

            if($request->filled('country')){

                $query->where(
                    'country',
                    $request->country
                );

            }

        })

        ->rawColumns([
            'address',
            'address_type',
            'is_default',
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
        ClientAddress::class
    );

    $term = trim($request->q);

    $addresses = ClientAddress::query()

        ->when($term,function($query) use($term){

            $query->where(function($q) use($term){

                $q->where(
                    'address_line_1',
                    'like',
                    "%{$term}%"
                )

                ->orWhere(
                    'city',
                    'like',
                    "%{$term}%"
                )

                ->orWhere(
                    'state',
                    'like',
                    "%{$term}%"
                )

                ->orWhere(
                    'postal_code',
                    'like',
                    "%{$term}%"
                );

            });

        })

        ->limit(20)

        ->get();

    return response()->json(

        $addresses->map(function($address){

            return [

                'id'=>$address->id,

                'text'=>$address->address_line_1.
                    ', '.$address->city,

            ];

        })

    );

}
/**
 * AJAX Delete
 */
public function ajaxDelete(
    ClientAddress $clientAddress
): JsonResponse
{
    $this->authorize(
        'delete',
        $clientAddress
    );

    $clientAddress->delete();

    return response()->json([

        'success'=>true,

        'message'=>'Address deleted successfully.'

    ]);
}
/**
 * Set Default Address
 */
public function setDefault(
    ClientAddress $clientAddress
): JsonResponse
{
    $this->authorize(
        'setDefault',
        $clientAddress
    );

    DB::beginTransaction();

    try{

        ClientAddress::where(

            'client_id',

            $clientAddress->client_id

        )->update([

            'is_default'=>false,

        ]);

        $clientAddress->update([

            'is_default'=>true,

        ]);

        DB::commit();

        return response()->json([

            'success'=>true,

            'message'=>'Default address updated.'

        ]);

    }

    catch(\Throwable $e){

        DB::rollBack();

        return response()->json([

            'success'=>false,

            'message'=>$e->getMessage(),

        ],500);

    }

}
/**
 * Verify Address
 */
public function verify(
    ClientAddress $clientAddress
): JsonResponse
{
    $this->authorize(
        'verify',
        $clientAddress
    );

    $clientAddress->update([

        'is_verified'=>true,

        'verified_at'=>now(),

        'verified_by'=>auth()->id(),

    ]);

    return response()->json([

        'success'=>true,

        'message'=>'Address verified successfully.'

    ]);
}
/**
 * Toggle Address Status
 */
public function toggleStatus(
    ClientAddress $clientAddress
): JsonResponse
{
    $this->authorize(
        'update',
        $clientAddress
    );

    $clientAddress->update([

        'is_active'=>!$clientAddress->is_active,

    ]);

    return response()->json([

        'success'=>true,

        'active'=>$clientAddress->is_active,

    ]);
}
}