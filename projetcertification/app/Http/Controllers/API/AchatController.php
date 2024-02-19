<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\Achat;
use App\Models\Produit;
use Illuminate\Http\Request;
use openApi\Annotations as OA;
use App\Http\Controllers\Controller;
use App\Http\Requests\Achat\EditAchatRequest;
use App\Http\Requests\Achat\CreateAchatRequest;
use App\Http\Requests\Achat\SupprimerAchatRequest;


/**
 
*@OA\Info(title="endpointAchat", version="0.1")*/
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


//     /**
//      * Show the form for creating a new resource.
//      */

//     /**
//      * Store a newly created resource in storage.
//      */


    public function store(CreateAchatRequest $request)
    {
        try 
          {
          
                $achat = new Achat();

                $achat->montantachat=($request->prixachat*$request->quantiteachat);
                $achat->nomachat= $request->nomachat;
                $achat->prixachat= $request->prixachat;
                $achat->quantiteachat=$request->quantiteachat;
                $achat->produit_id= $request->produit_id;
                $produit=Produit::where('id',$request->produit_id)->first();
                $produit->quantite +=$request->quantiteachat;
                if($achat->save()){
                if($produit->update()){
                    return response()->json([
                      'status_code' => 200,
                      'status_message' => 'Achat et produit ont été bien ajouté',
                      'achat' => $achat,
                      'produit' => $produit
                  ]);
                  }else{
                    return response()->json([
                      'status_code' => 500,
                      'status_message' => 'Échec de la mise à jour de l\'achat et du produit',
                      'achat' => $achat,
                      'produit' => $produit
                  ]);
                  }
                }else {
                  return response()->json([
                      'status_code' => 404,
                      'status_message' => 'Produit non trouvé',
                      'achat' => $achat
                  ], 404);
              }
  
            
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

 
    public function update(EditAchatRequest $request, Achat $achat)
    {
         
        try {
       
          $achat->montantachat=($request->prixachat*$request->quantiteachat);
          $achat->nomachat= $request->nomachat;
          $achat->prixachat= $request->prixachat;
          $achat->quantiteachat=$request->quantiteachat;
          $achat->produit_id= $request->produit_id;
          $produit=Produit::where('id',$request->produit_id)->first();
          $produit->quantite +=$request->quantiteachat;
          if($achat->save()){
            if($produit->update()){
              return response()->json([
                'status_code' => 200,
                'status_message' => 'achat a été modifier',
                'data' => $achat
              ]);
            }else{
              return response()->json([
                'status_code' => 200,
                'status_message' => 'produit a été modifié',
                'data' => $produit
              ]);
            }}
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
public function destroy(SupprimerAchatRequest $request, Achat $achat)
{
    try {
        $produit = Produit::find($achat->produit_id);

        if ($produit) {
            $produit->quantite -= $achat->quantiteachat;
            $produit->save(); 
           // Assurez-vous de sauvegarder les modifications sur le produit
            $achat->delete();

            return response()->json([
                'status_code' => 200,
                'status_message' => 'L\'achat a été bien supprimé, la quantité du produit a été mise à jour.',
                'data' => $achat
            ]);
        } else {
            return response()->json([
                'status_code' => 404,
                'status_message' => 'Le produit associé à cet achat n\'a pas été trouvé.'
            ], 404);
        }
    } catch (Exception $e) {
        return response()->json([
            'status_code' => 500,
            'status_message' => 'Une erreur s\'est produite lors de la suppression de l\'achat.',
            'error' => $e->getMessage()
        ], 500);
    }
}


  }

