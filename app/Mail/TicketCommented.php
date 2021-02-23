<?php

namespace App\Mail;

use App\Models\AutoLogin;
use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TicketCommented extends Mailable
{
    use Queueable, SerializesModels;

    public $comment;
    public $ticketRoute;

    /**
     * Create a new message instance.
     *
     * @param Comment $comment
     * @param AutoLogin|null $autoLogin
     */
    public function __construct(Comment $comment, AutoLogin $autoLogin = null)
    {
        $this->comment = $comment;

        $this->ticketRoute = is_null($autoLogin)
            ? route('tickets.show', $comment->ticket)
            : $autoLogin->getRouteForTicket($comment->ticket);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $mail = $this->markdown('emails.tickets.commented');

        if ($this->comment->attachment) {
            $mail->attachFromStorageDisk('public', $this->comment->attachment);
        }

        return $mail;
    }
}
