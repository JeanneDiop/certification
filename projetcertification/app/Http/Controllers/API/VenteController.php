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

        if ($produit) {
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
  public function update(Request $request, $id)
  {
    try {
      $vente = Vente::find($id);

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


  public function show(string $id)
  {
      try {
          $vente = Vente::findOrFail($id);
  
          return response()->json($vente);
      } catch (Exception) {
          return response()->json(['message' => 'Désolé, pas de vente trouvé.'], 404);
      }
  }



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
