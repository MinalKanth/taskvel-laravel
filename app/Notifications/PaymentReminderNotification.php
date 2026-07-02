<?php

namespace App\Notifications;

use App\Models\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentReminderNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Client instance.
     */
    protected Client $client;

    /**
     * Invoice amount.
     */
    protected float $amount;

    /**
     * Due date.
     */
    protected string $dueDate;

    /**
     * Invoice number.
     */
    protected ?string $invoiceNumber;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        Client $client,
        float $amount,
        string $dueDate,
        ?string $invoiceNumber = null
    ) {
        $this->client = $client;
        $this->amount = $amount;
        $this->dueDate = $dueDate;
        $this->invoiceNumber = $invoiceNumber;
    }

    /**
     * Notification channels.
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
            ->subject('Payment Reminder')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('This is a reminder for an upcoming or overdue payment.')

            ->line('Client: ' . $this->client->company_name)

            ->line(
                'Invoice No: ' .
                ($this->invoiceNumber ?? 'N/A')
            )

            ->line(
                'Amount: ₹' .
                number_format($this->amount, 2)
            )

            ->line(
                'Due Date: ' .
                $this->dueDate
            )

            ->action(
                'View Client',
                route('clients.show', $this->client)
            )

            ->line('Please complete the payment before the due date.');
    }

    /**
     * Database notification.
     */
    public function toDatabase(object $notifiable): DatabaseMessage
    {
        return new DatabaseMessage([

            'client_id' => $this->client->id,

            'title' => 'Payment Reminder',

            'message' => 'Payment is due.',

            'invoice_number' => $this->invoiceNumber,

            'amount' => $this->amount,

            'due_date' => $this->dueDate,

            'url' => route('clients.show', $this->client),

        ]);
    }

    /**
     * Array representation.
     */
    public function toArray(object $notifiable): array
    {
        return [

            'client_id' => $this->client->id,

            'title' => 'Payment Reminder',

            'message' => 'Payment is due.',

            'invoice_number' => $this->invoiceNumber,

            'amount' => $this->amount,

            'due_date' => $this->dueDate,

            'url' => route('clients.show', $this->client),

        ];
    }
}