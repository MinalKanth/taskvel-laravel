<?php

namespace App\Observers;

use App\Models\ClientDocument;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ClientDocumentObserver
{
    /**
     * Handle the ClientDocument "creating" event.
     */
    public function creating(ClientDocument $clientDocument): void
    {
        if (empty($clientDocument->created_by) && auth()->check()) {
            $clientDocument->created_by = auth()->id();
        }
    }

    /**
     * Handle the ClientDocument "created" event.
     */
    public function created(ClientDocument $clientDocument): void
    {
        Log::info('Client document created.', [
            'document_id' => $clientDocument->id,
            'client_id'   => $clientDocument->client_id,
            'user_id'     => auth()->id(),
        ]);

        // Future:
        // ClientTimeline::create([...]);
        // Notification::send(...);
    }

    /**
     * Handle the ClientDocument "updating" event.
     */
    public function updating(ClientDocument $clientDocument): void
    {
        if (auth()->check()) {
            $clientDocument->updated_by = auth()->id();
        }
    }

    /**
     * Handle the ClientDocument "updated" event.
     */
    public function updated(ClientDocument $clientDocument): void
    {
        Log::info('Client document updated.', [
            'document_id' => $clientDocument->id,
            'client_id'   => $clientDocument->client_id,
            'user_id'     => auth()->id(),
        ]);
    }

    /**
     * Handle the ClientDocument "deleted" event.
     */
    public function deleted(ClientDocument $clientDocument): void
    {
        Log::warning('Client document deleted.', [
            'document_id' => $clientDocument->id,
            'client_id'   => $clientDocument->client_id,
            'user_id'     => auth()->id(),
        ]);
    }

    /**
     * Handle the ClientDocument "restored" event.
     */
    public function restored(ClientDocument $clientDocument): void
    {
        Log::info('Client document restored.', [
            'document_id' => $clientDocument->id,
            'client_id'   => $clientDocument->client_id,
            'user_id'     => auth()->id(),
        ]);
    }

    /**
     * Handle the ClientDocument "force deleted" event.
     */
    public function forceDeleted(ClientDocument $clientDocument): void
    {
        if (
            $clientDocument->file_path &&
            Storage::disk('public')->exists($clientDocument->file_path)
        ) {
            Storage::disk('public')->delete($clientDocument->file_path);
        }

        Log::critical('Client document permanently deleted.', [
            'document_id' => $clientDocument->id,
            'client_id'   => $clientDocument->client_id,
            'user_id'     => auth()->id(),
        ]);
    }
}