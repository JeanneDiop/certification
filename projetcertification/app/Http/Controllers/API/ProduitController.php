<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\Produit;
use App\Models\Categorie;
use Illuminate\Http\Request;
use openApi\Annotations as OA;
use App\Http\Controllers\Controller;
use App\Http\Requests\Produit\EditProduitRequest;
use App\Http\Requests\Produit\CreateProduitRequest;
/**
 
*@OA\Info(title="endpointProduit", version="0.1")*/
class ProduitController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     /**
 * @OA\Get(
 *      path="/api/produits",
 *      operationId="getProduits",
 *      tags={"Produits"},
 *      summary="Obtenir la liste de tous les produits",
 *      description="Retourne la liste de tous les produits.",
 *      @OA\Response(
 *          response=200,
 *          description="Opération réussie",
 *          @OA\JsonContent(
 *              @OA\Property(property="status_code", type="integer", example=200),
 *              @OA\Property(property="status_message", type="string", example="Tous les produits ont été récupérés"),
 *              @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Produit")),
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
 *
 * Obtient la liste de tous les produits.
 *
 * Cette fonction retourne la liste de tous les produits.
 *
 * @return \Illuminate\Http\JsonResponse
 */

 public function getProduitsByCategorie($categorie_id)
{
    try {
        // Trouver la catégorie par son ID
        $categorie = Categorie::findOrFail($categorie_id);
      
        // Récupérer tous les produits liés à cette catégorie
        $produit = $categorie->produit;
      
if($produit->isEmpty()){
    return response()->json([
        'status_code' => 500,
        'status_message' => 'aucun produit trouvé  pour cette categorie.',
        
    ]); 
}else{
    return response()->json([
        'status_code' => 200,
        'status_message' => 'Le produit de cette catégorie a été récupéré avec succès.',
        'data' => $produit
    ]);

}
}catch (\Exception $e) {
    return response()->json([
        'status_code' => 500,
        'status_message' => 'Une erreur s\'est produite lors de la recherche de produits par catégorie.',
        'error' => $e->getMessage()
    ], 500);
}
     
}

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

     /**
 * @OA\Post(
 *      path="/api/produits",
 *      operationId="createProduit",
 *      tags={"Produits"},
 *      summary="Créer un nouveau produit",
 *      description="Crée un nouveau produit avec les données fournies dans la requête.",
 *      @OA\RequestBody(
 *          required=true,
 *          description="Données du produit à créer",
 *          @OA\JsonContent(ref="#/components/schemas/CreateProduitRequest")
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="Opération réussie",
 *          @OA\JsonContent(
 *              @OA\Property(property="status_code", type="integer", example=200),
 *              @OA\Property(property="status_message", type="string", example="Produit ajouté avec succès"),
 *              @OA\Property(property="data", ref="#/components/schemas/Produit"),
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
 *
 * Crée un nouveau produit.
 *
 * Cette fonction crée un nouveau produit avec les données fournies dans la requête.
 *
 * @param  \App\Http\Requests\CreateProduitRequest  $request
 * @return \Illuminate\Http\JsonResponse
 */
    public function store(CreateProduitRequest $request)
    { 
            try
         {
                

                $produit = new Produit();
                $produit->nomproduit = $request->nomproduit;
                $produit->image = $request->image;
                $produit->prixU = $request->prixU;
                $produit->quantite=$request->quantite;
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


     /**
 * @OA\Get(
 *      path="/api/produits/{id}",
 *      operationId="getProduitById",
 *      tags={"Produits"},
 *      summary="Obtenir un produit par ID",
 *      description="Retourne un produit spécifié par son identifiant.",
 *      @OA\Parameter(
 *          name="id",
 *          required=true,
 *          in="path",
 *          description="ID du produit",
 *          @OA\Schema(type="string")
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="Opération réussie",
 *          @OA\JsonContent(ref="#/components/schemas/Produit"),
 *      ),
 *      @OA\Response(
 *          response=404,
 *          description="Produit non trouvé",
 *          @OA\JsonContent(
 *              @OA\Property(property="message", type="string", example="Désolé, pas de produit trouvé."),
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
 *
 * Obtient un produit par ID.
 *
 * Cette fonction retourne un produit spécifié par son identifiant.
 *
 * @param  string  $id
 * @return \Illuminate\Http\JsonResponse
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

     /**
 * @OA\Put(
 *      path="/api/produits/{id}",
 *      operationId="updateProduit",
 *      tags={"Produits"},
 *      summary="Modifier un produit par ID",
 *      description="Modifie un produit spécifié par son identifiant avec les données fournies dans la requête.",
 *      @OA\Parameter(
 *          name="id",
 *          required=true,
 *          in="path",
 *          description="ID du produit",
 *          @OA\Schema(type="string")
 *      ),
 *      @OA\RequestBody(
 *          required=true,
 *          description="Données du produit à modifier",
 *          @OA\JsonContent(ref="#/components/schemas/EditProduitRequest")
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="Opération réussie",
 *          @OA\JsonContent(
 *              @OA\Property(property="status_code", type="integer", example=200),
 *              @OA\Property(property="status_message", type="string", example="Produit modifié avec succès"),
 *              @OA\Property(property="data", ref="#/components/schemas/Produit"),
 *          ),
 *      ),
 *      @OA\Response(
 *          response=404,
 *          description="Produit non trouvé",
 *          @OA\JsonContent(
 *              @OA\Property(property="message", type="string", example="Le produit avec l'ID spécifié n'a pas été trouvé."),
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
 *
 * Modifie un produit par ID.
 *
 * Cette fonction modifie un produit spécifié par son identifiant avec les données fournies dans la requête.
 *
 * @param  \App\Http\Requests\EditProduitRequest  $request
 * @param  string  $id
 * @return \Illuminate\Http\JsonResponse
 */
    public function update(EditProduitRequest $request, $id)
    {

        try {
            $produit = Produit::find($id);
            $produit->nomproduit = $request->nomproduit;
            $produit->image = $request->image;
            $produit->prixU = $request->prixU;
            $produit->quantite = $request->quantite;
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

     /**
 * @OA\Delete(
 *      path="/api/produits/{id}",
 *      operationId="deleteProduit",
 *      tags={"Produits"},
 *      summary="Supprimer un produit par ID",
 *      description="Supprime un produit spécifié par son identifiant.",
 *      @OA\Parameter(
 *          name="id",
 *          required=true,
 *          in="path",
 *          description="ID du produit",
 *          @OA\Schema(type="string")
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="Opération réussie",
 *          @OA\JsonContent(
 *              @OA\Property(property="status_code", type="integer", example=200),
 *              @OA\Property(property="status_message", type="string", example="Produit supprimé avec succès"),
 *              @OA\Property(property="data", ref="#/components/schemas/Produit"),
 *          ),
 *      ),
 *      @OA\Response(
 *          response=404,
 *          description="Produit non trouvé",
 *          @OA\JsonContent(
 *              @OA\Property(property="message", type="string", example="Le produit avec l'ID spécifié n'a pas été trouvé."),
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
 *
 * Supprime un produit par ID.
 *
 * Cette fonction supprime un produit spécifié par son identifiant.
 *
 * @param  string  $id
 * @return \Illuminate\Http\JsonResponse
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
