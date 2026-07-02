<?php

namespace App\Notifications;

use App\Models\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ClientAssignedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Client instance.
     */
    protected Client $client;

    /**
     * Create a new notification instance.
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
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
            ->subject('New Client Assigned')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('A new client has been assigned to you.')
            ->line('Client: ' . $this->client->company_name)
            ->line('Client Code: ' . $this->client->client_code)
            ->action(
                'View Client',
                route('clients.show', $this->client)
            )
            ->line('Thank you.');
    }

    /**
     * Database notification.
     */
    public function toDatabase(object $notifiable): DatabaseMessage
    {
        return new DatabaseMessage([
            'client_id'   => $this->client->id,
            'title'       => 'New Client Assigned',
            'message'     => 'A new client has been assigned to you.',
            'company'     => $this->client->company_name,
            'client_code' => $this->client->client_code,
            'url'         => route('clients.show', $this->client),
        ]);
    }

    /**
     * Array representation.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'client_id'   => $this->client->id,
            'title'       => 'New Client Assigned',
            'message'     => 'A new client has been assigned to you.',
            'company'     => $this->client->company_name,
            'client_code' => $this->client->client_code,
            'url'         => route('clients.show', $this->client),
        ];
    }
}