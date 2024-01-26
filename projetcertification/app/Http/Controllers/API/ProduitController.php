<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\Produit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Produit\EditProduitRequest;
use App\Http\Requests\Produit\CreateProduitRequest;

class ProduitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return response()->json([
                'status_code' => 200,
                'status_message' => 'tous les produits ont été recupéré',
                'data' => Produit::all(),
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
    public function store(CreateProduitRequest $request)
    { 
            try
         {
                

                $produit = new Produit();
                $produit->nomproduit = $request->nomproduit;
                $produit->image = $request->image;
                $produit->prixU = $request->prixU;
                $produit->quantiteinitiale=$request->quantiteinitiale;
                $produit->quantiterestante=$request->quantiteinitiale;
                $produit->quantiteseuil = $request->quantiteseuil;
                $produit->etat = $request->etat;
                $produit->categorie_id = $request->categorie_id;
                $produit->save();


                return response()->json([
                    'status_code' => 200,
                    'status_message' => 'produit a été ajouté',
                    'data' => $produit
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
            $produit = Produit::findOrFail($id);

            return response()->json($produit);
        } catch (Exception) {
            return response()->json(['message' => 'Désolé, pas de produit trouvé.'], 404);
        }
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function update(EditProduitRequest $request, $id)
    {

        try {
            $produit = Produit::find($id);
            $produit->nomproduit = $request->nomproduit;
            $produit->image = $request->image;
            $produit->prixU = $request->prixU;
            $produit->quantiteinitiale = $request->quantiteinitiale;
            $produit->quantiteseuil = $request->quantiteseuil;
            $produit->etat = $request->etat;
            $produit->categorie_id = $request->categorie_id;
            $produit->update();

            return response()->json([
                'status_code' => 200,
                'status_message' => 'produit a été modifié',
                'data' => $produit
            ]);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
          $produit = Produit::findOrFail($id);
  
          $produit->delete();
  
          return response()->json([
            'status_code' => 200,
            'status_message' => 'produit a été bien supprimer',
            'data' => $produit
          ]);
        } catch (Exception $e) {
          return response()->json($e);
        }
      
        }

 }
