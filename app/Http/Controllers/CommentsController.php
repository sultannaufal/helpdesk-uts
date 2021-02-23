<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Mail\TicketCommented;
use App\Models\AutoLogin;
use App\Models\Comment;
use App\Models\Ticket;
use App\Services\AttachmentService;
use Auth;
use Gate;
use Illuminate\Http\Request;
use Mail;

class CommentsController extends Controller
{
    private $attachmentService;

    public function __construct(AttachmentService $attachmentService)
    {
        $this->attachmentService = $attachmentService;
    }

    public function create(Ticket $ticket)
    {
        Gate::authorize('create-comment', $ticket);
        return view('comments.create', compact('ticket'));
    }

    public function store(CommentRequest $request, Ticket $ticket)
    {
        $comment = Comment::make($request->only(['theme', 'content']));
        $comment->user()->associate(Auth::user());
        $comment->ticket()->associate($ticket);

        $comment->attachment = $this->attachmentService->store($request);

        $comment->save();

        if (Auth::user()->isManager()) {
            Mail::to($ticket->client)->send(new TicketCommented($comment));
        }

        if (Auth::user()->isClient() && $ticket->manager()->exists()) {
            $autoLogin = AutoLogin::createFor(Auth::user());
            Mail::to($ticket->manager)->send(new TicketCommented($comment, $autoLogin));
        }

        return redirect()
            ->route('tickets.show', $ticket)
            ->with('toast_success', 'Berhasil menambah komentar');
    }

    public function edit(Ticket $ticket, Comment $comment)
    {
        Gate::authorize('edit-comment', [$ticket, $comment]);
        return view('comments.edit', compact('ticket', 'comment'));
    }

    public function update(CommentRequest $request, Ticket $ticket, Comment $comment)
    {
        Gate::authorize('edit-comment', [$ticket, $comment]);

        $comment->update($request->only(['theme', 'content']));

        $comment->attachment = $this->attachmentService->update($request, $comment->attachment);
        $comment->save();

        return redirect()
            ->route('tickets.show', $ticket)
            ->with('toast_success', 'Komentar berhasil diedit');
    }

    public function destroy(Ticket $ticket, Comment $comment)
    {
        Gate::authorize('edit-comment', [$ticket, $comment]);
        $comment->delete();
        return redirect()->route('tickets.show', $ticket);
    }
}
