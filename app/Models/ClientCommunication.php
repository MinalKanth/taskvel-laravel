<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientCommunication extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [

        'client_id',

        'channel',

        'direction',

        'subject',

        'message',

        'sender_name',
        'sender_email',
        'sender_phone',

        'receiver_name',
        'receiver_email',
        'receiver_phone',

        'thread_id',

        'message_id',

        'has_attachment',

        'status',

        'user_id',

        'communication_at',

        'metadata',
    ];

    protected $casts = [

        'communication_at' => 'datetime',

        'metadata' => 'array',

        'has_attachment' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeIncoming($query)
    {
        return $query->where('direction', 'Incoming');
    }

    public function scopeOutgoing($query)
    {
        return $query->where('direction', 'Outgoing');
    }

    public function scopeUnread($query)
    {
        return $query->where('status', 'Delivered');
    }
}