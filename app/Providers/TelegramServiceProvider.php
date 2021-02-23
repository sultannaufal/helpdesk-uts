<?php

namespace App\Providers;

use App\Services\TelegramService;
use Illuminate\Support\ServiceProvider;

class TelegramServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton(TelegramService::class, function ($app) {
            return new TelegramService(config('telegram'));
        });
    }
}
