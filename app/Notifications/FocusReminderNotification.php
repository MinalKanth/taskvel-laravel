<?php

namespace App\Notifications;

use App\Models\FocusSession;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class FocusReminderNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        protected FocusSession $focusSession
    ) {
    }

    /**
     * Determine the notification delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Store notification in the database.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Focus Session Reminder',
            'message' => 'Your scheduled focus session is about to begin.',
            'focus_session_id' => $this->focusSession->id,
            'task_id' => $this->focusSession->task_id,
            'duration_minutes' => $this->focusSession->duration_minutes,
            'session_type' => $this->focusSession->session_type,
            'started_at' => $this->focusSession->started_at,
            'type' => 'focus_reminder',
        ];
    }

    /**
     * Send the notification via email.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Focus Session Reminder')
            ->greeting("Hello {$notifiable->name},")
            ->line('It is time to start your scheduled focus session.')
            ->line("Session Type: {$this->focusSession->session_type}")
            ->line("Duration: {$this->focusSession->duration_minutes} minutes")
            ->when(
                $this->focusSession->task,
                fn (MailMessage $mail) => $mail->line(
                    "Task: {$this->focusSession->task->title}"
                )
            )
            ->action('Open Dashboard', url('/dashboard'))
            ->line('Stay focused and have a productive session!');
    }
}