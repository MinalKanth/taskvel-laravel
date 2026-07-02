<?php

namespace App\Observers;

use App\Models\ClientCredential;
use Illuminate\Support\Facades\Log;

class ClientCredentialObserver
{
    /**
     * Handle the ClientCredential "retrieved" event.
     */
    public function retrieved(ClientCredential $clientCredential): void
    {
        //
    }

    /**
     * Handle the ClientCredential "creating" event.
     */
    public function creating(ClientCredential $clientCredential): void
    {
        if (empty($clientCredential->created_by) && auth()->check()) {
            $clientCredential->created_by = auth()->id();
        }
    }

    /**
     * Handle the ClientCredential "created" event.
     */
    public function created(ClientCredential $clientCredential): void
    {
        Log::info('Client credential created.', [
            'credential_id' => $clientCredential->id,
            'client_id'     => $clientCredential->client_id,
            'portal'        => $clientCredential->portal,
            'user_id'       => auth()->id(),
        ]);

        // Future:
        // event(new CredentialUpdated($clientCredential));
        // ClientTimeline::create([...]);
    }

    /**
     * Handle the ClientCredential "updating" event.
     */
    public function updating(ClientCredential $clientCredential): void
    {
        if (auth()->check()) {
            $clientCredential->updated_by = auth()->id();
        }
    }

    /**
     * Handle the ClientCredential "updated" event.
     */
    public function updated(ClientCredential $clientCredential): void
    {
        Log::info('Client credential updated.', [
            'credential_id' => $clientCredential->id,
            'client_id'     => $clientCredential->client_id,
            'portal'        => $clientCredential->portal,
            'user_id'       => auth()->id(),
        ]);
    }

    /**
     * Handle the ClientCredential "saving" event.
     */
    public function saving(ClientCredential $clientCredential): void
    {
        //
    }

    /**
     * Handle the ClientCredential "saved" event.
     */
    public function saved(ClientCredential $clientCredential): void
    {
        //
    }

    /**
     * Handle the ClientCredential "deleting" event.
     */
    public function deleting(ClientCredential $clientCredential): void
    {
        //
    }

    /**
     * Handle the ClientCredential "deleted" event.
     */
    public function deleted(ClientCredential $clientCredential): void
    {
        Log::warning('Client credential deleted.', [
            'credential_id' => $clientCredential->id,
            'client_id'     => $clientCredential->client_id,
            'portal'        => $clientCredential->portal,
            'user_id'       => auth()->id(),
        ]);
    }

    /**
     * Handle the ClientCredential "restoring" event.
     */
    public function restoring(ClientCredential $clientCredential): void
    {
        //
    }

    /**
     * Handle the ClientCredential "restored" event.
     */
    public function restored(ClientCredential $clientCredential): void
    {
        Log::info('Client credential restored.', [
            'credential_id' => $clientCredential->id,
            'client_id'     => $clientCredential->client_id,
            'portal'        => $clientCredential->portal,
            'user_id'       => auth()->id(),
        ]);
    }

    /**
     * Handle the ClientCredential "force deleting" event.
     */
    public function forceDeleting(ClientCredential $clientCredential): void
    {
        //
    }

    /**
     * Handle the ClientCredential "force deleted" event.
     */
    public function forceDeleted(ClientCredential $clientCredential): void
    {
        Log::critical('Client credential permanently deleted.', [
            'credential_id' => $clientCredential->id,
            'client_id'     => $clientCredential->client_id,
            'portal'        => $clientCredential->portal,
            'user_id'       => auth()->id(),
        ]);
    }
}