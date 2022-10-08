<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TicketRequest;
use App\Mail\TicketClosed;
use App\Mail\TicketCreated;
use App\Models\AutoLogin;
use App\Models\Location;
use App\Models\Ticket;
use App\Models\User;
use App\Services\AttachmentService;
use App\Services\TelegramService;
use Auth;
use Gate;
use Mail;

class TicketController extends Controller
{
    private $attachmentService;

    public function __construct(AttachmentService $attachmentService)
    {
        $this->attachmentService = $attachmentService;
    }

    public function index(Request $request)
    {
        $tickets = null;
        $new = Ticket::where('status', 'new');
        $progress = Ticket::where('status', 'in-progress');
        $closed = Ticket::where('status', 'closed');

        if (Auth::user()->isClient()) {
            $tickets = Auth::user()
                ->tickets()
                ->orderBy('created_at', 'DESC')
                ->paginate(10);
        }

        if (Auth::user()->isManager()) {
            $query = Ticket::orderBy('created_at', 'DESC');

            if ($request->has('view')) {
                if ($request['view'] === 'yes') {
                    $query->viewedBy(Auth::user());
                }

                if ($request['view'] === 'no') {
                    $query->notViewedBy(Auth::user());
                }
            }

            if ($request->has('status')) {
                if ($request['status'] === 'active') {
                    $query->active();
                }

                if ($request['status'] === 'closed') {
                    $query->closed();
                }
            }

            if ($request->has('answer')) {
                if ($request['answer'] === 'yes') {
                    $query->answered();
                }

                if ($request['answer'] === 'no') {
                    $query->notAnswered();
                }
            }

            $tickets = $query->paginate(10);
        }
        return view('tickets.index', compact('tickets', 'new', 'progress', 'closed'));
    }

    public function create()
    {
        Gate::authorize('create-ticket');
        $location = Location::all();
        return view('tickets.create')->with('locations', $location);
    }

    public function store(TicketRequest $request)
    {
        Gate::authorize('create-ticket');
        $ticket = Ticket::make($request->only(['theme', 'content', 'location_id']));
        $ticket->client()->associate(Auth::user());

        $ticket->attachment = $this->attachmentService->store($request);

        $ticket->save();
        User::managers()->get()->each(function (User $manager) use ($ticket) {
            $autoLogin = AutoLogin::createFor($manager);
            Mail::to($manager)->send(new TicketCreated($ticket, $autoLogin));
        });

        app(TelegramService::class)->sendMessage(
            'Pengaduan baru telah dibuat: ' . $ticket->theme . PHP_EOL
            . 'Pergi ke aplikasi: ' . route('tickets.show', $ticket)
        );

        return redirect()
            ->route('tickets.show', $ticket)
            ->with('toast_success', 'Pengaduan telah dibuat');
    }

    public function show(Ticket $ticket)
    {
        Gate::authorize('edit-ticket', $ticket);

        if (Auth::user()->isManager() && !$ticket->isViewedBy(Auth::user())) {
            $ticket->markAsViewedBy(Auth::user());
        }
        $image = $ticket->image;
        $comments = $ticket->comments()->with('user')->paginate(5);
        return view('tickets.show', compact('ticket', 'comments', 'image'));
    }

    public function edit(Ticket $ticket)
    {
        Gate::authorize('edit-ticket', $ticket);
        $locations = Location::all();
        $locs = Ticket::join('locations', 'locations.id', '=', 'tickets.location_id')->first();
        return view('tickets.edit', compact('ticket', 'locations'))->with('locs', $locs);
    }

    public function update(TicketRequest $request, Ticket $ticket)
    {
        Gate::authorize('edit-ticket', $ticket);

        $ticket->update($request->only(['theme', 'content', 'location_id']));

        $ticket->attachment = $this->attachmentService->update($request, $ticket->attachment);
        $ticket->save();

        return redirect()
            ->route('tickets.show', $ticket)
            ->with('toast_success', 'Pengaduan telah diupdate');
    }

    public function destroy(Ticket $ticket)
    {
        Gate::authorize('edit-ticket', $ticket);
        $ticket->delete();
        return redirect()->route('tickets.index');
    }

    public function close(Ticket $ticket)
    {
        Gate::authorize('edit-ticket', $ticket);
        $ticket->close();

        if (Auth::user()->isClient() && $ticket->hasManager()) {
            $autoLogin = AutoLogin::createFor($ticket->manager);
            Mail::to($ticket->manager)->send(new TicketClosed($ticket, $autoLogin));
        }

        return redirect()->route('tickets.show', $ticket)
            ->with('toast_success', 'Pengaduan telah ditutup');
    }

    public function assignManager(Ticket $ticket)
    {
        Gate::authorize('manage');
        $ticket->assignManager(Auth::user());
        return redirect()->route('tickets.show', $ticket)
            ->with('toast_success', 'Anda telah ditunjuk sebagai pengurus pengaduan ini');
    }

    public function printOption()
    {
        Gate::authorize('manage');
        return view('tickets.option');
    }

    public function reportDate($date1, $date2)
    {
        Gate::authorize('manage');
        $reportDate = Ticket::whereBetween('created_at', [$date1, $date2])->get();
        return view('tickets.print', compact('reportDate'));
    }
}
