<?php

namespace App\Events;

use App\Models\Client;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ClientUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The updated client.
     */
    public Client $client;

    /**
     * Original attributes before update.
     */
    public array $original;

    /**
     * Changed attributes.
     */
    public array $changes;

    /**
     * Create a new event instance.
     */
    public function __construct(
        Client $client,
        array $original = [],
        array $changes = []
    ) {
        $this->client = $client;
        $this->original = $original;
        $this->changes = $changes;
    }
}