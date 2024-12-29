<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\DataStatisticsResource;

use App\Http\Resources\StastLogsResource;
use App\Models\ActionLog;
use Illuminate\Support\Facades\DB;


class StatisticsDataUsersController extends Controller
{
    public function index()
    {
        $totalAccounts = DB::table('users')->count();
        $newestUser = DB::table('users')->orderBy('created_at', 'desc')->first();
        $oldestUser = DB::table('users')->orderBy('created_at', 'asc')->first();
        $verifiedAccounts = DB::table('users')->whereNotNull('email_verified_at')->count();
        $unverifiedAccounts = DB::table('users')->whereNull('email_verified_at')->count();
        $verifiedUsers = DB::table('users')->whereNotNull('email_verified_at')->get(['id','name','email','created_at']);
        $unverifiedUsers = DB::table('users')->whereNull('email_verified_at')->get(['id','name','email','created_at']);

        return new DataStatisticsResource([
            'totalAccounts' => $totalAccounts,
            'newestUser' => $newestUser,
            'oldestUser' => $oldestUser,
            'verifiedAccounts' => $verifiedAccounts,
            'unverifiedAccounts' => $unverifiedAccounts,
            'unverifiedUsers' => $unverifiedUsers,
            'verifiedUsers' => $verifiedUsers,
        ]);
    }
    public function logstats()
    {
        //$logs = DB::table('action_logs')->count();
        // $logs = ActionLog::all()->toArray();

        $totalLogs = DB::table('action_logs')->count();
        $logs = DB::table('action_logs')->get(['id','user_id','action','ip_address','endpoint','request_data','response_data']);
        $newsLogs = DB::table('action_logs')->orderBy('created_at', 'desc')->first();
        $oldLogs = DB::table('action_logs')->orderBy('created_at', 'asc')->first();



        return new StastLogsResource([
            'totalLogs' => $totalLogs,
            'logs'=> $logs,
            'newsLogs'=>$newsLogs,
            'oldLogs'=>$oldLogs,


        ]);



    }
}
