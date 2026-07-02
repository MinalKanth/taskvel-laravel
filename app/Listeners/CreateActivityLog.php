<?php

namespace App\Listeners;

use App\Events\ClientCreated;
use App\Events\ClientDeleted;
use App\Events\ClientUpdated;
use App\Events\CommunicationSent;
use App\Events\CredentialUpdated;
use App\Events\DocumentUploaded;
use App\Events\RemarkCreated;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CreateActivityLog
{
    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $activity = [

            'user_id' => Auth::id(),

            'ip_address' => request()?->ip(),

            'user_agent' => request()?->userAgent(),

            'created_at' => now(),

        ];

        switch (true) {

            case $event instanceof ClientCreated:

                Log::channel('daily')->info(
                    'Client Created',
                    array_merge($activity, [

                        'client_id' => $event->client->id,

                        'action' => 'client.created',

                    ])
                );

                break;

            case $event instanceof ClientUpdated:

                Log::channel('daily')->info(
                    'Client Updated',
                    array_merge($activity, [

                        'client_id' => $event->client->id,

                        'action' => 'client.updated',

                        'changes' => $event->changes,

                    ])
                );

                break;

            case $event instanceof ClientDeleted:

                Log::channel('daily')->warning(
                    'Client Deleted',
                    array_merge($activity, [

                        'client_id' => $event->client->id,

                        'action' => $event->forceDeleted
                            ? 'client.force_deleted'
                            : 'client.deleted',

                    ])
                );

                break;

            case $event instanceof DocumentUploaded:

                Log::channel('daily')->info(
                    'Document Uploaded',
                    array_merge($activity, [

                        'client_id' => $event->document->client_id,

                        'document_id' => $event->document->id,

                        'action' => 'document.uploaded',

                    ])
                );

                break;

            case $event instanceof CredentialUpdated:

                Log::channel('daily')->info(
                    'Credential Updated',
                    array_merge($activity, [

                        'client_id' => $event->credential->client_id,

                        'credential_id' => $event->credential->id,

                        'portal' => $event->credential->portal,

                        'action' => 'credential.updated',

                    ])
                );

                break;

            case $event instanceof RemarkCreated:

                Log::channel('daily')->info(
                    'Remark Created',
                    array_merge($activity, [

                        'client_id' => $event->remark->client_id,

                        'remark_id' => $event->remark->id,

                        'action' => 'remark.created',

                    ])
                );

                break;

            case $event instanceof CommunicationSent:

                Log::channel('daily')->info(
                    'Communication Sent',
                    array_merge($activity, [

                        'client_id' => $event->communication->client_id,

                        'communication_id' => $event->communication->id,

                        'status' => $event->status,

                        'action' => 'communication.sent',

                    ])
                );

                break;
        }
    }
}