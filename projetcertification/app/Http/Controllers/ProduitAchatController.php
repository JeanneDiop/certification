<?php

namespace App\Http\Controllers;

use Exception;

use App\Models\Produit_Achat;
use App\Http\Requests\ProduitAchat\EditProduitAchatRequest;
use App\Http\Requests\ProduitAchat\CreateProduitAchatRequest;

class ProduitAchatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
          return response()->json([
            'status_code' => 200,
            'status_message' => 'tous les produit_achats ont été recupéré',
            'data' => Produit_Achat::all(),
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
    public function store(CreateProduitAchatRequest $request)
    {
        try {
            $produitachat = new Produit_Achat();
            $produitachat->quantité_achat = $request->quantité_achat;
            $produitachat->produit_id = $request->produit_id;
            $produitachat->achat_id = $request->achat_id;
            $produitachat->save();
              return response()->json([
                'status_code' => 200,
                'status_message' => 'produit_achat a été ajouté',
                'data' => $produitachat
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
            $produitachat = Produit_Achat::findOrFail($id);
    
            return response()->json($produitachat);
        } catch (Exception) {
            return response()->json(['message' => 'Désolé, pas de produitachat trouvé.'], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(EditProduitAchatRequest $request, $id)
    // {
         
    //     try {
    //       $produitachat = Produit_Achat::find($id);
    //       $produitachat->quantité_achat = $request->quantité_achat;
    //       $produitachat->produit_id = $request->produit_id;
    //       $produitachat->achat_id = $request->achat_id;
    //       $produitachat->save();
    
    //       return response()->json([
    //         'status_code' => 200,
    //         'status_message' => 'produitachat a été modifié',
    //         'data' => $produitachat
    //       ]);
    //     } catch (Exception $e) {
    //       return response()->json($e);
    //     }
      
    //     }
    
    /**
     * Update the specified resource in storage.
     */


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $produit = Produit_Achat::findOrFail($id);

        $produit->delete();

        return response('produitachat  bien supprimé', 200);
    }
}