<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClientContactRequest;
use App\Http\Requests\UpdateClientContactRequest;
use App\Models\Client;
use App\Models\ClientContact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\JsonResponse;


class ClientContactController extends Controller
{
    /**
     * Display all contacts.
     */
    public function index(Request $request)
{
    $this->authorize(
        'viewAny',
        ClientContact::class
    );

    $query = ClientContact::query()

        ->with([
            'client',
        ]);

    if ($request->filled('client_id')) {

        $query->where(
            'client_id',
            $request->client_id
        );

    }

    if ($request->filled('is_active')) {

        $query->where(
            'is_active',
            $request->is_active
        );

    }

    if ($request->filled('is_primary')) {

        $query->where(
            'is_primary',
            $request->is_primary
        );

    }

    if ($request->filled('search')) {

        $search = trim($request->search);

        $query->where(function ($q) use ($search) {

            $q->where(
                'first_name',
                'like',
                "%{$search}%"
            )

            ->orWhere(
                'last_name',
                'like',
                "%{$search}%"
            )

            ->orWhere(
                'full_name',
                'like',
                "%{$search}%"
            )

            ->orWhere(
                'designation',
                'like',
                "%{$search}%"
            )

            ->orWhere(
                'department',
                'like',
                "%{$search}%"
            )

            ->orWhere(
                'email',
                'like',
                "%{$search}%"
            )

            ->orWhere(
                'mobile',
                'like',
                "%{$search}%"
            )

            ->orWhere(
                'whatsapp_number',
                'like',
                "%{$search}%"
            );

        });

    }

    $contacts = $query

        ->latest()

        ->paginate(20)

        ->withQueryString();

    $clients = Client::orderBy(
        'company_name'
    )->get();

    return view(
        'client-contacts.index',
        compact(
            'contacts',
            'clients'
        )
    );
}

