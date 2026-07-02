<?php

namespace App\Events;

use App\Models\ClientCommunication;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CommunicationSent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The communication instance.
     */
    public ClientCommunication $communication;

    /**
     * Delivery status.
     */
    public string $status;

    /**
     * Optional provider response.
     */
    public ?array $response;

    /**
     * Create a new event instance.
     */
    public function __construct(
        ClientCommunication $communication,
        string $status = 'Sent',
        ?array $response = null
    ) {
        $this->communication = $communication;
        $this->status = $status;
        $this->response = $response;
    }
}