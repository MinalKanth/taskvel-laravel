<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'service_code',
        'name',
        'short_name',
        'description',

        'category',

        'is_recurring',
        'frequency',
        'due_day',

        'default_price',

        'icon',
        'color',

        'sort_order',

        'is_active',
    ];

    protected $casts = [
        'is_recurring' => 'boolean',
        'default_price' => 'decimal:2',
        'due_day' => 'integer',
        'sort_order' => 'integer',
        'is_active' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function clientServices()
    {
        return $this->hasMany(ClientService::class);
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

    public function scopeRecurring($query)
    {
        return $query->where('is_recurring', true);
    }

    /*
    |--------------------------------------------------------------------------
    | Accessor
    |--------------------------------------------------------------------------
    */

    public function getDisplayNameAttribute()
    {
        return "{$this->service_code} - {$this->name}";
    }

    /*
    |--------------------------------------------------------------------------
    | Constants
    |--------------------------------------------------------------------------
    */

    public const CATEGORY_REGISTRATION = 'Registration';
    public const CATEGORY_COMPLIANCE = 'Compliance';
    public const CATEGORY_PAYROLL = 'Payroll';
    public const CATEGORY_TAXATION = 'Taxation';
    public const CATEGORY_ACCOUNTING = 'Accounting';
    public const CATEGORY_LICENSING = 'Licensing';
    public const CATEGORY_CONSULTANCY = 'Consultancy';
    public const CATEGORY_LEGAL = 'Legal';
    public const CATEGORY_OTHER = 'Other';
}