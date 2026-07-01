<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FocusSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'task_id',
        'session_type',
        'planned_minutes',
        'actual_minutes',
        'started_at',
        'ended_at',
        'completed',
        'interrupted',
        'interruptions',
        'notes',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
        'completed' => 'boolean',
        'interrupted' => 'boolean',
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

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeCompleted($query)
    {
        return $query->where('completed', true);
    }

    public function scopeToday($query)
    {
        return $query->whereDate('started_at', today());
    }

    public function scopeFocus($query)
    {
        return $query->where('session_type', 'focus');
    }

    /*
    |--------------------------------------------------------------------------
    | Helper Methods
    |--------------------------------------------------------------------------
    */

    public function markCompleted()
    {
        $this->update([
            'completed' => true,
            'ended_at' => now(),
        ]);
    }

    public function addInterruption()
    {
        $this->increment('interruptions');

        $this->update([
            'interrupted' => true,
        ]);
    }
}