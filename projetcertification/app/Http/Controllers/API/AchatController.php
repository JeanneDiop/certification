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
 
*@OA\Info(title="endpointCandidature", version="0.1")*/
class AchatController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     /**
 * @OA\Get(
 *      path="/api/achats",
 *      operationId="getAchats",
 *      tags={"Achats"},
 *      summary="Obtenir la liste de tous les achats",
 *      description="Retourne la liste de tous les achats",
 *      @OA\Response(
 *          response=200,
 *          description="Opération réussie",
 *          @OA\JsonContent(
 *              @OA\Property(property="status_code", type="integer", example=200),
 *              @OA\Property(property="status_message", type="string", example="tous les achats ont été récupérés"),
 *              @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Achat")),
 *          ),
 *      ),
 *      @OA\Response(
 *          response=500,
 *          description="Erreur interne du serveur",
 *          @OA\JsonContent(
 *              @OA\Property(property="message", type="string", example="Internal Server Error"),
 *          ),
 *      ),
 * )
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

//      /**
//  * @OA\Post(
//  *      path="/api/achats",
//  *      operationId="createAchat",
//  *      tags={"Achats"},
//  *      summary="Ajouter un nouvel achat",
//  *      description="Ajoute un nouvel achat à la base de données",
//  *      @OA\RequestBody(
//  *          required=true,
//  *          @OA\JsonContent(ref="#/components/schemas/CreateAchatRequest"),
//  *      ),
//  *      @OA\Response(
//  *          response=200,
//  *          description="Opération réussie",
//  *          @OA\JsonContent(
//  *              @OA\Property(property="status_code", type="integer", example=200),
//  *              @OA\Property(property="status_message", type="string", example="Achat ajouté avec succès"),
//  *              @OA\Property(property="data", type="object", ref="#/components/schemas/Achat"),
//  *          ),
//  *      ),
//  *      @OA\Response(
//  *          response=500,
//  *          description="Erreur interne du serveur",
//  *          @OA\JsonContent(
//  *              @OA\Property(property="message", type="string", example="Internal Server Error"),
//  *          ),
//  *      ),
//  * )
//  */
    public function store(CreateAchatRequest $request)
    {
            try 
          {
          
                // $produit= new Produit();
                // $produit->nomproduit=$request->nomproduit;
                // $produit->image=$request->image;
                // $produit->prixU=$request->prixU;
                // $produit->etat=$request->etat;
                // $produit->quantiteseuil=$request->quantiteseuil;
                // $produit->quantite=$request->quantite;
                // $produit->categorie_id=$request->categorie_id;
                // $produit->save();
                // $achat = new Achat();
                // $achat->montantachat=($request->prixachat*$request->quantiteachat);
                // $achat->nomachat= $request->nomachat;
                // $achat->quantiteachat=$request->quantiteachat;
                // $achat->produit_id=$request->produit->id;
                // $achat->save();
                // return response()->json([
                //   'status_code' => 200,
                //   'status_message' => 'achat et produit ont été bien ajouté',
                //   'achat'=>$achat,
                 
                // ]);
    
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

     /**
 * @OA\Get(
 *      path="/api/achats/{id}",
 *      operationId="getAchatById",
 *      tags={"Achats"},
 *      summary="Obtenir les détails d'un achat",
 *      description="Retourne les détails d'un achat en fonction de l'ID spécifié",
 *      @OA\Parameter(
 *          name="id",
 *          in="path",
 *          required=true,
 *          description="ID de l'achat",
 *          @OA\Schema(type="string"),
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="Opération réussie",
 *          @OA\JsonContent(
 *              @OA\Property(property="status_code", type="integer", example=200),
 *              @OA\Property(property="status_message", type="string", example="Détails de l'achat récupérés avec succès"),
 *              @OA\Property(property="data", type="object", ref="#/components/schemas/Achat"),
 *          ),
 *      ),
 *      @OA\Response(
 *          response=404,
 *          description="Achat non trouvé",
 *          @OA\JsonContent(
 *              @OA\Property(property="message", type="string", example="Désolé, pas d'achat trouvé."),
 *          ),
 *      ),
 * )
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

     /**
 * @OA\Patch(
 *      path="/api/achats/{achat}",
 *      operationId="editAchat",
 *      tags={"Achats"},
 *      summary="Modifier un achat existant",
 *      description="Modifie un achat existant dans la base de données",
 *      @OA\Parameter(
 *          name="achat",
 *          in="path",
 *          required=true,
 *          description="ID de l'achat à modifier",
 *          @OA\Schema(type="integer"),
 *      ),
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(ref="#/components/schemas/EditAchatRequest"),
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="Opération réussie",
 *          @OA\JsonContent(
 *              @OA\Property(property="status_code", type="integer", example=200),
 *              @OA\Property(property="status_message", type="string", example="Achat modifié avec succès"),
 *              @OA\Property(property="data", type="object", ref="#/components/schemas/Achat"),
 *          ),
 *      ),
 *      @OA\Response(
 *          response=500,
 *          description="Erreur interne du serveur",
 *          @OA\JsonContent(
 *              @OA\Property(property="message", type="string", example="Internal Server Error"),
 *          ),
 *      ),
 * )
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

     /**
 * @OA\Patch(
 *      path="/api/achats/{achat}",
 *      operationId="editAchat",
 *      tags={"Achats"},
 *      summary="Modifier un achat existant",
 *      description="Modifie un achat existant dans la base de données",
 *      @OA\Parameter(
 *          name="achat",
 *          in="path",
 *          required=true,
 *          description="ID de l'achat à modifier",
 *          @OA\Schema(type="integer"),
 *      ),
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(ref="#/components/schemas/EditAchatRequest"),
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="Opération réussie",
 *          @OA\JsonContent(
 *              @OA\Property(property="status_code", type="integer", example=200),
 *              @OA\Property(property="status_message", type="string", example="Achat modifié avec succès"),
 *              @OA\Property(property="data", type="object", ref="#/components/schemas/Achat"),
 *          ),
 *      ),
 *      @OA\Response(
 *          response=500,
 *          description="Erreur interne du serveur",
 *          @OA\JsonContent(
 *              @OA\Property(property="message", type="string", example="Internal Server Error"),
 *          ),
 *      ),
 * )
 */
public function destroy(SupprimerAchatRequest $request, Achat $achat)
{
    try {
        $produit = Produit::where('id', $request->produit_id)->first();

        if ($produit) {
            $produit->quantite -= $request->quantiteachat;
            $produit->save(); // Assurez-vous de sauvegarder les modifications sur le produit

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

