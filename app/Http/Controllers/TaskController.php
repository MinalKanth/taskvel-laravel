<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Tag;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->user()
            ->tasks()
            ->active()
            ->with(['tags', 'steps', 'focusSessions']);

        if ($request->filled('status'))   { $query->where('status',   $request->status);   }
        if ($request->filled('priority')) { $query->where('priority', $request->priority); }
        if ($request->filled('category')) { $query->where('category', $request->category); }

        if ($request->filled('due')) {
            match ($request->due) {
                'today'   => $query->dueToday(),
                'overdue' => $query->overdue(),
                default   => null,
            };
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title',       'like', "%{$request->search}%")
                  ->orWhere('description','like', "%{$request->search}%")
                  ->orWhere('notes',      'like', "%{$request->search}%");
            });
        }

        $sort = match ($request->sort ?? 'newest') {
            'due_date'  => ['due_date',    'asc'],
            'priority'  => ['urgency',     'desc'],
            'progress'  => ['progress',    'desc'],
            'title'     => ['title',       'asc'],
            default     => ['created_at',  'desc'],
        };

        $query->orderBy('is_pinned', 'desc')
              ->orderBy($sort[0], $sort[1]);

        $tasks = $query->paginate(12)->withQueryString();

        // Dashboard stats for header cards
        $user = $request->user();
        $stats = [
            'total'       => $user->tasks()->active()->count(),
            'in_progress' => $user->tasks()->active()->where('status', 'in_progress')->count(),
            'completed'   => $user->tasks()->active()->where('status', 'completed')->count(),
            'overdue'     => $user->tasks()->active()->overdue()->count(),
            'due_today'   => $user->tasks()->active()->dueToday()->count(),
            'focus_mins'  => $user->focusSessions()->whereDate('started_at', today())->sum('actual_minutes'),
        ];

        $categories = $user->tasks()->active()
            ->whereNotNull('category')
            ->distinct()
            ->pluck('category');

        return view('tasks.index', compact('tasks', 'stats', 'categories'));
    }

    public function create(Request $request)
    {
        $tags = $request->user()->tags()->orderBy('name')->get();
        return view('tasks.create', compact('tags'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'             => ['required', 'string', 'max:255'],
            'description'       => ['nullable', 'string'],
            'notes'             => ['nullable', 'string'],
            'priority'          => ['required', 'in:low,medium,high,urgent'],
            'status'            => ['required', 'in:pending,in_progress,completed,cancelled'],
            'progress'          => ['nullable', 'integer', 'min:0', 'max:100'],
            'category'          => ['nullable', 'string', 'max:100'],
            'color'             => ['nullable', 'string', 'max:7'],
            'due_date'          => ['nullable', 'date'],
            'reminder_at'       => ['nullable', 'date'],
            'recurrence'        => ['nullable', 'in:none,daily,weekly,monthly'],
            'estimated_minutes' => ['nullable', 'integer', 'min:0'],
            'urgency'           => ['nullable', 'integer', 'min:1', 'max:5'],
            'impact'            => ['nullable', 'integer', 'min:1', 'max:5'],
            'tags'              => ['nullable', 'array'],
            'tags.*'            => ['exists:tags,id'],
            'steps'             => ['nullable', 'array'],
            'steps.*'           => ['nullable', 'string', 'max:255'],
        ]);

        $validated['user_id'] = $request->user()->id;
        $validated['progress'] = $validated['progress'] ?? 0;
        $validated['recurrence'] = $validated['recurrence'] ?? 'none';
        $validated['color'] = $validated['color'] ?? '#4f46e5';

        if ($validated['status'] === 'completed') {
            $validated['completed_at'] = now();
            $validated['progress']     = 100;
        }

        $tagIds = $validated['tags'] ?? [];
        $steps  = array_filter($validated['steps'] ?? []);
        unset($validated['tags'], $validated['steps']);

        $task = Task::create($validated);

        if (!empty($tagIds)) {
            $task->tags()->sync($tagIds);
        }

        foreach ($steps as $i => $stepTitle) {
            $task->steps()->create([
                'title'      => $stepTitle,
                'sort_order' => $i,
            ]);
        }

        return redirect()->route('tasks.show', $task)
            ->with('success', 'Task created successfully.');
    }

    public function show(Task $task)
    {
        $this->authorizeTask($task);
        $task->load(['steps', 'remarks.user', 'tags', 'focusSessions']);
        return view('tasks.show', compact('task'));
    }

    public function edit(Request $request, Task $task)
    {
        $this->authorizeTask($task);
        $tags = $request->user()->tags()->orderBy('name')->get();
        return view('tasks.edit', compact('task', 'tags'));
    }

    public function update(Request $request, Task $task)
    {
        $this->authorizeTask($task);

        $validated = $request->validate([
            'title'             => ['required', 'string', 'max:255'],
            'description'       => ['nullable', 'string'],
            'notes'             => ['nullable', 'string'],
            'priority'          => ['required', 'in:low,medium,high,urgent'],
            'status'            => ['required', 'in:pending,in_progress,completed,cancelled'],
            'progress'          => ['nullable', 'integer', 'min:0', 'max:100'],
            'category'          => ['nullable', 'string', 'max:100'],
            'color'             => ['nullable', 'string', 'max:7'],
            'due_date'          => ['nullable', 'date'],
            'reminder_at'       => ['nullable', 'date'],
            'recurrence'        => ['nullable', 'in:none,daily,weekly,monthly'],
            'estimated_minutes' => ['nullable', 'integer', 'min:0'],
            'urgency'           => ['nullable', 'integer', 'min:1', 'max:5'],
            'impact'            => ['nullable', 'integer', 'min:1', 'max:5'],
            'tags'              => ['nullable', 'array'],
            'tags.*'            => ['exists:tags,id'],
            'steps'             => ['nullable', 'array'],
            'steps.*'           => ['nullable', 'string', 'max:255'],
        ]);

        // completed_at lifecycle
        if ($validated['status'] === 'completed' && !$task->completed_at) {
            $validated['completed_at'] = now();
            $validated['progress']     = 100;
        } elseif ($validated['status'] !== 'completed') {
            $validated['completed_at'] = null;
        }

        $tagIds = $validated['tags'] ?? null;
        $steps  = $validated['steps'] ?? null;
        unset($validated['tags'], $validated['steps']);

        $task->update($validated);

        if ($tagIds !== null) {
            $task->tags()->sync($tagIds);
        }

        if ($steps !== null) {
            $task->steps()->delete();
            foreach (array_filter($steps) as $i => $stepTitle) {
                $task->steps()->create([
                    'title'      => $stepTitle,
                    'sort_order' => $i,
                ]);
            }
        }

        return redirect()->route('tasks.show', $task)
            ->with('success', 'Task updated successfully.');
    }

    public function destroy(Task $task)
    {
        $this->authorizeTask($task);
        $task->delete();
        return redirect()->route('tasks.index')
            ->with('success', 'Task deleted.');
    }

    public function favorite(Task $task)
    {
        $this->authorizeTask($task);
        $task->update(['is_favorite' => !$task->is_favorite]);
        return back()->with('success', $task->is_favorite ? 'Added to favorites.' : 'Removed from favorites.');
    }

    public function pin(Task $task)
    {
        $this->authorizeTask($task);
        $task->update(['is_pinned' => !$task->is_pinned]);
        return back();
    }

    public function archive(Task $task)
    {
        $this->authorizeTask($task);
        $task->update(['is_archived' => true]);
        return back()->with('success', 'Task archived.');
    }

    public function restore(Task $task)
    {
        $this->authorizeTask($task);
        $task->update(['is_archived' => false]);
        return back()->with('success', 'Task restored.');
    }

    private function authorizeTask(Task $task): void
    {
        abort_if($task->user_id !== auth()->id(), 403);
    }
}