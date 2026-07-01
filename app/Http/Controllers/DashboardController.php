<?php

namespace App\Http\Controllers;

use App\Models\Remark;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        /*——— Task counts ———————————————————————————————————————————*/
        $totalTasks      = $user->tasks()->active()->count();
        $completedTasks  = $user->tasks()->active()->where('status', 'completed')->count();
        $pendingTasks    = $user->tasks()->active()->where('status', 'pending')->count();
        $inProgressTasks = $user->tasks()->active()->where('status', 'in_progress')->count();
        $overdueTasks    = $user->tasks()->active()->overdue()->count();

        $productivity = $totalTasks > 0
            ? (int) round(($completedTasks / $totalTasks) * 100)
            : 0;

        /*——— Focus stats ————————————————————————————————————————————*/
        $focusMinutesAll = $user->focusSessions()->where('completed', true)->sum('actual_minutes');
        $focusHours      = round($focusMinutesAll / 60, 1);

        $focusMinsToday = $user->focusSessions()
            ->whereDate('started_at', today())
            ->where('completed', true)
            ->sum('actual_minutes');

        $todaySessions = $user->focusSessions()
            ->whereDate('started_at', today())
            ->where('completed', true)
            ->count();

        /*——— Recent focus sessions (last 10, with task) ————————————*/
        $recentFocusSessions = $user->focusSessions()
            ->with('task')
            ->latest('started_at')
            ->take(10)
            ->get();

        /*——— Weekly chart ———————————————————————————————————————————*/
        $weeklyChart = [];
        for ($i = 6; $i >= 0; $i--) {
            $date          = now()->subDays($i)->toDateString();
            $weeklyChart[] = $user->tasks()->whereDate('completed_at', $date)->count();
        }

        /*——— 28-day heatmap ————————————————————————————————————————*/
        $heatmapRaw = $user->focusSessions()
            ->where('completed', true)
            ->where('started_at', '>=', now()->subDays(27)->startOfDay())
            ->selectRaw('DATE(started_at) as day, COUNT(*) as cnt')
            ->groupBy('day')
            ->pluck('cnt', 'day')
            ->toArray();

        $heatmapData = [];
        for ($i = 27; $i >= 0; $i--) {
            $date          = now()->subDays($i)->toDateString();
            $heatmapData[] = (int) ($heatmapRaw[$date] ?? 0);
        }

        /*——— Task collections ——————————————————————————————————————*/
        $recentTasks = $user->tasks()->active()->with(['tags'])->latest()->take(8)->get();

        $todayTasks = $user->tasks()
            ->active()
            ->where(function ($q) {
                $q->whereDate('due_date', today())
                  ->orWhereDate('created_at', today());
            })
            ->where('status', '!=', 'completed')
            ->with(['tags'])
            ->latest()
            ->take(10)
            ->get();

        $upcomingTasks = $user->tasks()
            ->active()
            ->whereNotNull('due_date')
            ->whereBetween('due_date', [now(), now()->addDays(7)])
            ->where('status', '!=', 'completed')
            ->orderBy('due_date')
            ->take(5)
            ->get();

        $pinnedTasks = $user->tasks()
            ->active()
            ->where(function ($q) {
                $q->where('is_pinned', true)->orWhere('is_favorite', true);
            })
            ->latest()
            ->take(5)
            ->get();

        /*——— Recent remarks ————————————————————————————————————————*/
        $remarks = Remark::whereHas('task', fn ($q) => $q->where('user_id', $user->id))
            ->with('task')
            ->latest()
            ->take(6)
            ->get();

        /*——— Stats bag — every key variant, old and new ————————————*/
        $stats = [
            'total_tasks'         => $totalTasks,
            'completed_tasks'     => $completedTasks,
            'pending_tasks'       => $pendingTasks,
            'in_progress_tasks'   => $inProgressTasks,
            'overdue_tasks'       => $overdueTasks,
            'productivity'        => $productivity,

            // Focus — canonical
            'focus_hours'         => $focusHours,
            'focus_minutes_today' => $focusMinsToday,
            'today_sessions'      => $todaySessions,

            // Aliases for any old Blade references
            'today_focus_minutes' => $focusMinsToday,
            'today_focus_hours'   => round($focusMinsToday / 60, 1),
            'completed_sessions'  => $todaySessions,
            'total_sessions'      => $user->focusSessions()->count(),
            'focus_minutes'       => $focusMinutesAll,
        ];

        return view('dashboard', compact(
            'stats',
            'weeklyChart',
            'heatmapData',
            'recentTasks',
            'todayTasks',
            'upcomingTasks',
            'pinnedTasks',
            'recentFocusSessions',
            'remarks'
        ));
    }
}