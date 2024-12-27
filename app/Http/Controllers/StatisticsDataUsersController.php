<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\DataStatisticsResource;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class StatisticsDataUsersController extends Controller
{
    public function index()
    {
        $totalAccounts = DB::table('users')->count();
        $newestUser = DB::table('users')->orderBy('created_at', 'desc')->first();
        $oldestUser = DB::table('users')->orderBy('created_at', 'asc')->first();
        $verifiedAccounts = DB::table('users')->whereNotNull('email_verified_at')->count();
        $unverifiedAccounts = DB::table('users')->whereNull('email_verified_at')->count();

        return new DataStatisticsResource([
            'totalAccounts' => $totalAccounts,
            'newestUser' => $newestUser,
            'oldestUser' => $oldestUser,
            'verifiedAccounts' => $verifiedAccounts,
            'unverifiedAccounts' => $unverifiedAccounts
        ]);
    }
}
