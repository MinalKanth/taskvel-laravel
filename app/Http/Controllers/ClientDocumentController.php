<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClientDocumentRequest;
use App\Http\Requests\UpdateClientDocumentRequest;
use App\Models\Client;
use App\Models\ClientDocument;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use App\Models\User;

class ClientDocumentController extends Controller
{
    /**
     * Display a listing of documents.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', ClientDocument::class);

        $query = ClientDocument::query()
            ->with('client');

        if ($request->filled('client_id')) {

            $query->where(
                'client_id',
                $request->client_id
            );

        }

        if ($request->filled('category')) {

            $query->where(
                'category',
                $request->category
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
                    'document_number',
                    'like',
                    "%{$search}%"
                );

            });

        }

        $documents = $query
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $clients = Client::orderBy('company_name')->get();

        return view(
            'client-documents.index',
            compact(
                'documents',
                'clients'
            )
        );
    }

    /**
     * Show upload page.
     */
    public function create()

{

    $this->authorize('create', ClientDocument::class);

    $clients = Client::orderBy('company_name')->get();

    $users = User::orderBy('name')->get();

    return view(

        'client-documents.create',

        compact(

            'clients',

            'users'

        )

    );

}

    /**
 * Store a newly uploaded document.
 */
public function store(StoreClientDocumentRequest $request)
{
    
    $this->authorize('create', ClientDocument::class);

    DB::beginTransaction();

    try {

        $data = $request->validated();

        /*
        |--------------------------------------------------------------------------
        | Boolean Fields
        |--------------------------------------------------------------------------
        */

        $data['is_confidential'] = $request->boolean('is_confidential');

        $data['is_downloadable'] = $request->boolean('is_downloadable');

        $data['is_active'] = $request->boolean('is_active', true);

        /*
        |--------------------------------------------------------------------------
        | Uploaded By
        |--------------------------------------------------------------------------
        */

        $data['uploaded_by'] = auth()->id();

        /*
        |--------------------------------------------------------------------------
        | Upload Document
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('document')) {

            $file = $request->file('document');

            $data['file_path'] = $file->store(
                'client-documents',
                'public'
            );

            $data['original_name'] = $file->getClientOriginalName();

            $data['file_name'] = basename($data['file_path']);

            $data['disk'] = 'public';

            $data['extension'] = $file->getClientOriginalExtension();

            $data['mime_type'] = $file->getMimeType();

            $data['file_size'] = $file->getSize();

        }
        

        // $document = ClientDocument::create($data);
        $document = new ClientDocument($data);



        $document->save();
        DB::commit();

// dd($document, $request->all());
        return redirect()
            ->route(
                'client-documents.show',
                $document
            )
            ->with(
                'success',
                'Document uploaded successfully.'
            );

    } catch (\Throwable $e) {

        DB::rollBack();

        if (
            isset($data['file_path']) &&
            Storage::disk('public')->exists($data['file_path'])
        ) {
            Storage::disk('public')->delete($data['file_path']);
        }

        return back()
            ->withInput()
            ->with(
                'error',
                $e->getMessage()
            );

    }
}

/**
 * Display document details.
 */
public function show(ClientDocument $clientDocument)
{
    $this->authorize(
        'view',
        $clientDocument
    );

    $clientDocument->load([
        'client',
    ]);

    return view(
        'client-documents.show',
        compact(
            'clientDocument'
        )
    );
}

/**
 * Show edit form.
 */
public function edit(ClientDocument $clientDocument)

{

    $this->authorize(

        'update',

        $clientDocument

    );

    $clients = Client::orderBy('company_name')->get();

    $users = User::orderBy('name')->get();

    return view(

        'client-documents.edit',

        compact(

            'clientDocument',

            'clients',

            'users'

        )

    );

}

/**
 * Update document.
 */
public function update(
    UpdateClientDocumentRequest $request,
    ClientDocument $clientDocument
)
{
    $this->authorize(
        'update',
        $clientDocument
    );

    DB::beginTransaction();

    try {

        $data = $request->validated();

        /*
        |--------------------------------------------------------------------------
        | Replace Uploaded File
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('document')) {

            if (
                $clientDocument->file_path &&
                Storage::disk('public')->exists(
                    $clientDocument->file_path
                )
            ) {

                Storage::disk('public')->delete(
                    $clientDocument->file_path
                );

            }

            $data['file_path'] = $request
                ->file('document')
                ->store(
                    'client-documents',
                    'public'
                );

            $data['original_name'] =
                $request->file('document')
                    ->getClientOriginalName();

            $data['file_size'] =
                $request->file('document')
                    ->getSize();

            $data['mime_type'] =
                $request->file('document')
                    ->getMimeType();

        }

        $clientDocument->update($data);

        DB::commit();

        return redirect()
            ->route(
                'client-documents.show',
                $clientDocument
            )
            ->with(
                'success',
                'Document updated successfully.'
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
 * Delete document.
 */
public function destroy(
    ClientDocument $clientDocument
)
{
    $this->authorize(
        'delete',
        $clientDocument
    );

    DB::beginTransaction();

    try {

        if (
            $clientDocument->file_path &&
            Storage::disk('public')->exists(
                $clientDocument->file_path
            )
        ) {

            Storage::disk('public')->delete(
                $clientDocument->file_path
            );

        }

        $clientDocument->delete();

        DB::commit();

        return redirect()
            ->route(
                'client-documents.index'
            )
            ->with(
                'success',
                'Document deleted successfully.'
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
 * Display trashed documents.
 */
public function trashed(Request $request)
{
    $this->authorize('restore', ClientDocument::class);

    $query = ClientDocument::onlyTrashed()
        ->with('client');

    if ($request->filled('client_id')) {

        $query->where(
            'client_id',
            $request->client_id
        );

    }

    if ($request->filled('category')) {

    $query->where(
        'category',
        $request->category
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
                'document_number',
                'like',
                "%{$search}%"
            );

        });

    }

    $documents = $query

        ->latest('deleted_at')

        ->paginate(20)

        ->withQueryString();

    return view(
        'client-documents.trashed',
        compact('documents')
    );
}

/**
 * Restore document.
 */
public function restore($id)
{
    $document = ClientDocument::onlyTrashed()
        ->findOrFail($id);

    $this->authorize(
        'restore',
        $document
    );

    DB::beginTransaction();

    try {

        $document->restore();

        DB::commit();

        return redirect()

            ->route('client-documents.trashed')

            ->with(
                'success',
                'Document restored successfully.'
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
 * Permanently delete document.
 */
public function forceDelete($id)
{
    $document = ClientDocument::onlyTrashed()
        ->findOrFail($id);

    $this->authorize(
        'forceDelete',
        $document
    );

    DB::beginTransaction();

    try {

        /*
        |--------------------------------------------------------------------------
        | Delete physical file
        |--------------------------------------------------------------------------
        */

        if (
            $document->file_path &&
            Storage::disk('public')->exists(
                $document->file_path
            )
        ) {

            Storage::disk('public')->delete(
                $document->file_path
            );

        }

        $document->forceDelete();

        DB::commit();

        return redirect()

            ->route('client-documents.trashed')

            ->with(
                'success',
                'Document permanently deleted.'
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
 * Bulk delete.
 */
public function bulkDelete(Request $request)
{
    $this->authorize(
        'delete',
        ClientDocument::class
    );

    $request->validate([

        'ids'=>[
            'required',
            'array',
            'min:1',
        ],

        'ids.*'=>[
            'exists:client_documents,id',
        ],

    ]);

    DB::beginTransaction();

    try {

        ClientDocument::whereIn(
            'id',
            $request->ids
        )->delete();

        DB::commit();

        return back()->with(
            'success',
            count($request->ids).
            ' document(s) deleted successfully.'
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
 * Bulk restore.
 */
public function bulkRestore(Request $request)
{
    $this->authorize(
        'restore',
        ClientDocument::class
    );

    $request->validate([

        'ids'=>[
            'required',
            'array',
        ],

        'ids.*'=>[
            'integer',
        ],

    ]);

    DB::beginTransaction();

    try {

        ClientDocument::onlyTrashed()

            ->whereIn(
                'id',
                $request->ids
            )

            ->restore();

        DB::commit();

        return back()->with(
            'success',
            count($request->ids).
            ' document(s) restored successfully.'
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
 * Empty Trash.
 */
public function emptyTrash()
{
    $this->authorize(
        'forceDelete',
        ClientDocument::class
    );

    DB::beginTransaction();

    try {

        $documents = ClientDocument::onlyTrashed()->get();

        foreach ($documents as $document) {

            if (

                $document->file_path &&

                Storage::disk('public')->exists(
                    $document->file_path
                )

            ) {

                Storage::disk('public')->delete(
                    $document->file_path
                );

            }

            $document->forceDelete();

        }

        DB::commit();

        return back()->with(
            'success',
            'Trash emptied successfully.'
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
 * Download document
 */
public function download(ClientDocument $clientDocument)
{
    $this->authorize('view', $clientDocument);

    abort_if(
        !$clientDocument->file_path ||
        !Storage::disk('public')->exists($clientDocument->file_path),
        404,
        'Document not found.'
    );

    return Storage::disk('public')->download(
        $clientDocument->file_path,
        $clientDocument->original_name
    );
}
/**
 * Preview document
 */
public function preview(ClientDocument $clientDocument)
{
    $this->authorize('view', $clientDocument);

    abort_if(
        !$clientDocument->file_path ||
        !Storage::disk('public')->exists($clientDocument->file_path),
        404
    );

    return response()->file(
        Storage::disk('public')->path(
            $clientDocument->file_path
        )
    );
}
/**
 * Replace uploaded file
 */
public function replace(
    Request $request,
    ClientDocument $clientDocument
)
{
    $this->authorize('update', $clientDocument);

    $request->validate([
        'document' => [
            'required',
            'file',
            'max:10240',
        ],
    ]);

    DB::beginTransaction();

    try {

        if (
            $clientDocument->file_path &&
            Storage::disk('public')->exists($clientDocument->file_path)
        ) {
            Storage::disk('public')->delete($clientDocument->file_path);
        }

        $file = $request->file('document');

        $path = $file->store(
            'client-documents',
            'public'
        );

        $clientDocument->update([

            'file_path' => $path,

            'original_name' => $file->getClientOriginalName(),

            'file_name' => basename($path),

            'disk' => 'public',

            'extension' => $file->getClientOriginalExtension(),

            'mime_type' => $file->getMimeType(),

            'file_size' => $file->getSize(),

            'uploaded_by' => auth()->id(),

        ]);

        DB::commit();

        return back()->with(
            'success',
            'Document replaced successfully.'
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
 * Multiple upload
 */
public function multipleUpload(Request $request)
{
    $this->authorize(
        'create',
        ClientDocument::class
    );

    $request->validate([

        'client_id' => [
            'required',
            'exists:clients,id',
        ],

        'documents' => [
            'required',
            'array',
        ],

        'documents.*' => [
            'file',
            'max:10240',
        ],

    ]);

    DB::beginTransaction();

    try {

        foreach ($request->file('documents') as $file) {

            $path = $file->store(
                'client-documents',
                'public'
            );

            ClientDocument::create([

                'client_id' => $request->client_id,

                'category' => 'Other',

                'title' => pathinfo(
                    $file->getClientOriginalName(),
                    PATHINFO_FILENAME
                ),

                'document_number' => null,

                'description' => null,

                'original_name' => $file->getClientOriginalName(),

                'file_name' => basename($path),

                'file_path' => $path,

                'disk' => 'public',

                'extension' => $file->getClientOriginalExtension(),

                'mime_type' => $file->getMimeType(),

                'file_size' => $file->getSize(),

                'version' => '1.0',

                'status' => 'Pending',

                'is_confidential' => false,

                'is_downloadable' => true,

                'uploaded_by' => auth()->id(),

                'is_active' => true,

            ]);

        }

        DB::commit();

        return back()->with(
            'success',
            'Documents uploaded successfully.'
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
 * Download all client documents
 */
public function downloadZip(Client $client)
{
    $this->authorize(
        'view',
        ClientDocument::class
    );

    $zipName = 'client_'.$client->id.'.zip';

    $zipPath = storage_path(
        'app/temp/'.$zipName
    );

    if(!file_exists(dirname($zipPath))){

        mkdir(dirname($zipPath),0755,true);

    }

    $zip = new \ZipArchive();

    $zip->open(
        $zipPath,
        \ZipArchive::CREATE |
        \ZipArchive::OVERWRITE
    );

    foreach($client->documents as $document){

        if(

            Storage::disk('public')->exists(
                $document->file_path
            )

        ){

            $zip->addFile(

                Storage::disk('public')->path(
                    $document->file_path
                ),

                $document->original_name

            );

        }

    }

    $zip->close();

    return response()->download(
        $zipPath
    )->deleteFileAfterSend(true);

}
/**
 * View PDF
 */
public function viewPdf(
    ClientDocument $clientDocument
)
{
    $this->authorize(
        'view',
        $clientDocument
    );

    abort_unless(

        str_contains(
            $clientDocument->mime_type,
            'pdf'
        ),

        404

    );

    return response()->file(

        Storage::disk('public')->path(
            $clientDocument->file_path
        )

    );
}
}

