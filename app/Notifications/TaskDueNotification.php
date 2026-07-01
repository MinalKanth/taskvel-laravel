<?php

namespace App\Notifications;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskDueNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        protected Task $task
    ) {
    }

    /**
     * Delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Database notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Task Due',
            'message' => "Your task '{$this->task->title}' is due soon.",
            'task_id' => $this->task->id,
            'priority' => $this->task->priority,
            'due_date' => $this->task->due_date,
            'type' => 'task_due',
        ];
    }

    /**
     * Mail notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Task Due Reminder')
            ->greeting("Hello {$notifiable->name},")
            ->line("Your task '{$this->task->title}' is due soon.")
            ->line("Priority: {$this->task->priority}")
            ->line("Due Date: {$this->task->due_date}")
            ->action('View Task', url('/tasks/' . $this->task->id))
            ->line('Stay productive!');
    }
}