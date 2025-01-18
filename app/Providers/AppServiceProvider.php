<?php

namespace App\Providers;


use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
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

        VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
           return (new MailMessage)
           ->subject('Confirmação de E-mail')
           ->greeting('Olá!')
           ->line('Clique no botão abaixo para verificar seu endereço de e-mail.')
           ->action('Verificar E-mail', $url)
           ->line('Se você não criou esta conta, ignore este e-mail.')
           ->salutation('Att, Equipe Minha Aplicação');
        });



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
