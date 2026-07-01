<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Remark extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id',
        'user_id',
        'remark',
        'tone',        // ← new: emoji tone tag e.g. "✅ Progress"
        'is_pinned',
    ];

    protected $casts = [
        'is_pinned' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopePinned($query)
    {
        return $query->where('is_pinned', true);
    }

    public function scopeLatestFirst($query)
    {
        return $query->latest();
    }

    public function scopeForUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeSearch($query, string $term)
    {
        return $query->where('remark', 'like', '%' . $term . '%');
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    public function pin(): void
    {
        $this->update(['is_pinned' => true]);
    }

    public function unpin(): void
    {
        $this->update(['is_pinned' => false]);
    }

    public function togglePin(): void
    {
        $this->update(['is_pinned' => !$this->is_pinned]);
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    /** Word count of the remark body. */
    public function getWordCountAttribute(): int
    {
        return $this->remark ? str_word_count($this->remark) : 0;
    }

    /** Whether the remark was edited after creation. */
    public function getWasEditedAttribute(): bool
    {
        return $this->updated_at && $this->updated_at->ne($this->created_at);
    }
}