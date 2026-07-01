<?php

namespace App\Listeners;

use App\Events\TaskCompleted;
use App\Models\FocusSession;
use App\Models\Task;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateTaskStatistics implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Number of attempts.
     */
    public int $tries = 3;

    /**
     * Handle the event.
     */
    public function handle(TaskCompleted $event): void
    {
        $task = $event->task;
        $user = $task->user;

        // Total completed tasks
        $completedTasks = Task::where('user_id', $user->id)
            ->where('status', 'completed')
            ->count();

        // Pending tasks
        $pendingTasks = Task::where('user_id', $user->id)
            ->where('status', '!=', 'completed')
            ->count();

        // Total focus minutes
        $focusMinutes = FocusSession::where('user_id', $user->id)
            ->sum('duration_minutes');

        // Example: Store these in cache
        cache()->forever("stats:user:{$user->id}", [
            'completed_tasks' => $completedTasks,
            'pending_tasks' => $pendingTasks,
            'focus_minutes' => $focusMinutes,
            'last_updated' => now(),
        ]);

        logger()->info('Task statistics updated.', [
            'user_id' => $user->id,
            'task_id' => $task->id,
        ]);
    }

    /**
     * Handle a failed queued listener.
     */
    public function failed(TaskCompleted $event, \Throwable $exception): void
    {
        logger()->error('Failed to update task statistics.', [
            'task_id' => $event->task->id,
            'error' => $exception->getMessage(),
        ]);
    }
}