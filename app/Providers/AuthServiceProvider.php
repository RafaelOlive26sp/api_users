<?php

namespace App\Providers;

use App\Models\ActionLog;
use App\Models\User;
use App\Policies\UserPolicy;
use App\Policies\ActionLogPolicy;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    protected $policies = [
        User::class => UserPolicy::class,
        ActionLog::class => ActionLogPolicy::class
    ];

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {

    }
}
