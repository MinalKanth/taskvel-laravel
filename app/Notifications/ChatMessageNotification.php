<?php
namespace App\Notifications;

use Illuminate\Notifications\Notification;

class ChatMessageNotification extends Notification
{
    public $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'conversation_id' => $this->message->conversation_id,
            'message' => $this->message->message,
            'sender' => $this->message->sender->name,
        ];
    }
}