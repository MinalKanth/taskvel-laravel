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

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    

public function approver()
{
    return $this->belongsTo(User::class, 'approved_by');
}

    

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeVerified($query)
    {
        return $query->where('verification_status', 'Verified');
    }

    public function scopePending($query)
    {
        return $query->where('verification_status', 'Pending');
    }

    public function getFileUrlAttribute(): ?string
    {
        return $this->file_path
            ? asset('storage/' . $this->file_path)
            : null;
    }
}