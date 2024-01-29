<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\Vente;
use App\Models\Client;
use App\Models\Produit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Vente\EditVenteRequest;
use App\Http\Requests\Vente\CreateVenteRequest;
use openApi\Annotations as OA;
/**
 
*@OA\Info(title="endpointCandidature", version="0.1")*/
class VenteController extends Controller
{
  /**
   * Display a listing of the resource.
   */

   /**
 * @OA\Get(
 *      path="/api/ventes",
 *      operationId="getVentes",
 *      tags={"Ventes"},
 *      summary="Obtenir la liste de toutes les ventes",
 *      description="Retourne la liste de toutes les ventes.",
 *      @OA\Response(
 *          response=200,
 *          description="Opération réussie",
 *          @OA\JsonContent(
 *              @OA\Property(property="status_code", type="integer", example=200),
 *              @OA\Property(property="status_message", type="string", example="Toutes les ventes ont été récupérées"),
 *              @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Vente")),
 *          ),
 *      ),
 *      @OA\Response(
 *          response=500,
 *          description="Erreur interne du serveur",
 *          @OA\JsonContent(
 *              @OA\Property(property="message", type="string", example="Internal Server Error"),
 *          ),
 *      ),
 * )
 *
 * Obtient la liste de toutes les ventes.
 *
 * Cette fonction retourne la liste de toutes les ventes.
 *
 * @return \Illuminate\Http\JsonResponse
 */
  public function index()
  {
    try {
      return response()->json([
        'status_code' => 200,
        'status_message' => 'tous les ventes ont été recupéré',
        'data' => Vente::all(),
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
 *      path="/api/ventes",
 *      operationId="createVente",
 *      tags={"Ventes"},
 *      summary="Créer une nouvelle vente",
 *      description="Enregistre une nouvelle vente avec les informations fournies dans la requête.",
 *      @OA\RequestBody(
 *          required=true,
 *          description="Données de la vente à créer",
 *          @OA\JsonContent(ref="#/components/schemas/CreateVenteRequest")
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="Opération réussie",
 *          @OA\JsonContent(
 *              @OA\Property(property="status_code", type="integer", example=200),
 *              @OA\Property(property="status_message", type="string", example="Vente ajoutée avec succès et produit mis à jour"),
 *              @OA\Property(property="vente", ref="#/components/schemas/Vente"),
 *              @OA\Property(property="produit", ref="#/components/schemas/Produit"),
 *          ),
 *      ),
 *      @OA\Response(
 *          response=404,
 *          description="Client ou produit non trouvé",
 *          @OA\JsonContent(
 *              @OA\Property(property="status_code", type="integer", example=404),
 *              @OA\Property(property="status_message", type="string", example="Client ou produit non trouvé"),
 *          ),
 *      ),
 *      @OA\Response(
 *          response=500,
 *          description="Erreur interne du serveur",
 *          @OA\JsonContent(
 *              @OA\Property(property="status_code", type="integer", example=500),
 *              @OA\Property(property="status_message", type="string", example="Échec de la mise à jour de la vente ou du produit"),
 *          ),
 *      ),
 * )
 *
 * Crée une nouvelle vente.
 *
 * Cette fonction enregistre une nouvelle vente avec les informations fournies dans la requête. Elle met également à jour la quantité du produit vendu.
 *
 * @param  \App\Http\Requests\CreateVenteRequest  $request
 * @return \Illuminate\Http\JsonResponse
 */
  public function store(CreateVenteRequest $request)
  {

    try {

      $vente = new Vente();
      $client = Client::find($request->client_id);

      if ($client) {
        $produit = Produit::where('id', $request->produit_id)->first();
        $vente->quantite_vendu = $request->quantite_vendu;
        $vente->montant_total = ($produit->prixU * $request->quantite_vendu);
        $vente->produit_id = $request->produit_id;
        $vente->client_id = $client->id;
        $vente->user_id = auth()->user()->id;

        $produit = Produit::find($request->produit_id);
       //si le produit est trouvé
        if ($produit) {
        //ici on verifie d'abord si la quantite vendue est sup a la quantite en stock si c'est vrai on effectue pas l'insertion sinon on insere
         if( $produit->quantite < $request->quantite_vendu){
          return response()->json([
              'status_code' => 200,
              'status_message' => 'vous ne pouvez pas effectuer de vente car la quantité en stock est inferieur à la quantité que tu veux vendre',
            ]);
       }else{
          $produit->quantite -= $request->quantite_vendu;

          if ($vente->save() && $produit->update()) {
            return response()->json([
              'status_code' => 200,
              'status_message' => 'Vente a été ajouté et produit a été mis à jour',
              'vente' => $vente,
              'produit' => $produit,
            ]);
          } else {
            return response()->json([
              'status_code' => 500,
              'status_message' => 'Échec de la mise à jour de la vente ou du produit',
            ]);
          }
        }
        } else {
          return response()->json([
            'status_code' => 404,
            'status_message' => 'Produit non trouvé',
          ], 404);
        }
      } else {
        return response()->json([
          'status_code' => 404,
          'status_message' => 'Client non trouvé',
        ], 404);
      }
    } catch (Exception $e) {
      return response()->json([
        'status_code' => 500,
        'status_message' => 'Une erreur s\'est produite lors de l\'enregistrement de la vente et du client.',
        'error_details' => $e->getMessage(),
      ]);
    }
  }

  /**
 * @OA\Put(
 *      path="/api/ventes/{vente}",
 *      operationId="updateVente",
 *      tags={"Ventes"},
 *      summary="Mettre à jour une vente existante",
 *      description="Met à jour une vente existante avec les informations fournies dans la requête.",
 *      @OA\Parameter(
 *          name="vente",
 *          in="path",
 *          required=true,
 *          description="ID de la vente à mettre à jour",
 *          @OA\Schema(type="integer")
 *      ),
 *      @OA\RequestBody(
 *          required=true,
 *          description="Données de la vente à mettre à jour",
 *          @OA\JsonContent(ref="#/components/schemas/EditVenteRequest")
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="Opération réussie",
 *          @OA\JsonContent(
 *              @OA\Property(property="status_code", type="integer", example=200),
 *              @OA\Property(property="status_message", type="string", example="Vente mise à jour avec succès"),
 *              @OA\Property(property="vente", ref="#/components/schemas/Vente"),
 *              @OA\Property(property="produit", ref="#/components/schemas/Produit"),
 *          ),
 *      ),
 *      @OA\Response(
 *          response=404,
 *          description="Vente, client ou produit non trouvé",
 *          @OA\JsonContent(
 *              @OA\Property(property="status_code", type="integer", example=404),
 *              @OA\Property(property="status_message", type="string", example="Vente, client ou produit non trouvé"),
 *          ),
 *      ),
 *      @OA\Response(
 *          response=500,
 *          description="Erreur interne du serveur",
 *          @OA\JsonContent(
 *              @OA\Property(property="status_code", type="integer", example=500),
 *              @OA\Property(property="status_message", type="string", example="Échec de la mise à jour de la vente ou du produit"),
 *          ),
 *      ),
 * )
 *
 * Met à jour une vente existante.
 *
 * Cette fonction met à jour une vente existante avec les informations fournies dans la requête. Elle ajuste également la quantité du produit vendu en conséquence.
 *
 * @param  \App\Http\Requests\EditVenteRequest  $request
 * @param  \App\Models\Vente  $vente
 * @return \Illuminate\Http\JsonResponse
 */

  public function update(EditVenteRequest $request, Vente $vente)
  {
    try {
      $vente = Vente::find($vente);

      if (!$vente) {
        return response()->json([
          'status_code' => 404,
          'status_message' => 'Vente non trouvée',
        ], 404);
      }

      $client = Client::find($request->client_id);

      if (!$client) {
        return response()->json([
          'status_code' => 404,
          'status_message' => 'Client non trouvé',
        ], 404);
      }

      $produit = Produit::find($vente->produit_id);

      if (!$produit) {
        return response()->json([
          'status_code' => 404,
          'status_message' => 'Produit non trouvé',
        ], 404);
      }
      if($vente->quantite_vendu > $request->quantite_vendu){
  
        $diff=$vente->quantite_vendu - $request->quantite_vendu;
        $produit->quantite +=$diff;
      }elseif($vente->quantite_vendu < $request->quantite_vendu){
        $diff= $request->quantite_vendu - $vente->quantite_vendu;
        $produit->quantite -=$diff;
      }
      $vente->quantite_vendu=$request->quantite_vendu;
      $vente->montant_total = ($produit->prixU * $request->quantite_vendu);
      $vente->produit_id = $request->produit_id;
      $vente->client_id = $client->id;
      $vente->user_id = auth()->user()->id;

   
      if ($vente->save() && $produit->update()) {
        return response()->json([
          'status_code' => 200,
          'status_message' => 'Vente mise à jour avec succès',
          'vente' => $vente,
          'produit' => $produit,
        ]);
      } else {
        return response()->json([
          'status_code' => 500,
          'status_message' => 'Échec de la mise à jour de la vente ou du produit',
        ]);
      }
    } catch (Exception $e) {
      return response()->json([
        'status_code' => 500,
        'status_message' => 'Une erreur s\'est produite lors de la mise à jour de la vente.',
        'error_details' => $e->getMessage(),
      ]);
    }
  }
/**
 * @OA\Get(
 *      path="/api/ventes/{id}",
 *      operationId="getVenteById",
 *      tags={"Ventes"},
 *      summary="Obtenir une vente par ID",
 *      description="Retourne les informations d'une vente en fonction de son ID.",
 *      @OA\Parameter(
 *          name="id",
 *          in="path",
 *          required=true,
 *          description="ID de la vente à récupérer",
 *          @OA\Schema(type="integer")
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="Opération réussie",
 *          @OA\JsonContent(
 *              @OA\Property(property="status_code", type="integer", example=200),
 *              @OA\Property(property="status_message", type="string", example="Vente récupérée avec succès"),
 *              @OA\Property(property="data", ref="#/components/schemas/Vente"),
 *          ),
 *      ),
 *      @OA\Response(
 *          response=404,
 *          description="Vente non trouvée",
 *          @OA\JsonContent(
 *              @OA\Property(property="status_code", type="integer", example=404),
 *              @OA\Property(property="status_message", type="string", example="Désolé, pas de vente trouvé."),
 *          ),
 *      ),
 * )
 *
 * Obtenir une vente par ID.
 *
 * Cette fonction retourne les informations d'une vente en fonction de son ID. Si la vente est trouvée, elle est renvoyée avec un code de statut 200. Sinon, une réponse avec un code de statut 404 est renvoyée indiquant que la vente n'a pas été trouvée.
 *
 * @param  string  $id
 * @return \Illuminate\Http\JsonResponse
 */

  public function show(string $id)
  {
      try {
          $vente = Vente::findOrFail($id);
  
          return response()->json($vente);
      } catch (Exception) {
          return response()->json(['message' => 'Désolé, pas de vente trouvé.'], 404);
      }
  }

/**
 * @OA\Delete(
 *      path="/api/ventes/{vente}",
 *      operationId="deleteVente",
 *      tags={"Ventes"},
 *      summary="Supprimer une vente",
 *      description="Supprime une vente en fonction de son ID.",
 *      @OA\Parameter(
 *          name="vente",
 *          in="path",
 *          required=true,
 *          description="ID de la vente à supprimer",
 *          @OA\Schema(type="integer")
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="Opération réussie",
 *          @OA\JsonContent(
 *              @OA\Property(property="status_code", type="integer", example=200),
 *              @OA\Property(property="status_message", type="string", example="Vente supprimée avec succès"),
 *              @OA\Property(property="data", ref="#/components/schemas/Vente"),
 *          ),
 *      ),
 *      @OA\Response(
 *          response=404,
 *          description="Vente non trouvée",
 *          @OA\JsonContent(
 *              @OA\Property(property="status_code", type="integer", example=404),
 *              @OA\Property(property="status_message", type="string", example="Vente non trouvée"),
 *          ),
 *      ),
 *      @OA\Response(
 *          response=500,
 *          description="Erreur interne du serveur",
 *          @OA\JsonContent(
 *              @OA\Property(property="status_code", type="integer", example=500),
 *              @OA\Property(property="status_message", type="string", example="Échec de la suppression de la vente"),
 *          ),
 *      ),
 * )
 *
 * Supprimer une vente.
 *
 * Cette fonction supprime une vente en fonction de son ID. Si la vente est trouvée et supprimée avec succès, elle renvoie une réponse avec un code de statut 200. Si la vente n'est pas trouvée, une réponse avec un code de statut 404 est renvoyée. En cas d'échec de la suppression, une réponse avec un code de statut 500 est renvoyée.
 *
 * @param  \App\Models\Vente  $vente
 * @return \Illuminate\Http\JsonResponse
 */

  public function destroy(Vente $vente)
  {
    try{
      $vente->delete();

      return response()->json([
        'status_code' => 200,
        'status_message' => 'achat a été bien supprimer',
        'data' => $vente
      ]);
    } catch (Exception $e) {
      return response()->json($e);
    }
  
    }




  /**
   * Update the specified resource in storage.
   */


  /**
   * Remove the specified resource from storage.
   */
}
