<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientRemark extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [

    'client_id',

    'parent_id',

    'user_id',

    'remark',

    'type',

    'is_private',

    'is_pinned',

    'status',

    'attachment',

    'mentioned_user_id',

    'read_at',

    'created_by',

    'updated_by',

];

    protected $casts = [

        'is_private'=>'boolean',

        'is_pinned'=>'boolean',

        'read_at'=>'datetime',
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parent()
    {
        return $this->belongsTo(ClientRemark::class,'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(ClientRemark::class,'parent_id');
    }

    public function mentionedUser()
    {
        return $this->belongsTo(User::class,'mentioned_user_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeOpen($query)
    {
        return $query->where('status','Open');
    }

    public function scopePinned($query)
    {
        return $query->where('is_pinned',true);
    }
    
    public function creator()
{
    return $this->belongsTo(
        User::class,
        'created_by'
    );
}

public function updater()
{
    return $this->belongsTo(
        User::class,
        'updated_by'
    );
}
}