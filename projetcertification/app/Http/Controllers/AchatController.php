<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Achat;
use Illuminate\Http\Request;
use App\Http\Requests\Achat\EditAchatRequest;
use App\Http\Requests\Achat\CreateAchatRequest;

class AchatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
          return response()->json([
            'status_code' => 200,
            'status_message' => 'tous les achats ont été recupéré',
            'data' => Achat::all(),
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
    public function store(CreateAchatRequest $request)
    {
        
            try {
              $achat = new Achat();
              $achat->prixachat= $request->prixachat;
              $achat->save();
        
              return response()->json([
                'status_code' => 200,
                'status_message' => 'achat a été ajouté',
                'data' => $achat
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
            $produit = Achat::findOrFail($id);
    
            return response()->json($produit);
        } catch (Exception) {
            return response()->json(['message' => 'Désolé, pas de produit trouvé.'], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EditAchatRequest $request, $id)
    {
         
        try {
        $achat = Achat::find($id);
        $achat->prixachat= $request->prixachat;
        $achat->save();
    
          return response()->json([
            'status_code' => 200,
            'status_message' => 'achat a été modifié',
            'data' => $achat
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
    public function destroy(string $id)
    {
        $produit = Achat::findOrFail($id);

        $produit->delete();

        
        return response('achat  bien supprimé', 200);
    }

}