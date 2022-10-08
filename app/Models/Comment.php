<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Comment
 *
 * @property string $theme
 * @property string $content
 * @property string $attachment
 * @property boolean $is_root
 * @property $user
 * @property $user_id
 *
 * @mixin \Eloquent
 * @package App\Models
 */
class Comment extends Model
{
    protected $fillable = ['theme', 'content'];

    protected $casts = [
        'is_root' => 'boolean',
    ];

    public static function boot()
    {
        parent::boot();

        self::deleted(function (Comment $comment) {
            if ($comment->attachment) {
                \Storage::disk('public')->delete($comment->attachment);
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id', 'id');
    }
}
