<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'notes',
        'priority',
        'status',
        'progress',
        'category',
        'color',
        'due_date',
        'reminder_at',
        'recurrence',
        'completed_at',
        'estimated_minutes',
        'actual_minutes',
        'urgency',
        'impact',
        'is_favorite',
        'is_archived',
        'is_pinned',
        'sort_order',
    ];

    protected $casts = [
        'due_date'     => 'datetime',
        'reminder_at'  => 'datetime',
        'completed_at' => 'datetime',
        'is_favorite'  => 'boolean',
        'is_archived'  => 'boolean',
        'is_pinned'    => 'boolean',
        'progress'     => 'integer',
        'urgency'      => 'integer',
        'impact'       => 'integer',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function steps()
    {
        return $this->hasMany(Step::class)->orderBy('sort_order');
    }

    public function remarks()
    {
        return $this->hasMany(Remark::class)->latest();
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function focusSessions()
    {
        return $this->hasMany(FocusSession::class)->latest();
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', 'pending');
    }

    public function scopeInProgress(Builder $query): Builder
    {
        return $query->where('status', 'in_progress');
    }

    public function scopeCompleted(Builder $query): Builder
    {
        return $query->where('status', 'completed');
    }

    public function scopeFavorite(Builder $query): Builder
    {
        return $query->where('is_favorite', true);
    }

    public function scopePinned(Builder $query): Builder
    {
        return $query->where('is_pinned', true);
    }

    public function scopeArchived(Builder $query): Builder
    {
        return $query->where('is_archived', true);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_archived', false);
    }

    public function scopeOverdue(Builder $query): Builder
    {
        return $query->whereNotNull('due_date')
                     ->where('due_date', '<', now())
                     ->where('status', '!=', 'completed');
    }

    public function scopeDueToday(Builder $query): Builder
    {
        return $query->whereDate('due_date', today())
                     ->where('status', '!=', 'completed');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getIsOverdueAttribute(): bool
    {
        return $this->due_date
            && $this->due_date->isPast()
            && $this->status !== 'completed';
    }

    public function getIsDueTodayAttribute(): bool
    {
        return $this->due_date && $this->due_date->isToday();
    }

    public function getPriorityScoreAttribute(): int
    {
        return ($this->urgency ?? 1) * ($this->impact ?? 1);
    }

    public function getEfficiencyAttribute(): ?int
    {
        if (!$this->estimated_minutes || !$this->actual_minutes) {
            return null;
        }
        return (int) round(($this->estimated_minutes / $this->actual_minutes) * 100);
    }
}