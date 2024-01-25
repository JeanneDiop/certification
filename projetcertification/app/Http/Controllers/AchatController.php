<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Achat;
use App\Models\Produit;
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
        
            try 
          {
              if(isset($request->nomproduit)){
                $produit= new Produit();
                $produit->nomproduit=$request->nomproduit;
                $produit->image=$request->image;
                $produit->prixU=$request->prixU;
                $produit->etat=$request->etat;
                $produit->quantitéseuil=$request->quantitéseuil;
                $produit->quantite=$request->quantite;
                if($produit->save()){
                $achat = new Achat();
                $achat->prixachat=($request->prixacha*$request->quantite);
                $achat->nomachat= $request->nomachat;
                $achat->produit_id=$produit->Id;
        
                $achat->save();
    }
               
              }else{
                $achat = new Achat();
                $achat=Achat::where('id',$request->produit_id)->first();
                $achat->prixachat=($request->prixunitaire*$request->quantite);
                $achat->nomachat= $request->nomachat;
                $achat->produit_id= $request->produit_id;
                $produit=Produit::where('id',$request->produit_id)->first();
                $produit->quantité +=$request->quantite;
                if($achat->save()){
                  if($produit->update()){
                    return response()->json([
                      'status_code' => 200,
                      'status_message' => 'achat a été ajouté',
                      'data' => $achat
                    ]);
                  }else{
                    return response()->json([
                      'status_code' => 200,
                      'status_message' => 'produit a été ajouté',
                      'data' => $produit
                    ]);
                  }
                }else{

                  return response()->json([
                    'status_code' => 200,
                    'status_message' => 'achat a été ajouté',
                    'data' => $achat
                  ]);
                  
                }
                
             
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
    public function edit(EditAchatRequest $request,$achat)
    {
         
        // try {
        //   $achat->prixachat=($request->prixunitaire*$request->quantite);
        //   $achat->nomachat= $request->nomachat;
        //   $achat->produit_id= $request->produit_id;
        //   $produit=Produit::where('id',$request->produit_id)->first();
        //   $produit->quantité +=$request->quantite;
        //   if($achat->save()){
        //     if($produit->update()){
        //       return response()->json([
        //         'status_code' => 200,
        //         'status_message' => 'achat a été ajouté',
        //         'data' => $achat
        //       ]);
        //     }else{
        //       return response()->json([
        //         'status_code' => 200,
        //         'status_message' => 'produit a été ajouté',
        //         'data' => $produit
        //       ]);
        //     }}
        // } catch (Exception $e) {
        //   return response()->json($e);
        // }


     

   try {
        $produit = Produit::find($request->produit_id);

        if (!$produit) {
            return response()->json([
                'status_code' => 404,
                'status_message' => 'Le produit n\'existe pas.',
            ]);
        }

        // Mise à jour du produit
        $produit->quantité += $request->quantite;
        $produit->save();

        // Mise à jour de l'achat
        $achat->prixachat = $request->prixunitaire * $request->quantite;
        $achat->nomachat = $request->nomachat;
        $achat->produit_id = $request->produit_id;

        if ($achat->update()) {
            return response()->json([
                'status_code' => 200,
                'status_message' => 'L\'achat a été modifié.',
                'data' => $achat,
            ]);
        } else {
            return response()->json([
                'status_code' => 500,
                'status_message' => 'Erreur lors de la modification de l\'achat.',
            ]);
        }
    } catch (Exception $e) {
        return response()->json([
            'status_code' => 500,
            'status_message' => 'Erreur lors de la modification de l\'achat.',
        ]);
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