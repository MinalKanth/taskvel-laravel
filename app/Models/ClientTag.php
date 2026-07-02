<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientTag extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [

        'name',

        'slug',

        'color',

        'icon',

        'description',

        'sort_order',

        'is_active'
    ];

    protected $casts = [

        'is_active'=>'boolean'
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function clients()
    {
        return $this->belongsToMany(
            Client::class,
            'client_tag',
            'client_tag_id',
            'client_id'
        )->withTimestamps();
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeActive($query)
    {
        return $query->where('is_active',true);
    }
}