<?php

namespace App\Http\Controllers;

use App\Models\AutoLogin;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AutoLoginController extends Controller
{
    public function autologin(Request $request, string $token)
    {
        if (! $request->hasValidSignature()) {
            abort(401);
        }

        $validated = $request->validate([
            'ticket' => 'integer|exists:tickets,id',
        ]);

        if (\Auth::guest()) {

            $autoLoginLink = AutoLogin::where('token', '=', $token)->firstOrFail();

            if ($autoLoginLink->isExpired()) {
                abort(401);
            }

            \Auth::login($autoLoginLink->user);
        }

        if ($request->has('ticket')) {
            $ticket = Ticket::findOrFail($validated['ticket']);
            return redirect()->route('tickets.show', $ticket);
        }

        return redirect()->route('home');
    }
}
