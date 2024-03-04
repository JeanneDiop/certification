<?php

namespace App\Http\Controllers\API;


use Exception;
use App\Models\User;
use Illuminate\Http\Request;

use openApi\Annotations as OA;
use App\Http\Controllers\Controller;


use Illuminate\Support\Facades\Hash;
use App\Http\Requests\User\EditUserRequest;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\ArchiveUserRequest;



/**
 
*@OA\Info(title="endpointCandidature", version="0.1")*/
class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */


    
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register','refresh']
    ]);
    }
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */

/**
 * @OA\Put(
 *     path="/api/users/{id}/updatepassword",
 *     operationId="updateUserPassword",
 *     tags={"Users"},
 *     summary="Mise à jour du mot de passe de l'utilisateur",
 *     description="Mise à jour du mot de passe de l'utilisateur en fonction de l'ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID de l'utilisateur",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="password", type="string", format="password", description="Le nouveau mot de passe de l'utilisateur"),
 *             @OA\Property(property="password_confirmation", type="string", format="password", description="Confirmation du nouveau mot de passe"),
 *         ),
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Mot de passe mis à jour avec succès",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status_code", type="integer", example=200),
 *             @OA\Property(property="status_message", type="string", example="Mot de passe mis à jour avec succès"),
 *             @OA\Property(property="data", type="object", description="Utilisateur mis à jour", ref="#/components/schemas/User"),
 *         ),
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Utilisateur non trouvé",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status_code", type="integer", example=404),
 *             @OA\Property(property="status_message", type="string", example="Utilisateur non trouvé"),
 *         ),
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Échec de validation",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status_code", type="integer", example=422),
 *             @OA\Property(property="status_message", type="string", example="Échec de validation"),
 *             @OA\Property(property="errors", type="object", description="Liste des erreurs de validation", example={"password": {"Le champ mot de passe est requis."}}),
 *         ),
 *     ),
 * )
 */

    public function updatepassword(Request $request, $id)
{

     // Valider les données de la requête
     $validatedData = $request->validate([
        'password' => 'required|min:8',
    ], [
        'password.required' => 'Le champ mot de passe est requis.',
    ]);
    // Vérifier si l'utilisateur existe
    $user = User::find($id);

    if (!$user) {
        return response()->json([
            'status_code' => 404,
            'status_message' => 'Utilisateur non trouvé.'
        ], 404);
    }

    // Mettre à jour le mot de passe
    $user->password = Hash::make($request->password);
    $user->save();

    return response()->json([
        'status_code' => 200,
        'status_message' => 'Mot de passe mis à jour avec succès.',
        'data' => $user,
    ]);
}
/**
 * @OA\Post(
 *     path="/api/login",
 *     operationId="userLogin",
 *     tags={"Authentication"},
 *     summary="Authentification de l'utilisateur",
 *     description="Authentification de l'utilisateur via email et mot de passe",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="email", type="string", format="email", description="Adresse email de l'utilisateur"),
 *             @OA\Property(property="password", type="string", format="password", description="Mot de passe de l'utilisateur"),
 *         ),
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Authentification réussie",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="token", type="string", description="Token d'authentification"),
 *             @OA\Property(property="user", type="object", description="Informations sur l'utilisateur", ref="#/components/schemas/User"),
 *         ),
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Échec de l'authentification",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="error", type="string", example="Unauthorized", description="Message d'erreur"),
 *         ),
 *     ),
 * )
 */

    // public function login()
    // {
    //     $email=request(['email']);
    //     $user=User::where('email',$email['email'])->first();    
    //     $credentials = request(['email', 'password']);

    //     if (! $token = auth()->attempt($credentials)) {
    //         return response()->json(['error' => 'Unauthorized'], 401);
    //     }

    //     return $this->respondWithToken($token,$user);
    // }
    public function login()
    {
        $email=request(['email']);
        $user=User::where('email',$email['email'])->first();    
        $credentials = request(['email', 'password']);
    
        if ($user->etat === 'actif') {
            $credentials = request(['email', 'password']);
    
            if (! $token = auth()->attempt($credentials)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
            return $this->respondWithToken($token, $user);
        } else {
            return response()->json(['error' => 'Votre compte est inactif, vous ne pouvez pas vous connecter'], 403);
        }  
    }
    

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    // public function personneconnecter()
    // {
    //     return response()->json(auth()->user());
    // }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */

     /**
      * @OA\Post(
      *     path="/api/logout",
      *     operationId="userLogout",
      *     tags={"Authentication"},
      *     summary="Déconnexion de l'utilisateur",
      *     description="Déconnexion de l'utilisateur authentifié",
      *     security={{ "bearerAuth": {} }},
      *     @OA\Response(
      *         response=200,
      *         description="Déconnexion réussie",
      *         @OA\JsonContent(
      *             type="object",
      *             @OA\Property(property="message", type="string", example="Successfully logged out", description="Message de succès"),
      *         ),
      *     ),
      *     @OA\Response(
      *         response=401,
      *         description="Non autorisé",
      *         @OA\JsonContent(
      *             type="object",
      *             @OA\Property(property="error", type="string", example="Unauthorized", description="Message d'erreur"),
      *         ),
      *     ),
      * )
      */

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return response()->json(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    /**
 * @OA\schema(
 *     schema="TokenResponse",
 *     type="object",
 *     @OA\Property(property="user", type="object", description="Informations sur l'utilisateur", ref="#/components/schemas/User"),
 *     @OA\Property(property="access_token", type="string", description="Token d'authentification"),
 *     @OA\Property(property="token_type", type="string", example="bearer", description="Type de token"),
 *     @OA\Property(property="expires_in", type="integer", description="Durée de validité du token en secondes"),
 * ),
 *
 * @OA\Post(
 *     path="/api/login",
 *     operationId="userLogin",
 *     tags={"Authentication"},
 *     summary="Authentification de l'utilisateur",
 *     description="Authentification de l'utilisateur via email et mot de passe",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="email", type="string", format="email", description="Adresse email de l'utilisateur"),
 *             @OA\Property(property="password", type="string", format="password", description="Mot de passe de l'utilisateur"),
 *         ),
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Authentification réussie",
 *         @OA\JsonContent(ref="#/components/schemas/TokenResponse"),
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Échec de l'authentification",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="error", type="string", example="Unauthorized", description="Message d'erreur"),
 *         ),
 *     ),
 * ),
 */
 
    protected function respondWithToken($token,$user )
    {
        return response()->json([
           'user'=>$user,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 120
        ]);
    }

    /**
 * @OA\Post(
 *     path="/api/register",
 *     operationId="userRegister",
 *     tags={"Users"},
 *     summary="Enregistrement d'un nouvel utilisateur",
 *     description="Enregistrement d'un nouvel utilisateur avec les informations fournies",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="nom", type="string", description="Nom de l'utilisateur"),
 *             @OA\Property(property="prenom", type="string", description="Prénom de l'utilisateur"),
 *             @OA\Property(property="email", type="string", format="email", description="Adresse email de l'utilisateur"),
 *             @OA\Property(property="password", type="string", format="password", description="Mot de passe de l'utilisateur"),
 *             @OA\Property(property="telephone", type="string", description="Numéro de téléphone de l'utilisateur"),
 *             @OA\Property(property="etat", type="string", description="État de l'utilisateur (actif, inactif, etc.)"),
 *             @OA\Property(property="adresse", type="string", description="Adresse de l'utilisateur"),
 *             @OA\Property(property="role_id", type="integer", description="ID du rôle de l'utilisateur"),
 *         ),
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Utilisateur enregistré avec succès",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status_code", type="integer", example=200),
 *             @OA\Property(property="status_message", type="string", example="Utilisateur a été ajouté"),
 *             @OA\Property(property="data", type="object", description="Informations sur l'utilisateur enregistré", ref="#/components/schemas/User"),
 *         ),
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Erreur interne du serveur",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status_code", type="integer", example=500),
 *             @OA\Property(property="status_message", type="string", example="Erreur interne du serveur"),
 *         ),
 *     ),
 * )
 */
    public function register(CreateUserRequest $request)
  {
      try {
        // if (auth()->user()->role_id == 1) {
        $user = new User();
        $user->nom = $request->nom;
        $user->prenom = $request->prenom;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->telephone = $request->telephone;
        $user->etat = $request->etat;
        $user->adresse = $request->adresse;
        $user->role_id = $request->role_id;
        $user->save();
  
        return response()->json([
          'status_code' => 200,
          'status_message' => 'user a été ajouté',
          'data' => $user
        ]);

    // }else {
    //         // Un utilisateur avec un role_id différent de 1 n'a pas le droit de modifier
    //         return response()->json([
    //             'status_code' => 403,
    //             'status_message' => "Vous n'avez pas la permission d'ajouter cet utilisateur",
    //         ]);
    //     }
      } catch (Exception $e) {
        return response()->json($e);
      }
  }

  /**
 * @OA\Get(
 *     path="/api/users",
 *     operationId="getUsersByRoleId",
 *     tags={"Users"},
 *     summary="Récupération des utilisateurs (employés) par role_id",
 *     description="Récupération des utilisateurs ayant le role_id égal à 2 (employés)",
 *     security={{ "bearerAuth": {} }},
 *     @OA\Response(
 *         response=200,
 *         description="Utilisateurs récupérés avec succès",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status_code", type="integer", example=200),
 *             @OA\Property(property="status_message", type="string", example="Utilisateurs(employés) avec role_id = 2 récupérés"),
 *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/User"), description="Liste des utilisateurs"),
 *         ),
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Accès interdit",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status_code", type="integer", example=403),
 *             @OA\Property(property="status_message", type="string", example="Vous n'avez pas la permission"),
 *         ),
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Erreur interne du serveur",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status_code", type="integer", example=500),
 *             @OA\Property(property="status_message", type="string", example="Erreur interne du serveur"),
 *         ),
 *     ),
 * )
 */

  public function index()
{
  try 
  {
    if (auth()->user()->role_id == 1) {
    $users = User::where('role_id', 2)->get();

    return response()->json([
        'status_code' => 200,
        'status_message' => 'Utilisateurs(employés) avec role_id = 2  récupérés',
        'data' => $users,
    ]);
}else{
    // Un utilisateur avec un role_id différent de 1 n'a pas le droit de modifier
    return response()->json([
        'status_code' => 403,
        'status_message' => "Vous n'avez pas la permission ",
    ]);
}
} catch (Exception $e) {
    return response()->json($e);
}
  
}

/**
 * @OA\Get(
 *     path="/api/users/{id}",
 *     operationId="getUserById",
 *     tags={"Users"},
 *     summary="Récupération d'un utilisateur par ID",
 *     description="Récupération d'un utilisateur en fonction de son ID",
 *     security={{ "bearerAuth": {} }},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID de l'utilisateur",
 *         @OA\Schema(type="string"),
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Utilisateur récupéré avec succès",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="user", type="object", description="Informations sur l'utilisateur", ref="#/components/schemas/User"),
 *         ),
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Accès interdit",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status_code", type="integer", example=403),
 *             @OA\Property(property="status_message", type="string", example="Vous n'avez pas la permission"),
 *         ),
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Utilisateur non trouvé",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Désolé, pas de user trouvé."),
 *         ),
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Erreur interne du serveur",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status_code", type="integer", example=500),
 *             @OA\Property(property="status_message", type="string", example="Erreur interne du serveur"),
 *         ),
 *     ),
 * )
 */


public function show(string $id)
{
    try {
        if (auth()->user()->role_id == 1) {
        $user = User::findOrFail($id);

        return response()->json($user);
        }else{
            // Un utilisateur avec un role_id différent de 1 n'a pas le droit de modifier
            return response()->json([
                'status_code' => 403,
                'status_message' => "Vous n'avez pas la permission ",
            ]);
        }
    } catch (Exception) {
        return response()->json(['message' => 'Désolé, pas de user trouvé.'], 404);
    }
}

/**
 * @OA\Put(
 *     path="/api/users/{user}",
 *     operationId="updateUser",
 *     tags={"Users"},
 *     summary="Modification d'un utilisateur",
 *     description="Modification des informations d'un utilisateur",
 *     security={{ "bearerAuth": {} }},
 *     @OA\Parameter(
 *         name="user",
 *         in="path",
 *         required=true,
 *         description="ID de l'utilisateur",
 *         @OA\Schema(type="integer"),
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="nom", type="string", description="Nom de l'utilisateur"),
 *             @OA\Property(property="prenom", type="string", description="Prénom de l'utilisateur"),
 *             @OA\Property(property="email", type="string", format="email", description="Adresse email de l'utilisateur"),
 *             @OA\Property(property="password", type="string", format="password", description="Mot de passe de l'utilisateur"),
 *             @OA\Property(property="telephone", type="string", description="Numéro de téléphone de l'utilisateur"),
 *             @OA\Property(property="adresse", type="string", description="Adresse de l'utilisateur"),
 *             @OA\Property(property="etat", type="string", description="État de l'utilisateur (actif, inactif, etc.)"),
 *             @OA\Property(property="role_id", type="integer", description="ID du rôle de l'utilisateur"),
 *         ),
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Modification du compte enregistré avec succès",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status_code", type="integer", example=200),
 *             @OA\Property(property="status_message", type="string", example="Modification du compte enregistré"),
 *             @OA\Property(property="user", type="object", description="Informations sur l'utilisateur modifié", ref="#/components/schemas/User"),
 *         ),
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Accès interdit",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status_code", type="integer", example=403),
 *             @OA\Property(property="status_message", type="string", example="Vous n'avez pas la permission de modifier cet utilisateur"),
 *         ),
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Erreur interne du serveur",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status_code", type="integer", example=500),
 *             @OA\Property(property="status_message", type="string", example="Erreur interne du serveur"),
 *         ),
 *     ),
 * )
 */
public function update(EditUserRequest $request, User $user)
{
    try {
        $userRole = auth()->user()->role_id;

        if ($userRole == 1 || $userRole == 2) {
            // L'administrateur et le proprietaire (role_id égal à 1 et role_id egal à 2) auront le droit de modifier tous les comptes
            $user->nom = $request->nom;
            $user->prenom = $request->prenom;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->telephone = $request->telephone;
            $user->adresse = $request->adresse;
            $user->etat = $request->etat;
            $user->role_id = $request->role_id;

            $user->update();

            return response()->json([
                'status_code' => 200,
                'status_message' => "Modification du compte enregistré",
                'user' => $user
            ]);
        } else {
            // Un utilisateur avec un role_id différent de 1 n'a pas le droit de modifier
            return response()->json([
                'status_code' => 403,
                'status_message' => "Vous n'avez pas la permission de modifier cet utilisateur",
            ]);
        }
    } catch (Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

/**
 * @OA\Put(
 *     path="/api/users/{user}/archiver",
 *     operationId="archiverUser",
 *     tags={"Users"},
 *     summary="Activation/Désactivation d'un utilisateur",
 *     description="Activation/Désactivation d'un utilisateur en fonction de son état actuel",
 *     security={{ "bearerAuth": {} }},
 *     @OA\Parameter(
 *         name="user",
 *         in="path",
 *         required=true,
 *         description="ID de l'utilisateur",
 *         @OA\Schema(type="integer"),
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Activation/Désactivation du compte réussie",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status_code", type="integer", example=200),
 *             @OA\Property(property="status_message", type="string", example="Activation/Désactivation du compte réussie"),
 *             @OA\Property(property="user", type="object", description="Informations sur l'utilisateur", ref="#/components/schemas/User"),
 *         ),
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Accès interdit",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status_code", type="integer", example=403),
 *             @OA\Property(property="status_message", type="string", example="Vous n'avez pas la permission de désactiver des comptes"),
 *         ),
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Erreur interne du serveur",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status_code", type="integer", example=500),
 *             @OA\Property(property="status_message", type="string", example="Erreur interne du serveur"),
 *         ),
 *     ),
 * )
 */

public function archiver(User $user)
{
    try {
        // Vérifier si l'utilisateur actuel a le droit de désactiver des comptes
        if (auth()->user()->role_id == 1) {
            // L'utilisateur actuel est un administrateur et peut désactiver des comptes
           if( $user->etat == "actif"){
            $user->etat = "inactif";
            $user->save();
           }else{
        $user->etat="actif";
        $user->save();
        }
           return response()->json([
                    'status_code' => 200,
                    'status_message' => "La désactivation du compte a réussi",
                    'user'=>$user
                ]);
            } else {
            // L'utilisateur actuel n'est pas autorisé à désactiver des comptes
                return response()->json([
                    'status_code' => 403,
                    'status_message' => "Vous n'avez pas la permission de désactiver des comptes",
                ]);
            }
        } catch (Exception $e) {
            
                return response()->json(['error' => $e->getMessage()], 500);
        
        }
    }
    
}