<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientTimeline extends Model
{
    use HasFactory;

    protected $fillable = [

        'client_id',

        'user_id',

        'module',

        'action',

        'title',

        'description',

        'reference_id',

        'reference_type',

        'event_type',

        'icon',

        'color',

        'metadata',

        'is_visible',
    ];

    protected $casts = [

        'metadata'=>'array',

        'is_visible'=>'boolean',
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
    | Polymorphic Reference
    |--------------------------------------------------------------------------
    */

    public function reference()
    {
        return $this->morphTo();
    }

    /*
    |--------------------------------------------------------------------------
    | Scope
    |--------------------------------------------------------------------------
    */

    public function scopeVisible($query)
    {
        return $query->where('is_visible',true);
    }
}