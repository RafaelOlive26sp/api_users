<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group(function () {

Route::resource('users', UserController::class)->middleware(['auth:sanctum']);



Route::post('/login',[AuthController::class,'login'])->middleware(['throttle:30,1'])->name('login');
Route::post('/register',[AuthController::class,'register'])->name('register');

Route::post('/logout',[AuthController::class,'logout'])->middleware('auth:sanctum')->name('logout');
});

