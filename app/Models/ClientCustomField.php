<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientCustomField extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [

        'client_id',

        'field_name',

        'field_key',

        'field_type',

        'field_value',

        'is_required',

        'is_visible',

        'is_searchable',

        'sort_order',

        'remarks',
    ];

    protected $casts = [

        'is_required'=>'boolean',

        'is_visible'=>'boolean',

        'is_searchable'=>'boolean',
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
    | Scope
    |--------------------------------------------------------------------------
    */

    public function scopeVisible($query)
    {
        return $query->where('is_visible',true);
    }
}