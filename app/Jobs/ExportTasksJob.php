<?php

namespace App\Jobs;

use App\Models\User;
use App\Services\ExportService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ExportTasksJob implements ShouldQueue
{
    use Queueable, InteractsWithQueue, SerializesModels;

    /**
     * Number of attempts.
     */
    public int $tries = 3;

    /**
     * Timeout (seconds).
     */
    public int $timeout = 300;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected User $user,
        protected array $filters,
        protected string $format
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(ExportService $exportService): void
    {
        $exportService->export(
            user: $this->user,
            filters: $this->filters,
            format: $this->format
        );
    }

    /**
     * Handle a job failure.
     */
    public function failed(?\Throwable $exception): void
    {
        logger()->error('Task export failed.', [
            'user_id' => $this->user->id,
            'format' => $this->format,
            'filters' => $this->filters,
            'error' => $exception?->getMessage(),
        ]);
    }
}