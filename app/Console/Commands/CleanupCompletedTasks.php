<?php

namespace App\Console\Commands;

use App\Models\Task;
use Illuminate\Console\Command;

class CleanupCompletedTasks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * php artisan tasks:cleanup
     */
    protected $signature = 'tasks:cleanup
                            {--days=30 : Delete completed tasks older than the specified number of days}
                            {--force : Skip confirmation prompt}';

    /**
     * The console command description.
     */
    protected $description = 'Delete completed tasks older than the specified number of days';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $days = (int) $this->option('days');

        if (!$this->option('force')) {
            if (!$this->confirm("Delete completed tasks older than {$days} days?")) {
                $this->warn('Operation cancelled.');
                return self::SUCCESS;
            }
        }

        $query = Task::where('status', 'completed')
            ->whereNotNull('completed_at')
            ->where('completed_at', '<', now()->subDays($days));

        $count = $query->count();

        if ($count === 0) {
            $this->info('No completed tasks found for cleanup.');
            return self::SUCCESS;
        }

        $this->info("Found {$count} completed tasks.");

        $bar = $this->output->createProgressBar($count);
        $bar->start();

        $query->chunkById(100, function ($tasks) use ($bar) {
            foreach ($tasks as $task) {
                $task->delete();
                $bar->advance();
            }
        });

        $bar->finish();

        $this->newLine(2);
        $this->info("Successfully deleted {$count} completed tasks.");

        return self::SUCCESS;
    }
}