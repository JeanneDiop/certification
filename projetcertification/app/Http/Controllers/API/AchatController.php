<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\Achat;
use App\Models\Produit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Achat\EditAchatRequest;
use App\Http\Requests\Achat\CreateAchatRequest;

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


    /**
     * Show the form for creating a new resource.
     */

    /**
     * Store a newly created resource in storage.
     */

     /**
 * @OA\Post(
 *      path="/api/achats",
 *      operationId="createAchat",
 *      tags={"Achats"},
 *      summary="Ajouter un nouvel achat",
 *      description="Ajoute un nouvel achat à la base de données",
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(ref="#/components/schemas/CreateAchatRequest"),
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="Opération réussie",
 *          @OA\JsonContent(
 *              @OA\Property(property="status_code", type="integer", example=200),
 *              @OA\Property(property="status_message", type="string", example="Achat ajouté avec succès"),
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
                $produit->quantiteseuil=$request->quantiteseuil;
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
                $produit->quantite +=$request->quantite;
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
    public function destroy(Achat $achat)
    {
      try{
        $achat->delete();

        return response()->json([
          'status_code' => 200,
          'status_message' => 'achat a été bien supprimer',
          'data' => $achat
        ]);
      } catch (Exception $e) {
        return response()->json($e);
      }
    
      }

  }

