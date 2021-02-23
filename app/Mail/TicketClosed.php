<?php

namespace App\Mail;

use App\Models\AutoLogin;
use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TicketClosed extends Mailable
{
    use Queueable, SerializesModels;

    public $ticket;
    public $ticketRoute;

    /**
     * Create a new message instance.
     *
     * @param Ticket $ticket
     * @param AutoLogin|null $autoLogin
     */
    public function __construct(Ticket $ticket, AutoLogin $autoLogin = null)
    {
        $this->ticket = $ticket;

        $this->ticketRoute = is_null($autoLogin)
            ? route('tickets.show', $ticket)
            : $autoLogin->getRouteForTicket($ticket);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.tickets.closed');
    }
}
