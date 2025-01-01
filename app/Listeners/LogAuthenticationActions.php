<?php

namespace App\Listeners;

use App\Models\ActionLog;
use App\Services\LogService;
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
//        $action = $event instanceof Login ? 'Login' : 'Logout';
        $action = class_basename($event);

        $origin = request()->headers->get('origin') ?? 'unknown';
        $referer = request()->headers->get('referer') ?? 'unknown';
        $ip_address = request()->ip() ?? 'unknown';
        $endpoint = request()->path() ?? 'unknown';

        $requestData = $event instanceof Login ? request()->only(['email']) : [];

        LogService::log(
            $event->user,
            strtolower($action),
            $endpoint,
            array_merge($requestData,['origin' => $origin, 'referer' => $referer]),
            ['status' => 'success']
        );

        // Log adicional para debugging
        \Log::info("Log registrado com sucesso", [
            'user_id' => $event->user->id,
            'action' => $action,
            'origin' => $origin,
            'referer' => $referer,
            'ip_address' => $ip_address,
        ]);




        // Registra o log de login/logout
//        $requestData = $event instanceof Login
//            ? ['email' => substr(request('email'), 0, 3) . '***@' . explode('@', request('email'))[1]]
//            : [];

//        ActionLog::create([
//            'user_id' => $event->user->id,
//            'action' => strtolower($action),
//            'endpoint' => request()->path() ?? 'system', // Endpoint atual
//            'request_data' => json_encode(array_merge(
//                $requestData,
//                ['origin' => $origin, 'referer' => $referer]
//            )),
//            'response_data' => json_encode(['status' => 'success']),
//            'ip_address' => request()->ip() ?? 'unknown',
//        ]);





    }
}
