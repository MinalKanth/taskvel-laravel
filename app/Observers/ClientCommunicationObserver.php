<?php

namespace App\Observers;

use App\Models\ClientCommunication;
use Illuminate\Support\Facades\Log;

class ClientCommunicationObserver
{
    /**
     * Handle the ClientCommunication "retrieved" event.
     */
    public function retrieved(ClientCommunication $clientCommunication): void
    {
        //
    }

    /**
     * Handle the ClientCommunication "creating" event.
     */
    // public function creating(ClientCommunication $clientCommunication): void
    // {
    //     if (empty($clientCommunication->created_by) && auth()->check()) {
    //         $clientCommunication->created_by = auth()->id();
    //     }

    //     if (empty($clientCommunication->communication_at)) {
    //         $clientCommunication->communication_at = now();
    //     }
    // }

    /**
     * Handle the ClientCommunication "created" event.
     */
    public function created(ClientCommunication $clientCommunication): void
    {
        Log::info('Client communication created.', [
            'communication_id' => $clientCommunication->id,
            'client_id'        => $clientCommunication->client_id,
            'type'             => $clientCommunication->channel,
            'status'           => $clientCommunication->status,
            'user_id'          => auth()->id(),
        ]);

        // Future:
        // event(new CommunicationSent($clientCommunication));
        // ClientTimeline::create([...]);
        // Notification::send(...);
    }

    /**
     * Handle the ClientCommunication "updating" event.
     */
    // public function updating(ClientCommunication $clientCommunication): void
    // {
    //     if (auth()->check()) {
    //         $clientCommunication->updated_by = auth()->id();
    //     }
    // }

    /**
     * Handle the ClientCommunication "updated" event.
     */
    public function updated(ClientCommunication $clientCommunication): void
    {
        Log::info('Client communication updated.', [
            'communication_id' => $clientCommunication->id,
            'client_id'        => $clientCommunication->client_id,
            'type'             => $clientCommunication->channel,
            'status'           => $clientCommunication->status,
            'user_id'          => auth()->id(),
        ]);
    }

    /**
     * Handle the ClientCommunication "saving" event.
     */
    public function saving(ClientCommunication $clientCommunication): void
    {
        //
    }

    /**
     * Handle the ClientCommunication "saved" event.
     */
    public function saved(ClientCommunication $clientCommunication): void
    {
        //
    }

    /**
     * Handle the ClientCommunication "deleting" event.
     */
    public function deleting(ClientCommunication $clientCommunication): void
    {
        //
    }

    /**
     * Handle the ClientCommunication "deleted" event.
     */
    public function deleted(ClientCommunication $clientCommunication): void
    {
        Log::warning('Client communication deleted.', [
            'communication_id' => $clientCommunication->id,
            'client_id'        => $clientCommunication->client_id,
            'type'             => $clientCommunication->channel,
            'user_id'          => auth()->id(),
        ]);
    }

    /**
     * Handle the ClientCommunication "restoring" event.
     */
    public function restoring(ClientCommunication $clientCommunication): void
    {
        //
    }

    /**
     * Handle the ClientCommunication "restored" event.
     */
    public function restored(ClientCommunication $clientCommunication): void
    {
        Log::info('Client communication restored.', [
            'communication_id' => $clientCommunication->id,
            'client_id'        => $clientCommunication->client_id,
            'type'             => $clientCommunication->channel,
            'user_id'          => auth()->id(),
        ]);
    }

    /**
     * Handle the ClientCommunication "force deleting" event.
     */
    public function forceDeleting(ClientCommunication $clientCommunication): void
    {
        //
    }

    /**
     * Handle the ClientCommunication "force deleted" event.
     */
    public function forceDeleted(ClientCommunication $clientCommunication): void
    {
        Log::critical('Client communication permanently deleted.', [
            'communication_id' => $clientCommunication->id,
            'client_id'        => $clientCommunication->client_id,
            'type'             => $clientCommunication->channel,
            'user_id'          => auth()->id(),
        ]);
    }
}