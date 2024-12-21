<?php

use App\Http\Controllers\EmailVerificationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('api/documentation');
});

Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])->name('verification.verify');

//Route::get('/web',function (){
//    return view('email.verified');
//});
