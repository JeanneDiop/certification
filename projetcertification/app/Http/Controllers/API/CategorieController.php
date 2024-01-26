<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\Categorie;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Categorie\EditCategorieRequest;
use App\Http\Requests\Categorie\CreateCategorieRequest;

class CategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      try {
        return response()->json([
          'status_code' => 200,
          'status_message' => 'tous les categories ont été recupéré',
          'data' => Categorie::all(),
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
    public function store(CreateCategorieRequest $request)
    {
        {
            {
                try {
                  $produit = new Categorie();
                  $produit->nom = $request->nom;
                  $produit->save();
            
                  return response()->json([
                    'status_code' => 200,
                    'status_message' => 'categorie a été ajouté avec succés',
                    'data' => $produit
                  ]);
                } catch (Exception $e) {
                  return response()->json($e);
                }
              }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
      try {
          $categorie = Categorie::findOrFail($id);
  
          return response()->json($categorie);
      } catch (Exception) {
          return response()->json(['message' => 'Désolé, pas de categorie trouvé.'], 404);
      }
  }

    /**
     * Show the form for editing the specified resource.
     */
   

    /**
     * Update the specified resource in storage.
     */
    public function update(EditCategorieRequest $request,$id)
    {
        
            
                try 
                {
                  $produit = Categorie::find($id);
                  $produit->nom = $request->nom;
                  $produit->save();
            
                  return response()->json([
                    'status_code' => 200,
                    'status_message' => 'categorie a été modifié avec succés',
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
        $categorie = Categorie::findOrFail($id);

        $categorie->delete();
  
        return response()->json([
          'status_code' => 200,
          'status_message' => 'categorie a été supprimé avec succés',
          'data' => $categorie
        ]);

      }catch (Exception $e) {
        return response()->json($e);

      }
     
  }
}