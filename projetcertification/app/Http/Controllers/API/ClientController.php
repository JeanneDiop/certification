<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\User;
use App\Models\Client;
use Illuminate\Http\Request;
use openApi\Annotations as OA;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\EditClientRequest;
use App\Http\Requests\Client\CreateClientRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 
*@OA\Info(title="endpointClient", version="0.1")*/
class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     /**
 * @OA\Get(
 *     path="/api/clients",
 *     summary="Liste des clients",
 *     description="Récupère la liste de tous les clients.",
 *     operationId="getClients",
 *     tags={"Clients"},
 *     @OA\Response(
 *         response=200,
 *         description="Liste des clients récupérée avec succès.",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/Client")
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Erreur interne du serveur.",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Erreur interne du serveur.")
 *         )
 *     )
 * )
 */
    public function index()
    {
        try {
          return response()->json([
            'status_code' => 200,
            'status_message' => 'tous les clients ont été recupéré',
            'data' => Client::all(),
          ]);
        } catch (Exception $e) {
          return response()->json($e);
        }
      }

    /**
     * Show the form for creating a new resource.
     */
   

    /**
     * Store a newly created resource in storage.
     */

     /**
 * @OA\Post(
 *     path="/api/clients",
 *     summary="Ajouter un client",
 *     description="Ajoute un nouveau client.",
 *     operationId="addClient",
 *     tags={"Clients"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/CreateClientRequest")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Client ajouté avec succès.",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status_code", type="integer", example=200),
 *             @OA\Property(property="status_message", type="string", example="Client ajouté."),
 *             @OA\Property(property="data", ref="#/components/schemas/Client")
 *         )
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Erreur de validation des données.",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Les données fournies ne sont pas valides."),
 *             @OA\Property(property="errors", type="object", example={"champ_1": {"message 1", "message 2"}, "champ_2": {"message"}})
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Erreur interne du serveur.",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Erreur interne du serveur.")
 *         )
 *     )
 * )
 */
    public function store(CreateClientRequest $request)
    {
        {
            try {
              $client = new Client();
              $client->nom= $request->nom;
              $client->prenom= $request->prenom;
              $client->code_client= $request->code_client;
              $client->telephone= $request->telephone;
              $client->adresse= $request->adresse;
              $client->save();
        
              return response()->json([
                'status_code' => 200,
                'status_message' => 'client a été ajouté',
                'data' => $client
              ]);
            } catch (Exception $e) {
              return response()->json($e);
            }
          }
    }

    /**
     * Display the specified resource.
     */

     /**
 * @OA\Get(
 *     path="/api/clients/{id}",
 *     summary="Détails d'un client",
 *     description="Récupère les détails d'un client en fonction de l'ID.",
 *     operationId="getClientDetails",
 *     tags={"Clients"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID du client",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Détails du client récupérés avec succès.",
 *         @OA\JsonContent(ref="#/components/schemas/Client")
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Client non trouvé.",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Désolé, pas de client trouvé.")
 *         )
 *     )
 * )
 */
    public function show(string $id)
    {
        try {
            $client = Client::findOrFail($id);
    
            return response()->json($client);
        } catch (Exception) {
            return response()->json(['message' => 'Désolé, pas de client trouvé.'], 404);
        }
    }
    

    /**
     * Show the form for editing the specified resource.
     */

     /**
 * @OA\Put(
 *     path="/api/clients/{id}",
 *     summary="Modifier un client",
 *     description="Modifie les informations d'un client en fonction de l'ID.",
 *     operationId="editClient",
 *     tags={"Clients"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID du client",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/EditClientRequest")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Client modifié avec succès.",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status_code", type="integer", example=200),
 *             @OA\Property(property="status_message", type="string", example="Client modifié."),
 *             @OA\Property(property="data", ref="#/components/schemas/Client")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Client non trouvé.",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Désolé, pas de client trouvé.")
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Erreur interne du serveur.",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Erreur interne du serveur.")
 *         )
 *     )
 * )
 */ 
    public function update(EditClientRequest $request, $id)
    {
         
        try {
        $client = Client::find($id);
        $client->nom= $request->nom;
        $client->prenom= $request->prenom;
        $client->code_client= $request->code_client;
        $client->telephone= $request->telephone;
        $client->adresse= $request->adresse;
        $client->update();
    
          return response()->json([
            'status_code' => 200,
            'status_message' => 'client a été modifié',
            'data' => $client
          ]);
        } catch (Exception $e) {
          return response()->json($e);
        }
      
        }

    /**
     * Remove the specified resource from storage.
     */

     /**
 * @OA\Delete(
 *     path="/api/clients/{id}",
 *     summary="Supprimer un client",
 *     description="Supprime un client en fonction de l'ID.",
 *     operationId="deleteClient",
 *     tags={"Clients"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID du client",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Client supprimé avec succès.",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status_code", type="integer", example=200),
 *             @OA\Property(property="status_message", type="string", example="Client supprimé."),
 *             @OA\Property(property="data", ref="#/components/schemas/Client")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Client non trouvé.",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Désolé, pas de client trouvé.")
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Erreur interne du serveur.",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Erreur interne du serveur.")
 *         )
 *     )
 * )
 */
    public function destroy(string $id)
    {
      try{
        $client = Client::findOrFail($id);

        $client->delete();

        return response()->json([
          'status_code' => 200,
          'status_message' => 'client a été bien supprimer',
          'data' => $client
        ]);
      } catch (Exception $e) {
        return response()->json($e);
      }
    
      }

      public function redirigerWhatsApp($id)
    {
        try {
            if (!is_numeric($id)) {
                throw new Exception('L\'ID doit être numérique.');
            }

            $users = User::findOrFail($id);

            $numeroOriginal = $users->telephone;

            if (empty($numeroOriginal)) {
                throw new Exception("Numéro de téléphone non valide. Numéro original : $numeroOriginal, Numéro nettoyé : $numeroOriginal");
            }

            $urlWhatsApp = "https://api.whatsapp.com/send?phone=$numeroOriginal";

            return redirect()->to($urlWhatsApp);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('whatsapp.userquincaillerie');
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
  }
      

       
    
