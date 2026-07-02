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

class SendWhatsappNotification
{
    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        switch (true) {

            case $event instanceof ClientCreated:

                $this->send(
                    $event->client->phone,
                    'Welcome! Your client profile has been created successfully.'
                );

                break;

            case $event instanceof ClientUpdated:

                $this->send(
                    $event->client->phone,
                    'Your client profile has been updated successfully.'
                );

                break;

            case $event instanceof ClientDeleted:

                $this->send(
                    $event->client->phone,
                    $event->forceDeleted
                        ? 'Your client profile has been permanently removed.'
                        : 'Your client profile has been moved to trash.'
                );

                break;

            case $event instanceof DocumentUploaded:

                $this->send(
                    optional($event->document->client)->phone,
                    'A new document has been uploaded to your account.'
                );

                break;

            case $event instanceof CredentialUpdated:

                $this->send(
                    optional($event->credential->client)->phone,
                    'Your portal credentials have been updated.'
                );

                break;

            case $event instanceof RemarkCreated:

                $this->send(
                    optional($event->remark->client)->phone,
                    'A new remark has been added to your account.'
                );

                break;

            case $event instanceof CommunicationSent:

                $this->send(
                    optional($event->communication->client)->phone,
                    'A communication has been sent regarding your account.'
                );

                break;
        }
    }

    /**
     * Send WhatsApp message.
     */
    protected function send(
        ?string $phone,
        string $message
    ): void {

        if (empty($phone)) {
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Future Integrations
        |--------------------------------------------------------------------------
        |
        | WhatsApp Cloud API
        | Twilio WhatsApp
        | Gupshup
        | Interakt
        | WATI
        | MSG91
        |
        */

        Log::info('WhatsApp notification queued.', [

            'phone' => $phone,

            'message' => $message,

        ]);

        /*
        Example:

        app(WhatsAppService::class)->send(
            phone: $phone,
            message: $message
        );
        */
    }
}