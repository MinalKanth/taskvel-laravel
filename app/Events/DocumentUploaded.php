<?php

namespace App\Events;

use App\Models\ClientCredential;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CredentialUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The updated credential.
     */
    public ClientCredential $credential;

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
        ClientCredential $credential,
        array $original = [],
        array $changes = []
    ) {
        $this->credential = $credential;
        $this->original = $original;
        $this->changes = $changes;
    }
}