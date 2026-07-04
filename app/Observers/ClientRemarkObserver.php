<?php

namespace App\Observers;

use App\Models\ClientRemark;
use Illuminate\Support\Facades\Log;

class ClientRemarkObserver
{
    /**
     * Handle the ClientRemark "retrieved" event.
     */
    public function retrieved(ClientRemark $clientRemark): void
    {
        //
    }

    /**
     * Handle the ClientRemark "creating" event.
     */
    // public function creating(ClientRemark $clientRemark): void
    // {
    //     if (empty($clientRemark->created_by) && auth()->check()) {
    //         $clientRemark->created_by = auth()->id();
    //     }
    // }

    /**
     * Handle the ClientRemark "created" event.
     */
    public function created(ClientRemark $clientRemark): void
    {
        Log::info('Client remark created.', [
            'remark_id' => $clientRemark->id,
            'client_id' => $clientRemark->client_id,
            'user_id'   => auth()->id(),
        ]);

        // Future:
        // event(new RemarkCreated($clientRemark));
        // ClientTimeline::create([...]);
        // Notification::send(...);
    }

    /**
     * Handle the ClientRemark "updating" event.
     */
    public function updating(ClientRemark $clientRemark): void
    {
        if (auth()->check()) {
            $clientRemark->updated_by = auth()->id();
        }
    }

    /**
     * Handle the ClientRemark "updated" event.
     */
    public function updated(ClientRemark $clientRemark): void
    {
        Log::info('Client remark updated.', [
            'remark_id' => $clientRemark->id,
            'client_id' => $clientRemark->client_id,
            'user_id'   => auth()->id(),
        ]);
    }

    /**
     * Handle the ClientRemark "saving" event.
     */
    public function saving(ClientRemark $clientRemark): void
    {
        //
    }

    /**
     * Handle the ClientRemark "saved" event.
     */
    public function saved(ClientRemark $clientRemark): void
    {
        //
    }

    /**
     * Handle the ClientRemark "deleting" event.
     */
    public function deleting(ClientRemark $clientRemark): void
    {
        //
    }

    /**
     * Handle the ClientRemark "deleted" event.
     */
    public function deleted(ClientRemark $clientRemark): void
    {
        Log::warning('Client remark deleted.', [
            'remark_id' => $clientRemark->id,
            'client_id' => $clientRemark->client_id,
            'user_id'   => auth()->id(),
        ]);
    }

    /**
     * Handle the ClientRemark "restoring" event.
     */
    public function restoring(ClientRemark $clientRemark): void
    {
        //
    }

    /**
     * Handle the ClientRemark "restored" event.
     */
    public function restored(ClientRemark $clientRemark): void
    {
        Log::info('Client remark restored.', [
            'remark_id' => $clientRemark->id,
            'client_id' => $clientRemark->client_id,
            'user_id'   => auth()->id(),
        ]);
    }

    /**
     * Handle the ClientRemark "force deleting" event.
     */
    public function forceDeleting(ClientRemark $clientRemark): void
    {
        //
    }

    /**
     * Handle the ClientRemark "force deleted" event.
     */
    public function forceDeleted(ClientRemark $clientRemark): void
    {
        Log::critical('Client remark permanently deleted.', [
            'remark_id' => $clientRemark->id,
            'client_id' => $clientRemark->client_id,
            'user_id'   => auth()->id(),
        ]);
    }

    public function creating(ClientRemark $clientRemark): void
{
    if (auth()->check()) {

        $clientRemark->created_by = auth()->id();

    }
}

}