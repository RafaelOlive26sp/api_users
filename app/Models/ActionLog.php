<?php

namespace App\Models;

use GuzzleHttp\Psr7\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class ActionLog extends Model
{

    use HasFactory;

    protected $fillable = [
        'user_id',
        'action',
        'endpoint',
        'request_data',
        'response_data',
        'ip_address',
        'created_at',
    ];





}
