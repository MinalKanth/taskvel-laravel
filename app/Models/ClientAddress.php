<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientAddress extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'client_id',

        'address_type',

        'address_line_1',
        'address_line_2',
        'landmark',

        'city',
        'district',
        'state',
        'country',
        'postal_code',

        'latitude',
        'longitude',

        'is_default',
        'is_active',

        'remarks',
    ];

    protected $casts = [
        'latitude'   => 'decimal:7',
        'longitude'  => 'decimal:7',
        'is_default' => 'boolean',
        'is_active'  => 'boolean',
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

    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
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

    public function getFullAddressAttribute()
    {
        return collect([
            $this->address_line_1,
            $this->address_line_2,
            $this->landmark,
            $this->city,
            $this->district,
            $this->state,
            $this->country,
            $this->postal_code,
        ])->filter()->implode(', ');
    }

    /*
    |--------------------------------------------------------------------------
    | Constants
    |--------------------------------------------------------------------------
    */

    public const REGISTERED = 'Registered Office';
    public const CORPORATE = 'Corporate Office';
    public const BRANCH = 'Branch Office';
    public const FACTORY = 'Factory';
    public const WAREHOUSE = 'Warehouse';
    public const BILLING = 'Billing';
    public const SHIPPING = 'Shipping';
    public const OTHER = 'Other';
}