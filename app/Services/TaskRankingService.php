<?php

namespace App\Services;

use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;

class TaskRankingService
{
    /**
     * Get ranked tasks for a user.
     */
    public function rank(int $userId): Collection
    {
        return Task::where('user_id', $userId)
            ->where('is_archived', false)
            ->get()
            ->sortByDesc(fn ($task) => $this->score($task))
            ->values();
    }

    /**
     * Calculate a priority score for a task.
     */
    public function score(Task $task): float
    {
        $score = 0;

        // Priority Weight
        $score += match ($task->priority) {
            'urgent' => 100,
            'high'   => 75,
            'medium' => 50,
            'low'    => 25,
            default  => 0,
        };

        // Due Date Weight
        if ($task->due_date) {

            $days = now()->diffInDays($task->due_date, false);

            if ($days <= 0) {
                $score += 100;
            } elseif ($days <= 1) {
                $score += 80;
            } elseif ($days <= 3) {
                $score += 60;
            } elseif ($days <= 7) {
                $score += 40;
            } else {
                $score += 10;
            }
        }

        // Favorite Bonus
        if ($task->is_favorite) {
            $score += 20;
        }

        // Estimated Workload
        if ($task->estimated_minutes) {

            if ($task->estimated_minutes <= 30) {
                $score += 10;
            } elseif ($task->estimated_minutes <= 60) {
                $score += 5;
            }
        }

        // Penalty for completed tasks
        if ($task->status === 'completed') {
            $score = 0;
        }

        return $score;
    }

    /**
     * Get the highest priority task.
     */
    public function nextTask(int $userId): ?Task
    {
        return $this->rank($userId)->first();
    }
}