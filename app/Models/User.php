<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

#[Fillable([
    'name',
    'email',
    'password',
    'phone',
    'user_type',
    'client_id',
    'avatar',
    'designation',
    'department',
    'status',
    'timezone',
    'language',
])]

#[Hidden([
    'password',
    'remember_token',
])]

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * Attribute casting.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function remarks()
    {
        return $this->hasMany(Remark::class);
    }

    public function tags()
    {
        return $this->hasMany(Tag::class);
    }

    public function focusSessions()
    {
        return $this->hasMany(FocusSession::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}