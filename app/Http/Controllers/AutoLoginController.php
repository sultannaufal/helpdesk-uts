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
        if (! $request->hasValidSignature()) { // Защита от подбора
            abort(401);
        }

        $validated = $request->validate([
            'ticket' => 'integer|exists:tickets,id',
        ]);

        // Пытаться логинить только если гость, к тому же авторизованный модератор не рад будет получить 410 ответ
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
