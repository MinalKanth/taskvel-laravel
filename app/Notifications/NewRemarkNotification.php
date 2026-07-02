<?php

namespace App\Notifications;

use App\Models\ClientRemark;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewRemarkNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Client remark.
     */
    protected ClientRemark $remark;

    /**
     * Create a new notification instance.
     */
    public function __construct(ClientRemark $remark)
    {
        $this->remark = $remark;
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
            ->subject('New Client Remark')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('A new remark has been added for a client.')
            ->line('Client: ' . optional($this->remark->client)->company_name)
            ->line('Title: ' . ($this->remark->title ?? 'N/A'))
            ->line('Priority: ' . ($this->remark->priority ?? 'Normal'))
            ->action(
                'View Remark',
                route('client-remarks.show', $this->remark)
            )
            ->line('Please review the remark.');
    }

    /**
     * Database notification.
     */
    public function toDatabase(object $notifiable): DatabaseMessage
    {
        return new DatabaseMessage([
            'client_id' => $this->remark->client_id,
            'remark_id' => $this->remark->id,
            'title' => 'New Client Remark',
            'message' => 'A new client remark has been added.',
            'priority' => $this->remark->priority,
            'url' => route('client-remarks.show', $this->remark),
        ]);
    }

    /**
     * Array representation.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'client_id' => $this->remark->client_id,
            'remark_id' => $this->remark->id,
            'title' => 'New Client Remark',
            'message' => 'A new client remark has been added.',
            'priority' => $this->remark->priority,
            'url' => route('client-remarks.show', $this->remark),
        ];
    }
}