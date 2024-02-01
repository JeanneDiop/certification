<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\Vente;
use App\Models\Payement;
use Illuminate\Http\Request;
use openApi\Annotations as OA;
use App\Models\historiquevente;
use App\Http\Controllers\Controller;

use App\Http\Requests\Payement\EditPayementRequest;
use App\Http\Requests\Payement\CreatePayementRequest;
use App\Http\Requests\Payement\EditPayementAcompteRequest;
use App\Http\Requests\Payement\CreatePayementAcompteRequest;
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
public function listerpayementcomptant()
{
    try {
        $payements = Payement::where('etat', 'comptant')->get();

        return response()->json([
            'status_code' => 200,
            'status_message' => 'Tous les paiements avec l\'état "comptant" ont été récupérés',
            'data' => $payements,
        ]);
    } catch (Exception $e) {
        return response()->json($e);
    }
}

public function listerpayementacompte()
{
    try {
        $payements = Payement::where('etat', 'acompte')->get();

        return response()->json([
            'status_code' => 200,
            'status_message' => 'Tous les paiements avec l\'état "acompte" ont été récupérés',
            'data' => $payements,
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

  public function store(CreatePayementRequest $request,Payement $payement)
  {
      try {
          $historiquevente = historiquevente::with('vente.client', 'produit')->find($request->historiquevente_id);
  
          if (!$historiquevente) {
              return response()->json([
                  'message' => 'Historique non trouvé',
              ], 404);
          }
  
          $vente = $historiquevente->vente;
          $produit = $historiquevente->produit;
  
          // Informations supplémentaires
          $client_id = $vente->client_id;
          $montant_total_vente = $vente->montant_total;
          $produit_id = $produit->id;
  
          $payement = new Payement();
          $payement->historiquevente_id = $request->historiquevente_id;
          $payement->montant_payement = $montant_total_vente;
          $payement->etat = $request->etat;
  
          // Mise à jour du montant restant si l'état est "acompte"
          if ($payement->etat == "comptant") {
              $payement->montant_restant = 0;
          } elseif ($payement->etat == "acompte") {
              $payement->montant_restant = $montant_total_vente - $request->montant_payement;
          } else {
              // Si l'état n'est ni "comptant" ni "acompte", vous pouvez gérer cela selon vos besoins.
              return response()->json([
                  'message' => 'Type de paiement non valide',
              ], 422);
          }
  
          $payement->save();
  
          return response()->json([
              'status_code' => 200,
              'status_message' => 'Paiement a été ajouté',
              'data' => [
                  'payement' => $payement,
                  'vente' => $vente,
                  'client_id' => $client_id,
                  'montant_total_vente' => $montant_total_vente,
                  'produit_id' => $produit_id,
                  // Ajoutez d'autres informations au besoin
              ],
          ]);
  
      } catch (Exception $e) {
          return response()->json($e);
      }
  }
  

// public function payementacompte(CreatePayementAcompteRequest $request)
// {
//     try {
//         $historiquevente = historiquevente::with('vente.client', 'produit')->find($request->historiquevente_id);

//         if (!$historiquevente) {
//             return response()->json([
//                 'message' => 'Historique non trouvé',
//             ], 404);
//         }

//         $vente = $historiquevente->vente;
//         $produit = $historiquevente->produit;

//         // Informations supplémentaires
//         $client_id = $vente->client_id;
//         $montant_total = $vente->montant_total;
//         $produit_id = $produit->id;

//         $payement = new Payement();
//         $payement->historiquevente_id = $request->historiquevente_id;
//         $payement->montant_payement = $request->montant_payement;
//         $payement->etat = $request->etat;
//         $payement->etat ==="acompte";
//           $payement->montant_restant = $montant_total - $request->montant_payement;
//         $payement->save();

//         return response()->json([
//             'status_code' => 200,
//             'status_message' => 'Paiement a été ajouté',
//             'data' => [
//                 'payement' => $payement,
//                 'vente' => $vente,
//                 'client_id' => $client_id,
//                 'montant_total' => $montant_total,
//                 'produit_id' => $produit_id,
//                 // Ajoutez d'autres informations au besoin
//             ],
//         ]);

//     } catch (Exception $e) {
//         return response()->json($e);
//     }
// }
  


  /**
   * Display the specified resource.
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
         $historiquevente = historiquevente::with('vente.client', 'produit')->find($payement->historiquevente_id);
 
         if (!$historiquevente) {
             return response()->json([
                 'message' => 'Historique non trouvé',
             ], 404);
         }
 
         $vente = $historiquevente->vente;
         $produit = $historiquevente->produit;
 
         // Informations supplémentaires
         $client_id = $vente->client_id;
         $montant_total_vente = $vente->montant_total;
         $produit_id = $produit->id;
 
         // Mise à jour du paiement
         $payement->montant_payement = $request->montant_payement;
         $payement->etat = $request->etat;
 
         // Mise à jour du montant restant en fonction du type de paiement
         if ($request->etat == "acompte") {
             $payement->montant_restant = $montant_total_vente - $request->montant_payement;
         } elseif ($request->etat == "comptant") {
             // Condition spécifique si le paiement est de type "comptant"
             $payement->montant_restant = 0;
             $payement->montant_payement = $montant_total_vente;
         } else {
             // Si l'état n'est ni "comptant" ni "acompte", vous pouvez gérer cela selon vos besoins.
             return response()->json([
                 'message' => 'Type de paiement non valide',
             ], 422);
         }
 
         $payement->update();
 
         return response()->json([
             'status_code' => 200,
             'status_message' => 'Paiement a été mis à jour',
             'data' => [
                 'payement' => $payement,
                 'vente' => $vente,
                 'client_id' => $client_id,
                 'montant_total_vente' => $montant_total_vente,
                 'produit_id' => $produit_id,
                 // Ajoutez d'autres informations au besoin
             ],
         ]);
 
     } catch (Exception $e) {
         return response()->json($e);
     }
 }
 


 public function modifierpayementcomptant(EditPayementRequest $request, $id)
 {
     try {
         $payement = Payement::find($id);
 
         if (!$payement) {
             return response()->json([
                 'message' => 'Paiement non trouvé',
             ], 404);
         }
 
         $historiquevente = historiquevente::with('vente.client', 'produit')->find($payement->historiquevente_id);
 
         if (!$historiquevente) {
             return response()->json([
                 'message' => 'Historique non trouvé',
             ], 404);
         }
 
         $vente = $historiquevente->vente;
         $produit = $historiquevente->produit;
 
         // Informations supplémentaires
         $client_id = $vente->client_id;
         $montant_total_vente = $vente->montant_total;
         $produit_id = $produit->id;
 
         // Mise à jour du paiement
         $payement->montant_payement = $montant_total_vente;
         $payement->etat = $request->etat;
 
         // Mise à jour du montant restant si l'état est "acompte"
         $payement->etat == "comptant";
         $payement->montant_restant = 0;
         $payement->update();
 
         return response()->json([
             'status_code' => 200,
             'status_message' => 'Paiement a été mis à jour',
             'data' => [
                 'payement' => $payement,
                 'vente' => $vente,
                 'client_id' => $client_id,
                 'montant_total' => $montant_total_vente,
                 'produit_id' => $produit_id,
                 // Ajoutez d'autres informations au besoin
             ],
         ]);
 
     } catch (Exception $e) {
         return response()->json($e);
     }
 }
 
   
   public function supprimer(Payement $payement)
{
     try{
       $payement->delete();
 
       return response()->json([
         'status_code' => 200,
         'status_message' => 'payement a été bien supprimer',
         'data' => $payement
       ]);
     } catch (Exception $e) {
       return response()->json($e);
     }
}


public function destroy($etat)
{
    try {
        $payement = Payement::where('etat', $etat)->first();

        if (!$payement) {
            return response()->json([
                'status_code' => 404,
                'status_message' => "Aucun paiement avec l'état '$etat' n'a été trouvé.",
            ], 404);
        }
        $payement->delete();

        return response()->json([
            'status_code' => 200,
            'status_message' => "Le paiement avec l'état '$etat' a été supprimé",
            'data' => $payement,
        ]);
    } catch (Exception $e) {
        return response()->json($e);
    }
}
}