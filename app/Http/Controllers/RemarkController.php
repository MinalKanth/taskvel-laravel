<?php

namespace App\Http\Controllers;

use App\Models\Remark;
use App\Models\Task;

use Illuminate\Http\Request;

class RemarkController extends Controller
{

    public function index(Request $request)

{

    $tasks = auth()->user()->tasks()

        ->orderBy('title')

        ->get();

    $remarks = Remark::with(['task', 'user'])

        ->where('user_id', auth()->id())

        ->when($request->filled('search'), function ($query) use ($request) {

            $query->where('remark', 'like', '%' . $request->search . '%');

        })

        ->when($request->filled('task_id'), function ($query) use ($request) {

            $query->where('task_id', $request->task_id);

        })

        ->latest()

        ->paginate(10)

        ->withQueryString();

    return view('remarks.index', compact('remarks', 'tasks'));

}
    /**
     * Store a new remark.
     */

    
    public function create(Request $request)

{

    $task = Task::findOrFail($request->task);

    $this->authorizeTask($task);

    return view('remarks.create', compact('task'));

}

    public function store(Request $request)
{
    $validated = $request->validate([
        'task_id' => ['required', 'exists:tasks,id'],
        'remark'  => ['required', 'string', 'max:5000'],
    ]);

    $task = Task::findOrFail($validated['task_id']);

    $this->authorizeTask($task);

    $task->remarks()->create([
        'user_id' => auth()->id(),
        'remark'  => $validated['remark'],
    ]);

    return redirect()
        ->route('tasks.show', $task)
        ->with('success', 'Remark added successfully.');
}

public function edit(Remark $remark)
{
    $this->authorizeRemark($remark);

    $tasks = auth()->user()
        ->tasks()
        ->orderBy('title')
        ->get();

    return view('remarks.edit', compact('remark', 'tasks'));
}

    /**
     * Update an existing remark.
     */
    public function update(Request $request, Remark $remark)
    {
        $this->authorizeRemark($remark);

        $validated = $request->validate([
            'remark' => ['required', 'string', 'max:5000'],
        ]);

        $remark->update([
            'remark' => $validated['remark'],
        ]);

        return back()->with('success', 'Remark updated successfully.');
    }

    /**
     * Delete a remark.
     */
    public function destroy(Remark $remark)
    {
        $this->authorizeRemark($remark);

        $remark->delete();

        return back()->with('success', 'Remark deleted successfully.');
    }

    /**
     * Pin a remark.
     */
    public function pin(Remark $remark)
    {
        $this->authorizeRemark($remark);

        $remark->update([
            'is_pinned' => true,
        ]);

        return back()->with('success', 'Remark pinned.');
    }

    /**
     * Unpin a remark.
     */
    public function unpin(Remark $remark)
    {
        $this->authorizeRemark($remark);

        $remark->update([
            'is_pinned' => false,
        ]);

        return back()->with('success', 'Remark unpinned.');
    }

    /**
     * Authorize task ownership.
     */
    private function authorizeTask(Task $task): void
    {
        abort_if($task->user_id !== auth()->id(), 403);
    }

    /**
     * Authorize remark ownership.
     */
    private function authorizeRemark(Remark $remark): void
    {
        abort_if($remark->user_id !== auth()->id(), 403);
    }
}