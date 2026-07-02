<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientDocument extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [

        'client_id',

        'category',

        'title',
        'document_number',
        'description',

        'original_name',
        'file_name',
        'file_path',
        'disk',
        'extension',
        'mime_type',
        'file_size',

        'version',

        'issue_date',
        'expiry_date',

        'status',

        'is_confidential',
        'is_downloadable',

        'uploaded_by',
        'approved_by',
        'approved_at',

        'remarks',

        'is_active',
    ];

    protected $casts = [

        'issue_date' => 'date',

        'expiry_date' => 'date',

        'approved_at' => 'datetime',

        'is_confidential' => 'boolean',

        'is_downloadable' => 'boolean',

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

    public function uploader()
    {
        return $this->belongsTo(User::class,'uploaded_by');
    }

    public function approver()
    {
        return $this->belongsTo(User::class,'approved_by');
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeApproved($query)
    {
        return $query->where('status','Approved');
    }

    public function scopePending($query)
    {
        return $query->where('status','Pending');
    }

    public function scopeExpired($query)
    {
        return $query->whereDate('expiry_date','<',today());
    }

    /*
    |--------------------------------------------------------------------------
    | Accessor
    |--------------------------------------------------------------------------
    */

    public function getFileSizeInMbAttribute()
    {
        return round($this->file_size / 1024 / 1024,2);
    }
}