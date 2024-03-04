<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\Vente;
use App\Models\Payement;
use Illuminate\Http\Request;
use openApi\Annotations as OA;
use App\Models\Historiquevente;
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

    //   public function store(CreatePayementRequest $request,Payement $payement)
    //   {
    //       try {
    //           $historiquevente = Historiquevente::with('vente.client', 'produit')->find($request->historiquevente_id);

    //           if (!$historiquevente) {
    //               return response()->json([
    //                   'message' => 'Historique non trouvé',
    //               ], 404);
    //           }

    //           $vente = $historiquevente->vente;
    //           $produit = $historiquevente->produit;

    //           // Informations supplémentaires
    //           $client_id = $vente->client_id;
    //           $montant_total_vente = $vente->montant_total;
    //           $produit_id = $produit->id;

    //           $payement = new Payement();
    //           $payement->historiquevente_id = $request->historiquevente_id;
    //           $payement->montant_payement = $montant_total_vente;
    //           $payement->etat = $request->etat;

    //           // Mise à jour du montant restant si l'état est "acompte"
    //           if ($payement->etat == "comptant") {
    //               $payement->montant_restant = 0;
    //           } elseif ($payement->etat == "acompte") {
    //               $payement->montant_restant = $montant_total_vente - $request->montant_payement;
    //           } else {
    //               // Si l'état n'est ni "comptant" ni "acompte", vous pouvez gérer cela selon vos besoins.
    //               return response()->json([
    //                   'message' => 'Type de paiement non valide',
    //               ], 422);
    //           }

    //           $payement->save();

    //           return response()->json([
    //               'status_code' => 200,
    //               'status_message' => 'Paiement a été ajouté',
    //               'data' => [
    //                   'payement' => $payement,
    //                   'vente' => $vente,
    //                   'client_id' => $client_id,
    //                   'montant_total_vente' => $montant_total_vente,
    //                   'produit_id' => $produit_id,
    //                   // Ajoutez d'autres informations au besoin
    //               ],
    //           ]);

    //       } catch (Exception $e) {
    //           return response()->json($e);
    //       }
    //   }


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

    public function store(CreatePayementRequest $request, Vente $vente)
    {
        $historiques = Historiquevente::Where('vente_id', $vente->id)->get();
        if ($request->etat == 'comptant') {
            if ($vente->montant_total == $request->montantVerser) {
                $montantRestant = 0;
            } else {
                return response()->json([
                    'message' => 'Veuillez verifier le montant saisie'
                ]);
            }
        } elseif ($request->etat == 'acompte') {
            $montantRestant = $vente->montant_total - $request->montantVerser;
        }

        $data =  [];

        foreach ($historiques as $historique) {
            $data[] = [
                'produit_id' => $historique->produit_id
            ];
        }

        $info = [
            'client_id' => $vente->client_id,
            'vente_id' => $vente->id,
            'montantRestant' => $montantRestant,
            'montantVerser' => $request->montantVerser
        ];

        $paiement = new Payement();
        $paiement->montant_payement = $request->montantVerser;
        $paiement->vente_id = $vente->id;
        $paiement->etat = $request->etat;
        $paiement->montant_restant = $montantRestant;
        $paiement->save();

        return response()->json([
           "les produits" => $data,
           "informationPaiement" => $info,
           "idPaiement" => $paiement-> id
        ]);
    }

    public function update(EditPayementRequest $request, $id)
    {
        $vente = Vente::find($id);
    
        if (!$vente) {
            return response()->json([
                'message' => "Aucune vente enregistrée avec l'ID spécifié."
            ]);
        }
    
        $paiement = Payement::where('vente_id', $vente->id)->first();
    
        if (!$paiement) {
            return response()->json([
                'message' => "Aucun paiement associé à cette vente."
            ]);
        }
    
        if ($paiement->etat == "acompte") {
            if ($paiement->montant_restant > 0) {
                $paiement->montant_restant = $vente->montant_total - ($paiement->montant_payement + $request->montantVerser);
                $paiement->montant_payement += $request->montantVerser;
                if ($paiement->save()) {
                    return response()->json([
                        'message' => 'Paiement modifier avec succès',
                        'client_id' => $vente->client_id,
                        'montantVerser' => $request->montantVerser,
                        'payement' => $paiement,
                    ]);
                }
            } else {
                return response()->json([
                    'message' => 'Le paiement est OK, plus de versements à faire.'
                ]);
            }
        } elseif ($paiement->etat == "comptant") {
            $paiement->montant_restant = 0;
            $paiement->montant_payement = $vente->montant_total;
            if ($paiement->save()) {
                return response()->json([
                    'message' => 'Paiement modifier avec succès',
                    'client_id' => $vente->client_id,
                    'montantVerser' => $paiement->montant_payement,
                    'montant_restant' => 0,
                    'paiement' => $paiement
                ]);
            }
        } else {
            return response()->json([
                'message' => 'État de paiement invalide.'
            ], 422);
        }
    }


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

    public function supprimer(string $id)
    {
        try {
            $payement = Payement::find($id);
    
            if (!$payement) {
                return response()->json([
                    'status_code' => 404,
                    'status_message' => "Aucun paiement avec l'ID '$id' n'a été trouvé.",
                ], 404);
            }
    
            // Trouver la vente associée au paiement
            $vente = $payement->vente;
    
            if ($vente) {
                // Supprimer d'abord le paiement
                $payement->delete();
                
                // Ensuite, supprimer la vente
                $vente->delete();
            } else {
                // Si aucune vente associée n'est trouvée, supprimez seulement le paiement
                $payement->delete();
            }
    
            return response()->json([
                'status_code' => 200,
                'status_message' => "Le paiement avec l'ID '$id' et la vente associée ont été supprimés.",
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status_code' => 500,
                'status_message' => 'Une erreur est survenue lors de la suppression du paiement.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    
}
