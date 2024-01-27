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

class VenteController extends Controller
{
  /**
   * Display a listing of the resource.
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
  public function store(CreateVenteRequest $request)
  {
      try {
          if (isset($request->nomclient)) {
              $client = new Client();
              $client->nom = $request->nomclient;
              $client->prenom = $request->prenom;
              $client->code_client = $request->code_client;
              $client->telephone = $request->telephone;
              $client->adresse = $request->adresse;
              $client->save();
  
              $vente = new Vente();
              $vente->montant_total = ($request->prixU * $request->quantite_vendu);
              $vente->quantite_vendu = $request->quantite_vendu;
              $vente->produit_id = $request->produit_id;
              $vente->client_id = $client->id;
              $vente->user_id = auth()->user()->id;
              $vente->save();
  
              return response()->json([
                  'status_code' => 200,
                  'status_message' => 'Vente et client ont été bien ajoutés',
                  'client' => $client,
                  'produit' => $vente,
              ]);
          } else {
              $vente = new Vente();
              $client = Client::find($request->client_id);
  
              if ($client) {
                  $vente->quantite_vendu = $request->quantite_vendu;
                  $vente->montant_total = ($request->prixU * $request->quantite_vendu);
                  $vente->produit_id = $request->produit_id;
                  $vente->client_id = $client->id;
                  $vente->user_id = auth()->user()->id;
  
                  $produit = Produit::find($request->produit_id);
  
                  if ($produit) {
                      $produit->quantite -= $request->quantite_vendu;
  
                      if ($vente->save() && $produit->update()) {
                        return response()->json([
                            'status_code' => 200,
                            'status_message' => 'Vente et produit ont été bien mis à jour',
                            'vente' => $vente,
                            'produit' => $produit,
                        ]);
                    } else {
                        return response()->json([
                            'status_code' => 500,
                            'status_message' => 'Échec de la mise à jour de la vente ou du produit',
                        ]);
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
        }
    } catch (Exception $e) {
        return response()->json([
            'status_code' => 500,
            'status_message' => 'Une erreur s\'est produite lors de l\'enregistrement de la vente et du client.',
            'error_details' => $e->getMessage(),
        ]);
    }
}


public function update(EditVenteRequest $request, Vente $vente)
{
    try {
        // Mettez à jour les champs de vente nécessaires en fonction des données de la requête
              $vente->montant_total = ($request->prixU * $request->quantite_vendu);
              $vente->quantite_vendu = $request->quantite_vendu;
              $vente->produit_id = $request->produit_id;
              $vente->client_id = $client->id;
              $vente->user_id = auth()->user()->id;

        // Sauvegardez la vente mise à jour
        if ($vente->save()) {
            // Mise à jour du produit si nécessaire (ajustez selon votre modèle de données)
            $produit = Produit::find($vente->produit_id);

            if ($produit) {
                $produit->quantite -= $request->quantite_vendu;

                if ($produit->update()) {
                    return response()->json([
                        'status_code' => 200,
                        'status_message' => 'Vente et produit ont été bien mis à jour',
                        'vente' => $vente,
                        'produit' => $produit,
                    ]);
                } else {
                    return response()->json([
                        'status_code' => 500,
                        'status_message' => 'Échec de la mise à jour du produit',
                    ]);
                }
            } else {
                return response()->json([
                    'status_code' => 404,
                    'status_message' => 'Produit non trouvé',
                ], 404);
            }
        } else {
            return response()->json([
                'status_code' => 500,
                'status_message' => 'Échec de la mise à jour de la vente',
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
   * Update the specified resource in storage.
   */


  /**
   * Remove the specified resource from storage.
   */


}