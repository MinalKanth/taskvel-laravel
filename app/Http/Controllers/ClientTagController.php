<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClientTagRequest;
use App\Http\Requests\UpdateClientTagRequest;
use App\Models\ClientTag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class ClientTagController extends Controller
{
    /**
     * Display a listing of the tags.
     */
    public function index(Request $request)
    {
        $this->authorize(
            'viewAny',
            ClientTag::class
        );

        $query = ClientTag::query();

        if ($request->filled('status')) {

            $query->where(
                'is_active',
                $request->status
            );

        }

        if ($request->filled('search')) {

            $search = trim($request->search);

            $query->where(function ($q) use ($search) {

                $q->where(
                    'name',
                    'like',
                    "%{$search}%"
                )

                ->orWhere(
                    'slug',
                    'like',
                    "%{$search}%"
                )

                ->orWhere(
                    'description',
                    'like',
                    "%{$search}%"
                );

            });

        }

        $tags = $query

            ->withCount('clients')

            ->orderBy(
                'sort_order'
            )

            ->orderBy(
                'name'
            )

            ->paginate(20)

            ->withQueryString();

        return view(
            'client-tags.index',
            compact('tags')
        );
    }

    /**
     * Show the form for creating a new tag.
     */
    public function create()
    {
        $this->authorize(
            'create',
            ClientTag::class
        );

        return view(
            'client-tags.create'
        );
    }

    /**
     * Store a newly created tag.
     */
    public function store(
        StoreClientTagRequest $request
    )
    {
        $this->authorize(
            'create',
            ClientTag::class
        );

        DB::beginTransaction();

        try {

            $data = $request->validated();

            if (empty($data['slug'])) {

                $data['slug'] = Str::slug(
                    $data['name']
                );

            }

            $clientTag = ClientTag::create(
                $data
            );

            DB::commit();

            return redirect()
                ->route(
                    'client-tags.show',
                    $clientTag
                )
                ->with(
                    'success',
                    'Client tag created successfully.'
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
     * Display the specified tag.
     */
    public function show(
        ClientTag $clientTag
    )
    {
        $this->authorize(
            'view',
            $clientTag
        );

        $clientTag->load([
            'clients',
        ]);

        return view(
            'client-tags.show',
            compact(
                'clientTag'
            )
        );
    }

    /**
     * Show the form for editing the specified tag.
     */
    public function edit(
        ClientTag $clientTag
    )
    {
        $this->authorize(
            'update',
            $clientTag
        );

        return view(
            'client-tags.edit',
            compact(
                'clientTag'
            )
        );
    }

    /**
     * Update the specified tag.
     */
    public function update(
        UpdateClientTagRequest $request,
        ClientTag $clientTag
    )
    {
        $this->authorize(
            'update',
            $clientTag
        );

        DB::beginTransaction();

        try {

            $data = $request->validated();

            if (empty($data['slug'])) {

                $data['slug'] = Str::slug(
                    $data['name']
                );

            }

            $clientTag->update(
                $data
            );

            DB::commit();

            return redirect()
                ->route(
                    'client-tags.show',
                    $clientTag
                )
                ->with(
                    'success',
                    'Client tag updated successfully.'
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
     * Remove the specified tag.
     */
    public function destroy(
        ClientTag $clientTag
    )
    {
        $this->authorize(
            'delete',
            $clientTag
        );

        DB::beginTransaction();

        try {

            $clientTag->delete();

            DB::commit();

            return redirect()
                ->route(
                    'client-tags.index'
                )
                ->with(
                    'success',
                    'Client tag deleted successfully.'
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
     * Display trashed tags.
     */
    public function trashed(
        Request $request
    )
    {
        $this->authorize(
            'restore',
            ClientTag::class
        );

        $query = ClientTag::onlyTrashed();

        if ($request->filled('status')) {

            $query->where(
                'is_active',
                $request->status
            );

        }

        if ($request->filled('search')) {

            $search = trim(
                $request->search
            );

            $query->where(function ($q) use ($search) {

                $q->where(
                    'name',
                    'like',
                    "%{$search}%"
                )

                ->orWhere(
                    'slug',
                    'like',
                    "%{$search}%"
                )

                ->orWhere(
                    'description',
                    'like',
                    "%{$search}%"
                );

            });

        }

        $tags = $query

            ->withCount(
                'clients'
            )

            ->latest(
                'deleted_at'
            )

            ->paginate(20)

            ->withQueryString();

        return view(
            'client-tags.trashed',
            compact(
                'tags'
            )
        );
    }

    /**
     * Restore tag.
     */
    public function restore(
        $id
    )
    {
        $clientTag = ClientTag::onlyTrashed()
            ->findOrFail($id);

        $this->authorize(
            'restore',
            $clientTag
        );

        DB::beginTransaction();

        try {

            $clientTag->restore();

            DB::commit();

            return redirect()
                ->route(
                    'client-tags.trashed'
                )
                ->with(
                    'success',
                    'Client tag restored successfully.'
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
     * Permanently delete tag.
     */
    public function forceDelete(
        $id
    )
    {
        $clientTag = ClientTag::onlyTrashed()
            ->findOrFail($id);

        $this->authorize(
            'forceDelete',
            $clientTag
        );

        DB::beginTransaction();

        try {

            $clientTag->forceDelete();

            DB::commit();

            return redirect()
                ->route(
                    'client-tags.trashed'
                )
                ->with(
                    'success',
                    'Client tag permanently deleted.'
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
     * Bulk delete tags.
     */
    public function bulkDelete(
        Request $request
    )
    {
        $this->authorize(
            'delete',
            ClientTag::class
        );

        $request->validate([

            'ids' => [
                'required',
                'array',
                'min:1',
            ],

            'ids.*' => [
                'exists:client_tags,id',
            ],

        ]);

        DB::beginTransaction();

        try {

            ClientTag::whereIn(
                'id',
                $request->ids
            )->delete();

            DB::commit();

            return back()->with(
                'success',
                count($request->ids) .
                ' tag(s) deleted successfully.'
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
     * Bulk restore tags.
     */
    public function bulkRestore(
        Request $request
    )
    {
        $this->authorize(
            'restore',
            ClientTag::class
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

            ClientTag::onlyTrashed()

                ->whereIn(
                    'id',
                    $request->ids
                )

                ->restore();

            DB::commit();

            return back()->with(

                'success',

                count($request->ids)

                .' tag(s) restored successfully.'

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
     * Empty tag trash.
     */
    public function emptyTrash()
    {
        $this->authorize(
            'forceDelete',
            ClientTag::class
        );

        DB::beginTransaction();

        try {

            ClientTag::onlyTrashed()

                ->forceDelete();

            DB::commit();

            return back()->with(

                'success',

                'Tag trash emptied successfully.'

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
     * DataTable
     */
    public function datatable(
        Request $request
    ): JsonResponse
    {
        $this->authorize(
            'viewAny',
            ClientTag::class
        );

        $query = ClientTag::query()

            ->withCount(
                'clients'
            );

        return DataTables::eloquent($query)

            ->addIndexColumn()
                        ->editColumn(
                'name',
                function ($tag) {

                    return '<span class="fw-semibold">' .
                        e($tag->name) .
                        '</span>';

                }
            )

            ->editColumn(
                'color',
                function ($tag) {

                    return '<span class="badge" style="background:' .
                        e($tag->color ?: '#6c757d') .
                        ';color:#fff;">' .
                        e($tag->color ?: 'Default') .
                        '</span>';

                }
            )

            ->editColumn(
                'icon',
                function ($tag) {

                    if (blank($tag->icon)) {

                        return '-';

                    }

                    return '<i class="' .
                        e($tag->icon) .
                        '"></i> ' .
                        e($tag->icon);

                }
            )

            ->editColumn(
                'is_active',
                function ($tag) {

                    return $tag->is_active

                        ? '<span class="badge bg-success">Active</span>'

                        : '<span class="badge bg-danger">Inactive</span>';

                }
            )

            ->editColumn(
                'clients_count',
                function ($tag) {

                    return '<span class="badge bg-primary">' .
                        $tag->clients_count .
                        '</span>';

                }
            )

            ->editColumn(
                'sort_order',
                function ($tag) {

                    return $tag->sort_order;

                }
            )

            ->addColumn(
                'actions',
                function ($tag) {

                    return view(
                        'client-tags.partials.actions',
                        compact('tag')
                    )->render();

                }
            )
                        ->filter(function ($query) use ($request) {

                if ($request->filled('status')) {

                    $query->where(
                        'is_active',
                        $request->status
                    );

                }

                if ($request->filled('search')) {

                    $search = trim(
                        $request->search
                    );

                    $query->where(function ($q) use ($search) {

                        $q->where(
                            'name',
                            'like',
                            "%{$search}%"
                        )

                        ->orWhere(
                            'slug',
                            'like',
                            "%{$search}%"
                        )

                        ->orWhere(
                            'description',
                            'like',
                            "%{$search}%"
                        );

                    });

                }

            })

            ->rawColumns([

                'name',

                'color',

                'icon',

                'is_active',

                'clients_count',

                'actions',

            ])

            ->make(true);

    }

    /**
     * AJAX search.
     */
    public function search(
        Request $request
    ): JsonResponse
    {
        $this->authorize(
            'viewAny',
            ClientTag::class
        );

        $term = trim(
            $request->q
        );

        $tags = ClientTag::query()

            ->when(
                $term,
                function ($query) use ($term) {

                    $query->where(
                        'name',
                        'like',
                        "%{$term}%"
                    )

                    ->orWhere(
                        'slug',
                        'like',
                        "%{$term}%"
                    );

                }
            )

            ->orderBy(
                'name'
            )

            ->limit(20)
                        ->get([

                'id',

                'name',

                'slug',

            ]);

        return response()->json(

            $tags->map(function ($tag) {

                return [

                    'id' => $tag->id,

                    'text' => $tag->name,

                    'slug' => $tag->slug,

                ];

            })

        );

    }

    /**
     * AJAX delete.
     */
    public function ajaxDelete(
        ClientTag $clientTag
    ): JsonResponse
    {
        $this->authorize(
            'delete',
            $clientTag
        );

        $clientTag->delete();

        return response()->json([

            'success' => true,

            'message' => 'Client tag deleted successfully.',

        ]);

    }

    /**
     * Change status.
     */
    public function changeStatus(
        Request $request,
        ClientTag $clientTag
    ): JsonResponse
    {
        $this->authorize(
            'update',
            $clientTag
        );

        $request->validate([

            'is_active' => [

                'required',

                'boolean',

            ],

        ]);

        $clientTag->update([

            'is_active' => $request->boolean(
                'is_active'
            ),

        ]);

        return response()->json([

            'success' => true,

            'message' => 'Status updated successfully.',

        ]);

    }

    /**
     * Update sort order.
     */
    public function updateSortOrder(
        Request $request
    ): JsonResponse
    {
        $this->authorize(
            'update',
            ClientTag::class
        );

        $request->validate([
                        'tags' => [

                'required',

                'array',

            ],

            'tags.*.id' => [

                'required',

                'exists:client_tags,id',

            ],

            'tags.*.sort_order' => [

                'required',

                'integer',

                'min:0',

            ],

        ]);

        DB::beginTransaction();

        try {

            foreach ($request->tags as $tag) {

                ClientTag::where(
                    'id',
                    $tag['id']
                )->update([

                    'sort_order' => $tag['sort_order'],

                ]);

            }

            DB::commit();

            return response()->json([

                'success' => true,

                'message' => 'Sort order updated successfully.',

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
     * Toggle active status.
     */
    public function toggleStatus(
        ClientTag $clientTag
    ): JsonResponse
    {
        $this->authorize(
            'update',
            $clientTag
        );

        $clientTag->update([

            'is_active' => ! $clientTag->is_active,

        ]);

        return response()->json([

            'success' => true,

            'status' => $clientTag->is_active,

            'message' => 'Status updated successfully.',

        ]);

    }
        /**
     * Get active tags for AJAX.
     */
    public function active(): JsonResponse
    {
        $this->authorize(
            'viewAny',
            ClientTag::class
        );

        $tags = ClientTag::active()

            ->ordered()

            ->get([
                'id',
                'name',
                'slug',
                'color',
                'icon',
            ]);

        return response()->json([

            'success' => true,

            'data' => $tags,

        ]);

    }

    /**
     * Duplicate an existing tag.
     */
    public function duplicate(
        ClientTag $clientTag
    )
    {
        $this->authorize(
            'create',
            ClientTag::class
        );

        DB::beginTransaction();

        try {

            $newTag = $clientTag->replicate();

            $newTag->name = $clientTag->name . ' Copy';

            $newTag->slug = Str::slug(
                $newTag->name
            );

            $newTag->save();

            DB::commit();

            return redirect()

                ->route(
                    'client-tags.edit',
                    $newTag
                )

                ->with(
                    'success',
                    'Client tag duplicated successfully.'
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
     * Bulk change active status.
     */
    public function bulkStatus(
        Request $request
    )
    {
        $this->authorize(
            'update',
            ClientTag::class
        );

        $request->validate([

            'ids' => [
                'required',
                'array',
                'min:1',
            ],

            'ids.*' => [
                'exists:client_tags,id',
            ],

            'is_active' => [
                'required',
                'boolean',
            ],

        ]);

        DB::beginTransaction();

        try {

            ClientTag::whereIn(
                'id',
                $request->ids
            )->update([

                'is_active' => $request->boolean(
                    'is_active'
                ),

            ]);

            DB::commit();

            return back()->with(

                'success',

                count($request->ids)
                .' tag(s) updated successfully.'

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
     * Get tag statistics.
     */
    public function statistics(): JsonResponse
    {
        $this->authorize(
            'viewAny',
            ClientTag::class
        );

        return response()->json([

            'total' => ClientTag::count(),

            'active' => ClientTag::where(
                'is_active',
                true
            )->count(),

            'inactive' => ClientTag::where(
                'is_active',
                false
            )->count(),

            'deleted' => ClientTag::onlyTrashed()
                ->count(),

            'assigned' => ClientTag::has(
                'clients'
            )->count(),

            'unassigned' => ClientTag::doesntHave(
                'clients'
            )->count(),

        ]);

    }
        /**
     * Get tag options for Select2.
     */
    public function options(): JsonResponse
    {
        $this->authorize(
            'viewAny',
            ClientTag::class
        );

        $tags = ClientTag::active()

            ->ordered()

            ->get([
                'id',
                'name',
            ]);

        return response()->json(

            $tags->map(function ($tag) {

                return [

                    'id' => $tag->id,

                    'text' => $tag->name,

                ];

            })

        );

    }
}
