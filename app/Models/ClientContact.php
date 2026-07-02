<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientContact extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'client_id',

        'first_name',
        'last_name',
        'full_name',

        'designation',
        'department',

        'mobile',
        'alternate_mobile',
        'email',
        'whatsapp_number',

        'date_of_birth',
        'anniversary',

        'is_primary',
        'receive_email',
        'receive_whatsapp',
        'receive_sms',

        'is_active',

        'remarks',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'anniversary' => 'date',

        'is_primary' => 'boolean',
        'receive_email' => 'boolean',
        'receive_whatsapp' => 'boolean',
        'receive_sms' => 'boolean',
        'is_active' => 'boolean',
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

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopePrimary($query)
    {
        return $query->where('is_primary', true);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getDisplayNameAttribute()
    {
        return "{$this->full_name} ({$this->designation})";
    }

    /*
    |--------------------------------------------------------------------------
    | Mutators
    |--------------------------------------------------------------------------
    */

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($contact) {
            $contact->full_name = trim(
                $contact->first_name . ' ' . $contact->last_name
            );
        });
    }
}