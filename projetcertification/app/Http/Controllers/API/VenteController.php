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
      if(isset($request->nomclient))
      {
            $client= new Client();
          
            $client->nom=$request->nom;
            $client->prenom=$request->prenom;
            $client->code_client=$request->code_client;
            $client->telephone=$request->telephone;
            $client->adresse=$request->adresse;
            dd($client);
           
            $client->save();
           
            $vente = new Vente(); 
                    
            $vente->quantite_vendu = $request->quantite_vendu;
            $vente->montant_total = ($request->prixU*$request->quantite_vendu);
            
            $vente->produit_id = $request->produit_id;
          
            $vente->client_id = $client->id;
            
            $vente->user_id = auth()->user()->id;
            
            
            $vente->save();
           
          
            return response()->json([
                  'status_code' => 200,
                  'status_message' => 'vente et client ont été bien ajouté',
                  'client'=>$client,
                  'produit'=> $vente,
                ]);
      }else{
                $vente = new Vente();
                $client= Client::where('id',$request->client_id)->first();         
                $vente->quantite_vendu = $request->quantite_vendu;
                $vente->montant_total = ($request->prixU*$request->quantite_vendu);
                $vente->produit_id = $request->produit_id;
                $vente->client_id = $client->id;
                $vente->user_id = auth()->user()->id;
                $produit=Produit::where('id',$request->produit_id)->first();
                $produit->quantite -=$request->quantitevendu;
                if($vente->save()){
                if($produit->update()){
                return response()->json([
                'status_code' => 200,
                'status_message' => 'vente et produit ont été bien mis à jour',
                'achat' => $vente,
                'produit' => $produit
                ]);
                }else{
                return response()->json([
                'status_code' => 500,
                'status_message' => 'Échec de la mise à jour de l\'achat et du produit',
                  ]);
                }
                }else {
                  return response()->json([
                  'status_code' => 404,
                  'status_message' => 'Produit non trouvé',
                  ], 404);
                        }
                        
      }
                } catch (Exception $e) {
                return response()->json($e);
                }
  }


public function show(string $id)
{
try {
  $produit = Vente::findOrFail($id);

  return response()->json($produit);
} catch (Exception) {
  return response()->json(['message' => 'Désolé, pas de produit trouvé.'], 404);
}
}

/**
* Show the form for editing the specified resource.
*/







  /**
   * Display the specified resource.
   */


  /**
   * Show the form for editing the specified resource.
   */
  public function update(EditVenteRequest $request, Vente $vente)
  {
      try {
          $vente->quantite_vendu = $request->quantite_vendu;
          $vente->montant_total = $request->prixU * $request->quantite_vendu;
          $vente->produit_id = $request->produit_id;
          $vente->client_id = $request->client_id;
          $vente->user_id = auth()->user()->id;
  
          $produit = Produit::findOrFail($request->produit_id);
  
          // Correction : Utiliser l'opérateur -= pour décrémenter la quantité
          $produit->quantite -= $request->quantite_vendu;
          $produit->save();
  
          if ($vente->save()) {
              return response()->json([
                  'status_code' => 200,
                  'status_message' => 'Vente a été modifié',
                  'data' => $vente,
              ]);
          } else {
              return response()->json([
                  'status_code' => 500,
                  'status_message' => 'La modification de la vente a échoué',
                  'data' => $vente,
              ]);
          }
      } catch (Exception $e) {
          return response()->json([
              'status_code' => 500,
              'status_message' => 'Erreur lors de la mise à jour de la vente',
              'error' => $e->getMessage(),
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