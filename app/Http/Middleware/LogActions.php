<?php

namespace App\Http\Middleware;

use App\Models\ActionLog;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Notifications\Action;
use Symfony\Component\HttpFoundation\Response;

class LogActions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
            ActionLog::create([
                'user_id' => auth()->id(),
                'action' => $request->method(),
                'endpoint' => $request->path(),
                'request_data' => $request->all(),
                'response_data' => json_encode(['status' => 'success']),
                'ip_address' => $request->ip(),
            ]);
            return $response;

    }
}