    /**
     * Create Contact
     */
    public function create(Request $request)
    {
        $this->authorize('create', ClientContact::class);

        $clients = Client::orderBy('company_name')
            ->get(['id', 'client_code', 'company_name']);

        $selectedClient = $request->query('client');

        return view(
            'client-contacts.create',
            compact(
                'clients',
                'selectedClient'
            )
        );
    }
        /**
     * Store a newly created contact.
     */
    public function store(StoreClientContactRequest $request)
    {
        $this->authorize('create', ClientContact::class);

        DB::beginTransaction();

        try {

            $data = $request->validated();

            /*
            |--------------------------------------------------------------------------
            | Only one primary contact per client
            |--------------------------------------------------------------------------
            */

            if (!empty($data['is_primary'])) {

                ClientContact::where(
                    'client_id',
                    $data['client_id']
                )->update([
                    'is_primary' => false,
                ]);

            }

            $contact = ClientContact::create($data);

            DB::commit();

            return redirect()
                ->route('client-contacts.show', $contact)
                ->with(
                    'success',
                    'Client contact created successfully.'
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
     * Display contact details.
     */
    public function show(ClientContact $clientContact)
    {
        $this->authorize('view', $clientContact);

        $clientContact->load([
            'client',
        ]);

        return view(
            'client-contacts.show',
            compact('clientContact')
        );
    }

    /**
     * Show edit form.
     */
    public function edit(ClientContact $clientContact)
    {
        $this->authorize('update', $clientContact);

        $clients = Client::select(
                'id',
                'client_code',
                'company_name'
            )
            ->orderBy('company_name')
            ->get();

        return view(
            'client-contacts.edit',
            compact(
                'clientContact',
                'clients'
            )
        );
    }

    /**
     * Update contact.
     */
    public function update(
        UpdateClientContactRequest $request,
        ClientContact $clientContact
    ) {
        $this->authorize('update', $clientContact);

        DB::beginTransaction();

        try {

            $data = $request->validated();

            /*
            |--------------------------------------------------------------------------
            | Maintain one primary contact
            |--------------------------------------------------------------------------
            */

            if (!empty($data['is_primary'])) {

                ClientContact::where(
                    'client_id',
                    $clientContact->client_id
                )
                ->where(
                    'id',
                    '!=',
                    $clientContact->id
                )
                ->update([
                    'is_primary' => false,
                ]);

            }

            $clientContact->update($data);

            DB::commit();

            return redirect()
                ->route(
                    'client-contacts.show',
                    $clientContact
                )
                ->with(
                    'success',
                    'Client contact updated successfully.'
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
     * Delete contact.
     */
    public function destroy(ClientContact $clientContact)
    {
        $this->authorize('delete', $clientContact);

        DB::beginTransaction();

        try {

            $clientContact->delete();

            DB::commit();

            return redirect()
                ->route('client-contacts.index')
                ->with(
                    'success',
                    'Client contact deleted successfully.'
                );

        } catch (\Throwable $e) {

            DB::rollBack();

            return back()
                ->with(
                    'error',
                    $e->getMessage()
                );

        }
    }
    /**
 * Display trashed contacts.
 */
public function trashed(Request $request)
{
    $this->authorize('restore', ClientContact::class);

    $query = ClientContact::onlyTrashed()
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

            $q->where('name', 'like', "%{$search}%")
                ->orWhere('designation', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('mobile', 'like', "%{$search}%");

        });

    }

    $contacts = $query
        ->latest('deleted_at')
        ->paginate(20)
        ->withQueryString();

    return view(
        'client-contacts.trashed',
        compact('contacts')
    );
}

/**
 * Restore contact.
 */
public function restore($id)
{
    $contact = ClientContact::onlyTrashed()
        ->findOrFail($id);

    $this->authorize('restore', $contact);

    DB::beginTransaction();

    try {

        /*
        |--------------------------------------------------------------------------
        | Restore
        |--------------------------------------------------------------------------
        */

        if ($contact->is_primary) {

            ClientContact::where(
                'client_id',
                $contact->client_id
            )->update([
                'is_primary' => false,
            ]);

        }

        $contact->restore();

        DB::commit();

        return redirect()
            ->route('client-contacts.trashed')
            ->with(
                'success',
                'Contact restored successfully.'
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
 * Permanently delete contact.
 */
public function forceDelete($id)
{
    $contact = ClientContact::onlyTrashed()
        ->findOrFail($id);

    $this->authorize(
        'forceDelete',
        $contact
    );

    DB::beginTransaction();

    try {

        $contact->forceDelete();

        DB::commit();

        return redirect()
            ->route('client-contacts.trashed')
            ->with(
                'success',
                'Contact permanently deleted.'
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
 * Bulk delete.
 */
public function bulkDelete(Request $request)
{
    $this->authorize(
        'delete',
        ClientContact::class
    );

    $request->validate([

        'ids' => [
            'required',
            'array',
            'min:1',
        ],

        'ids.*' => [
            'integer',
            'exists:client_contacts,id',
        ],

    ]);

    DB::beginTransaction();

    try {

        ClientContact::whereIn(
            'id',
            $request->ids
        )->delete();

        DB::commit();

        return back()->with(
            'success',
            count($request->ids) .
            ' contact(s) deleted successfully.'
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
 * Bulk restore.
 */
public function bulkRestore(Request $request)
{
    $this->authorize(
        'restore',
        ClientContact::class
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

        $contacts = ClientContact::onlyTrashed()
            ->whereIn(
                'id',
                $request->ids
            )
            ->get();

        foreach ($contacts as $contact) {

            if ($contact->is_primary) {

                ClientContact::where(
                    'client_id',
                    $contact->client_id
                )->update([
                    'is_primary' => false,
                ]);

            }

            $contact->restore();

        }

        DB::commit();

        return back()->with(
            'success',
            count($contacts) .
            ' contact(s) restored successfully.'
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
 * AJAX Datatable
 */
public function datatable(Request $request): JsonResponse
{
    $this->authorize('viewAny', ClientContact::class);

    $query = ClientContact::query()
        ->with('client');

    return DataTables::eloquent($query)

        ->addIndexColumn()

        ->addColumn('company', function ($contact) {

            return optional($contact->client)->company_name;

        })

        ->editColumn('name', function ($contact) {

            return '
                <strong>'.$contact->name.'</strong>
                <br>
                <small class="text-muted">'.$contact->designation.'</small>
            ';

        })

        ->editColumn('email', function ($contact) {

            return '
                '.$contact->email.'
                <br>
                <small>'.$contact->mobile.'</small>
            ';

        })

        ->editColumn('is_primary', function ($contact) {

            if($contact->is_primary){

                return '<span class="badge bg-success">Primary</span>';

            }

            return '<span class="badge bg-secondary">Secondary</span>';

        })

        ->editColumn('status', function ($contact) {

            return $contact->is_active

                ? '<span class="badge bg-success">Active</span>'

                : '<span class="badge bg-danger">Inactive</span>';

        })

        ->addColumn('action', function ($contact){

            return view(
                'client-contacts.partials.actions',
                compact('contact')
            )->render();

        })

        ->filter(function ($query) use ($request){

            if($request->filled('client_id')){

                $query->where(
                    'client_id',
                    $request->client_id
                );

            }

            if($request->filled('is_primary')){

                $query->where(
                    'is_primary',
                    $request->is_primary
                );

            }

            if($request->filled('status')){

                $query->where(
                    'is_active',
                    $request->status
                );

            }

        })

        ->rawColumns([
            'name',
            'email',
            'status',
            'is_primary',
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
        ClientContact::class
    );

    $term = trim($request->q);

    $contacts = ClientContact::query()

        ->when($term,function($query) use($term){

            $query->where(function($q) use($term){

                $q->where(
                    'name',
                    'like',
                    "%{$term}%"
                )

                ->orWhere(
                    'email',
                    'like',
                    "%{$term}%"
                )

                ->orWhere(
                    'mobile',
                    'like',
                    "%{$term}%"
                );

            });

        })

        ->limit(20)

        ->get([
            'id',
            'name',
            'designation'
        ]);

    return response()->json(

        $contacts->map(function($contact){

            return [

                'id'=>$contact->id,

                'text'=>$contact->name.
                    ' ('.
                    $contact->designation.
                    ')',

            ];

        })

    );

}
/**
 * AJAX Delete
 */
public function ajaxDelete(
    ClientContact $clientContact
): JsonResponse
{

    $this->authorize(
        'delete',
        $clientContact
    );

    $clientContact->delete();

    return response()->json([

        'success'=>true,

        'message'=>'Contact deleted successfully.'

    ]);

}
/**
 * Activate Contact
 */
public function activate(
    ClientContact $clientContact
): JsonResponse
{

    $this->authorize(
        'update',
        $clientContact
    );

    $clientContact->update([

        'is_active'=>true,

    ]);

    return response()->json([

        'success'=>true,

    ]);

}
/**
 * Deactivate Contact
 */
public function deactivate(
    ClientContact $clientContact
): JsonResponse
{

    $this->authorize(
        'update',
        $clientContact
    );

    $clientContact->update([

        'is_active'=>false,

    ]);

    return response()->json([

        'success'=>true,

    ]);

}
/**
 * Toggle Primary Contact
 */
public function setPrimary(
    ClientContact $clientContact
): JsonResponse
{

    $this->authorize(
        'markPrimary',
        $clientContact
    );

    DB::beginTransaction();

    try{

        ClientContact::where(

            'client_id',

            $clientContact->client_id

        )->update([

            'is_primary'=>false,

        ]);

        $clientContact->update([

            'is_primary'=>true,

        ]);

        DB::commit();

        return response()->json([

            'success'=>true,

            'message'=>'Primary contact updated.'

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
}