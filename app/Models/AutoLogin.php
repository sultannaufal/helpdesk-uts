<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use URL;

/**
 * Class AutoLoginLink
 *
 * @property int $id
 * @property User $user
 * @property string $token
 * @property Carbon $expires_at
 *
 * @mixin \Eloquent
 * @package App\Models
 */
class AutoLogin extends Model
{
    protected $table = 'auto_login';

    public $timestamps = false;

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public const ROUTE_NAME = 'autologin';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function isExpired(): bool
    {
        return $this->expires_at->lessThan(now());
    }

    public function getRoute(): string
    {
        return URL::signedRoute('autologin', [
            'token' => $this->token,
        ]);
    }

    public function getRouteForTicket(Ticket $ticket): string
    {
        return URL::signedRoute(self::ROUTE_NAME, [
            'token' => $this->token,
            'ticket' => $ticket->id,
        ]);
    }

    public static function createFor(User $user, Carbon $expires_at = null): AutoLogin
    {
        $autoLogin = self::make();
        $autoLogin->user()->associate($user);
        $autoLogin->expires_at = $expires_at ?? Carbon::now()->addDay();
        $autoLogin->token = uniqid();
        $autoLogin->saveOrFail();

        return $autoLogin;
    }
}
