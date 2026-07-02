<?php

namespace App\Notifications;

use App\Models\ClientCredential;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CredentialExpiryNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Client credential.
     */
    protected ClientCredential $credential;

    /**
     * Create a new notification instance.
     */
    public function __construct(ClientCredential $credential)
    {
        $this->credential = $credential;
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
            ->subject('Credential Expiry Reminder')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('A client credential is approaching its expiry date.')
            ->line('Client: ' . optional($this->credential->client)->company_name)
            ->line('Portal: ' . $this->credential->portal)
            ->line('Username: ' . $this->credential->username)
            ->line(
                'Expiry Date: ' .
                optional($this->credential->expiry_date)?->format('d M Y')
            )
            ->action(
                'View Credential',
                route('client-credentials.show', $this->credential)
            )
            ->line('Please update or renew the credential before it expires.');
    }

    /**
     * Database notification.
     */
    public function toDatabase(object $notifiable): DatabaseMessage
    {
        return new DatabaseMessage([
            'client_id'     => $this->credential->client_id,
            'credential_id' => $this->credential->id,
            'title'         => 'Credential Expiry Reminder',
            'message'       => 'A client credential is about to expire.',
            'portal'        => $this->credential->portal,
            'username'      => $this->credential->username,
            'expiry_date'   => optional($this->credential->expiry_date)?->toDateString(),
            'url'           => route('client-credentials.show', $this->credential),
        ]);
    }

    /**
     * Array representation.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'client_id'     => $this->credential->client_id,
            'credential_id' => $this->credential->id,
            'title'         => 'Credential Expiry Reminder',
            'message'       => 'A client credential is about to expire.',
            'portal'        => $this->credential->portal,
            'username'      => $this->credential->username,
            'expiry_date'   => optional($this->credential->expiry_date)?->toDateString(),
            'url'           => route('client-credentials.show', $this->credential),
        ];
    }
}