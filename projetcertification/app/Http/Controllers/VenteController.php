<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Vente;
use Illuminate\Http\Request;
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
      $vente->quantité_vendu = $request->quantité_vendu;
      $vente->montant_total = $request->montant* $request->quantité_vendu;
      $vente->produit_id = $request->produit_id;
      $vente->client_id = $request->client_id;
      $vente->user_id = $request->user_id;
      $vente->save();

      return response()->json([
        'status_code' => 200,
        'status_message' => 'vente a été ajouté',
        'data' => $vente
      ]);
    } catch (Exception $e) {
      return response()->json($e);
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
  public function edit(EditVenteRequest $request, $id)
  {

    try {
      $vente = Vente::find($id);
      $vente->quantité_vendu = $request->quantité_vendu;
      $vente->montant_total = $request->montant_total;
      $vente->produit_id = $request->produit_id;
      $vente->client_id = $request->client_id;
      $vente->user_id = $request->user_id;
      $vente->save();

      return response()->json([
        'status_code' => 200,
        'status_message' => 'vente a été modifié',
        'data' => $vente
      ]);
    } catch (Exception $e) {
      return response()->json($e);
    }
  }
  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Vente $vente)
  {
    //
  }

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