<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientService extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [

        'client_id',

        'service_id',

        'start_date',
        'end_date',

        'assigned_to',

        'service_fee',
        'discount',
        'tax_percentage',

        'billing_cycle',

        'due_day',

        'auto_generate_tasks',

        'status',

        'renewable',

        'renewal_date',

        'remarks',

        'is_active',
    ];

    protected $casts = [

        'start_date' => 'date',

        'end_date' => 'date',

        'renewal_date' => 'date',

        'service_fee' => 'decimal:2',

        'discount' => 'decimal:2',

        'tax_percentage' => 'decimal:2',

        'auto_generate_tasks' => 'boolean',

        'renewable' => 'boolean',

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

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
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

    public function scopeRunning($query)
    {
        return $query->where('status', 'Active');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessor
    |--------------------------------------------------------------------------
    */

    public function getFinalAmountAttribute()
    {
        $amount = $this->service_fee - $this->discount;

        return $amount + ($amount * $this->tax_percentage / 100);
    }
    
}