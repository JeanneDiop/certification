<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\Vente;
use App\Models\Payement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Payement\EditPayementRequest;
use App\Http\Requests\Payement\CreatePayementRequest;

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

  //  {
  //     public function store(Request $request)
  //     {
  //         // Récupérer la vente associée
  //         $vente = Vente::find($request->vente_id);

  //         // Vérifier si la vente existe
  //         if (!$vente) {
  //             // Gérer le cas où la vente n'est pas trouvée
  //         }

  //         // Créer une nouvelle instance de Payement
  //         $payement = new Payement;
  //         $payement->vente_id = $request->vente_id;
  //         $payement->montant_payement = $request->montant_payement;
  //         $payement->etat = $request->etat;

  //         // Si le statut est "comptant", définir le montant restant à 0
  //         if ($request->etat === 'comptant') {
  //             $payement->montant_restant = 0;
  //         } else {
  //             // Définir le montant restant en fonction de la logique acompte
  //             $payement->montant_restant = $vente->montant_total - $request->montant_payement;
  //         }

  //         // Enregistrez le paiement
  //         $payement->save();

  //         // ... le reste du code
  //     }
  // }
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
  public function show(string $id)
  {
    try {
      $payement = Payement::findOrFail($id);

      return response()->json($payement);
    } catch (Exception) {
      return response()->json(['message' => 'Désolé, pas de payement trouvé.'], 404);
    }
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(EditPayementRequest $request, $id)
  {

    try {
      $payement = Payement::find($id);
      $payement->vente_id = $request->vente_id;
      $payement->montant_payement = $request->montant_payement;
      $payement->montant_restant = $request->montant_restant;
      $payement->statut = $request->statut;
      $payement->save();

      return response()->json([
        'status_code' => 200,
        'status_message' => 'achat a été modifié',
        'data' => $payement
      ]);
    } catch (Exception $e) {
      return response()->json($e);
    }
  }
  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Payement $payement)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    $payement = Payement::findOrFail($id);

    $payement->delete();

    return response('achat  bien supprimé', 200);
  }
}
