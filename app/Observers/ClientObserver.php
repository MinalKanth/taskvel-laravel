<?php

namespace App\Observers;

use App\Models\Client;
use Illuminate\Support\Facades\Log;

class ClientObserver
{
    /**
     * Handle the Client "creating" event.
     */
    public function creating(Client $client): void
    {
        if (empty($client->created_by) && auth()->check()) {
            $client->created_by = auth()->id();
        }
    }

    /**
     * Handle the Client "created" event.
     */
    public function created(Client $client): void
    {
        Log::info('Client created.', [
            'client_id' => $client->id,
            'user_id'   => auth()->id(),
        ]);

        // Future:
        // ClientTimeline::create([...]);
        // Notification::send(...);
    }

    /**
     * Handle the Client "updating" event.
     */
    public function updating(Client $client): void
    {
        if (auth()->check()) {
            $client->updated_by = auth()->id();
        }
    }

    /**
     * Handle the Client "updated" event.
     */
    public function updated(Client $client): void
    {
        Log::info('Client updated.', [
            'client_id' => $client->id,
            'user_id'   => auth()->id(),
        ]);
    }

    /**
     * Handle the Client "deleted" event.
     */
    public function deleted(Client $client): void
    {
        Log::warning('Client deleted.', [
            'client_id' => $client->id,
            'user_id'   => auth()->id(),
        ]);
    }

    /**
     * Handle the Client "restored" event.
     */
    public function restored(Client $client): void
    {
        Log::info('Client restored.', [
            'client_id' => $client->id,
            'user_id'   => auth()->id(),
        ]);
    }

    /**
     * Handle the Client "force deleted" event.
     */
    public function forceDeleted(Client $client): void
    {
        Log::critical('Client permanently deleted.', [
            'client_id' => $client->id,
            'user_id'   => auth()->id(),
        ]);
    }
}