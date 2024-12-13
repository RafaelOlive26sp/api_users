<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UsersResource;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Auth\Middleware\Authorize;

class UserController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index(User $user)
    {

        try {
            $this->authorize('viewAny', User::class);
        } catch (AuthorizationException $e) {
            return response()->json(['message' => 'You are not authorized to acess'], 403);
        }
        return UsersResource::collection(User::all());
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $this->authorize('update', User::class);
        }catch (AuthorizationException $e) {
            return response()->json(['message' => 'You are not authorized to acess'], 403);
        }
        return 'estamos no store';
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
    public function update(StoreUserRequest $request, string $id)
    {
        $user = User::findOrFail($id);

        $validatorData = $request->validated();

        $user->update($validatorData);

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
