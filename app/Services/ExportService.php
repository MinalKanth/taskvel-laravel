<?php

namespace App\Services;

use App\Models\FocusSession;
use App\Models\Task;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportService
{
    /**
     * Export tasks as CSV.
     */
    public function exportTasks(int $userId): StreamedResponse
    {
        $tasks = Task::with('tags')
            ->where('user_id', $userId)
            ->latest()
            ->get();

        $fileName = 'tasks_' . now()->format('Ymd_His') . '.csv';

        return response()->streamDownload(function () use ($tasks) {

            $handle = fopen('php://output', 'w');

            fputcsv($handle, [
                'Title',
                'Description',
                'Priority',
                'Status',
                'Due Date',
                'Estimated Minutes',
                'Actual Minutes',
                'Favorite',
                'Archived',
                'Tags',
                'Created At',
            ]);

            foreach ($tasks as $task) {

                fputcsv($handle, [
                    $task->title,
                    $task->description,
                    ucfirst($task->priority),
                    ucfirst(str_replace('_', ' ', $task->status)),
                    optional($task->due_date)->format('Y-m-d'),
                    $task->estimated_minutes,
                    $task->actual_minutes,
                    $task->is_favorite ? 'Yes' : 'No',
                    $task->is_archived ? 'Yes' : 'No',
                    $task->tags->pluck('name')->implode(', '),
                    $task->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($handle);

        }, $fileName);
    }

    /**
     * Export focus sessions as CSV.
     */
    public function exportFocusSessions(int $userId): StreamedResponse
    {
        $sessions = FocusSession::with('task')
            ->where('user_id', $userId)
            ->latest()
            ->get();

        $fileName = 'focus_sessions_' . now()->format('Ymd_His') . '.csv';

        return response()->streamDownload(function () use ($sessions) {

            $handle = fopen('php://output', 'w');

            fputcsv($handle, [
                'Task',
                'Session Type',
                'Planned Minutes',
                'Actual Minutes',
                'Completed',
                'Interruptions',
                'Started At',
                'Ended At',
            ]);

            foreach ($sessions as $session) {

                fputcsv($handle, [
                    optional($session->task)->title,
                    ucfirst(str_replace('_', ' ', $session->session_type)),
                    $session->planned_minutes,
                    $session->actual_minutes,
                    $session->completed ? 'Yes' : 'No',
                    $session->interruptions,
                    optional($session->started_at)->format('Y-m-d H:i:s'),
                    optional($session->ended_at)->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($handle);

        }, $fileName);
    }

    /**
     * Export dashboard summary as CSV.
     */
    public function exportSummary(int $userId): StreamedResponse
    {
        $taskQuery = Task::where('user_id', $userId);
        $focusQuery = FocusSession::where('user_id', $userId);

        $summary = [
            ['Metric', 'Value'],
            ['Total Tasks', $taskQuery->count()],
            ['Completed Tasks', (clone $taskQuery)->where('status', 'completed')->count()],
            ['Pending Tasks', (clone $taskQuery)->where('status', '!=', 'completed')->count()],
            ['Total Focus Sessions', $focusQuery->count()],
            ['Completed Focus Sessions', (clone $focusQuery)->where('completed', true)->count()],
            ['Total Focus Minutes', (clone $focusQuery)->sum('actual_minutes')],
        ];

        $fileName = 'dashboard_summary_' . now()->format('Ymd_His') . '.csv';

        return response()->streamDownload(function () use ($summary) {

            $handle = fopen('php://output', 'w');

            foreach ($summary as $row) {
                fputcsv($handle, $row);
            }

            fclose($handle);

        }, $fileName);
    }
}