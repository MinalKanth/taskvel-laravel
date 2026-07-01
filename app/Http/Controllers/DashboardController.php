<?php

namespace App\Http\Controllers;

use App\Models\FocusSession;
use App\Models\Task;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the application dashboard.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $stats = [
            'total_tasks' => $user->tasks()->count(),

            'pending_tasks' => $user->tasks()
                ->whereIn('status', ['todo', 'in_progress'])
                ->count(),

            'completed_tasks' => $user->tasks()
                ->where('status', 'completed')
                ->count(),

            'favorite_tasks' => $user->tasks()
                ->where('is_favorite', true)
                ->count(),

            'today_focus_minutes' => $user->focusSessions()
                ->whereDate('started_at', today())
                ->sum('actual_minutes'),

            'completed_focus_sessions' => $user->focusSessions()
                ->where('completed', true)
                ->count(),
        ];

        $todayTasks = $user->tasks()
            ->whereDate('due_date', today())
            ->orderBy('priority')
            ->get();

        $upcomingTasks = $user->tasks()
            ->where('status', '!=', 'completed')
            ->whereNotNull('due_date')
            ->orderBy('due_date')
            ->limit(5)
            ->get();

        $recentFocusSessions = $user->focusSessions()
            ->latest('started_at')
            ->limit(10)
            ->get();

        return view('dashboard', compact(
            'stats',
            'todayTasks',
            'upcomingTasks',
            'recentFocusSessions'
        ));
    }
}