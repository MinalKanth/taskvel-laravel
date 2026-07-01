<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DailySummaryNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        protected array $summary
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
            'title' => 'Daily Task Summary',
            'message' => 'Your productivity summary for today is ready.',
            'summary' => $this->summary,
            'type' => 'daily_summary',
        ];
    }

    /**
     * Mail notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Your Daily Productivity Summary')
            ->greeting("Hello {$notifiable->name},")
            ->line('Here is your productivity summary for today.')
            ->line("Tasks Completed: {$this->summary['completed']}")
            ->line("Tasks Pending: {$this->summary['pending']}")
            ->line("Focus Sessions: {$this->summary['focus_sessions']}")
            ->line("Focus Time: {$this->summary['focus_minutes']} minutes")
            ->line("Completion Rate: {$this->summary['completion_rate']}%")
            ->action('Open Dashboard', url('/dashboard'))
            ->line('Keep up the good work!');
    }
}