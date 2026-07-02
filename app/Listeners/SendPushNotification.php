<?php

namespace App\Listeners;

use App\Events\ClientCreated;
use App\Events\ClientDeleted;
use App\Events\ClientUpdated;
use App\Events\CommunicationSent;
use App\Events\CredentialUpdated;
use App\Events\DocumentUploaded;
use App\Events\RemarkCreated;
use Illuminate\Support\Facades\Log;

class SendPushNotification
{
    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        switch (true) {

            case $event instanceof ClientCreated:

                $this->send(
                    'Client Created',
                    'A new client has been added.',
                    [
                        'client_id' => $event->client->id,
                    ]
                );

                break;

            case $event instanceof ClientUpdated:

                $this->send(
                    'Client Updated',
                    'Client information has been updated.',
                    [
                        'client_id' => $event->client->id,
                    ]
                );

                break;

            case $event instanceof ClientDeleted:

                $this->send(
                    'Client Deleted',
                    $event->forceDeleted
                        ? 'Client permanently deleted.'
                        : 'Client moved to trash.',
                    [
                        'client_id' => $event->client->id,
                    ]
                );

                break;

            case $event instanceof DocumentUploaded:

                $this->send(
                    'Document Uploaded',
                    'A new document has been uploaded.',
                    [
                        'client_id'   => $event->document->client_id,
                        'document_id' => $event->document->id,
                    ]
                );

                break;

            case $event instanceof CredentialUpdated:

                $this->send(
                    'Credential Updated',
                    'Client credential updated successfully.',
                    [
                        'client_id'     => $event->credential->client_id,
                        'credential_id' => $event->credential->id,
                    ]
                );

                break;

            case $event instanceof RemarkCreated:

                $this->send(
                    'New Remark',
                    'A new client remark has been added.',
                    [
                        'client_id' => $event->remark->client_id,
                        'remark_id' => $event->remark->id,
                    ]
                );

                break;

            case $event instanceof CommunicationSent:

                $this->send(
                    'Communication Sent',
                    'Client communication completed.',
                    [
                        'client_id'        => $event->communication->client_id,
                        'communication_id' => $event->communication->id,
                    ]
                );

                break;
        }
    }

    /**
     * Send push notification.
     */
    protected function send(
        string $title,
        string $body,
        array $data = []
    ): void {

        /*
        |--------------------------------------------------------------------------
        | Future Integration
        |--------------------------------------------------------------------------
        |
        | Firebase Cloud Messaging (FCM)
        | OneSignal
        | Apple Push Notification Service
        | Pusher Beams
        |
        */

        Log::info('Push notification queued.', [

            'title' => $title,

            'body' => $body,

            'data' => $data,

        ]);

        /*
        Example:

        app(FirebaseService::class)->send(
            title: $title,
            body: $body,
            data: $data
        );
        */
    }
}