<?php

namespace App\Services;

use App\Models\FocusSession;
use App\Models\Task;
use Carbon\Carbon;

class TimerService
{
    /**
     * Start a new focus session.
     */
    public function start(
        int $userId,
        ?int $taskId = null,
        string $sessionType = 'focus',
        int $plannedMinutes = 25
    ): FocusSession {

        if ($taskId) {
            $task = Task::findOrFail($taskId);

            abort_if($task->user_id !== $userId, 403);
        }

        return FocusSession::create([
            'user_id' => $userId,
            'task_id' => $taskId,
            'session_type' => $sessionType,
            'planned_minutes' => $plannedMinutes,
            'started_at' => now(),
            'completed' => false,
            'interrupted' => false,
            'interruptions' => 0,
        ]);
    }

    /**
     * Complete a focus session.
     */
    public function complete(
        FocusSession $session,
        ?string $notes = null
    ): FocusSession {

        $started = Carbon::parse($session->started_at);

        $minutes = max(
            1,
            $started->diffInMinutes(now())
        );

        $session->update([
            'actual_minutes' => $minutes,
            'ended_at' => now(),
            'completed' => true,
            'notes' => $notes,
        ]);

        if ($session->task) {
            $session->task->increment(
                'actual_minutes',
                $minutes
            );

            if (
                $session->task->estimated_minutes &&
                $session->task->actual_minutes >= $session->task->estimated_minutes
            ) {
                $session->task->update([
                    'status' => 'completed',
                    'completed_at' => now(),
                ]);
            }
        }

        return $session->fresh();
    }

    /**
     * Cancel a session.
     */
    public function cancel(FocusSession $session): bool
    {
        return $session->delete();
    }

    /**
     * Record an interruption.
     */
    public function interrupt(FocusSession $session): FocusSession
    {
        $session->increment('interruptions');

        $session->update([
            'interrupted' => true,
        ]);

        return $session->fresh();
    }

    /**
     * Pause a timer.
     */
    public function pause(FocusSession $session): FocusSession
    {
        $session->update([
            'ended_at' => now(),
        ]);

        return $session->fresh();
    }

    /**
     * Resume a paused timer.
     */
    public function resume(FocusSession $session): FocusSession
    {
        $session->update([
            'started_at' => now(),
            'ended_at' => null,
        ]);

        return $session->fresh();
    }

    /**
     * Get today's statistics.
     */
    public function todayStats(int $userId): array
    {
        $sessions = FocusSession::where('user_id', $userId)
            ->whereDate('started_at', today());

        return [
            'sessions' => (clone $sessions)->count(),

            'completed' => (clone $sessions)
                ->where('completed', true)
                ->count(),

            'minutes' => (clone $sessions)
                ->sum('actual_minutes'),

            'interruptions' => (clone $sessions)
                ->sum('interruptions'),
        ];
    }

    /**
     * Check if user has an active timer.
     */
    public function activeSession(int $userId): ?FocusSession
    {
        return FocusSession::where('user_id', $userId)
            ->whereNull('ended_at')
            ->latest('started_at')
            ->first();
    }

    /**
     * Determine whether a user currently has an active timer.
     */
    public function hasActiveSession(int $userId): bool
    {
        return $this->activeSession($userId) !== null;
    }
}