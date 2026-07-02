<?php

namespace App\Events;

use App\Models\ClientRemark;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RemarkCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The newly created remark.
     */
    public ClientRemark $remark;

    /**
     * Create a new event instance.
     */
    public function __construct(ClientRemark $remark)
    {
        $this->remark = $remark;
    }
}