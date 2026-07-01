<?php

namespace App\Http\Controllers;

use App\Models\Remark;
use App\Models\Task;
use Illuminate\Http\Request;

class RemarkController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Index — list with search, task filter, date filter, sort
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $tasks = auth()->user()
            ->tasks()
            ->orderBy('title')
            ->get();

        $query = Remark::with(['task', 'user'])
            ->where('user_id', auth()->id());

        // Search remark body
        if ($request->filled('search')) {
            $query->where('remark', 'like', '%' . $request->search . '%');
        }

        // Filter by task
        if ($request->filled('task_id')) {
            $query->where('task_id', $request->task_id);
        }

        // Date filter
        if ($request->filled('date_filter')) {
            match ($request->date_filter) {
                'today' => $query->whereDate('created_at', today()),
                'week'  => $query->whereBetween('created_at', [
                                now()->startOfWeek(), now()->endOfWeek(),
                           ]),
                'month' => $query->whereMonth('created_at', now()->month)
                                 ->whereYear('created_at', now()->year),
                default => null,
            };
        }

        // Sort
        match ($request->sort ?? 'newest') {
            'oldest'  => $query->oldest(),
            'longest' => $query->orderByRaw('LENGTH(remark) DESC'),
            'pinned'  => $query->orderBy('is_pinned', 'desc')->latest(),
            default   => $query->latest(),
        };

        $remarks = $query->paginate(10)->withQueryString();

        return view('remarks.index', compact('remarks', 'tasks'));
    }

    /*
    |--------------------------------------------------------------------------
    | Create
    |--------------------------------------------------------------------------
    */
    public function create(Request $request)
    {
        // Support both ?task=ID (from task show page) and general create
        $task  = null;
        $tasks = auth()->user()->tasks()->active()->orderBy('title')->get();

        if ($request->filled('task')) {
            $task = Task::findOrFail($request->task);
            $this->authorizeTask($task);
        }

        return view('remarks.create', compact('task', 'tasks'));
    }

    /*
    |--------------------------------------------------------------------------
    | Store
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'task_id' => ['required', 'exists:tasks,id'],
            'remark'  => ['required', 'string', 'min:3', 'max:5000'],
            'tone'    => ['nullable', 'string', 'max:30'],
        ]);

        $task = Task::findOrFail($validated['task_id']);
        $this->authorizeTask($task);

        $task->remarks()->create([
            'user_id' => auth()->id(),
            'remark'  => $validated['remark'],
            'tone'    => $validated['tone'] ?? null,
        ]);

        return redirect()
            ->route('tasks.show', $task)
            ->with('success', 'Remark added successfully.');
    }

    /*
    |--------------------------------------------------------------------------
    | Edit
    |--------------------------------------------------------------------------
    */
    public function edit(Remark $remark)
    {
        $this->authorizeRemark($remark);

        $tasks = auth()->user()
            ->tasks()
            ->orderBy('title')
            ->get();

        return view('remarks.edit', compact('remark', 'tasks'));
    }

    /*
    |--------------------------------------------------------------------------
    | Update
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, Remark $remark)
    {
        $this->authorizeRemark($remark);

        $validated = $request->validate([
            'task_id' => ['required', 'exists:tasks,id'],
            'remark'  => ['required', 'string', 'min:3', 'max:5000'],
            'tone'    => ['nullable', 'string', 'max:30'],
        ]);

        // Ensure the reassigned task also belongs to this user
        $task = auth()->user()->tasks()->findOrFail($validated['task_id']);

        $remark->update([
            'task_id' => $task->id,
            'remark'  => $validated['remark'],
            'tone'    => $validated['tone'] ?? null,
        ]);

        return redirect()
            ->route('tasks.show', $remark->fresh()->task)
            ->with('success', 'Remark updated successfully.');
    }

    /*
    |--------------------------------------------------------------------------
    | Destroy
    |--------------------------------------------------------------------------
    */
    public function destroy(Remark $remark)
    {
        $this->authorizeRemark($remark);

        $task = $remark->task;
        $remark->delete();

        // If delete came from the task page, go back there;
        // otherwise go to remarks index
        return request()->headers->get('referer') &&
               str_contains(request()->headers->get('referer'), '/tasks/')
            ? redirect()->route('tasks.show', $task)->with('success', 'Remark deleted.')
            : redirect()->route('remarks.index')->with('success', 'Remark deleted.');
    }

    /*
    |--------------------------------------------------------------------------
    | Pin / Unpin
    |--------------------------------------------------------------------------
    */
    public function pin(Remark $remark)
    {
        $this->authorizeRemark($remark);
        $remark->pin();
        return back()->with('success', 'Remark pinned.');
    }

    public function unpin(Remark $remark)
    {
        $this->authorizeRemark($remark);
        $remark->unpin();
        return back()->with('success', 'Remark unpinned.');
    }

    /** Single toggle endpoint — simpler to wire in JS */
    public function togglePin(Remark $remark)
    {
        $this->authorizeRemark($remark);
        $remark->togglePin();
        return back()->with('success', $remark->is_pinned ? 'Remark pinned.' : 'Remark unpinned.');
    }

    /*
    |--------------------------------------------------------------------------
    | Authorization helpers
    |--------------------------------------------------------------------------
    */
    private function authorizeTask(Task $task): void
    {
        abort_if($task->user_id !== auth()->id(), 403);
    }

    private function authorizeRemark(Remark $remark): void
    {
        abort_if($remark->user_id !== auth()->id(), 403);
    }
}