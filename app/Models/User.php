<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Comment;

/**
 * Class User
 *
 * @property $id
 * @property string $email
 * @property $role
 * @property $tickets
 *
 * @method static Builder managers()
 *
 * @mixin \Eloquent
 * @package App\Models
 */
class User extends Authenticatable
{
    use Notifiable;

    protected static function booted()
    {
        static::deleted(function ($user) {
            $user->tickets()->delete();
            $user->comments()->delete();
        });
    }

    public const ROLE_CLIENT = 'client';
    public const ROLE_MANAGER = 'manager';

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'client_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function isClient(): bool
    {
        return $this->role === self::ROLE_CLIENT;
    }

    public function isManager(): bool
    {
        return $this->role === self::ROLE_MANAGER;
    }

    public function getLastTicket()
    {
        return self::tickets()
            ->orderBy('created_at', 'DESC')
            ->limit(1)
            ->first();
    }

    public static function scopeManagers(): Builder
    {
        return self::where('role', '=', User::ROLE_MANAGER);
    }
}
