<?php

namespace App\Http\Controllers\API;


use Exception;
use App\Models\User;
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
        $this->middleware('auth:api', ['except' => ['login','register', 'index','update','archiver']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */


     /**
 * @OA\Post(
 *     path="/api/login",
 *     tags={"Authentification"},
 *     summary="Connexion utilisateur",
 *     description="Connecte un utilisateur en utilisant les informations d'identification fournies.",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="email", type="string", format="email", description="Adresse e-mail de l'utilisateur"),
 *             @OA\Property(property="password", type="string", description="Mot de passe de l'utilisateur"),
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Utilisateur connecté avec succès",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="user", ref="#/components/schemas/User"),
 *             @OA\Property(property="authorization", type="object",
 *                 @OA\Property(property="token", type="string", description="Jeton d'authentification (Bearer token)"),
 *                 @OA\Property(property="type", type="string", description="Type de jeton (bearer)"),
 *             ),
 *         ),
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Non autorisé",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="error", type="string"),
 *         ),
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Erreur de validation",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="error", type="object"),
 *         ),
 *     ),
 * )
 */
    public function login()
    {
        $email=request(['email']);
        $user=User::where('email',$email['email'])->first();    
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token,$user);
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
 *     tags={"Authentification"},
 *     summary="Déconnexion utilisateur",
 *     description="Déconnecte l'utilisateur actuellement authentifié.",
 *     security={{"bearerAuth":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="Déconnexion réussie",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", description="Message indiquant que la déconnexion a réussi"),
 *         ),
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Non autorisé",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="error", type="string", description="Message d'erreur indiquant que l'utilisateur n'est pas authentifié"),
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
    // public function refresh()
    // {
    //     return $this->respondWithToken(auth()->refresh());
    // }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */




     /**
 * @OA\Parameter(
 *     name="token",
 *     in="query",
 *     description="Jeton d'authentification (Bearer token)",
 *     required=true,
 *     @OA\Schema(type="string")
 * )
 *
 * @OA\Parameter(
 *     name="user",
 *     in="query",
 *     description="Objet utilisateur",
 *     required=true,
 *     @OA\Schema(ref="#/components/schemas/User")
 * )
 *
 * @OA\Post(
 *     path="/api/respondWithToken",
 *     tags={"Authentification"},
 *     summary="Réponse avec jeton d'authentification",
 *     description="Fournit une réponse avec le jeton d'authentification, l'utilisateur, le type de jeton et sa durée de validité.",
 *     @OA\Response(
 *         response=200,
 *         description="Réponse avec succès",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="user", ref="#/components/schemas/User"),
 *             @OA\Property(property="access_token", type="string", description="Jeton d'authentification (Bearer token)"),
 *             @OA\Property(property="token_type", type="string", description="Type de jeton (bearer)"),
 *             @OA\Property(property="expires_in", type="integer", description="Durée de validité du jeton en secondes"),
 *         ),
 *     ),
 * )
 */
    protected function respondWithToken($token,$user )
    {
        return response()->json([
           'user'=>$user,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }



    /**
 * @OA\Post(
 *     path="/api/register",
 *     tags={"Utilisateurs"},
 *     summary="Enregistrement d'un nouvel utilisateur",
 *     description="Enregistre un nouvel utilisateur avec les informations fournies.",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="nom", type="string", description="Nom de l'utilisateur"),
 *             @OA\Property(property="prenom", type="string", description="Prénom de l'utilisateur"),
 *             @OA\Property(property="email", type="string", format="email", description="Adresse e-mail de l'utilisateur"),
 *             @OA\Property(property="password", type="string", description="Mot de passe de l'utilisateur"),
 *             @OA\Property(property="telephone", type="string", description="Numéro de téléphone de l'utilisateur"),
 *             @OA\Property(property="etat", type="string", description="État de l'utilisateur"),
 *             @OA\Property(property="adresse", type="string", description="Adresse de l'utilisateur"),
 *             @OA\Property(property="role_id", type="integer", description="ID du rôle de l'utilisateur"),
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Utilisateur enregistré avec succès",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status_code", type="integer", description="Code de statut de la réponse"),
 *             @OA\Property(property="status_message", type="string", description="Message de statut de la réponse"),
 *             @OA\Property(property="data", ref="#/components/schemas/User"),
 *         ),
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Erreur de validation",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="error", type="object"),
 *         ),
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Erreur lors de l'enregistrement de l'utilisateur",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="error", type="string"),
 *         ),
 *     ),
 * )
 */
    public function register(CreateUserRequest $request)
  {
      try {
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
      } catch (Exception $e) {
        return response()->json($e);
      }
  }




  /**
 * @OA\Get(
 *     path="/api/employees",
 *     tags={"Utilisateurs"},
 *     summary="Liste des employés avec le rôle_id égal à 2",
 *     description="Récupère la liste de tous les employés ayant le rôle avec l'ID égal à 2.",
 *     security={{"bearerAuth":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="Liste des employés récupérée avec succès",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status_code", type="integer", description="Code de statut de la réponse"),
 *             @OA\Property(property="status_message", type="string", description="Message de statut de la réponse"),
 *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/User")),
 *         ),
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Erreur lors de la récupération des employés",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status_code", type="integer", description="Code de statut de la réponse"),
 *             @OA\Property(property="status_message", type="string", description="Message de statut de la réponse"),
 *             @OA\Property(property="error", type="string", description="Message d'erreur détaillé"),
 *         ),
 *     ),
 * )
 */
  public function index()
{
  try 
  {
    $users = User::where('role_id', 2)->get();

    return response()->json([
        'status_code' => 200,
        'status_message' => 'Utilisateurs(employés) avec role_id = 2  récupérés',
        'data' => $users,
    ]);
} catch (Exception $e) {
    return response()->json($e);
}
  
}




/**
 * @OA\Put(
 *     path="/api/employees/{id}",
 *     tags={"Utilisateurs"},
 *     summary="Modifier un employé avec le rôle_id égal à 2",
 *     description="Modifie un utilisateur ayant le rôle avec l'ID égal à 2.",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID de l'utilisateur à modifier",
 *         @OA\Schema(type="integer"),
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="nom", type="string", description="Nouveau nom de l'utilisateur"),
 *             @OA\Property(property="prenom", type="string", description="Nouveau prénom de l'utilisateur"),
 *             @OA\Property(property="email", type="string", format="email", description="Nouvelle adresse e-mail de l'utilisateur"),
 *             @OA\Property(property="password", type="string", description="Nouveau mot de passe de l'utilisateur"),
 *             @OA\Property(property="telephone", type="string", description="Nouveau numéro de téléphone de l'utilisateur"),
 *             @OA\Property(property="etat", type="string", description="Nouvel état de l'utilisateur"),
 *             @OA\Property(property="adresse", type="string", description="Nouvelle adresse de l'utilisateur"),
 *             @OA\Property(property="role_id", type="integer", description="Nouvel ID du rôle de l'utilisateur"),
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Utilisateur modifié avec succès",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status_code", type="integer", description="Code de statut de la réponse"),
 *             @OA\Property(property="status_message", type="string", description="Message de statut de la réponse"),
 *             @OA\Property(property="data", ref="#/components/schemas/User"),
 *         ),
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Utilisateur non trouvé",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status_code", type="integer", description="Code de statut de la réponse"),
 *             @OA\Property(property="status_message", type="string", description="Message de statut de la réponse"),
 *             @OA\Property(property="error", type="string", description="Message d'erreur indiquant que l'utilisateur n'a pas été trouvé"),
 *         ),
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Erreur lors de la modification de l'utilisateur",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status_code", type="integer", description="Code de statut de la réponse"),
 *             @OA\Property(property="status_message", type="string", description="Message de statut de la réponse"),
 *             @OA\Property(property="error", type="string", description="Message d'erreur détaillé"),
 *         ),
 *     ),
 * )
 */
public function update(EditUserRequest $request, User $user)
{
    try {
        if (auth()->user()->role_id == 1) {
            // L'administrateur (role_id égal à 1) a le droit de modifier tous les comptes
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




public function archiver(User $user)
{
    try {
        // Vérifier si l'utilisateur actuel a le droit de désactiver des comptes
        if (auth()->user()->role_id == 1) {
            // L'utilisateur actuel est un administrateur et peut désactiver des comptes
            $user->etat = "inactif";
            $user->save();
           
    
                return response()->json([
                    'status_code' => 200,
                    'status_message' => "La désactivation du compte a réussi"
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