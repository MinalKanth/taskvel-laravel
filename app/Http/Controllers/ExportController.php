<?php

namespace App\Http\Controllers;

use App\Models\Remark;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Index page
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        return view('export.index');
    }

    /*
    |--------------------------------------------------------------------------
    | Main dispatcher
    |--------------------------------------------------------------------------
    */
    public function download(Request $request): StreamedResponse
    {
        $request->validate([
            'type'   => ['required', 'in:tasks,focus,remarks,summary,full'],
            'format' => ['required', 'in:csv,excel,pdf,json'],
        ]);

        return match ($request->type) {
            'tasks'   => $this->exportTasks($request),
            'focus'   => $this->exportFocus($request),
            'remarks' => $this->exportRemarks($request),
            'summary' => $this->exportSummary($request),
            'full'    => $this->exportFull($request),
        };
    }

    /*
    |--------------------------------------------------------------------------
    | Tasks export
    |--------------------------------------------------------------------------
    */
    private function exportTasks(Request $request): StreamedResponse
    {
        $user = $request->user();

        // Build query
        $query = $user->tasks()->with(['tags', 'steps', 'focusSessions']);

        // Date filter
        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        // Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Priority
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        // Include archived
        match ($request->input('include', 'active')) {
            'archived' => $query->where('is_archived', true),
            'all'      => null,
            default    => $query->where('is_archived', false),
        };

        $tasks = $query->latest()->get();

        // Columns
        $selectedCols = $request->input('columns', [
            'title','description','priority','status','progress',
            'due_date','estimated_minutes','actual_minutes','tags','created_at',
        ]);

        $fileName = 'tasks_' . now()->format('Ymd_His');

        return match ($request->format) {
            'json'  => $this->streamJson($fileName, $tasks->map(fn($t) => $this->taskRow($t, $selectedCols))->toArray()),
            default => $this->streamCsv($fileName, $selectedCols, $tasks->map(fn($t) => $this->taskRow($t, $selectedCols))->toArray()),
        };
    }

    private function taskRow($task, array $cols): array
    {
        $map = [
            'title'             => $task->title,
            'description'       => $task->description,
            'notes'             => $task->notes,
            'priority'          => ucfirst($task->priority),
            'status'            => ucwords(str_replace('_', ' ', $task->status)),
            'progress'          => ($task->progress ?? 0) . '%',
            'category'          => $task->category,
            'due_date'          => optional($task->due_date)->format('Y-m-d H:i'),
            'reminder_at'       => optional($task->reminder_at)->format('Y-m-d H:i'),
            'recurrence'        => ucfirst($task->recurrence ?? 'none'),
            'estimated_minutes' => $task->estimated_minutes,
            'actual_minutes'    => $task->actual_minutes ?? 0,
            'tags'              => $task->tags->pluck('name')->implode(', '),
            'urgency'           => $task->urgency ?? 1,
            'impact'            => $task->impact ?? 1,
            'is_favorite'       => $task->is_favorite ? 'Yes' : 'No',
            'is_pinned'         => $task->is_pinned ? 'Yes' : 'No',
            'completed_at'      => optional($task->completed_at)->format('Y-m-d H:i'),
            'created_at'        => $task->created_at->format('Y-m-d H:i:s'),
        ];

        return array_intersect_key($map, array_flip($cols));
    }

    /*
    |--------------------------------------------------------------------------
    | Focus sessions export
    |--------------------------------------------------------------------------
    */
    private function exportFocus(Request $request): StreamedResponse
    {
        $query = $request->user()->focusSessions()->with('task');

        if ($request->filled('from_date')) {
            $query->whereDate('started_at', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('started_at', '<=', $request->to_date);
        }

        $sessions = $query->latest('started_at')->get();

        $headers = [
            'task', 'session_type', 'planned_minutes', 'actual_minutes',
            'completed', 'interrupted', 'interruptions', 'notes', 'started_at', 'ended_at',
        ];

        $rows = $sessions->map(fn($s) => [
            'task'             => optional($s->task)->title ?? 'General',
            'session_type'     => ucfirst(str_replace('_', ' ', $s->session_type)),
            'planned_minutes'  => $s->planned_minutes,
            'actual_minutes'   => $s->actual_minutes ?? 0,
            'completed'        => $s->completed ? 'Yes' : 'No',
            'interrupted'      => $s->interrupted ? 'Yes' : 'No',
            'interruptions'    => $s->interruptions ?? 0,
            'notes'            => $s->notes,
            'started_at'       => optional($s->started_at)->format('Y-m-d H:i:s'),
            'ended_at'         => optional($s->ended_at)->format('Y-m-d H:i:s'),
        ])->toArray();

        $fileName = 'focus_sessions_' . now()->format('Ymd_His');

        return $request->format === 'json'
            ? $this->streamJson($fileName, $rows)
            : $this->streamCsv($fileName, $headers, $rows);
    }

    /*
    |--------------------------------------------------------------------------
    | Remarks export
    |--------------------------------------------------------------------------
    */
    private function exportRemarks(Request $request): StreamedResponse
    {
        $query = Remark::with(['task', 'user'])
            ->where('user_id', $request->user()->id);

        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $remarks = $query->latest()->get();

        $headers = ['task', 'remark', 'tone', 'is_pinned', 'word_count', 'created_at'];

        $rows = $remarks->map(fn($r) => [
            'task'       => optional($r->task)->title ?? '—',
            'remark'     => $r->remark,
            'tone'       => $r->tone ?? '',
            'is_pinned'  => $r->is_pinned ? 'Yes' : 'No',
            'word_count' => str_word_count($r->remark),
            'created_at' => $r->created_at->format('Y-m-d H:i:s'),
        ])->toArray();

        $fileName = 'remarks_' . now()->format('Ymd_His');

        return $request->format === 'json'
            ? $this->streamJson($fileName, $rows)
            : $this->streamCsv($fileName, $headers, $rows);
    }

    /*
    |--------------------------------------------------------------------------
    | Summary report
    |--------------------------------------------------------------------------
    */
    private function exportSummary(Request $request): StreamedResponse
    {
        $user = $request->user();

        $from = $request->from_date ? now()->parse($request->from_date) : null;
        $to   = $request->to_date   ? now()->parse($request->to_date)   : null;

        $tasks = $user->tasks()
            ->when($from, fn($q) => $q->whereDate('created_at', '>=', $from))
            ->when($to,   fn($q) => $q->whereDate('created_at', '<=', $to));

        $focus = $user->focusSessions()
            ->when($from, fn($q) => $q->whereDate('started_at', '>=', $from))
            ->when($to,   fn($q) => $q->whereDate('started_at', '<=', $to));

        $total       = $tasks->count();
        $completed   = (clone $tasks)->where('status', 'completed')->count();
        $pending     = (clone $tasks)->where('status', 'pending')->count();
        $inProgress  = (clone $tasks)->where('status', 'in_progress')->count();
        $overdue     = (clone $tasks)->whereNotNull('due_date')->where('due_date','<',now())->where('status','!=','completed')->count();
        $focusMins   = (clone $focus)->where('completed', true)->sum('actual_minutes');
        $focusSess   = (clone $focus)->where('completed', true)->count();
        $productivity= $total > 0 ? round(($completed/$total)*100) : 0;
        $remarks     = Remark::where('user_id', $user->id)->count();

        $rows = [
            ['Metric', 'Value'],
            ['Report generated', now()->format('d M Y H:i')],
            ['Period from', $from?->format('d M Y') ?? 'All time'],
            ['Period to',   $to?->format('d M Y') ?? 'Now'],
            [''],
            ['── Tasks ──', ''],
            ['Total tasks',         $total],
            ['Completed',           $completed],
            ['In progress',         $inProgress],
            ['Pending',             $pending],
            ['Overdue',             $overdue],
            ['Productivity score',  $productivity.'%'],
            [''],
            ['── Focus ──', ''],
            ['Total sessions',      $focusSess],
            ['Total focus minutes', $focusMins],
            ['Total focus hours',   round($focusMins/60, 1)],
            ['Avg session length',  $focusSess > 0 ? round($focusMins/$focusSess) . ' min' : 'N/A'],
            [''],
            ['── Other ──', ''],
            ['Total remarks',       $remarks],
        ];

        $fileName = 'summary_' . now()->format('Ymd_His');

        if ($request->format === 'json') {
            return $this->streamJson($fileName, compact(
                'total','completed','pending','inProgress','overdue',
                'productivity','focusMins','focusSess','remarks'
            ));
        }

        return response()->stream(function () use ($rows) {
            $h = fopen('php://output', 'w');
            foreach ($rows as $row) { fputcsv($h, $row); }
            fclose($h);
        }, 200, [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename={$fileName}.csv",
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Full export (all data as JSON)
    |--------------------------------------------------------------------------
    */
    private function exportFull(Request $request): StreamedResponse
    {
        $user = $request->user();

        $data = [
            'exported_at' => now()->toIso8601String(),
            'user'        => ['name' => $user->name, 'email' => $user->email],
            'tasks'       => $user->tasks()->with(['tags','steps','remarks','focusSessions'])->get()->toArray(),
            'focus'       => $user->focusSessions()->with('task')->latest()->get()->toArray(),
            'remarks'     => Remark::where('user_id',$user->id)->with('task')->latest()->get()->toArray(),
        ];

        $fileName = 'taskvel_full_export_' . now()->format('Ymd_His') . '.json';

        return response()->stream(function () use ($data) {
            echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }, 200, [
            'Content-Type'        => 'application/json',
            'Content-Disposition' => "attachment; filename={$fileName}",
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Stream helpers
    |--------------------------------------------------------------------------
    */
    private function streamCsv(string $name, array $headers, array $rows): StreamedResponse
    {
        return response()->stream(function () use ($headers, $rows) {
            $h = fopen('php://output', 'w');
            // BOM for Excel UTF-8 compatibility
            fprintf($h, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($h, array_map(fn($c) => ucwords(str_replace('_',' ',$c)), $headers));
            foreach ($rows as $row) {
                fputcsv($h, is_array($row) ? array_values($row) : [$row]);
            }
            fclose($h);
        }, 200, [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename={$name}.csv",
        ]);
    }

    private function streamJson(string $name, array $data): StreamedResponse
    {
        return response()->stream(function () use ($data) {
            echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }, 200, [
            'Content-Type'        => 'application/json',
            'Content-Disposition' => "attachment; filename={$name}.json",
        ]);
    }
}