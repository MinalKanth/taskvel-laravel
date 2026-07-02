<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Exports\ClientsExport;
use App\Imports\ClientsImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use App\Models\ClientDocument;
use App\Models\ClientCredential;
use App\Models\ClientCommunication;
use App\Models\ClientRemark;
use App\Models\ClientService;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\JsonResponse;
use App\Models\User;


class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Client::class);

        $query = Client::query();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('company_name', 'like', "%{$search}%")
                  ->orWhere('client_code', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('gstin', 'like', "%{$search}%")
                  ->orWhere('pan', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('business_type')) {
            $query->where('business_type', $request->business_type);
        }

        $clients = $query->latest()->paginate(15)->withQueryString();

        return view('clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()

{

    $this->authorize('create', Client::class);

    $users = User::orderBy('name')->get();

    return view('clients.create', compact('users'));

}

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClientRequest $request)
    {
        $this->authorize('create', Client::class);

        DB::beginTransaction();

        try {

            // Generate Unique Client Code
            $lastClient = Client::latest('id')->first();

            $nextNumber = $lastClient
                ? ((int) str_replace('CLI', '', $lastClient->client_code)) + 1
                : 1;

            $data = $request->validated();

            $data['client_code'] = 'CLI' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);

            // Create Client
            $client = Client::create($data);

            DB::commit();

            return redirect()
                ->route('clients.show', $client)
                ->with('success', 'Client created successfully.');

        } catch (\Throwable $e) {

            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        $this->authorize('view', $client);

        $client->load([
            'contacts',
            'addresses',
            'services',
            'documents',
            'credentials',
            'remarks',
            'communications',
            'bankAccounts',
            'notes',
            'timeline',
        ]);

        return view('clients.show', compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    
    public function edit(Client $client)
    {
        $this->authorize('update', $client);

        $users = User::orderBy('name')->get();

        return view('clients.edit', compact('client', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClientRequest $request, Client $client)
    {
        $this->authorize('update', $client);

        DB::beginTransaction();

        try {
            $client->update($request->validated());

            DB::commit();

            return redirect()
                ->route('clients.show', $client)
                ->with('success', 'Client updated successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        $this->authorize('delete', $client);

        $client->delete();

        return redirect()
            ->route('clients.index')
            ->with('success', 'Client deleted successfully.');
    }

    /**
 * Display all soft deleted clients.
 */
public function trashed(Request $request)
{
    $this->authorize('restore', Client::class);

    $query = Client::onlyTrashed();

    if ($request->filled('search')) {

        $search = $request->search;

        $query->where(function ($q) use ($search) {

            $q->where('company_name', 'like', "%{$search}%")
              ->orWhere('client_code', 'like', "%{$search}%")
              ->orWhere('gstin', 'like', "%{$search}%")
              ->orWhere('pan', 'like', "%{$search}%")
              ->orWhere('phone', 'like', "%{$search}%");

        });
    }

    $clients = $query
        ->latest('deleted_at')
        ->paginate(15)
        ->withQueryString();

    return view('clients.trashed', compact('clients'));
}
/**
 * Restore a soft deleted client.
 */
public function restore(int $id)
{
    $client = Client::onlyTrashed()->findOrFail($id);

    $this->authorize('restore', $client);

    DB::beginTransaction();

    try {

        $client->restore();

        DB::commit();

        return redirect()
            ->route('clients.trashed')
            ->with('success', 'Client restored successfully.');

    } catch (\Throwable $e) {

        DB::rollBack();

        return back()->with('error', $e->getMessage());

    }
}
/**
 * Permanently delete a client.
 */
public function forceDelete(int $id)
{
    $client = Client::onlyTrashed()->findOrFail($id);

    $this->authorize('forceDelete', $client);

    DB::beginTransaction();

    try {

        // Delete related files if required

        // foreach ($client->documents as $document) {
        //     Storage::disk('public')->delete($document->file_path);
        // }

        $client->forceDelete();

        DB::commit();

        return redirect()
            ->route('clients.trashed')
            ->with('success', 'Client permanently deleted.');

    } catch (\Throwable $e) {

        DB::rollBack();

        return back()->with('error', $e->getMessage());

    }
}
/**
 * Restore multiple clients.
 */
public function bulkRestore(Request $request)
{
    $this->authorize('restore', Client::class);

    $request->validate([
        'ids' => ['required', 'array'],
        'ids.*' => ['integer'],
    ]);

    DB::beginTransaction();

    try {

        Client::onlyTrashed()
            ->whereIn('id', $request->ids)
            ->restore();

        DB::commit();

        return back()->with(
            'success',
            count($request->ids) . ' client(s) restored successfully.'
        );

    } catch (\Throwable $e) {

        DB::rollBack();

        return back()->with('error', $e->getMessage());

    }
}
/**
 * Permanently delete multiple clients.
 */
public function bulkForceDelete(Request $request)
{
    $this->authorize('forceDelete', Client::class);

    $request->validate([
        'ids' => ['required', 'array'],
        'ids.*' => ['integer'],
    ]);

    DB::beginTransaction();

    try {

        Client::onlyTrashed()
            ->whereIn('id', $request->ids)
            ->forceDelete();

        DB::commit();

        return back()->with(
            'success',
            count($request->ids) . ' client(s) permanently deleted.'
        );

    } catch (\Throwable $e) {

        DB::rollBack();

        return back()->with('error', $e->getMessage());

    }
}
/**
 * Permanently delete all trashed clients.
 */
public function emptyTrash()
{
    $this->authorize('forceDelete', Client::class);

    DB::beginTransaction();

    try {

        Client::onlyTrashed()->forceDelete();

        DB::commit();

        return back()->with(
            'success',
            'Trash emptied successfully.'
        );

    } catch (\Throwable $e) {

        DB::rollBack();

        return back()->with('error', $e->getMessage());

    }
}
/**
 * Soft delete multiple clients.
 */
public function bulkDelete(Request $request)
{
    $this->authorize('delete', Client::class);

    $request->validate([
        'ids' => ['required', 'array', 'min:1'],
        'ids.*' => ['integer', 'exists:clients,id'],
    ]);

    DB::beginTransaction();

    try {

        Client::whereIn('id', $request->ids)->delete();

        DB::commit();

        return back()->with(
            'success',
            count($request->ids) . ' client(s) deleted successfully.'
        );

    } catch (\Throwable $e) {

        DB::rollBack();

        return back()->with('error', $e->getMessage());

    }
}
/**
 * Update status of multiple clients.
 */
public function bulkStatus(Request $request)
{
    $this->authorize('update', Client::class);

    $request->validate([

        'ids' => ['required', 'array'],

        'ids.*' => ['exists:clients,id'],

        'status' => [
            'required',
            'in:Lead,Prospect,Active,Inactive,Suspended,Closed',
        ],

    ]);

    DB::beginTransaction();

    try {

        Client::whereIn('id', $request->ids)
            ->update([
                'status' => $request->status,
            ]);

        DB::commit();

        return back()->with(
            'success',
            'Status updated successfully.'
        );

    } catch (\Throwable $e) {

        DB::rollBack();

        return back()->with('error', $e->getMessage());

    }
}
/**
 * Update priority of multiple clients.
 */
public function bulkPriority(Request $request)
{
    $this->authorize('update', Client::class);

    $request->validate([

        'ids' => ['required', 'array'],

        'ids.*' => ['exists:clients,id'],

        'priority' => [
            'required',
            'in:Low,Medium,High,Critical',
        ],

    ]);

    DB::beginTransaction();

    try {

        Client::whereIn('id', $request->ids)
            ->update([
                'priority' => $request->priority,
            ]);

        DB::commit();

        return back()->with(
            'success',
            'Priority updated successfully.'
        );

    } catch (\Throwable $e) {

        DB::rollBack();

        return back()->with('error', $e->getMessage());

    }
}
/**
 * Assign executive to multiple clients.
 */
public function bulkAssign(Request $request)
{
    $this->authorize('assign', Client::class);

    $request->validate([

        'ids' => ['required', 'array'],

        'ids.*' => ['exists:clients,id'],

        'assigned_to' => [
            'required',
            'exists:users,id',
        ],

    ]);

    DB::beginTransaction();

    try {

        Client::whereIn('id', $request->ids)
            ->update([
                'assigned_to' => $request->assigned_to,
            ]);

        DB::commit();

        return back()->with(
            'success',
            'Clients assigned successfully.'
        );

    } catch (\Throwable $e) {

        DB::rollBack();

        return back()->with('error', $e->getMessage());

    }
}
/**
 * Archive multiple clients.
 */
public function bulkArchive(Request $request)
{
    $this->authorize('update', Client::class);

    $request->validate([
        'ids' => ['required', 'array'],
        'ids.*' => ['exists:clients,id'],
    ]);

    Client::whereIn('id', $request->ids)
        ->update([
            'is_active' => false,
        ]);

    return back()->with(
        'success',
        'Clients archived successfully.'
    );
}
/**
 * Activate archived clients.
 */
public function bulkUnarchive(Request $request)
{
    $this->authorize('update', Client::class);

    $request->validate([
        'ids' => ['required', 'array'],
        'ids.*' => ['exists:clients,id'],
    ]);

    Client::whereIn('id', $request->ids)
        ->update([
            'is_active' => true,
        ]);

    return back()->with(
        'success',
        'Clients activated successfully.'
    );
}
/**
 * Export Clients
 */
public function export(Request $request)
{
    $this->authorize('export', Client::class);

    $filename = 'clients_' . now()->format('Y_m_d_H_i_s') . '.xlsx';

    return Excel::download(
        new ClientsExport($request),
        $filename
    );
}
/**
 * Show Import Page
 */
public function import()
{
    $this->authorize('import', Client::class);

    return view('clients.import');
}
/**
 * Import Clients
 */
public function importStore(Request $request)
{
    $this->authorize('import', Client::class);

    $validator = Validator::make($request->all(), [

        'file' => [
            'required',
            'file',
            'mimes:xlsx,xls,csv',
            'max:10240',
        ],

    ]);

    if ($validator->fails()) {

        return back()
            ->withErrors($validator)
            ->withInput();

    }

    DB::beginTransaction();

    try {

        Excel::import(
            new ClientsImport,
            $request->file('file')
        );

        DB::commit();

        return redirect()
            ->route('clients.index')
            ->with('success', 'Clients imported successfully.');

    } catch (\Throwable $e) {

        DB::rollBack();

        return back()
            ->with('error', $e->getMessage());

    }
}
/**
 * Download Import Template
 */
public function downloadTemplate()
{
    $this->authorize('import', Client::class);

    $headers = [

        [
            'Client Code',
            'Company Name',
            'Legal Name',
            'Business Type',
            'GSTIN',
            'PAN',
            'TAN',
            'Email',
            'Phone',
            'Website',
            'Status',
            'Priority',
        ],

    ];

    $filename = storage_path(
        'app/public/client_import_template.csv'
    );

    $file = fopen($filename, 'w');

    foreach ($headers as $row) {
        fputcsv($file, $row);
    }

    fclose($file);

    return response()->download($filename);
}
/**
 * Export Selected Clients
 */
public function exportSelected(Request $request)
{
    $this->authorize('export', Client::class);

    $request->validate([

        'ids' => ['required', 'array'],

        'ids.*' => ['exists:clients,id'],

    ]);

    return Excel::download(

        new ClientsExport($request->ids),

        'selected_clients.xlsx'

    );
}
/**
 * Export Deleted Clients
 */
public function exportTrashed()
{
    $this->authorize('export', Client::class);

    return Excel::download(

        new ClientsExport(
            null,
            true
        ),

        'deleted_clients.xlsx'

    );
}

/**
 * Display Dashboard
 */
public function dashboard()
{
    $this->authorize('viewAny', Client::class);

    $today = Carbon::today();

    $dashboard = [

        /*
        |--------------------------------------------------------------------------
        | Clients
        |--------------------------------------------------------------------------
        */

        'total_clients' => Client::count(),

        'active_clients' => Client::where('status', 'Active')->count(),

        'inactive_clients' => Client::where('status', 'Inactive')->count(),

        'lead_clients' => Client::where('status', 'Lead')->count(),

        'prospect_clients' => Client::where('status', 'Prospect')->count(),

        'closed_clients' => Client::where('status', 'Closed')->count(),

        /*
        |--------------------------------------------------------------------------
        | Documents
        |--------------------------------------------------------------------------
        */

        'total_documents' => ClientDocument::count(),

        'documents_expiring' => ClientDocument::whereDate(
            'expiry_date',
            '<=',
            $today->copy()->addDays(30)
        )->count(),

        /*
        |--------------------------------------------------------------------------
        | Credentials
        |--------------------------------------------------------------------------
        */

        'total_credentials' => ClientCredential::count(),

        'credentials_expiring' => ClientCredential::whereDate(
            'expiry_date',
            '<=',
            $today->copy()->addDays(30)
        )->count(),

        /*
        |--------------------------------------------------------------------------
        | Communications
        |--------------------------------------------------------------------------
        */

        'communications_today' => ClientCommunication::whereDate(
            'communication_at',
            $today
        )->count(),

        /*
        |--------------------------------------------------------------------------
        | Remarks
        |--------------------------------------------------------------------------
        */

        'remarks_today' => ClientRemark::whereDate(
            'created_at',
            $today
        )->count(),

        /*
        |--------------------------------------------------------------------------
        | Services
        |--------------------------------------------------------------------------
        */

        'active_services' => ClientService::where(
            'status',
            'Active'
        )->count(),

        'pending_services' => ClientService::where(
            'status',
            'Pending'
        )->count(),

        /*
        |--------------------------------------------------------------------------
        | Recent Clients
        |--------------------------------------------------------------------------
        */

        'recent_clients' => Client::latest()
            ->take(10)
            ->get(),

        /*
        |--------------------------------------------------------------------------
        | Recent Remarks
        |--------------------------------------------------------------------------
        */

        'recent_remarks' => ClientRemark::with([
                'client',
                'user',
            ])
            ->latest()
            ->take(10)
            ->get(),

        /*
        |--------------------------------------------------------------------------
        | Expiring Documents
        |--------------------------------------------------------------------------
        */

        'expiring_documents' => ClientDocument::with('client')
            ->whereDate(
                'expiry_date',
                '<=',
                $today->copy()->addDays(30)
            )
            ->orderBy('expiry_date')
            ->take(10)
            ->get(),

        /*
        |--------------------------------------------------------------------------
        | Expiring Credentials
        |--------------------------------------------------------------------------
        */

        'expiring_credentials' => ClientCredential::with('client')
            ->whereDate(
                'expiry_date',
                '<=',
                $today->copy()->addDays(30)
            )
            ->orderBy('expiry_date')
            ->take(10)
            ->get(),

        /*
        |--------------------------------------------------------------------------
        | Monthly Client Growth
        |--------------------------------------------------------------------------
        */

        'monthly_clients' => Client::select(

                DB::raw('MONTH(created_at) as month'),

                DB::raw('COUNT(*) as total')

            )
            ->whereYear(
                'created_at',
                now()->year
            )
            ->groupBy('month')
            ->pluck('total', 'month'),

    ];

    $crmStats = [

    'total_clients' => Client::count(),

    'active_clients' => Client::where('is_active', true)->count(),

    'documents' => ClientDocument::count(),

    'expiring_documents' => ClientDocument::whereDate(

        'expiry_date',

        '<=',

        now()->addDays(30)

    )->count(),

];

$recentClients = Client::latest()

    ->take(5)

    ->get();

$expiringDocuments = ClientDocument::with('client')

    ->whereDate('expiry_date', '<=', now()->addDays(30))

    ->orderBy('expiry_date')

    ->take(5)

    ->get();

    return view(
        'dashboard.index',
        compact('dashboard',
        'stats',

    'recentTasks',

    'remarks',

    'weeklyChart',

    'crmStats',

    'recentClients',

    'expiringDocuments')
    );
}
/**
 * Client DataTable
 */
public function datatable(Request $request): JsonResponse
{
    $this->authorize('viewAny', Client::class);

    $query = Client::query()
        ->with([
            'contacts',
            'services',
        ]);

    return DataTables::eloquent($query)

        ->addIndexColumn()

        ->addColumn('company', function ($client) {

            return '
                <div class="fw-bold">' .
                    e($client->company_name) .
                '</div>
                <small class="text-muted">' .
                    e($client->client_code) .
                '</small>';

        })

        ->addColumn('contact', function ($client) {

            return $client->phone .
                '<br><small>' .
                $client->email .
                '</small>';

        })

        ->editColumn('status', function ($client) {

            $class = match ($client->status) {

                'Active' => 'success',

                'Inactive' => 'secondary',

                'Lead' => 'warning',

                'Prospect' => 'info',

                'Suspended' => 'danger',

                default => 'dark',
            };

            return '<span class="badge bg-' .
                $class .
                '">' .
                e($client->status) .
                '</span>';

        })

        ->editColumn('priority', function ($client) {

            $class = match ($client->priority) {

                'Critical' => 'danger',

                'High' => 'warning',

                'Medium' => 'primary',

                default => 'secondary',
            };

            return '<span class="badge bg-' .
                $class .
                '">' .
                e($client->priority) .
                '</span>';

        })

        ->addColumn('services', function ($client) {

            return $client->services->count();

        })

        ->addColumn('actions', function ($client) {

            return view(
                'clients.partials.actions',
                compact('client')
            )->render();

        })

        ->filter(function ($query) use ($request) {

            if ($request->filled('status')) {

                $query->where(
                    'status',
                    $request->status
                );

            }

            if ($request->filled('priority')) {

                $query->where(
                    'priority',
                    $request->priority
                );

            }

            if ($request->filled('business_type')) {

                $query->where(
                    'business_type',
                    $request->business_type
                );

            }

            if ($request->filled('assigned_to')) {

                $query->where(
                    'assigned_to',
                    $request->assigned_to
                );

            }

        })

        ->rawColumns([
            'company',
            'status',
            'priority',
            'contact',
            'actions',
        ])

        ->make(true);
}
/**
 * AJAX Search
 */
public function search(Request $request): JsonResponse
{
    $this->authorize('viewAny', Client::class);

    $term = $request->get('q');

    $clients = Client::query()

        ->when($term, function ($query) use ($term) {

            $query->where(function ($q) use ($term) {

                $q->where(
                    'company_name',
                    'like',
                    "%{$term}%"
                )

                ->orWhere(
                    'client_code',
                    'like',
                    "%{$term}%"
                )

                ->orWhere(
                    'gstin',
                    'like',
                    "%{$term}%"
                )

                ->orWhere(
                    'pan',
                    'like',
                    "%{$term}%"
                );

            });

        })

        ->limit(20)

        ->get([
            'id',
            'company_name',
            'client_code',
        ]);

    return response()->json(

        $clients->map(function ($client) {

            return [

                'id' => $client->id,

                'text' => $client->client_code .
                    ' - ' .
                    $client->company_name,

            ];

        })

    );
}
/**
 * AJAX Status Update
 */
public function changeStatus(Request $request, Client $client): JsonResponse
{
    $this->authorize('update', $client);

    $request->validate([

        'status' => [
            'required',
            'in:Lead,Prospect,Active,Inactive,Suspended,Closed',
        ],

    ]);

    $client->update([

        'status' => $request->status,

    ]);

    return response()->json([

        'success' => true,

        'message' => 'Status updated successfully.',

    ]);
}
/**
 * Toggle Active Status
 */
public function toggleStatus(Client $client): JsonResponse
{
    $this->authorize('update', $client);

    $client->update([

        'is_active' => ! $client->is_active,

    ]);

    return response()->json([

        'success' => true,

        'active' => $client->is_active,

    ]);
}
/**
 * AJAX Delete
 */
public function ajaxDelete(Client $client): JsonResponse
{
    $this->authorize('delete', $client);

    $client->delete();

    return response()->json([

        'success' => true,

        'message' => 'Client deleted successfully.',

    ]);
}
/**
 * Display client contacts.
 */
public function contacts(Client $client)
{
    $this->authorize('view', $client);

    $contacts = $client->contacts()
        ->latest()
        ->paginate(15);

    return view(
        'clients.contacts',
        compact(
            'client',
            'contacts'
        )
    );
}
/**
 * Display client addresses.
 */
public function addresses(Client $client)
{
    $this->authorize('view', $client);

    $addresses = $client->addresses()
        ->orderByDesc('is_default')
        ->latest()
        ->paginate(15);

    return view(
        'clients.addresses',
        compact(
            'client',
            'addresses'
        )
    );
}
/**
 * Display client services.
 */
public function services(Client $client)
{
    $this->authorize('view', $client);

    $services = $client->services()
        ->with('service')
        ->latest()
        ->paginate(15);

    return view(
        'clients.services',
        compact(
            'client',
            'services'
        )
    );
}
/**
 * Display client documents.
 */
public function documents(Client $client)
{
    $this->authorize('viewDocuments', $client);

    $documents = $client->documents()
        ->latest()
        ->paginate(15);

    return view(
        'clients.documents',
        compact(
            'client',
            'documents'
        )
    );
}
/**
 * Display client credentials.
 */
public function credentials(Client $client)
{
    $this->authorize('viewCredentials', $client);

    $credentials = $client->credentials()
        ->latest()
        ->paginate(15);

    return view(
        'clients.credentials',
        compact(
            'client',
            'credentials'
        )
    );
}
/**
 * Display client remarks.
 */
public function remarks(Client $client)
{
    $this->authorize('view', $client);

    $remarks = $client->remarks()
        ->with([
            'user',
            'replies',
        ])
        ->latest()
        ->paginate(20);

    return view(
        'clients.remarks',
        compact(
            'client',
            'remarks'
        )
    );
}
/**
 * Display client communications.
 */
public function communications(Client $client)
{
    $this->authorize('manageCommunications', $client);

    $communications = $client->communications()
        ->latest('communication_at')
        ->paginate(20);

    return view(
        'clients.communications',
        compact(
            'client',
            'communications'
        )
    );
}
/**
 * Display client notes.
 */
public function notes(Client $client)
{
    $this->authorize('view', $client);

    $notes = $client->notes()
        ->with('user')
        ->latest()
        ->paginate(20);

    return view(
        'clients.notes',
        compact(
            'client',
            'notes'
        )
    );
}
/**
 * Display client timeline.
 */
public function timeline(Client $client)
{
    $this->authorize('view', $client);

    $timeline = $client->timeline()
        ->latest()
        ->paginate(30);

    return view(
        'clients.timeline',
        compact(
            'client',
            'timeline'
        )
    );
}
/**
 * Display client bank accounts.
 */
public function bankAccounts(Client $client)
{
    $this->authorize('view', $client);

    $bankAccounts = $client->bankAccounts()
        ->latest()
        ->paginate(10);

    return view(
        'clients.bank-accounts',
        compact(
            'client',
            'bankAccounts'
        )
    );
}
/**
 * Duplicate a client.
 */
public function duplicate(Client $client)
{
    $this->authorize('create', Client::class);

    DB::beginTransaction();

    try {

        $newClient = $client->replicate();

        $newClient->client_code = 'CL-' . strtoupper(uniqid());

        $newClient->company_name = $client->company_name . ' (Copy)';

        $newClient->status = 'Lead';

        $newClient->save();

        DB::commit();

        return redirect()
            ->route('clients.edit', $newClient)
            ->with('success', 'Client duplicated successfully.');

    } catch (\Throwable $e) {

        DB::rollBack();

        return back()->with('error', $e->getMessage());

    }
}
/**
 * Change client priority.
 */
public function changePriority(Request $request, Client $client)
{
    $this->authorize('update', $client);

    $request->validate([

        'priority' => [
            'required',
            'in:Low,Medium,High,Critical',
        ],

    ]);

    $client->update([

        'priority' => $request->priority,

    ]);

    return back()->with(
        'success',
        'Priority updated successfully.'
    );
}
/**
 * Archive client.
 */
public function archive(Client $client)
{
    $this->authorize('update', $client);

    $client->update([

        'is_active' => false,

        'status' => 'Archived',

    ]);

    return back()->with(
        'success',
        'Client archived successfully.'
    );
}
/**
 * Unarchive client.
 */
public function unarchive(Client $client)
{
    $this->authorize('update', $client);

    $client->update([

        'is_active' => true,

        'status' => 'Active',

    ]);

    return back()->with(
        'success',
        'Client activated successfully.'
    );
}
/**
 * Assign employee.
 */
public function assignExecutive(Request $request, Client $client)
{
    $this->authorize('assign', $client);

    $request->validate([

        'assigned_to' => [
            'required',
            'exists:users,id',
        ],

    ]);

    $client->update([

        'assigned_to' => $request->assigned_to,

    ]);

    return back()->with(
        'success',
        'Executive assigned successfully.'
    );
}
/**
 * Remove assigned employee.
 */
public function removeExecutive(Client $client)
{
    $this->authorize('assign', $client);

    $client->update([

        'assigned_to' => null,

    ]);

    return back()->with(
        'success',
        'Executive removed.'
    );
}
/**
 * Client overview.
 */
public function overview(Client $client)
{
    $this->authorize('view', $client);

    $client->load([

        'contacts',

        'addresses',

        'services',

        'documents',

        'credentials',

        'remarks',

        'communications',

    ]);

    return view(
        'clients.overview',
        compact('client')
    );
}
/**
 * Mark client as favourite.
 */
public function favourite(Client $client)
{
    $this->authorize('update', $client);

    $client->update([

        'is_favourite' => ! $client->is_favourite,

    ]);

    return back()->with(
        'success',
        'Favourite updated successfully.'
    );
}
/**
 * Generate next client code.
 */
public function generateCode()
{
    $last = Client::latest('id')->first();

    $next = $last ? $last->id + 1 : 1;

    return response()->json([

        'client_code' => sprintf(
            'CLI-%05d',
            $next
        ),

    ]);
}
}
