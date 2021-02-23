<?php

namespace App\Providers;

use App\Models\Comment;
use App\Models\Ticket;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('manage', function (User $user) {
            return $user->isManager();
        });

        Gate::define('create-ticket', function (User $user) {
            if ($user->isManager()) {
                return true;
            }

            if ($user->tickets()->today()->count() <= 4) {
                return true;
            }

            return $user->getLastTicket()
                ->created_at
                ->lessThan(Carbon::now()->subDay());
        });

        Gate::define('edit-ticket', function (User $user, Ticket $ticket) {
            return $user->isManager()
                || $ticket->client_id === $user->id;
        });

        Gate::define('create-comment', function (User $user, Ticket $ticket) {
            return ! $ticket->isClosed();
        });

        Gate::define('edit-comment', function (User $user, Ticket $ticket, Comment $comment) {
            return $user->isManager()
                || ($comment->user_id === $user->id && ! $ticket->isClosed());
        });

        Gate::define('ticket-print', function (User $user) {
            return $user->isManager();
        });
    }
}
