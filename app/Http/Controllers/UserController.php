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

     /**
     * @OA\GET(
     *     path="/user",
     *     summary="Realiza uma Collection de todos os usuarios, Somente admins e atendentes podem Realizar essa consulta ",
     *     tags={"Usuario"},
     *     security={{"sanctumAuth":{}}},

     *     @OA\Response(
     *         response=200,
     *         description="OK, Dados recuperados com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(
     *                      type="object",
     *                      @OA\Property(property="id", type="integer", example="2"),
     *                      @OA\Property(property="email", type="string", example="email@teste.com"),
     *                      @OA\Property(property="privilege_id", type="integer", example="3"),
     *                  ),
     *                 @OA\Items(
     *                      type="object",
     *                      @OA\Property(property="id", type="integer", example="3"),
     *                      @OA\Property(property="email", type="string", example="email@test
     *                      e.com"),
     *                      @OA\Property(property="privilege_id", type="integer", example="3"),
     *                  )
     *              )

     *            )
     *
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="You are not authorized to acess",
     *         @OA\JsonContent(
     *             @OA\Property(
      *             property="message",
      *             type="string",
      *             example="You are not authorized to acess",
      *             description="Somente administradores poderao ver todas as contas do sistema como um collection"
      *             )
     *         )
     *     )
     * )
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

     /**
      * @OA\Post(
      *   tags={"Usuario"},
      *   path="/users",
      *   summary="Acessa o Store , porem o acesso é somente a admins",
      *    security={{"sanctumAuth":{}}},
      *
      *
      *   @OA\Response(
     *         response=403,
     *         description="You are not authorized to acess",
     *         @OA\JsonContent(
     *             @OA\Property(
      *             property="message",
      *             type="string",
      *             example="You are not authorized to acess",
      *             description="Somente administradores poderao Acessar"
      *             )
     *         )
     *     )
      *
      * )
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

    /**
         * @OA\Get(
         *   tags={"Usuario"},
         *   path="/users/{id}",
         *   summary="Retorna os dados da conta do Usuario logado, Somente admins e atendentes podem ver dados de contas de terceiros",
         *   security={{"sanctumAuth":{}}},
         *
         *   @OA\Response(
         *     response=200,
         *     description="OK",
         *     @OA\JsonContent(
         *        @OA\Property(property="data", type="object",
         *          @OA\Property(
         *            property="id",
         *            type="integer",
         *            example="2",
         *            description="Id do usuario"
         *          ),
         *          @OA\Property(
         *            property="name",
         *            type="string",
         *            example="Richard",
         *            description="Nome do Usuario"
         *          ),
         *          @OA\Property(
         *            property="email",
         *            type="string",
         *            example="richard@teste.com",
         *            description="email do Usuario"
         *          ),
         *          @OA\Property(
         *            property="privilege_id",
         *            type="integer",
         *            example="3",
         *            description="Mostra qual indentificador do usuario, em Role que indica se 3-Cliente,2-Atendente,1-Admin"
         *          ),
         *      )
         *     )
         *   ),
         *   @OA\Response(
         *     response=403,
         *     description="Forbidden",
         *     @OA\JsonContent(
         *
         *       @OA\Property(
         *         property="message",
         *         type="string",
         *         example="You are not authorized to acess",
         *         description="Somente administradores poderao verificar informaçoes de outras contas"
         *      )
         *     )
         *
         *
         * ),
         *
         * )
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


     /**
      * @OA\PUT(
      *   tags={"Usuario"},
      *   path="/users/{id}",
      *   summary="PUT, Atualiza os dados do usuario, Porem somente admins e atendentes poderam atualizar dados de outras contas",
      *   security={{"sanctumAuth":{}}},
      *    @OA\Parameter(
      *     name="id",
      *     in="path",
      *     required=true,
      *     description="ID do usuário",
      *     @OA\Schema(type="integer", example=1),
      *    ),
      *   @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","email", "password"},
     *             @OA\Property(property="name", type="string", format="name", example="Edward"),
     *             @OA\Property(property="email", type="string", format="email", example="junior@t.com"),
     *             @OA\Property(property="password", type="string", format="password", example="password"),
     *         )
     *     ),
      *
      *   @OA\Response(
      *       response=200,
      *       description="OK, Somente admins e atendentes podem alterar outros ID's",
      *        @OA\JsonContent(
      *          @OA\Property(property="data", type="object",
      *            @OA\Property(
      *              property="name",
      *              type="string",
      *              example="jonas",
      *              description="Novo nome"
      *            ),
      *            @OA\Property(
      *              property="email",
      *              type="string",
      *              example="jonas@teste.com",
      *              description="novo email"
      *            ),
      *            @OA\Property(
      *              property="password",
      *              type="password",
      *              example="jonas12345",
      *              description="Nova senha"
      *            ),
      *            @OA\Property(
      *              property="email_verified_at",
      *              type="string",
      *              example="2024-11-25T06:45:36.000000Z",
      *              description="Data de quando o email foi verificado"
      *            ),
      *            @OA\Property(
      *              property="role_id",
      *              type="string",
      *              example="3",
      *              description="Mostra qual indentificador do usuario, em Role que indica se 3-Cliente,2-Atendente,1-Admin"
      *            ),
      *
      *          )
      *        )
      *     ),
      *   @OA\Response(
      *          response=401,
      *          description="Unauthorized",
      *          @OA\JsonContent(
      *            @OA\Property(
      *                  property="message",
      *                  type="string",
      *                  example="You are not authorized to acess",
      *                  description="Se o usuario tentar acessar outro ID alem do seu, Somente admins podem alterar outras contas"
      *                  )
      *          )
      *      ),
      *          @OA\Response(
      *            response=404,
      *            description="Usuário não encontrado",
      *            @OA\JsonContent(
      *              @OA\Property(
      *                 property="message",
      *                 type="string",
      *                 example="User not found",
      *                 description="Se for digitado um ID que nao existe, sera exibido esse erro"
      *                 )
       *            )
      *          )
      *
      * )
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

    /**
     * @OA\Delete(
     *     tags={"Usuario"},
     *    path="/user/{id}",
     *    summary="Excluir um Usuario,Somente admins e atendentes podem excluir contas de terceiros",
     *    description="Deleta o Usuario, somente admins podem utilizar outros ID's",
     *    security={{"sanctumAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do usuario a ser excluido",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="User removed success",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="User removed success",
     *                  description="Retornara uma mensagem de sucesso que o usuario foi exluido com sucesso"
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="You are not authorized to delete this user, somente admins podem exluir outros ID's",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="You are not authorized to delete this user",
     *                  description="Somente administradores de sistema e atendentes podem excluir contas de terceiros"
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response=404,
     *          description="Usuario nao encontrado",
     *        @OA\JsonContent(
     *            @OA\Property(
     *                property="message",
     *                type="string",
     *                example="User Not found",
     *                description="Se o usuario nao existir no banco de dados ou se ja foi exluido"
     *            )
     *        )
     *     ),
     * )
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
