<?php

namespace App\Providers;

use App\Listeners\LogAuthenticationActions;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {


        Event::listen(Login::class, LogAuthenticationActions::class);
        Event::listen(Logout::class, LogAuthenticationActions::class);
    }

    // protected $listen = [
    //     Login::class => [
    //         LogAuthenticationActions::class,
    //     ],
    //     Logout::class => [
    //         LogAuthenticationActions::class,
    //     ],
    // ];
}
