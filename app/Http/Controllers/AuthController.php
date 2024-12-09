<?php

namespace App\Http\Controllers;

use App\Http\Resources\UsersResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use OpenApi\Annotations as OA;


/**
 * @OA\Info(
 *     title="API Desk Documentation",
 *     version="1.0",
 *     description="Documentação da API Desk."
 * )
 * * @OA\SecurityScheme(
 *     securityScheme="sanctumAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 *  @OA\Server(
 *      url=L5_SWAGGER_CONST_HOST,
 *      description="Demo API Server"
 * )
 *
 */
class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    /**
     *@OA\Post(
     *     path="/login",
     *     summary="",
     *     tags={"Autenticação"},
     *     description="",
     *     @OA\RequestBody(
     *         required=true,
     *        @OA\JsonContent(
     *            required={"email","password"},
     *              @OA\Property(
     *                  property="email",
     *                  type="string",
     *
     *                  example="fulan@teste.com",
     *                  description="d"
     *              ),
     *              @OA\Property(
     *                  property="password",
     *                  type="string",
     *
     *                  example="password",
     *                  description="d"
     *              )
     *        )
     *     ),
     *     @OA\Response(
     *         response=200,
     *          description="k",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="id",
     *                  type="integer",
     *                  example="4",
     *                  description="d"
     *              ),
     *              @OA\Property(
     *                  property="name",
     *                  type="string",
     *                  example="fulano",
     *                  description="d"
     *              ),
     *              @OA\Property(
     *                  property="email",
     *                  type="string",
     *                  example="fulan@teste.com",
     *                  description="d"
     *              ),
     *
     *          )
     *     ),
     *     @OA\Response(
     *         response=401,
     *          description="d",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="Unauthorized",
     *                  description="d"
     *              )
     *          )
     *     )
     *
     *)
     */


    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);
        $credentials = $request->only(['email', 'password']);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $tokenResult = $user->createToken('auth_token')->plainTextToken;
            return response()->json([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
            ]);
        }
//        if (!Auth::attempt($credentials)) {
//            return response()->json([
//                'message' => 'Unauthorized'
//            ],401);
//        }
        return response()->json([
            'message' => 'Unauthorized'

        ],401);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function logout (Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json([
            'message' => 'Logged out'
        ],200);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6'

        ]);

         $user = User::create([
             'name'=>$request->input('name'),
             'email'=>$request->input('email'),
             'password'=>Hash::make($request->input('password'))
         ]);





        return new UsersResource($user);
    }


}
