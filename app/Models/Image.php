<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = ['ticket_id','before', 'after'];
    public $timestamps = false;

    public static function boot()
    {
        parent::boot();

        self::deleted(function (Image $image) {
                \Storage::disk('public')->delete($image->before);
                \Storage::disk('public')->delete($image->after);
            }
        );
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id', 'id');
    }
}
