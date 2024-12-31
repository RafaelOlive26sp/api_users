<?php

namespace App\Http\Resources;

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

                ];
            }) ,
            'newsLogs' => $this['newsLogs']? [
                'id' => $this['newsLogs']->id,
                'user_id' => $this['newsLogs']->user_id,
                'action' => $this['newsLogs']->action,
                'endpoint' => $this['newsLogs']->endpoint,
                'ip_address' => $this['newsLogs']->ip_address,
                'request_data' => json_decode($this->resource['newsLogs']->request_data, true),
                'response_data' => json_decode($this->resource['newsLogs']->response_data, true),
            ]: null,
            'oldLogs' => $this['oldLogs']? [
                'id' => $this['oldLogs']->id,
                'user_id' => $this['oldLogs']->user_id,
                'action' => $this['oldLogs']->action,
                'endpoint' => $this['oldLogs']->endpoint,
                'ip_address' => $this['oldLogs']->ip_address,
                'request_data' => json_decode($this->resource['oldLogs']->request_data, true),
                'response_data' => json_decode($this->resource['oldLogs']->response_data, true),
            ]: null,
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
