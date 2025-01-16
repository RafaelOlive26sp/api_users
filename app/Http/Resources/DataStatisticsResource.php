<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DataStatisticsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'totalAccounts' => $this->resource['totalAccounts'],
            'verifiedAccounts' => $this->resource['verifiedAccounts'],
            'unverifiedAccounts' => $this->resource['unverifiedAccounts'],
            'newstUser' => $this['newestUser'] ? [
                'id' => $this['newestUser']->id,
                'name' => $this['newestUser']->name,
                'email' => $this['newestUser']->email,
                'created_at' => $this['newestUser']->created_at,
                'updated_at' => $this['newestUser']->updated_at,
                'privilege_id' => $this['newestUser']->privilege_id,

            ] : null,
            'oldestUser' => $this['oldestUser'] ? [
                'id' =>$this['oldestUser']->id,
                'name' =>$this['oldestUser']->name,
                'email' =>$this['oldestUser']->email,
                'created_at' =>$this['oldestUser']->created_at,
                'updated_at' =>$this['oldestUser']->updated_at,
                'privilege_id' =>$this['oldestUser']->privilege_id,
            ]: null,
            'verifiedUsers' => $this['verifiedUsers']->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'created_at' => $user->created_at,
                    'updated_at' => $user->updated_at,
                    'privilege_id' => $user->privilege_id,
                ];
            }),
            'unverifiedUsers' => $this['unverifiedUsers']->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'created_at' => $user->created_at,
                    'updated_at' => $user->updated_at,
                    'privilege_id' => $user->privilege_id,
                ];
            }),
        ];
    }
}
