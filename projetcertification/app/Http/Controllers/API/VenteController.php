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
          if($client->save()) {
                $vente = new Vente();
                $vente->quantite_vendu = $request->quantité_vendu;
                $vente->montant_total = $request->montant* $request->quantite_vendu;
                $vente->produit_id = $request->produit_id;
                $vente->client_id = $client->id;
                $vente->user_id = auth()->user()->id;
              if($vente->save()){
                $produit=Produit::where('id',$request->produit_id)->first();
                $produit->quantiterestante-=$vente->quantite_vendu;
                $produit->save();
                return response()->json([
                  'status_code' => 200,
                  'status_message' => 'vente a été ajouté',
                  'data' => $vente
                ]);
              }else{
                return response()->json([
                  'status_code' => 200,
                  'status_message' => 'enregistrement de vente est echoué',
                  'data' => $vente
                ]);
              }
             }else{
              return response()->json([
                'status_code' => 200,
                'status_message' => 'enregistrement du client est echoué',
                'data' => $client
              ]);
             }
      }else{
            $vente = new Vente();
            $vente->quantite_vendu=$request->quantite_vendu;
            $vente->montant_total = $request->montant_total* $request->quantite_vendu;
            $vente->produit_id = $request->produit_id;
            $vente->client_id = $request->client_id;
            $vente->user_id = auth()->user()->id;
            $produit=Produit::where('id',$request->produit_id)->first();
            $produit->quantiterestante +=$request->quantite;
            $vente->save();
            $produit->save();
        
          }
          return response()->json([
            'status_code' => 200,
            'status_message' => 'vente a été ajouté',
            'data' => $vente
          ]);
        

    } catch (Exception $e) {
      return response()->json($e->getMessage());
    }
}


  /**
   * Display the specified resource.
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
   * Show the form for editing the specified resource.
   */
  public function update(EditVenteRequest $request, Vente $vente)
  {

    try {
        $vente->quantite_vendu = $request->quantite_vendu;
        $vente->montant_total = $request->montant_total* $request->quantite_vendu;
        $vente->produit_id = $request->produit_id;
        $vente->client_id = $request->client_id;
        $vente->user_id = auth()->user()->id;
        $produit=Produit::where('id',$request->produit_id)->first();
        $produit->quantiterestante =$produit->quantiteinitiale- $vente->quantite_vendu;
        $produit->save();
        if($vente->update()){
         
          return response()->json([
            'status_code' => 200,
            'status_message' => 'vente a été modifié',
            'data' => $vente
          ]);
        }else{
          return response()->json([
            'status_code'=>200,
            'status_message' => ' la modification du vente a échoué',
            'data' =>$vente
          ]);
        
      
        }
     
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
  // public function destroy(string $id)
  // {
  //     $vente = Vente::findOrFail($id);

  //     $vente->delete();

  //     return response('vente  bien supprimé', 200);
  // }

}