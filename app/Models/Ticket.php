<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Ticket
 *
 * @property int $id
 * @property string $theme
 * @property string $content
 * @property string $attachment
 * @property string $location
 * @property string $status
 * @property $client
 * @property $client_id
 * @property $manager
 *
 * @mixin \Eloquent
 * @package App\Models
 */
class Ticket extends Model
{
    public const STATUS_NEW = 'new';
    public const STATUS_IN_PROGRESS = 'in-progress';
    public const STATUS_CLOSED = 'closed';

    protected $fillable = ['theme', 'content', 'location_id'];

    public static function boot()
    {
        parent::boot();

        self::deleted(function (Ticket $ticket) {
            if ($ticket->attachment) {
                \Storage::disk('public')->delete($ticket->attachment);
            }
            if ($ticket->image->before && $ticket->image->after){
                \Storage::disk('public')->delete($ticket->image->before);
                \Storage::disk('public')->delete($ticket->image->after);
            }
        });
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id', 'id');
    }

    public function image()
    {
        return $this->hasOne(Image::class, 'ticket_id', 'id');
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id', 'id');
    }

    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'ticket_id', 'id');
    }

    public function setStatusAttribute(string $status): void
    {
        if (! in_array($status, array_keys(self::getStatuses()))) {
            throw new \DomainException('Wrong status');
        }

        $this->attributes['status'] = $status;
    }

    public function getStatusLabel(): string
    {
        return self::getStatuses()[$this->status];
    }

    public function isInProgress(): bool
    {
        return $this->status === self::STATUS_IN_PROGRESS;
    }

    public function isClosed(): bool
    {
        return $this->status === self::STATUS_CLOSED;
    }

    public function isNew(): bool
    {
        return $this->status === self::STATUS_NEW;
    }

    public function close()
    {
        $this->status = Ticket::STATUS_CLOSED;
        $this->saveOrFail();
    }

    public function assignManager(User $manager)
    {
        if ($this->hasManager()) {
            throw new \DomainException('Pengaduan sudah memiliki pengurus');
        }

        if (! $manager->isManager()) {
            throw new \DomainException('Harus jadi pengurus');
        }

        if ($this->isClosed()) {
            throw new \DomainException('Pengaduan telah ditutup');
        }

        $this->manager()->associate($manager);
        $this->status = self::STATUS_IN_PROGRESS;
        $this->update();
    }

    public function hasManager(): bool
    {
        return $this->manager()->exists();
    }

    public function hasImage(): bool
    {
        return $this->image()->exists();
    }

    public function markAsViewedBy(User $user)
    {
        DB::table('users_tickets_view')
            ->insert([
                'ticket_id' => $this->id,
                'user_id' => $user->id,
            ]);
    }

    public function isViewedBy(User $user)
    {
        return DB::table('users_tickets_view')
            ->where([
                'ticket_id' => $this->id,
                'user_id' => $user->id,
            ])
            ->exists();
    }

    public static function getStatuses(): array
    {
        return [
            self::STATUS_NEW => 'Baru',
            self::STATUS_IN_PROGRESS => 'Diproses',
            self::STATUS_CLOSED => 'Selesai',
        ];
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', '<>', Ticket::STATUS_CLOSED);
    }

    public function scopeClosed(Builder $query): Builder
    {
        return $query->where('status', '=', Ticket::STATUS_CLOSED);
    }

    public function scopeAnswered(Builder $query): Builder
    {
        return $query->whereHas('comments', function ($query) {
            return $query->whereHas('user', function($query) {
                return $query->where('role', '=', User::ROLE_MANAGER);
            });
        });
    }

    public function scopeNotAnswered(Builder $query): Builder
    {
        return $query->whereHas('comments', function ($query) {
            return $query->whereHas('user', function ($query) {
                return $query->where('role', '<>', User::ROLE_MANAGER);
            });
        })
            ->orWhereDoesntHave('comments');
    }

    public function scopeViewedBy(Builder $query, User $user): Builder
    {
        $viewedTicketsIds = DB::table('users_tickets_view')
            ->select('ticket_id')
            ->where('user_id', '=', $user->id)
            ->pluck('ticket_id');

        return $query->whereIn('id', $viewedTicketsIds);
    }

    public function scopeNotViewedBy(Builder $query, User $user): Builder
    {
        $viewedTicketsIds = DB::table('users_tickets_view')
            ->select('ticket_id')
            ->where('user_id', '=', $user->id)
            ->pluck('ticket_id');

        return $query->whereNotIn('id', $viewedTicketsIds);
    }

    public function scopeToday($builder)
    {
        return $builder->where('created_at', '>', today());
    }
}
