<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\StatisticsDataUsersController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group(function () {

Route::resource('users', UserController::class)->middleware(['auth:sanctum']);
Route::post('/email/resend', [EmailVerificationController::class, 'resend'])->middleware('throttle:6,1')->name('verification.resend');
Route::get('statisticdata',[StatisticsDataUsersController::class, 'index'])->middleware('auth:sanctum')->name('data');


Route::post('/login',[AuthController::class,'login'])->middleware(['throttle:30,1'])->name('login');
Route::post('/register',[AuthController::class,'register'])->middleware(['throttle:5,1'])->name('register');

Route::post('/logout',[AuthController::class,'logout'])->middleware('auth:sanctum')->name('logout');

});

