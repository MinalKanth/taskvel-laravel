<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportController extends Controller
{
    /**
     * Export all tasks as CSV.
     */
    public function tasks(Request $request): StreamedResponse
    {
        $tasks = $request->user()
            ->tasks()
            ->with('tags')
            ->orderBy('created_at', 'desc')
            ->get();

        $fileName = 'tasks_' . now()->format('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$fileName}",
        ];

        return response()->stream(function () use ($tasks) {

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

        }, 200, $headers);
    }

    /**
     * Export focus sessions as CSV.
     */
    public function focusSessions(Request $request): StreamedResponse
    {
        $sessions = $request->user()
            ->focusSessions()
            ->with('task')
            ->latest()
            ->get();

        $fileName = 'focus_sessions_' . now()->format('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$fileName}",
        ];

        return response()->stream(function () use ($sessions) {

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

        }, 200, $headers);
    }

    /**
     * Export dashboard summary.
     */
    public function summary(Request $request): StreamedResponse
    {
        $user = $request->user();

        $fileName = 'summary_' . now()->format('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$fileName}",
        ];

        return response()->stream(function () use ($user) {

            $handle = fopen('php://output', 'w');

            fputcsv($handle, ['Metric', 'Value']);

            fputcsv($handle, [
                'Total Tasks',
                $user->tasks()->count(),
            ]);

            fputcsv($handle, [
                'Completed Tasks',
                $user->tasks()->where('status', 'completed')->count(),
            ]);

            fputcsv($handle, [
                'Pending Tasks',
                $user->tasks()->where('status', '!=', 'completed')->count(),
            ]);

            fputcsv($handle, [
                'Total Focus Sessions',
                $user->focusSessions()->count(),
            ]);

            fputcsv($handle, [
                'Focus Minutes',
                $user->focusSessions()->sum('actual_minutes'),
            ]);

            fclose($handle);

        }, 200, $headers);
    }
}