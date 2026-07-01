<?php

namespace App\Console\Commands;

use App\Models\FocusSession;
use App\Models\Task;
use App\Models\User;
use App\Notifications\DailySummaryNotification;
use Illuminate\Console\Command;

class SendDailySummary extends Command
{
    /**
     * The name and signature of the console command.
     *
     * php artisan tasks:daily-summary
     */
    protected $signature = 'tasks:daily-summary';

    /**
     * The console command description.
     */
    protected $description = 'Send a daily productivity summary to all users';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Sending daily summaries...');

        User::chunk(100, function ($users) {

            foreach ($users as $user) {

                $completed = Task::where('user_id', $user->id)
                    ->where('status', 'completed')
                    ->whereDate('updated_at', today())
                    ->count();

                $pending = Task::where('user_id', $user->id)
                    ->where('status', '!=', 'completed')
                    ->count();

                $focusSessions = FocusSession::where('user_id', $user->id)
                    ->whereDate('started_at', today());

                $focusCount = $focusSessions->count();

                $focusMinutes = $focusSessions->sum('duration_minutes');

                $totalTasks = $completed + $pending;

                $completionRate = $totalTasks > 0
                    ? round(($completed / $totalTasks) * 100)
                    : 0;

                $summary = [
                    'completed' => $completed,
                    'pending' => $pending,
                    'focus_sessions' => $focusCount,
                    'focus_minutes' => $focusMinutes,
                    'completion_rate' => $completionRate,
                ];

                $user->notify(new DailySummaryNotification($summary));

                $this->line("Summary sent to {$user->email}");
            }
        });

        $this->info('Daily summaries sent successfully.');

        return self::SUCCESS;
    }
}