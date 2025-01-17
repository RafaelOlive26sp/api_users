<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UsersResource;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use OpenApi\Annotations as OA;



class UserController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */

     /**
     * @OA\GET(
     *     path="/users",
     *     summary="Realiza uma Collection de todos os usuarios ",
      *     description="Somente admins e atendentes podem Realizar essa consulta",
     *     tags={"Administração"},
     *     security={{"sanctumAuth":{}}},

     *     @OA\Response(
     *         response=200,
     *         description="OK, Dados recuperados com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(
     *                      type="object",
     *                      @OA\Property(property="id", type="integer", example="2"),
     *                      @OA\Property(property="email", type="string", example="edward@teste.com"),
     *                      @OA\Property(property="privilege_id", type="integer", example="3"),
     *                  ),
     *                 @OA\Items(
     *                      type="object",
     *                      @OA\Property(property="id", type="integer", example="3"),
     *                      @OA\Property(property="email", type="string", example="edward@teste.com"),
     *                      @OA\Property(property="privilege_id", type="integer", example="3"),
     *                  )
     *              )

     *            )
     *
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Você não tem permissão para acessar este recurso.",
     *         @OA\JsonContent(
     *             @OA\Property(
      *             property="message",
      *             type="string",
      *             example="You are not authorized to access",
      *             description="Somente administradores poderao ver todas as contas do sistema como um collection"
      *             )
     *         )
     *     ),
      *     @OA\Response(
      *          response=401,
      *          description="Usuário não autenticado. Faça login para continuar.",
      *          @OA\JsonContent(
      *              @OA\Property(property="message",
      *              type="string",
      *              example="Unauthenticated")
      *          )
      *      ),
     * )
    */


    public function index(User $user)
    {

        try {
            $this->authorize('viewAny', User::class);
        } catch (AuthorizationException $e) {
            return response()->json(['message' => 'You are not authorized to access'], 403);
        }
        return UsersResource::collection(User::all());
    }


    /**
     * Store a newly created resource in storage.
     */

     /**
      * @OA\Post(
      *   tags={"Administração"},
      *   path="/users",
      *   summary="Acessa o Store , porem o acesso é somente a admins",
      *     description="O metodo Store ainda nao possui funcionalidade, porem através de policies o seu acesso é somente para admins e atendentes",
      *    security={{"sanctumAuth":{}}},
      *
      *
      *   @OA\Response(
      *          response=403,
      *          description="Você não tem permissão para acessar este recurso.",
      *          @OA\JsonContent(
      *              @OA\Property(
      *              property="message",
      *              type="string",
      *              example="You are not authorized to access",
      *              description="Somente administradores e atendentes terão acesso a essa função"
      *              )
      *          )
      *      ),
      *     @OA\Response(
      *          response=401,
      *          description="Usuário não autenticado. Faça login para continuar.",
      *          @OA\JsonContent(
      *              @OA\Property(property="message",
      *              type="string",
      *              example="Unauthenticated")
      *          )
      *      ),
      *
      * )
      */


    public function store(Request $request)
    {
        try {
            $this->authorize('update', User::class);
        }catch (AuthorizationException $e) {
            return response()->json(['message' => 'You are not authorized to access'], 403);
        }
        return 'in store';
    }

    /**
     * Display the specified resource.
     */

    /**
         * @OA\Get(
         *   tags={"Usuario"},
         *   path="/users/{id}",
         *   summary="Retorna os dados da conta do Usuario logado.",
     *      description="Somente admins e atendentes podem ver dados de contas de terceiros",
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
         *            example="Edward",
         *            description="Nome do Usuario"
         *          ),
         *          @OA\Property(
         *            property="email",
         *            type="string",
         *            example="edward@teste.com",
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
     *           response=403,
     *           description="Você não tem permissão para acessar este recurso.",
     *           @OA\JsonContent(
     *               @OA\Property(
     *               property="message",
     *               type="string",
     *               example="You are not authorized to access",
     *               description="Somente admistradores do sistema podem acessar informaçoes de outros Usuarios"
     *               )
     *           )
     *       ),
     *     @OA\Response(
     *          response=401,
     *          description="Usuário não autenticado. Faça login para continuar.",
     *          @OA\JsonContent(
     *              @OA\Property(property="message",
     *              type="string",
     *              example="Unauthenticated")
     *          )
     *      ),
         *
         * )
         */




    public function show(User $user)
    {
        // Quando usando o USER no parametro na funcao o laravel faz a pesquisa no bd automaticamente

        try {
            // Autoriza o acesso ao usuário específico
            $this->authorize('view', $user);

            // Retorna diretamente os dados do usuário
            return new UsersResource($user);

        } catch (AuthorizationException $e) {
            // Retorna erro 403 em caso de autorização negada
            return response()->json(['message' => 'You are not authorized to access'], 403);
        }

    }



    /**
     * Update the specified resource in storage.
     */


     /**
      * @OA\PATCH(
      *   tags={"Usuario"},
      *   path="/users/{id}",
      *   summary="PUT, Atualiza os dados do usuario, Porem somente admins e atendentes poderam atualizar dados de outras contas,",
      *   description="O Campo Privilege_id, é autorizado somente para o ADMINISTRADOR ",
      *     security={{"sanctumAuth":{}}},
      *    @OA\Parameter(
      *     name="id",
      *     in="path",
      *     required=true,
      *     description="ID do usuário",
      *     @OA\Schema(type="integer", example=1),
      *    ),
      *   @OA\RequestBody(
     *         required=true,
      *
     *         @OA\JsonContent(
     *                  type="object",
     *             @OA\Property(property="name", type="string", format="name", example="Edward"),
     *             @OA\Property(property="email", type="string", format="email", example="edward@teste.com"),
     *             @OA\Property(property="privilege_id", type="string",  example="3", description="Somente o administrador podera alterar o privilegio do usuario 3= Cliente, 2= Atendente, 1= Administrador"),
     *             @OA\Property(property="password", type="string", format="password", example="password"),
     *         )
     *     ),
      *
      *
      *   @OA\Response(
      *       response=200,
      *       description="OK, Somente admins e atendentes podem alterar outros ID's",
      *        @OA\JsonContent(
      *          @OA\Property(property="data", type="object",
      *            @OA\Property(
      *              property="name",
      *              type="string",
      *              example="Edward",
      *              description="Novo nome"
      *            ),
      *            @OA\Property(
      *              property="email",
      *              type="string",
      *              example="edward@teste.com",
      *              description="novo email"
      *            ),
      *             @OA\Property(
      *              property="privilege_id",
      *              type="string",
      *              example="3",
      *              description="Mostra qual indentificador do usuario, em Role que indica se 3-Cliente,2-Atendente,1-Admin"
      *            ),
      *
      *
      *          )
      *        )
      *     ),
      *   @OA\Response(
      *           response=403,
      *           description="Você não tem permissão para accessar este recurso.",
      *           @OA\JsonContent(
      *               @OA\Property(
      *               property="message",
      *               type="string",
      *               example="You are not authorized to access",
      *               description="Somente administradores do sistema poderam atualizar outras contas"
      *               )
      *           )
      *       ),
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
      *          ),
      *     @OA\Response(
      *          response=401,
      *          description="Usuário não autenticado. Faça login para continuar.",
      *          @OA\JsonContent(
      *              @OA\Property(property="message",
      *              type="string",
      *              example="Unauthenticated")
      *          )
      *      ),
      *     @OA\Response(
     *         response=422,
     *         description=" Ação nao permitida, Nao é permitido alterar o privilegio da conta.",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="The privilege id field is prohibited.",
     *                 description="Mensagem de erro, pois nao é permitido alterar o campo da conta do administrador"
     *            ),
     *             @OA\Property(
     *                     property="errors",
     *                     type="object",
     *                 @OA\Property(
     *                     property="privilege_id",
     *                     type="array",
     *                     @OA\Items(
     *                         type="string",
     *                         example="The privilege id field is prohibited.",
     *                         description="Alteração Proibida."
     *                     )
     *                 )
     *             )
     *         )
     *     ),
      *
      * )
      */



    public function update(StoreUserRequest $request, string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'User not found'
            ],404);
        }

        if ($user->id === auth()->id()){
            $validatorData = $request->validated();

        }else{
                $this->authorize('updateAdmin', $user);

                $validatorData = $request->validated();
                $validatorData['privilege_id'] = $request->privilege_id;
        }
        $validatorData = array_filter($validatorData, function ($value) {
            return !is_null($value) && $value !== '';
        });
        $user->update($validatorData);

        return new UsersResource($user);
    }

    /**
     * Remove the specified resource from storage.
     */

    /**
     * @OA\Delete(
     *     tags={"Usuario"},
     *    path="/users/{id}",
     *    summary="Excluir um Usuario,Somente admins e atendentes podem excluir contas de terceiros",
     *    description="Deleta o Usuario, Somente o administrador e Atendente poderá excluir outras contas, caso contrario o propio usuarios podera excluir sua conta.",
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
     *         description="Você não tem permissão para accessar este recurso.",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="You are not authorized to access",
     *                  description="Somente administradores de sistema e atendentes podem excluir contas de terceiros"
     *              )
     *          )
     *     ),
     *
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
     *    @OA\Response(
     *          response=401,
     *          description="Usuário não autenticado. Faça login para continuar.",
     *          @OA\JsonContent(
     *              @OA\Property(property="message",
     *              type="string",
     *              example="Unauthenticated")
     *          )
     *      ),
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
        try {
            $this->authorize('delete', $user);
        }catch (AuthorizationException $e) {
            return response()->json(['message' => 'You are not authorized to access'], 403);
        }

        DB::transaction(function () use ($user) {
            $user->tokens()->delete();
        });

        $user->delete();

        return response()->json([
            'message' => 'User deleted successfully'
        ]);

    }
}
