<?php

namespace App\Events;

use App\Models\Client;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ClientDeleted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The deleted client.
     */
    public Client $client;

    /**
     * Whether the deletion is permanent.
     */
    public bool $forceDeleted;

    /**
     * Create a new event instance.
     */
    public function __construct(
        Client $client,
        bool $forceDeleted = false
    ) {
        $this->client = $client;
        $this->forceDeleted = $forceDeleted;
    }
}