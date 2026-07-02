<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'client_code',
        'company_name',
        'legal_name',
        'business_type',
        'constitution',

        'gstin',
        'pan',
        'tan',
        'cin',
        'udyam_number',
        'esic_code',
        'epf_code',

        'email',
        'website',
        'phone',
        'alternate_phone',

        'status',
        'priority',

        'incorporation_date',

        'opening_balance',
        'credit_limit',
        'payment_terms',

        'assigned_to',

        'created_by',
        'updated_by',

        'notes',
        'is_active',
    ];

    protected $casts = [
        'incorporation_date' => 'date',
        'opening_balance' => 'decimal:2',
        'credit_limit' => 'decimal:2',
        'payment_terms' => 'integer',
        'is_active' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | Status Constants
    |--------------------------------------------------------------------------
    */

    public const STATUS_LEAD = 'Lead';
    public const STATUS_PROSPECT = 'Prospect';
    public const STATUS_ACTIVE = 'Active';
    public const STATUS_INACTIVE = 'Inactive';
    public const STATUS_SUSPENDED = 'Suspended';
    public const STATUS_CLOSED = 'Closed';

    /*
    |--------------------------------------------------------------------------
    | Priority Constants
    |--------------------------------------------------------------------------
    */

    public const PRIORITY_LOW = 'Low';
    public const PRIORITY_MEDIUM = 'Medium';
    public const PRIORITY_HIGH = 'High';
    public const PRIORITY_CRITICAL = 'Critical';

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function contacts()
    {
        return $this->hasMany(ClientContact::class);
    }

    public function addresses()
    {
        return $this->hasMany(ClientAddress::class);
    }

    public function services()
    {
        return $this->hasMany(ClientService::class);
    }

    public function documents()
    {
        return $this->hasMany(ClientDocument::class);
    }

    public function notes()
    {
        return $this->hasMany(ClientNote::class);
    }

    public function remarks()
    {
        return $this->hasMany(ClientRemark::class);
    }

    public function timelines()
    {
        return $this->hasMany(ClientTimeline::class);
    }

    public function credentials()
    {
        return $this->hasMany(ClientCredential::class);
    }

    public function communications()
    {
        return $this->hasMany(ClientCommunication::class);
    }

    public function statusHistory()
    {
        return $this->hasMany(ClientStatusHistory::class);
    }

    public function customFields()
    {
        return $this->hasMany(ClientCustomField::class);
    }

    public function tags()
    {
        return $this->belongsToMany(
            ClientTag::class,
            'client_tag',
            'client_id',
            'client_tag_id'
        )->withTimestamps();
    }

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
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

    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getDisplayNameAttribute(): string
    {
        return "{$this->client_code} - {$this->company_name}";
    }
    
    public function timeline()
{
    return $this->hasMany(ClientTimeline::class);
}
}