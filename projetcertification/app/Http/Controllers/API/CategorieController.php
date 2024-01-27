<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\Categorie;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Categorie\EditCategorieRequest;
use App\Http\Requests\Categorie\CreateCategorieRequest;
use openApi\Annotations as OA;
/**
 
*@OA\Info(title="endpointCategorie", version="0.1")*/
class CategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     /**
 * @OA\Get(
 *      path="/api/categories",
 *      operationId="getCategories",
 *      tags={"Categories"},
 *      summary="Obtenir la liste de toutes les catégories",
 *      description="Retourne la liste de toutes les catégories",
 *      @OA\Response(
 *          response=200,
 *          description="Opération réussie",
 *          @OA\JsonContent(
 *              @OA\Property(property="status_code", type="integer", example=200),
 *              @OA\Property(property="status_message", type="string", example="Toutes les catégories ont été récupérées"),
 *              @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Categorie")),
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
 * Récupère toutes les catégories.
 *
 * Cette fonction renvoie toutes les catégories disponibles.
 *
 * @return \Illuminate\Http\JsonResponse
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

     /**
 * @OA\Post(
 *      path="/api/categories",
 *      operationId="createCategorie",
 *      tags={"Categories"},
 *      summary="Créer une nouvelle catégorie",
 *      description="Crée une nouvelle catégorie avec les données fournies dans la requête.",
 *      @OA\RequestBody(
 *          required=true,
 *          description="Données de la catégorie à créer",
 *          @OA\JsonContent(ref="#/components/schemas/CreateCategorieRequest")
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="Opération réussie",
 *          @OA\JsonContent(
 *              @OA\Property(property="status_code", type="integer", example=200),
 *              @OA\Property(property="status_message", type="string", example="Catégorie ajoutée avec succès"),
 *              @OA\Property(property="data", ref="#/components/schemas/Categorie"),
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
 * Crée une nouvelle catégorie.
 *
 * Cette fonction crée une nouvelle catégorie avec les données fournies dans la requête.
 *
 * @param  \App\Http\Requests\CreateCategorieRequest  $request
 * @return \Illuminate\Http\JsonResponse
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

     /**
 * @OA\Get(
 *      path="/api/categories/{id}",
 *      operationId="getCategorieById",
 *      tags={"Categories"},
 *      summary="Obtenir une catégorie par ID",
 *      description="Retourne une catégorie spécifiée par son identifiant.",
 *      @OA\Parameter(
 *          name="id",
 *          required=true,
 *          in="path",
 *          description="ID de la catégorie",
 *          @OA\Schema(type="string")
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="Opération réussie",
 *          @OA\JsonContent(ref="#/components/schemas/Categorie"),
 *      ),
 *      @OA\Response(
 *          response=404,
 *          description="Catégorie non trouvée",
 *          @OA\JsonContent(
 *              @OA\Property(property="message", type="string", example="Désolé, pas de catégorie trouvée."),
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
 * Obtient une catégorie par ID.
 *
 * Cette fonction retourne une catégorie spécifiée par son identifiant.
 *
 * @param  string  $id
 * @return \Illuminate\Http\JsonResponse
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

     /**
 * @OA\Put(
 *      path="/api/categories/{id}",
 *      operationId="updateCategorie",
 *      tags={"Categories"},
 *      summary="Modifier une catégorie par ID",
 *      description="Modifie une catégorie spécifiée par son identifiant avec les données fournies dans la requête.",
 *      @OA\Parameter(
 *          name="id",
 *          required=true,
 *          in="path",
 *          description="ID de la catégorie",
 *          @OA\Schema(type="string")
 *      ),
 *      @OA\RequestBody(
 *          required=true,
 *          description="Données de la catégorie à modifier",
 *          @OA\JsonContent(ref="#/components/schemas/EditCategorieRequest")
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="Opération réussie",
 *          @OA\JsonContent(
 *              @OA\Property(property="status_code", type="integer", example=200),
 *              @OA\Property(property="status_message", type="string", example="Catégorie modifiée avec succès"),
 *              @OA\Property(property="data", ref="#/components/schemas/Categorie"),
 *          ),
 *      ),
 *      @OA\Response(
 *          response=404,
 *          description="Catégorie non trouvée",
 *          @OA\JsonContent(
 *              @OA\Property(property="message", type="string", example="Désolé, pas de catégorie trouvée."),
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
 * Modifie une catégorie par ID.
 *
 * Cette fonction modifie une catégorie spécifiée par son identifiant avec les données fournies dans la requête.
 *
 * @param  \App\Http\Requests\EditCategorieRequest  $request
 * @param  string  $id
 * @return \Illuminate\Http\JsonResponse
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

     /**
 * @OA\Delete(
 *      path="/api/categories/{id}",
 *      operationId="deleteCategorie",
 *      tags={"Categories"},
 *      summary="Supprimer une catégorie par ID",
 *      description="Supprime une catégorie spécifiée par son identifiant.",
 *      @OA\Parameter(
 *          name="id",
 *          required=true,
 *          in="path",
 *          description="ID de la catégorie",
 *          @OA\Schema(type="string")
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="Opération réussie",
 *          @OA\JsonContent(
 *              @OA\Property(property="status_code", type="integer", example=200),
 *              @OA\Property(property="status_message", type="string", example="Catégorie supprimée avec succès"),
 *              @OA\Property(property="data", ref="#/components/schemas/Categorie"),
 *          ),
 *      ),
 *      @OA\Response(
 *          response=404,
 *          description="Catégorie non trouvée",
 *          @OA\JsonContent(
 *              @OA\Property(property="message", type="string", example="Désolé, pas de catégorie trouvée."),
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
 * Supprime une catégorie par ID.
 *
 * Cette fonction supprime une catégorie spécifiée par son identifiant.
 *
 * @param  string  $id
 * @return \Illuminate\Http\JsonResponse
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