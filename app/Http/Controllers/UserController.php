<?php

namespace App\Http\Controllers;

use App\Http\Resources\UsersResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return false;
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $userId = Auth::user()->id;

        $accountData = User::where('id',$userId)->firstOrFail();

        return new UsersResource($accountData);

    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'User not found'
            ],404);
        }

        $request->validate([
            'name' => ['sometimes', 'string'],
            'email' => ['sometimes', 'email', Rule::unique('users')->ignore($user)],
            'password' => ['sometimes', 'string','min:6'],
        ]);

        $user->update($request->only(['name','email','password']));

        return new UsersResource($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'User not found'
            ],404);
        }

        DB::transaction(function () use ($user) {
            $user->tokens()->delete();
        });

        $user->delete();

        return response()->json([
            'message' => 'User deleted successfully'
        ],200);

    }
}
