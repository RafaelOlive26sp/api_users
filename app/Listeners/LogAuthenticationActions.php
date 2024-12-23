<?php

namespace App\Listeners;

use App\Models\ActionLog;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;


class LogAuthenticationActions
{



    /**
     * Handle the event.
     */
    public function handle($event)
    {
        // Determina a ação (login ou logout)
        $action = $event instanceof Login ? 'Login' : 'Logout';

        $requestData = $event instanceof Login ? request()->only(['email']) : [];

        // Registra o log de login/logout

        ActionLog::create([
            'user_id' => $event->user->id,
            'action' => $action,
            'endpoint' => request()->path(), // Endpoint atual
            'request_data' => json_encode($requestData),
            'response_data' => json_encode(['status' => 'success']),
            'ip_address' => request()->ip(),
        ]);
    }
}
