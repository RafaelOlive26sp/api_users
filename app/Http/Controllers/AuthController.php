<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginPostRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UsersResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
     *                  description="Input do email do login"
     *              ),
     *              @OA\Property(
     *                  property="password",
     *                  type="string",
     *
     *                  example="password",
     *                  description="Input da Senha da conta"
     *              )
     *        )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Login realizado com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="access_toke", type="string", example="000|pnQZ3VxhbHU49DWTycJOvZgLaKob6RB5Gn8zVtZsb9b7455a"),
     *              @OA\Property(property="token_type", type="string", example="Bearer"),

     *             )
     *
     *     ),
     *    @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthorized")
     *         )
     *     ),
     *    @OA\Response(
     *         response=422,
     *         description="Campos obrigatórios não foram preenchidos. Caso um ou mais campos sejam omitidos, será exibida uma mensagem de erro.",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="O campo email é Obrigatorio",
     *                 description="Mensagem de erro quando um campo obrigatório não é enviado."
     *            ),
     *             @OA\Property(
     *                     property="errors",
     *                     type="object",
     *                 @OA\Property(
     *                     property="title",
     *                     type="array",
     *                     @OA\Items(
     *                         type="string",
     *                         example="O campo email é Obrigatorio",
     *                         description="Lista os erros específicos do campo."
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *
     *)
     */


    public function login(LoginPostRequest $request)
    {

        $credentials = $request->only(['email', 'password']);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $tokenResult = $user->createToken('auth_token')->plainTextToken;
            return response()->json([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
            ]);
        }

        return response()->json([
            'message' => 'Unauthorized'

        ],401);
    }


    /**
     * Store a newly created resource in storage.
     */

     /**
     * @OA\Post(
     *     path="/logout",
     *     summary="Realiza logout do usuário",
     *     tags={"Autenticação"},
     *     security={{"sanctumAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Logout realizado com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(
     *               property="message",
     *               type="string",
     *               example="Logged out")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Não autenticado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message",
     *             type="string",
     *             example="Unauthenticated")
     *         )
     *     )
     * )
     */


    public function logout (Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json([
            'message' => 'Logged out'
        ]);
    }



    /**
     * @OA\Post(
     *     path="/register",
     *     summary="Realiza o cadastro de Usuarios.",
     *     tags={"Usuario"},
     *     description="Realiza o cadastro de usuarios para acesso ao sistema .",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","email", "password"},
     *             @OA\Property(property="name", type="string", format="name", example="Edward"),
     *             @OA\Property(property="email", type="string", format="email", example="junior@t.com"),
     *             @OA\Property(property="password", type="string", format="password", example="password"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Conta Criada com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="object",
     *                  @OA\Property(property="id", type="integer", example="21"),
     *                  @OA\Property(property="name", type="string", example="edward"),
     *                  @OA\Property(property="email", type="string", example="edward@tete.com"),
     *                  @OA\Property(property="privilege_id", type="string", example="null",description="Por Padrao todos os usuarios teram o privilegio de 3, que significa cliente, no momento o valor apresentado sera como null, mas posteriormente ele é alterado"),
     *
     *              )

     *          )

     *      ),
     *     @OA\Response(
     *         response=422,
     *         description="Campos obrigatórios não foram preenchidos. Caso um ou mais campos sejam omitidos, será exibida uma mensagem de erro.",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="O campo nome é Obrigatorio (and 1 more error)",
     *                 description="Mensagem de erro quando um campo obrigatório não é enviado."
     *            ),
     *             @OA\Property(
     *                     property="errors",
     *                     type="object",
     *                 @OA\Property(
     *                     property="name",
     *                     type="array",
     *                     @OA\Items(
     *                         type="string",
     *                         example="O campo Name é Obrigatorio",
     *                         description="Se o campo for emitido, sera exibido o erro no campo especifico."
     *                     )
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     type="array",
     *                     @OA\Items(
     *                         type="string",
     *                         example="Este email ja esta em uso!",
     *                         description="Caso, o email que o usuario esteja tentando cadastrar ja exista."
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     * )
     */

    public function register(StoreUserRequest $request)
    {
        $validateData = $request->validated();


        $user = User::create($validateData);




        return new UsersResource($user);
    }


}
