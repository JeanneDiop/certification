<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\Vente;
use App\Models\Client;
use App\Models\Produit;
use Illuminate\Http\Request;
use openApi\Annotations as OA;
use App\Models\historiquevente;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests\Vente\EditVenteRequest;
use App\Http\Requests\Vente\CreateVenteRequest;
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

 

//  public function update(EditVenteRequest $request, Vente $vente)
//  {
//      try {
//          $montant_total = 0;
//          $produits = $request->produit;
 
//          foreach ($produits as $produit) {
//              $produitTrouve = Produit::find($produit['id']);
 
//              if (!$produitTrouve) {
//                  return response()->json([
//                      'message' => "Le produit avec l'ID {$produit['id']} n'a pas été trouvé."
//                  ], 404);
//              }
 
//              if ($produit['quantite'] > $produitTrouve->quantite) {
//                  return response()->json([
//                      'message' => "La quantité que vous avez saisie est supérieure à celle restante pour le produit {$produitTrouve->nomproduit}."
//                  ], 422);
//              }
 
//              $montant_total += $produitTrouve->prixU * $produit['quantite'];
//          }
 
//          $vente->client_id = $request->client_id;
//          $vente->montant_total = $montant_total;
//          $vente->user_id = auth('api')->user()->id;
 
//          if ($vente->save()) {
//              foreach ($produits as $produit) {
//                  // Utilisation de where pour récupérer l'enregistrement existant ou null
//                  $historiquevente = historiquevente::where('vente_id', $vente->id)
//                      ->where('produit_id', $produit['id'])
//                      ->first();
 
//                  if (!$historiquevente) {
//                      // Créer un nouvel enregistrement si non trouvé
//                      $historiquevente = new historiquevente();
//                      $historiquevente->vente_id = $vente->id;
//                      $historiquevente->produit_id = $produit['id'];
//                  }
 
//                  $historiquevente->quantite_vendu = $produit['quantite'];
//                  $historiquevente->save();
 
//                  $produitModifier = Produit::find($produit['id']);
 
//                  if ($historiquevente->quantite_vendu > $produit['quantite']) {
//                      // Nouvelle quantité vendue est inférieure à la quantité précédente
//                      $diff = $historiquevente->quantite_vendu - $produit['quantite'];
//                      $produitModifier->quantite += $diff;
//                      $produitModifier->update();
//                  } elseif ($historiquevente->quantite_vendu < $produit['quantite']) {
//                      // Nouvelle quantité vendue est supérieure à la quantité précédente
//                      $diff = $produit['quantite'] - $historiquevente->quantite_vendu;
//                      $produitModifier->quantite -= $diff;
//                      $produitModifier->update();
//                  }
//              }
 
//              return response()->json([
//                  'status_code' => 200,
//                  'status_message' => 'La vente a été bien mise à jour',
//                  'vente' => $vente,
//              ]);
//          }
//      } catch (\Throwable $th) {
//          return response()->json([
//              'message' => 'Une erreur s\'est produite lors de la mise à jour de la vente.'
//          ], 500);
//      }
//  }
 
 
 
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

  public function destroy(string $id)
  {
    try{
      $vente = Vente::findOrFail($id);

      $vente->delete();

      return response()->json([
        'status_code' => 200,
        'status_message' => 'vente a été bien supprimer',
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

  public function store(CreateVenteRequest $request){
    $vente= new Vente();
    $montant_total=0;
    $produits=$request->produit;
    foreach ($produits as $produit) {
      $produitTrouver=Produit::Find($produit['id']);
      if($produit['quantite']>$produitTrouver->quantite){
        return response()->json([
          'message'=>"La quantite que vou avez saisie est superieur à celle restant"
        ]);
      }
      $montant_total += $produitTrouver->prixU * $produit['quantite'];
    }
    $vente->client_id=$request->client_id;
    $vente->montant_total=$montant_total;
    $vente->user_id	= Auth::user()->id;
    if($vente->save()){
    
      foreach ($produits as $produit) {
        $historiqueventes= new 	historiquevente();
        $historiqueventes->vente_id=$vente->id;
        $historiqueventes->quantite_vendu=$produit['quantite'];
        $historiqueventes->produit_id= $produit['id'];
        $produitModifier=Produit::Find($produit['id']);
        $produitModifier->quantite -=$produit['quantite'];
        $produitModifier->save();
        $historiqueventes->save();
      }
      return response()->json([
        'status_code' => 200,
        'status_message' => 'vente a été bien ajouté',
        'vente'=>$vente,
      ]);
     
    }
  }

  public function update(EditVenteRequest $request, $id){
    try {
        $montant_total = 0;
        $produits = $request->produit;

        foreach ($produits as $produit) {
            $produitTrouve = Produit::find($produit['id']);

            if (!$produitTrouve) {
                return response()->json([
                    'message' => "Le produit avec l'ID {$produit['id']} n'a pas été trouvé."
                ], 404);
            }

            if ($produit['quantite'] > $produitTrouve->quantite) {
                return response()->json([
                    'message' => "La quantité que vous avez saisie est supérieure à celle restante pour le produit {$produitTrouve->nomproduit}."
                ], 422);
            }

            $montant_total += $produitTrouve->prixU * $produit['quantite'];
        }

        // Trouver la vente à mettre à jour
        $vente = Vente::find($id);

        // Vérifier si la vente existe
        if (!$vente) {
            return response()->json([
                'message' => 'Vente non trouvée',
            ], 404);
        }

        // Mettre à jour les détails de la vente
        $vente->client_id = $request->client_id;
        $vente->montant_total = $montant_total;
        $vente->user_id = auth('api')->user()->id;
        if ($vente->save()) {
          $historiqueventes=Historiquevente::where('vente_id', $vente->id)->get();
          foreach ( $historiqueventes as  $historiquevente) {
            foreach ($produits as $produit) {    
         
              if($historiquevente->produit_id==$produit['id'] && $historiquevente->quantite_vendu > $produit['quantite'] ){
                $produittr=Produit::find($produit['id']);
                $produittr->quantite += $historiquevente->quantite_vendu - $produit['quantite'];
                $produittr->update();

              }elseif($historiquevente->produit_id==$produit['id'] && $historiquevente->quantite_vendu < $produit['quantite'] ){
                $produittr=Produit::find($produit['id']);
               
                $produittr->quantite -= $produit['quantite'] - $historiquevente->quantite_vendu  ;
                $produittr->update();
              }
            }
            $historiquevente->save();
          }
            

            // Répondre avec succès et renvoyer les détails de la vente mise à jour
            return response()->json([
                'status_code' => 200,
                'status_message' => 'Vente a été bien mise à jour',
                'vente' => $vente,
            ]);

        } else {
            // En cas d'échec de la mise à jour de la vente
            return response()->json([
                'message' => 'Erreur lors de la mise à jour de la vente',
            ], 500);
        }
    } catch (Exception $e) {
        // En cas d'erreur imprévue
        return response()->json([
            'status_code' => 500,
            'status_message' => 'Une erreur s\'est produite lors de la mise à jour de la vente.',
            'error_details' => $e->getMessage(),
        ]);
    }
}


}
