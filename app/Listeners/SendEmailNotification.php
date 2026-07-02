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
use Illuminate\Support\Facades\Mail;

class SendEmailNotification
{
    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        switch (true) {

            case $event instanceof ClientCreated:

                if (!empty($event->client->email)) {

                    // Mail::to($event->client->email)
                    //     ->queue(new WelcomeClientMail($event->client));

                    Log::info('Welcome email queued.', [
                        'client_id' => $event->client->id,
                    ]);

                }

                break;

            case $event instanceof ClientUpdated:

                if (!empty($event->client->email)) {

                    Log::info('Client update notification queued.', [
                        'client_id' => $event->client->id,
                    ]);

                }

                break;

            case $event instanceof ClientDeleted:

                Log::info('Client deletion notification.', [
                    'client_id' => $event->client->id,
                ]);

                break;

            case $event instanceof DocumentUploaded:

                Log::info('Document upload notification.', [
                    'document_id' => $event->document->id,
                    'client_id'   => $event->document->client_id,
                ]);

                break;

            case $event instanceof CredentialUpdated:

                Log::info('Credential update notification.', [
                    'credential_id' => $event->credential->id,
                    'client_id'     => $event->credential->client_id,
                ]);

                break;

            case $event instanceof RemarkCreated:

                Log::info('Remark notification.', [
                    'remark_id' => $event->remark->id,
                    'client_id' => $event->remark->client_id,
                ]);

                break;

            case $event instanceof CommunicationSent:

                Log::info('Communication email notification.', [
                    'communication_id' => $event->communication->id,
                    'client_id'        => $event->communication->client_id,
                ]);

                break;
        }
    }
}