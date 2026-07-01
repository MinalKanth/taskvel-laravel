<?php

namespace App\Http\Controllers;

use App\Models\FocusSession;
use App\Models\Task;
use Illuminate\Http\Request;

class FocusController extends Controller
{
    /**
     * Display focus sessions.
     *
     * Accepts an optional ?task=ID query param so that clicking
     * "Start Focus" on any specific task pre-selects that task
     * instead of always falling back to the latest in_progress one.
     */
    public function index(Request $request)
    {
        $sessions = $request->user()
            ->focusSessions()
            ->with('task')
            ->latest('started_at')
            ->paginate(20);

        // If a specific task_id is passed in the URL (?task=X), use that task.
        // Otherwise fall back to the most recent in_progress task.
        $task = null;

        if ($request->filled('task')) {
            $task = $request->user()
                ->tasks()
                ->where('id', $request->task)
                ->first();
        }

        if (!$task) {
            $task = $request->user()
                ->tasks()
                ->where('status', 'in_progress')
                ->latest()
                ->first();
        }

        $todayMinutes = $request->user()
            ->focusSessions()
            ->whereDate('started_at', today())
            ->where('completed', true)
            ->sum('actual_minutes');

        $todaySessions = $request->user()
            ->focusSessions()
            ->whereDate('started_at', today())
            ->where('completed', true)
            ->count();

        return view('focus.index', compact(
            'sessions',
            'task',
            'todayMinutes',
            'todaySessions'
        ));
    }

    /**
     * Start a new focus session.
     */
    public function start(Request $request)
    {
        $validated = $request->validate([
            'task_id'        => ['nullable', 'exists:tasks,id'],
            'session_type'   => ['required', 'in:focus,short_break,long_break'],
            'planned_minutes' => ['required', 'integer', 'min:1', 'max:180'],
        ]);

        if (!empty($validated['task_id'])) {
            $task = Task::findOrFail($validated['task_id']);
            abort_if($task->user_id !== auth()->id(), 403);
        }

        $session = FocusSession::create([
            'user_id'         => auth()->id(),
            'task_id'         => $validated['task_id'] ?? null,
            'session_type'    => $validated['session_type'],
            'planned_minutes' => $validated['planned_minutes'],
            'started_at'      => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Focus session started.',
            'session' => $session,
        ]);
    }

    /**
     * Complete a focus session.
     */
    public function complete(Request $request, FocusSession $session)
    {
        $this->authorizeSession($session);

        $validated = $request->validate([
            'actual_minutes' => ['required', 'integer', 'min:1'],
            'notes'          => ['nullable', 'string'],
        ]);

        $session->update([
            'actual_minutes' => $validated['actual_minutes'],
            'notes'          => $validated['notes'] ?? null,
            'completed'      => true,
            'ended_at'       => now(),
        ]);

        if ($session->task) {
            $session->task->increment('actual_minutes', $validated['actual_minutes']);
        }

        return response()->json([
            'success' => true,
            'message' => 'Focus session completed.',
        ]);
    }

    /**
     * Interrupt a running session.
     */
    public function interrupt(FocusSession $session)
    {
        $this->authorizeSession($session);

        $session->increment('interruptions');
        $session->update(['interrupted' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Interruption recorded.',
        ]);
    }

    /**
     * Cancel a session.
     */
    public function cancel(FocusSession $session)
    {
        $this->authorizeSession($session);

        $session->delete();

        return response()->json([
            'success' => true,
            'message' => 'Focus session cancelled.',
        ]);
    }

    /**
     * Show session statistics.
     */
    public function statistics(Request $request)
    {
        $user  = $request->user();

        $stats = [
            'total_sessions' => $user->focusSessions()->count(),

            'completed_sessions' => $user->focusSessions()
                ->where('completed', true)
                ->count(),

            'focus_minutes' => $user->focusSessions()
                ->where('completed', true)
                ->sum('actual_minutes'),

            'interruptions' => $user->focusSessions()
                ->sum('interruptions'),

            'today_minutes' => $user->focusSessions()
                ->whereDate('started_at', today())
                ->sum('actual_minutes'),
        ];

        return response()->json($stats);
    }

    /**
     * Ensure session belongs to authenticated user.
     */
    private function authorizeSession(FocusSession $session): void
    {
        abort_if($session->user_id !== auth()->id(), 403);
    }
}