<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ImageRequest;
use App\Models\Ticket;
use App\Models\Image;
use Gate;

class ImageController extends Controller
{
    public function store(ImageRequest $request, Ticket $ticket)
    {
        Gate::authorize('manage');
        if ($request->hasFile('before') && $request->hasFile('after')) {
        $image = new Image();
        $image->ticket()->associate($ticket);
        $image->before = \Storage::disk('public')
            ->putFile('attachments', $request->file('before'));
        $image->after = \Storage::disk('public')
            ->putFile('attachments', $request->file('after'));

        $image->save();
        }
        return redirect()
            ->route('tickets.show', $ticket)
            ->with('toast_success', 'Gambar telah ditambah');
    }

    public function add(Ticket $ticket)
    {
        Gate::authorize('manage');
        return view('tickets.add-image', compact('ticket'));
    }

    public function destroy(Ticket $ticket, Image $image)
    {
        Gate::authorize('manage');
        $image->delete();
        return redirect()
            ->route('tickets.show', $ticket)
            ->with('toast_success', 'Gambar telah dihapus');
    }
}
