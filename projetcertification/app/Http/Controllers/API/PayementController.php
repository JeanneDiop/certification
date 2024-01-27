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

  /**
   * Update the specified resource in storage.
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