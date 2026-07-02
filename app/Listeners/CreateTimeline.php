<?php

namespace App\Listeners;

use App\Events\ClientCreated;
use App\Events\ClientUpdated;
use App\Events\ClientDeleted;
use App\Events\DocumentUploaded;
use App\Events\CredentialUpdated;
use App\Events\RemarkCreated;
use App\Events\CommunicationSent;
use App\Models\ClientTimeline;
use Illuminate\Support\Facades\Auth;

class CreateTimeline
{
    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $clientId = null;
        $title = null;
        $description = null;
        $type = null;

        switch (true) {

            case $event instanceof ClientCreated:

                $clientId = $event->client->id;

                $type = 'client_created';

                $title = 'Client Created';

                $description = 'New client created successfully.';

                break;

            case $event instanceof ClientUpdated:

                $clientId = $event->client->id;

                $type = 'client_updated';

                $title = 'Client Updated';

                $description = 'Client information updated.';

                break;

            case $event instanceof ClientDeleted:

                $clientId = $event->client->id;

                $type = 'client_deleted';

                $title = 'Client Deleted';

                $description = $event->forceDeleted
                    ? 'Client permanently deleted.'
                    : 'Client moved to trash.';

                break;

            case $event instanceof DocumentUploaded:

                $clientId = $event->document->client_id;

                $type = 'document_uploaded';

                $title = 'Document Uploaded';

                $description = $event->document->document_name;

                break;

            case $event instanceof CredentialUpdated:

                $clientId = $event->credential->client_id;

                $type = 'credential_updated';

                $title = 'Credential Updated';

                $description = $event->credential->portal;

                break;

            case $event instanceof RemarkCreated:

                $clientId = $event->remark->client_id;

                $type = 'remark_created';

                $title = 'Remark Added';

                $description = $event->remark->title;

                break;

            case $event instanceof CommunicationSent:

                $clientId = $event->communication->client_id;

                $type = 'communication_sent';

                $title = 'Communication Sent';

                $description = $event->communication->subject;

                break;

            default:

                return;

        }

        ClientTimeline::create([

            'client_id' => $clientId,

            'type' => $type,

            'title' => $title,

            'description' => $description,

            'user_id' => Auth::id(),

            'event_at' => now(),

        ]);
    }
}