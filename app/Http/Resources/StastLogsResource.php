<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StastLogsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return[
            'totalLogs' => $this->resource['totalLogs'],
            'logs' => $this['logs']->map(function ($log){
                return [
                    'id' => $log->id,
                    'user_id' => $log->user_id,
                    'action' => $log->action,
                    'endpoint' => $log->endpoint,
                    'ip_address' => $log->ip_address,
                    'request_data' => json_decode($log->request_data, true) ,
                    'response_data' => json_decode($log->response_data,true),
                    'created_at' => Carbon::parse($log->created_at)->format('d/m/Y H:i:s'),
                ];
            }) ,
            'pagination' =>[
                'current_page'=> $this->resource['logs']->currentPage(),
                'last_page'=> $this->resource['logs']->lastPage(),
                'per_page'=> $this->resource['logs']->perPage(),
                'total'=> $this->resource['logs']->total(),
                'next_page_url'=> $this->resource['logs']->nextPageUrl(),
                'prev_page_url'=> $this->resource['logs']->previousPageUrl(),
            ],
            'newsLogs' => $this->formatLog($this['newsLogs']),
            'oldLogs' => $this->formatLog($this['oldLogs']),

        ];
    }
    private function formatLog($log)
    {
        if (!$log)
        {
            return null;
        }

        return [
            'id' => $log->id,
            'user_id' => $log->user_id,
            'action' => $log->action,
            'endpoint' => $log->endpoint,
            'ip_address' => $log->ip_address,
            'request_data' => json_decode($log->request_data, true),
            'response_data' => json_decode($log->response_data, true),
            'created_at' => Carbon::parse($log->created_at)->format('d/m/Y H:i:s'),
        ];
    }

}



// Object { id: 1, user_id: 12, action: "Login", … }
// ​​​
// action: "Login"
// ​​​
// endpoint: "api/v1/login"
// ​​​
// id: 1
// ​​​
// ip_address: "127.0.0.1"
// ​​​
// request_data: '{"email": "rafael@admin.com"}'
// ​​​
// response_data: '{"status": "success"}'
// ​​​
// user_id: 12



// 'totalAccounts' => $this->resource['totalAccounts'],
// 'verifiedAccounts' => $this->resource['verifiedAccounts'],
// 'unverifiedAccounts' => $this->resource['unverifiedAccounts'],
// 'newstUser' => $this['newestUser'] ? [
//     'id' => $this['newestUser']->id,
//     'name' => $this['newestUser']->name,
//     'email' => $this['newestUser']->email,
//     'created_at' => $this['newestUser']->created_at,

// ] : null,
