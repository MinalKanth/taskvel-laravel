<?php

namespace App\Notifications;

use App\Models\ClientDocument;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DocumentExpiryNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Client document.
     */
    protected ClientDocument $document;

    /**
     * Create a new notification instance.
     */
    public function __construct(ClientDocument $document)
    {
        $this->document = $document;
    }

    /**
     * Delivery channels.
     */
    public function via(object $notifiable): array
    {
        return [
            'database',
            'mail',
        ];
    }

    /**
     * Mail notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Document Expiry Reminder')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('A client document is approaching its expiry date.')
            ->line('Client: ' . optional($this->document->client)->company_name)
            ->line('Document: ' . $this->document->document_name)
            ->line('Expiry Date: ' . optional($this->document->expiry_date)?->format('d M Y'))
            ->action(
                'View Document',
                route('client-documents.show', $this->document)
            )
            ->line('Please renew or replace the document before it expires.');
    }

    /**
     * Database notification.
     */
    public function toDatabase(object $notifiable): DatabaseMessage
    {
        return new DatabaseMessage([
            'client_id'   => $this->document->client_id,
            'document_id' => $this->document->id,
            'title'       => 'Document Expiry Reminder',
            'message'     => 'A client document is about to expire.',
            'document'    => $this->document->document_name,
            'expiry_date' => optional($this->document->expiry_date)?->toDateString(),
            'url'         => route('client-documents.show', $this->document),
        ]);
    }

    /**
     * Array representation.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'client_id'   => $this->document->client_id,
            'document_id' => $this->document->id,
            'title'       => 'Document Expiry Reminder',
            'message'     => 'A client document is about to expire.',
            'document'    => $this->document->document_name,
            'expiry_date' => optional($this->document->expiry_date)?->toDateString(),
            'url'         => route('client-documents.show', $this->document),
        ];
    }
}