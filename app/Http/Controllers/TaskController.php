<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Tag;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of tasks.
     */
    public function index(Request $request)
    {
        $query = $request->user()->tasks()->with(['tags', 'steps']);

        // Status Filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Priority Filter
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        // Search
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', "%{$request->search}%")
                  ->orWhere('description', 'like', "%{$request->search}%");
            });
        }

        $tasks = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show create form.
     */
    public function create(Request $request)
    {
        $tags = $request->user()->tags()->orderBy('name')->get();

        return view('tasks.create', compact('tags'));
    }

    /**
     * Store new task.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'priority' => ['required', 'in:low,medium,high,urgent'],
            'status' => ['required', 'in:todo,in_progress,completed,cancelled'],
            'due_date' => ['nullable', 'date'],
            'estimated_minutes' => ['nullable', 'integer', 'min:0'],
            'tag_ids' => ['nullable', 'array'],
        ]);

        $validated['user_id'] = $request->user()->id;

        $task = Task::create($validated);

        if (!empty($validated['tag_ids'])) {
            $task->tags()->sync($validated['tag_ids']);
        }

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Task created successfully.');
    }

    /**
     * Display task.
     */
    public function show(Task $task)
    {
        $this->authorizeTask($task);

        $task->load([
    'steps',
    'remarks.user',
    'tags',
    'focusSessions',
]);

        return view('tasks.show', compact('task'));
    }

    /**
     * Edit task.
     */
    public function edit(Request $request, Task $task)
    {
        $this->authorizeTask($task);

        $tags = $request->user()->tags()->get();

        return view('tasks.edit', compact('task', 'tags'));
    }

    /**
     * Update task.
     */
    public function update(Request $request, Task $task)
    {
        $this->authorizeTask($task);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'priority' => ['required', 'in:low,medium,high,urgent'],
            'status' => ['required', 'in:todo,in_progress,completed,cancelled'],
            'due_date' => ['nullable', 'date'],
            'estimated_minutes' => ['nullable', 'integer', 'min:0'],
            'tag_ids' => ['nullable', 'array'],
        ]);

        if ($validated['status'] === 'completed' && !$task->completed_at) {
            $validated['completed_at'] = now();
        }

        if ($validated['status'] !== 'completed') {
            $validated['completed_at'] = null;
        }

        $task->update($validated);

        if (isset($validated['tag_ids'])) {
            $task->tags()->sync($validated['tag_ids']);
        }

        return redirect()
            ->route('tasks.show', $task)
            ->with('success', 'Task updated successfully.');
    }

    /**
     * Delete task.
     */
    public function destroy(Task $task)
    {
        $this->authorizeTask($task);

        $task->delete();

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Task deleted successfully.');
    }

    /**
     * Toggle favorite.
     */
    public function favorite(Task $task)
    {
        $this->authorizeTask($task);

        $task->update([
            'is_favorite' => !$task->is_favorite,
        ]);

        return back();
    }

    /**
     * Archive task.
     */
    public function archive(Task $task)
    {
        $this->authorizeTask($task);

        $task->update([
            'is_archived' => true,
        ]);

        return back();
    }

    /**
     * Restore archived task.
     */
    public function restore(Task $task)
    {
        $this->authorizeTask($task);

        $task->update([
            'is_archived' => false,
        ]);

        return back();
    }

    /**
     * Ensure task belongs to authenticated user.
     */
    private function authorizeTask(Task $task): void
    {
        abort_if($task->user_id !== auth()->id(), 403);
    }
}