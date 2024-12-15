<?php

namespace App\Providers;


use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->ensureDirectoryExists(storage_path('logs'));
        $this->ensureDirectoryExists(storage_path('framework/cache'));
        $this->ensureDirectoryExists(storage_path('framework/session'));
        $this->ensureDirectoryExists(storage_path('framework/views'));
        $this->ensureDirectoryExists(base_path('bootstrap/cache'));

        if (env('APP_ENV') === 'production') {
            URL::forceScheme('https');
        }

    }

    /**
     *@param
     * @return
     */
    protected function ensureDirectoryExists(string $directory): void
    {
        if (! is_dir($directory)) {
            if (!mkdir($directory, 0755, true) && !is_dir($directory)) {
                throw new \RuntimeException(sprintf('Directory "%s" was not created', $directory));
            }
        }
    }
}
