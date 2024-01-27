<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\Vente;
use App\Models\Payement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Payement\EditPayementRequest;
use App\Http\Requests\Payement\CreatePayementRequest;
use openApi\Annotations as OA;
/**
 
*@OA\Info(title="endpointPayement", version="0.1")*/
class PayementController extends Controller
{
  /**
   * Display a listing of the resource.
   */

   /**
 * @OA\Get(
 *      path="/api/payements",
 *      operationId="getPayements",
 *      tags={"Payements"},
 *      summary="Obtenir la liste de tous les payements",
 *      description="Retourne la liste de tous les payements.",
 *      @OA\Response(
 *          response=200,
 *          description="Opération réussie",
 *          @OA\JsonContent(
 *              @OA\Property(property="status_code", type="integer", example=200),
 *              @OA\Property(property="status_message", type="string", example="Tous les payements ont été récupérés"),
 *              @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Payement")),
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
 * Récupère tous les payements.
 *
 * Cette fonction retourne la liste de tous les payements.
 *
 * @return \Illuminate\Http\JsonResponse
 */
  public function index()
  {
    try {
      return response()->json([
        'status_code' => 200,
        'status_message' => 'tous les payements ont été recupéré',
        'data' => Payement::all(),
      ]);
    } catch (Exception $e) {
      return response()->json($e);
    }
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   */

  /**
   * @OA\Post(
   *      path="/api/payements",
   *      operationId="createPayement",
   *      tags={"Payements"},
   *      summary="Créer un nouveau paiement",
   *      description="Crée un nouveau paiement avec les données fournies dans la requête.",
   *      @OA\RequestBody(
   *          required=true,
   *          description="Données du paiement à créer",
   *          @OA\JsonContent(ref="#/components/schemas/CreatePayementRequest")
   *      ),
   *      @OA\Response(
   *          response=200,
   *          description="Opération réussie",
   *          @OA\JsonContent(
   *              @OA\Property(property="status_code", type="integer", example=200),
   *              @OA\Property(property="status_message", type="string", example="Paiement ajouté avec succès"),
   *              @OA\Property(property="data", ref="#/components/schemas/Payement"),
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
   * Crée un nouveau paiement.
   *
   * Cette fonction crée un nouveau paiement avec les données fournies dans la requête.
   *
   * @param  \App\Http\Requests\CreatePayementRequest  $request
   * @return \Illuminate\Http\JsonResponse
   */
 
  public function store(CreatePayementRequest $request)
  { 
       try {
        $vente = Vente::where('id', $request->vente_id)->first();
        $payement = new Payement();
        $payement->vente_id = $request->vente_id;
        $payement->montant_payement = $request->montant_payement;
        $payement->etat = $request->etat;
        if ($payement->etat=="comptant") {
          $payement->montant_restant = 0;
        } else {
          $payement->montant_restant = $vente->montant_total - $request->montant_payement;
        }
        $payement->save();

        return response()->json([
          'status_code' => 200,
          'status_message' => 'payement a été ajouté',
          'data' => $payement
        ]);
      } catch (Exception $e) {
        return response()->json($e);
      }
    }
  


  /**
   * Display the specified resource.
   */

   /**
 * @OA\Get(
 *      path="/api/payements/{payement}",
 *      operationId="getPayementById",
 *      tags={"Payements"},
 *      summary="Obtenir un paiement par ID",
 *      description="Retourne un paiement spécifié par son identifiant.",
 *      @OA\Parameter(
 *          name="payement",
 *          required=true,
 *          in="path",
 *          description="ID du paiement",
 *          @OA\Schema(type="string")
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="Opération réussie",
 *          @OA\JsonContent(ref="#/components/schemas/Payement"),
 *      ),
 *      @OA\Response(
 *          response=404,
 *          description="Paiement non trouvé",
 *          @OA\JsonContent(
 *              @OA\Property(property="message", type="string", example="Désolé, pas de paiement trouvé."),
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
 * Obtient un paiement par ID.
 *
 * Cette fonction retourne un paiement spécifié par son identifiant.
 *
 * @param  string  $payement
 * @return \Illuminate\Http\JsonResponse
 */
  public function show(string $payement)
  {
    try {
      $payement = Payement::findOrFail($payement);

      return response()->json($payement);
    } catch (Exception) {
      return response()->json(['message' => 'Désolé, pas de payement trouvé.'], 404);
    }
  }

  /**
   * Show the form for editing the specified resource.
   */

  /**
   * Update the specified resource in storage.
   */

   /**
 * @OA\Put(
 *      path="/api/payements/{payement}",
 *      operationId="updatePayement",
 *      tags={"Payements"},
 *      summary="Modifier un paiement par ID",
 *      description="Modifie un paiement spécifié par son identifiant avec les données fournies dans la requête.",
 *      @OA\Parameter(
 *          name="payement",
 *          required=true,
 *          in="path",
 *          description="ID du paiement",
 *          @OA\Schema(type="string")
 *      ),
 *      @OA\RequestBody(
 *          required=true,
 *          description="Données du paiement à modifier",
 *          @OA\JsonContent(ref="#/components/schemas/EditPayementRequest")
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="Opération réussie",
 *          @OA\JsonContent(
 *              @OA\Property(property="status_code", type="integer", example=200),
 *              @OA\Property(property="status_message", type="string", example="Paiement mis à jour avec succès"),
 *              @OA\Property(property="data", ref="#/components/schemas/Payement"),
 *          ),
 *      ),
 *      @OA\Response(
 *          response=404,
 *          description="Paiement non trouvé",
 *          @OA\JsonContent(
 *              @OA\Property(property="message", type="string", example="Le paiement avec l'ID spécifié n'a pas été trouvé."),
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
 * Modifie un paiement par ID.
 *
 * Cette fonction modifie un paiement spécifié par son identifiant avec les données fournies dans la requête.
 *
 * @param  \App\Http\Requests\EditPayementRequest  $request
 * @param  \App\Models\Payement  $payement
 * @return \Illuminate\Http\JsonResponse
 */
 
   public function update(EditPayementRequest $request, Payement $payement)
   {
       try {
           // Récupérer la vente associée
           $vente = $payement->vente;
   
           // Mettre à jour les champs du payement
           $payement->montant_payement = $request->montant_payement;
           $payement->etat = $request->etat;
   
           // Mettre à jour le montant_restant basé sur les nouvelles valeurs
           if ($payement->etat == "comptant") {
               $payement->montant_restant = 0;
           } else {
               $payement->montant_restant = $vente->montant_total - $request->montant_payement;
           }
   
           // Sauvegarder les modifications du payement
           $payement->save();
   
          //  // Mettre à jour les champs de la vente associée
          //  $vente->save(); // Assurez-vous que votre modèle Vente est correctement défini pour la mise à jour.
   
           return response()->json([
               'status_code' => 200,
               'status_message' => 'Le payement a été mis à jour avec succès',
               'data' => $payement
           ]);
       } catch (Exception $e) {
           // Gérer d'autres exceptions ici si nécessaire
           return response()->json(['error' => $e->getMessage()], 500);
       }
   
       // Si nous sommes arrivés ici, le modèle n'a pas été trouvé
       return response()->json(['error' => 'Le payement avec l\'ID spécifié n\'a pas été trouvé.'], 404);
   }

   /**
 * @OA\Delete(
 *      path="/api/payements/{payement}",
 *      operationId="deletePayement",
 *      tags={"Payements"},
 *      summary="Supprimer un paiement par ID",
 *      description="Supprime un paiement spécifié par son identifiant.",
 *      @OA\Parameter(
 *          name="payement",
 *          required=true,
 *          in="path",
 *          description="ID du paiement",
 *          @OA\Schema(type="string")
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="Opération réussie",
 *          @OA\JsonContent(
 *              @OA\Property(property="status_code", type="integer", example=200),
 *              @OA\Property(property="status_message", type="string", example="Paiement supprimé avec succès"),
 *              @OA\Property(property="data", ref="#/components/schemas/Payement"),
 *          ),
 *      ),
 *      @OA\Response(
 *          response=404,
 *          description="Paiement non trouvé",
 *          @OA\JsonContent(
 *              @OA\Property(property="message", type="string", example="Le paiement avec l'ID spécifié n'a pas été trouvé."),
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
 * Supprime un paiement par ID.
 *
 * Cette fonction supprime un paiement spécifié par son identifiant.
 *
 * @param  \App\Models\Payement  $payement
 * @return \Illuminate\Http\JsonResponse
 */
   
   public function destroy(Payement $payement)
   {
     try{
       $payement->delete();
 
       return response()->json([
         'status_code' => 200,
         'status_message' => 'achat a été bien supprimer',
         'data' => $payement
       ]);
     } catch (Exception $e) {
       return response()->json($e);
     }
}
}