<?php

namespace App\Services;

use App\Models\ActionLog;

class LogService
{
    /**
     * Registra um log de ação no banco de dados.
     *
     * @param \App\Models\User $user
     * @param string $action
     * @param string $endpoint
     * @param array $requestData
     * @param array $responseData
     * @return void
     */
    public static function log($user, string $action, string $endpoint,array $requestData = [], array $responseData = [] )
    {
        ActionLog::create([
            'user_id' => $user->id,
            'action' => $action,
            'endpoint' => $endpoint,
            'request_data' => json_encode($requestData),
            'response_data' => json_encode($responseData),
            'ip_address' => request()?->ip() ?? 'unknown',
        ]);
    }
}
