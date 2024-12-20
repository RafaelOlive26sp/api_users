<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
    public function verify(Request $request,$id, $hash)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User Not Found'], 404);
        }
        if (!hash_equals(sha1($user->email),$hash)) {
//            return response()->json(['message' => 'Invalid or expired verification link'], 401);
            return response()->view('email.verified',['message'=>'Invalid or expired verification link','status'=>401],401);
        }
        if ($user->hasVerifiedEmail()) {
//            return response()->json(['message' => 'User already verified'], 404);
            return response()->view('email.verified',['message'=>'Email already verified','status'=>404],404);
        }
        $user->markEmailAsVerified();
//        return response()->json(['message' => 'Email has been verified'], 200);
        return response()->view('email.verified',['message'=>'You have successfully verified your email address.','status'=>200],200);
    }

    public function resend(Request $request): JsonResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return response()->json(['message' => 'User already verified'], 404);
        }
        auth()->user()->sendEmailVerificationNotification();
        $email = auth()->user()->email;

        return response()->json(['message' => 'Email verification link sent on your email address ', $email], 200);
    }
}
