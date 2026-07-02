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

        'expiry_date',

        'is_active',

        'remarks',
    ];

    protected $casts = [
        'password' => 'encrypted',
        'security_answer' => 'encrypted',

        'otp_required' => 'boolean',
        'dsc_required' => 'boolean',
        'is_active' => 'boolean',

        'expiry_date' => 'date',
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
        return $query->whereDate('expiry_date', '<', now());
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getDisplayNameAttribute()
    {
        return "{$this->portal} - {$this->username}";
    }
}