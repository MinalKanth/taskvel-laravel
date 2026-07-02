<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

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

        'is_active',

    ];

    protected $casts = [

        'sort_order' => 'integer',

        'is_active' => 'boolean',

    ];

    /*
    |--------------------------------------------------------------------------
    | Boot
    |--------------------------------------------------------------------------
    */

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($tag) {

            if (empty($tag->slug)) {
                $tag->slug = Str::slug($tag->name);
            }

        });

        static::updating(function ($tag) {

            if (empty($tag->slug)) {
                $tag->slug = Str::slug($tag->name);
            }

        });
    }

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
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getDisplayNameAttribute(): string
    {
        return $this->name;
    }
}