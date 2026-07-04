<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientCredential extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'client_id',

        'portal',
        'portal_name',

        'username',
        'password',

        'registered_email',
        'registered_mobile',

        'security_question',
        'security_answer',

        'client_id_number',

        'otp_required',
        'dsc_required',

        'login_url',

        'api_key',
        'api_secret',

        'pin',

        'dsc_serial_number',
        'dsc_owner',
        'dsc_expiry_date',

        'expiry_date',
        'last_login_at',
        'last_password_changed_at',

        'is_active',

        'metadata',
        'remarks',

        'created_by',
        'updated_by',
    ];

    protected $casts = [
        
        'otp_required' => 'boolean',
        'dsc_required' => 'boolean',
        'is_active' => 'boolean',

        'expiry_date' => 'date',
        'dsc_expiry_date' => 'date',

        'last_login_at' => 'datetime',
        'last_password_changed_at' => 'datetime',

        'metadata' => 'array',
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

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeExpired($query)
    {
        return $query->whereDate('expiry_date', '<', today());
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getDisplayNameAttribute(): string
    {
        return "{$this->portal} ({$this->username})";
    }
}