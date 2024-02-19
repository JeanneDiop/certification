<?php

/**
 * @OA\Security(
 *     security={
 *         "BearerAuth": {}
 *     }),

 * @OA\SecurityScheme(
 *     securityScheme="BearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"),

 * @OA\Info(
 *     title="Your API Title",
 *     description="Your API Description",
 *     version="1.0.0"),

 * @OA\Consumes({
 *     "multipart/form-data"
 * }),
 */


/**
 * @OA\GET(
 *     path="/api/facture/{facture}",
 *     summary="afficher les facture par vente",
 *     description="",
 *         security={
 *    {       "BearerAuth": {}}
 *         },
 * @OA\Response(response="200", description="OK"),
 * @OA\Response(response="404", description="Not Found"),
 * @OA\Response(response="500", description="Internal Server Error"),
 *     @OA\Parameter(in="path", name="facture", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * ),
 *     tags={"Gestion Facture"},
*),
 */

/**
 * @OA\GET(
 *     path="/api/facture/detail/{id}",
 *     summary="afficher les details d'une facture",
 *     description="",
 *         security={
 *    {       "BearerAuth": {}}
 *         },
 * @OA\Response(response="200", description="OK"),
 * @OA\Response(response="404", description="Not Found"),
 * @OA\Response(response="500", description="Internal Server Error"),
 *     @OA\Parameter(in="path", name="id", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * ),
 *     tags={"Gestion Facture"},
*),
 */

/**
 * @OA\DELETE(
 *     path="/api/facture/supprimer/{id}",
 *     summary="supprimer facture",
 *     description="",
 *         security={
 *    {       "BearerAuth": {}}
 *         },
 * @OA\Response(response="204", description="Deleted successfully"),
 * @OA\Response(response="401", description="Unauthenticated"),
 * @OA\Response(response="403", description="Unauthorize"),
 * @OA\Response(response="404", description="Not Found"),
 *     @OA\Parameter(in="path", name="id", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * ),
 *     tags={"Gestion Facture"},
*),
 */

/**
 * @OA\GET(
 *     path="/api/facture/lister",
 *     summary="lister facture",
 *     description="",
 *         security={
 *    {       "BearerAuth": {}}
 *         },
 * @OA\Response(response="200", description="OK"),
 * @OA\Response(response="404", description="Not Found"),
 * @OA\Response(response="500", description="Internal Server Error"),
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * ),
 *     tags={"Gestion Facture"},
*),
 */

/**
 * @OA\PUT(
 *     path="/api/facture/edit/{id}",
 *     summary="modifier facture",
 *     description="",
 *         security={
 *    {       "BearerAuth": {}}
 *         },
 * @OA\Response(response="200", description="OK"),
 * @OA\Response(response="404", description="Not Found"),
 * @OA\Response(response="500", description="Internal Server Error"),
 *     @OA\Parameter(in="path", name="id", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/x-www-form-urlencoded",
 *             @OA\Schema(
 *                 type="object",
 *                 properties={
 *                     @OA\Property(property="payement_id", type="string"),
 *                     @OA\Property(property="numerofacture", type="string"),
 *                 },
 *             ),
 *         ),
 *     ),
 *     tags={"Gestion Facture"},
*),
 */

/**
 * @OA\POST(
 *     path="/api/facture/create",
 *     summary="ajouter facture",
 *     description="",
 *         security={
 *    {       "BearerAuth": {}}
 *         },
 * @OA\Response(response="201", description="Created successfully"),
 * @OA\Response(response="400", description="Bad Request"),
 * @OA\Response(response="401", description="Unauthenticated"),
 * @OA\Response(response="403", description="Unauthorize"),
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="multipart/form-data",
 *             @OA\Schema(
 *                 type="object",
 *                 properties={
 *                     @OA\Property(property="payement_id", type="string"),
 *                     @OA\Property(property="montantVerser", type="string"),
 *                 },
 *             ),
 *         ),
 *     ),
 *     tags={"Gestion Facture"},
*),
 */

/**
 * @OA\DELETE(
 *     path="/api/client/supprimer/{id}",
 *     summary="supprimer client",
 *     description="",
 *         security={
 *    {       "BearerAuth": {}}
 *         },
 * @OA\Response(response="204", description="Deleted successfully"),
 * @OA\Response(response="401", description="Unauthenticated"),
 * @OA\Response(response="403", description="Unauthorize"),
 * @OA\Response(response="404", description="Not Found"),
 *     @OA\Parameter(in="path", name="id", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * ),
 *     tags={"Gestion Client"},
*),
 */

/**
 * @OA\GET(
 *     path="/api/client/detail/{id}",
 *     summary="afficher les details d'un client",
 *     description="",
 *         security={
 *    {       "BearerAuth": {}}
 *         },
 * @OA\Response(response="200", description="OK"),
 * @OA\Response(response="404", description="Not Found"),
 * @OA\Response(response="500", description="Internal Server Error"),
 *     @OA\Parameter(in="path", name="id", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * ),
 *     tags={"Gestion Client"},
*),
 */

/**
 * @OA\GET(
 *     path="/api/client/lister",
 *     summary="lister client",
 *     description="",
 *         security={
 *    {       "BearerAuth": {}}
 *         },
 * @OA\Response(response="200", description="OK"),
 * @OA\Response(response="404", description="Not Found"),
 * @OA\Response(response="500", description="Internal Server Error"),
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * ),
 *     tags={"Gestion Client"},
*),
 */

/**
 * @OA\PUT(
 *     path="/api/client/edit/{id}",
 *     summary="modifier client",
 *     description="",
 *         security={
 *    {       "BearerAuth": {}}
 *         },
 * @OA\Response(response="200", description="OK"),
 * @OA\Response(response="404", description="Not Found"),
 * @OA\Response(response="500", description="Internal Server Error"),
 *     @OA\Parameter(in="path", name="id", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/x-www-form-urlencoded",
 *             @OA\Schema(
 *                 type="object",
 *                 properties={
 *                     @OA\Property(property="nom", type="string"),
 *                     @OA\Property(property="prenom", type="string"),
 *                     @OA\Property(property="code_client", type="string"),
 *                     @OA\Property(property="telephone", type="string"),
 *                     @OA\Property(property="adresse", type="string"),
 *                 },
 *             ),
 *         ),
 *     ),
 *     tags={"Gestion Client"},
*),
 */

/**
 * @OA\POST(
 *     path="/api/client/create",
 *     summary="ajouter client",
 *     description="",
 *         security={
 *    {       "BearerAuth": {}}
 *         },
 * @OA\Response(response="201", description="Created successfully"),
 * @OA\Response(response="400", description="Bad Request"),
 * @OA\Response(response="401", description="Unauthenticated"),
 * @OA\Response(response="403", description="Unauthorize"),
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="multipart/form-data",
 *             @OA\Schema(
 *                 type="object",
 *                 properties={
 *                     @OA\Property(property="nom", type="string"),
 *                     @OA\Property(property="prenom", type="string"),
 *                     @OA\Property(property="code_client", type="string"),
 *                     @OA\Property(property="telephone", type="string"),
 *                     @OA\Property(property="adresse", type="string"),
 *                 },
 *             ),
 *         ),
 *     ),
 *     tags={"Gestion Client"},
*),
 */

/**
 * @OA\GET(
 *     path="/api/payement/lister/comptant",
 *     summary="listerpayementpar etat",
 *     description="",
 *         security={
 *    {       "BearerAuth": {}}
 *         },
 * @OA\Response(response="200", description="OK"),
 * @OA\Response(response="404", description="Not Found"),
 * @OA\Response(response="500", description="Internal Server Error"),
 *     @OA\Parameter(in="path", name="etat", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * ),
 *     tags={"gestion payement"},
*),
 */

/**
 * @OA\DELETE(
 *     path="/api/supprimer/payement/comptant",
 *     summary="supprimer  payement par etat",
 *     description="",
 *         security={
 *    {       "BearerAuth": {}}
 *         },
 * @OA\Response(response="204", description="Deleted successfully"),
 * @OA\Response(response="401", description="Unauthenticated"),
 * @OA\Response(response="403", description="Unauthorize"),
 * @OA\Response(response="404", description="Not Found"),
 *     @OA\Parameter(in="path", name="etat", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * ),
 *     tags={"gestion payement"},
*),
 */

/**
 * @OA\POST(
 *     path="/api/payement/create/{vente}",
 *     summary="ajout payement",
 *     description="",
 *         security={
 *    {       "BearerAuth": {}}
 *         },
 * @OA\Response(response="201", description="Created successfully"),
 * @OA\Response(response="400", description="Bad Request"),
 * @OA\Response(response="401", description="Unauthenticated"),
 * @OA\Response(response="403", description="Unauthorize"),
 *     @OA\Parameter(in="path", name="vente", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="multipart/form-data",
 *             @OA\Schema(
 *                 type="object",
 *                 properties={
 *                     @OA\Property(property="montantVerser", type="string"),
 *                     @OA\Property(property="etat", type="string"),
 *                 },
 *             ),
 *         ),
 *     ),
 *     tags={"gestion payement"},
*),
 */

/**
 * @OA\POST(
 *     path="/api/payement/edit/{vente}",
 *     summary="modifier payement",
 *     description="",
 *         security={
 *    {       "BearerAuth": {}}
 *         },
 * @OA\Response(response="201", description="Created successfully"),
 * @OA\Response(response="400", description="Bad Request"),
 * @OA\Response(response="401", description="Unauthenticated"),
 * @OA\Response(response="403", description="Unauthorize"),
 *     @OA\Parameter(in="path", name="vente", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="multipart/form-data",
 *             @OA\Schema(
 *                 type="object",
 *                 properties={
 *                     @OA\Property(property="montantVerser", type="string"),
 *                 },
 *             ),
 *         ),
 *     ),
 *     tags={"gestion payement"},
*),
 */

/**
 * @OA\DELETE(
 *     path="/api/payement/supprimer/{id}",
 *     summary="supprimer payement",
 *     description="",
 *         security={
 *    {       "BearerAuth": {}}
 *         },
 * @OA\Response(response="204", description="Deleted successfully"),
 * @OA\Response(response="401", description="Unauthenticated"),
 * @OA\Response(response="403", description="Unauthorize"),
 * @OA\Response(response="404", description="Not Found"),
 *     @OA\Parameter(in="path", name="id", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * ),
 *     tags={"gestion payement"},
*),
 */

/**
 * @OA\GET(
 *     path="/api/payement/lister",
 *     summary="lister les payement",
 *     description="",
 *         security={
 *    {       "BearerAuth": {}}
 *         },
 * @OA\Response(response="200", description="OK"),
 * @OA\Response(response="404", description="Not Found"),
 * @OA\Response(response="500", description="Internal Server Error"),
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * ),
 *     tags={"gestion payement"},
*),
 */

/**
 * @OA\GET(
 *     path="/api/payement/detail/{payement}",
 *     summary="afficher payement",
 *     description="",
 *         security={
 *    {       "BearerAuth": {}}
 *         },
 * @OA\Response(response="200", description="OK"),
 * @OA\Response(response="404", description="Not Found"),
 * @OA\Response(response="500", description="Internal Server Error"),
 *     @OA\Parameter(in="path", name="payement", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * ),
 *     tags={"gestion payement"},
*),
 */

/**
 * @OA\DELETE(
 *     path="/api/achat/supprimer/{achat}",
 *     summary="supprimer achat",
 *     description="",
 *         security={
 *    {       "BearerAuth": {}}
 *         },
 * @OA\Response(response="204", description="Deleted successfully"),
 * @OA\Response(response="401", description="Unauthenticated"),
 * @OA\Response(response="403", description="Unauthorize"),
 * @OA\Response(response="404", description="Not Found"),
 *     @OA\Parameter(in="path", name="achat", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="multipart/form-data",
 *             @OA\Schema(
 *                 type="object",
 *                 properties={
 *                     @OA\Property(property="nomachat", type="string"),
 *                     @OA\Property(property="prixachat ", type="string"),
 *                     @OA\Property(property="quantiteachat", type="string"),
 *                     @OA\Property(property="produit_id", type="string"),
 *                 },
 *             ),
 *         ),
 *     ),
 *     tags={"gestion achat"},
*),
 */

/**
 * @OA\PUT(
 *     path="/api/achat/edit/{achat}",
 *     summary="modifier achat",
 *     description="",
 *         security={
 *    {       "BearerAuth": {}}
 *         },
 * @OA\Response(response="200", description="OK"),
 * @OA\Response(response="404", description="Not Found"),
 * @OA\Response(response="500", description="Internal Server Error"),
 *     @OA\Parameter(in="path", name="achat", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/x-www-form-urlencoded",
 *             @OA\Schema(
 *                 type="object",
 *                 properties={
 *                     @OA\Property(property="nomachat", type="string"),
 *                     @OA\Property(property="prixachat", type="string"),
 *                     @OA\Property(property="quantiteachat", type="string"),
 *                     @OA\Property(property="produit_id", type="integer"),
 *                 },
 *             ),
 *         ),
 *     ),
 *     tags={"gestion achat"},
*),
 */

/**
 * @OA\GET(
 *     path="/api/achat/lister",
 *     summary="lister achat",
 *     description="",
 *         security={
 *    {       "BearerAuth": {}}
 *         },
 * @OA\Response(response="200", description="OK"),
 * @OA\Response(response="404", description="Not Found"),
 * @OA\Response(response="500", description="Internal Server Error"),
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * ),
 *     tags={"gestion achat"},
*),
 */

/**
 * @OA\GET(
 *     path="/api/achat/detail/{id}",
 *     summary="afficher achat",
 *     description="",
 *         security={
 *    {       "BearerAuth": {}}
 *         },
 * @OA\Response(response="200", description="OK"),
 * @OA\Response(response="404", description="Not Found"),
 * @OA\Response(response="500", description="Internal Server Error"),
 *     @OA\Parameter(in="path", name="id", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * ),
 *     tags={"gestion achat"},
*),
 */

/**
 * @OA\POST(
 *     path="/api/achat/create",
 *     summary="ajout achat",
 *     description="",
 *         security={
 *    {       "BearerAuth": {}}
 *         },
 * @OA\Response(response="201", description="Created successfully"),
 * @OA\Response(response="400", description="Bad Request"),
 * @OA\Response(response="401", description="Unauthenticated"),
 * @OA\Response(response="403", description="Unauthorize"),
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="multipart/form-data",
 *             @OA\Schema(
 *                 type="object",
 *                 properties={
 *                     @OA\Property(property="nomachat", type="string"),
 *                     @OA\Property(property="prixachat", type="string"),
 *                     @OA\Property(property="quantiteachat", type="string"),
 *                     @OA\Property(property="produit_id", type="integer"),
 *                 },
 *             ),
 *         ),
 *     ),
 *     tags={"gestion achat"},
*),
 */

/**
 * @OA\GET(
 *     path="/api/categorie/lister",
 *     summary="lister categorie",
 *     description="",
 *         security={
 *    {       "BearerAuth": {}}
 *         },
 * @OA\Response(response="200", description="OK"),
 * @OA\Response(response="404", description="Not Found"),
 * @OA\Response(response="500", description="Internal Server Error"),
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * ),
 *     tags={"gestion categorie"},
*),
 */

/**
 * @OA\GET(
 *     path="/api/categorie/detail/{id}",
 *     summary="afficher categorie",
 *     description="",
 *         security={
 *    {       "BearerAuth": {}}
 *         },
 * @OA\Response(response="200", description="OK"),
 * @OA\Response(response="404", description="Not Found"),
 * @OA\Response(response="500", description="Internal Server Error"),
 *     @OA\Parameter(in="path", name="id", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * ),
 *     tags={"gestion categorie"},
*),
 */

/**
 * @OA\DELETE(
 *     path="/api/categorie/supprime/{id}",
 *     summary="supprimer categorie",
 *     description="",
 *         security={
 *    {       "BearerAuth": {}}
 *         },
 * @OA\Response(response="204", description="Deleted successfully"),
 * @OA\Response(response="401", description="Unauthenticated"),
 * @OA\Response(response="403", description="Unauthorize"),
 * @OA\Response(response="404", description="Not Found"),
 *     @OA\Parameter(in="path", name="id", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * ),
 *     tags={"gestion categorie"},
*),
 */

/**
 * @OA\POST(
 *     path="/api/categorie/create",
 *     summary="ajouter categorie",
 *     description="",
 *         security={
 *    {       "BearerAuth": {}}
 *         },
 * @OA\Response(response="201", description="Created successfully"),
 * @OA\Response(response="400", description="Bad Request"),
 * @OA\Response(response="401", description="Unauthenticated"),
 * @OA\Response(response="403", description="Unauthorize"),
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="multipart/form-data",
 *             @OA\Schema(
 *                 type="object",
 *                 properties={
 *                     @OA\Property(property="nom", type="string"),
 *                 },
 *             ),
 *         ),
 *     ),
 *     tags={"gestion categorie"},
*),
 */

/**
 * @OA\PUT(
 *     path="/api/categorie/edit/{id}",
 *     summary="modifier categorie",
 *     description="",
 *         security={
 *    {       "BearerAuth": {}}
 *         },
 * @OA\Response(response="200", description="OK"),
 * @OA\Response(response="404", description="Not Found"),
 * @OA\Response(response="500", description="Internal Server Error"),
 *     @OA\Parameter(in="path", name="id", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/x-www-form-urlencoded",
 *             @OA\Schema(
 *                 type="object",
 *                 properties={
 *                     @OA\Property(property="nom", type="string"),
 *                 },
 *             ),
 *         ),
 *     ),
 *     tags={"gestion categorie"},
*),
 */

/**
 * @OA\GET(
 *     path="/api/produit/{categorie_id}",
 *     summary="lister les produits par categorie",
 *     description="",
 *         security={
 *    {       "BearerAuth": {}}
 *         },
 * @OA\Response(response="200", description="OK"),
 * @OA\Response(response="404", description="Not Found"),
 * @OA\Response(response="500", description="Internal Server Error"),
 *     @OA\Parameter(in="path", name="categorie_id", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * ),
 *     tags={"gestion produit"},
*),
 */

/**
 * @OA\GET(
 *     path="/api/produit/detail/{id}",
 *     summary="afficher les details d'un produit",
 *     description="",
 *         security={
 *    {       "BearerAuth": {}}
 *         },
 * @OA\Response(response="200", description="OK"),
 * @OA\Response(response="404", description="Not Found"),
 * @OA\Response(response="500", description="Internal Server Error"),
 *     @OA\Parameter(in="path", name="id", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * ),
 *     tags={"gestion produit"},
*),
 */

/**
 * @OA\GET(
 *     path="/api/produits/lister",
 *     summary="lister produit",
 *     description="",
 *         security={
 *    {       "BearerAuth": {}}
 *         },
 * @OA\Response(response="200", description="OK"),
 * @OA\Response(response="404", description="Not Found"),
 * @OA\Response(response="500", description="Internal Server Error"),
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * ),
 *     tags={"gestion produit"},
*),
 */

/**
 * @OA\DELETE(
 *     path="/api/produit/supprimer/{id}",
 *     summary="supprimer produit",
 *     description="",
 *         security={
 *    {       "BearerAuth": {}}
 *         },
 * @OA\Response(response="204", description="Deleted successfully"),
 * @OA\Response(response="401", description="Unauthenticated"),
 * @OA\Response(response="403", description="Unauthorize"),
 * @OA\Response(response="404", description="Not Found"),
 *     @OA\Parameter(in="path", name="id", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * ),
 *     tags={"gestion produit"},
*),
 */

/**
 * @OA\POST(
 *     path="/api/produit/create",
 *     summary="ajouter produit",
 *     description="",
 *         security={
 *    {       "BearerAuth": {}}
 *         },
 * @OA\Response(response="201", description="Created successfully"),
 * @OA\Response(response="400", description="Bad Request"),
 * @OA\Response(response="401", description="Unauthenticated"),
 * @OA\Response(response="403", description="Unauthorize"),
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="multipart/form-data",
 *             @OA\Schema(
 *                 type="object",
 *                 properties={
 *                     @OA\Property(property="nomproduit", type="string"),
 *                     @OA\Property(property="image", type="string"),
 *                     @OA\Property(property="prixU", type="string"),
 *                     @OA\Property(property="quantite", type="string"),
 *                     @OA\Property(property="quantiteseuil", type="string"),
 *                     @OA\Property(property="etat", type="string"),
 *                     @OA\Property(property="categorie_id", type="string"),
 *                 },
 *             ),
 *         ),
 *     ),
 *     tags={"gestion produit"},
*),
 */

/**
 * @OA\PUT(
 *     path="/api/produit/edit/{id}",
 *     summary="modifier produit",
 *     description="",
 *         security={
 *    {       "BearerAuth": {}}
 *         },
 * @OA\Response(response="200", description="OK"),
 * @OA\Response(response="404", description="Not Found"),
 * @OA\Response(response="500", description="Internal Server Error"),
 *     @OA\Parameter(in="path", name="id", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/x-www-form-urlencoded",
 *             @OA\Schema(
 *                 type="object",
 *                 properties={
 *                     @OA\Property(property="nomproduit", type="string"),
 *                     @OA\Property(property="image", type="string"),
 *                     @OA\Property(property="prixU", type="string"),
 *                     @OA\Property(property="quantite", type="string"),
 *                     @OA\Property(property="quantiteseuil", type="string"),
 *                     @OA\Property(property="etat", type="string"),
 *                     @OA\Property(property="categorie_id", type="string"),
 *                 },
 *             ),
 *         ),
 *     ),
 *     tags={"gestion produit"},
*),
 */

/**
 * @OA\GET(
 *     path="/api/historiquevente/lister",
 *     summary="historiquevente/lister",
 *     description="",
 *         security={
 *    {       "BearerAuth": {}}
 *         },
 * @OA\Response(response="200", description="OK"),
 * @OA\Response(response="404", description="Not Found"),
 * @OA\Response(response="500", description="Internal Server Error"),
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * ),
 *     tags={"gestion vente"},
*),
 */

/**
 * @OA\GET(
 *     path="",
 *     summary="historiquevente/id",
 *     description="",
 *         security={
 *    {       "BearerAuth": {}}
 *         },
 * @OA\Response(response="200", description="OK"),
 * @OA\Response(response="404", description="Not Found"),
 * @OA\Response(response="500", description="Internal Server Error"),
 *     @OA\Parameter(in="path", name="vente->id", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * ),
 *     tags={"gestion vente"},
*),
 */

/**
 * @OA\GET(
 *     path="/api/vente/lister",
 *     summary="afficher les details d'une vente",
 *     description="",
 *         security={
 *    {       "BearerAuth": {}}
 *         },
 * @OA\Response(response="200", description="OK"),
 * @OA\Response(response="404", description="Not Found"),
 * @OA\Response(response="500", description="Internal Server Error"),
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * ),
 *     tags={"gestion vente"},
*),
 */

/**
 * @OA\DELETE(
 *     path="/api/vente/supprimer/{id}",
 *     summary="supprimer vente",
 *     description="",
 *         security={
 *    {       "BearerAuth": {}}
 *         },
 * @OA\Response(response="204", description="Deleted successfully"),
 * @OA\Response(response="401", description="Unauthenticated"),
 * @OA\Response(response="403", description="Unauthorize"),
 * @OA\Response(response="404", description="Not Found"),
 *     @OA\Parameter(in="path", name="id", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * ),
 *     tags={"gestion vente"},
*),
 */

/**
 * @OA\POST(
 *     path="/api/vente/create",
 *     summary="ajout vente",
 *     description="",
 *         security={
 *    {       "BearerAuth": {}}
 *         },
 * @OA\Response(response="201", description="Created successfully"),
 * @OA\Response(response="400", description="Bad Request"),
 * @OA\Response(response="401", description="Unauthenticated"),
 * @OA\Response(response="403", description="Unauthorize"),
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="multipart/form-data",
 *             @OA\Schema(
 *                 type="object",
 *                 properties={
 *                     @OA\Property(property="client_id", type="integer"),
 *                     @OA\Property(property="produit", type="string", format="binary"),
 *                 },
 *             ),
 *         ),
 *     ),
 *     tags={"gestion vente"},
*),
 */

/**
 * @OA\PUT(
 *     path="/api/vente/edit/{vente}",
 *     summary="modifier vente",
 *     description="",
 *         security={
 *    {       "BearerAuth": {}}
 *         },
 * @OA\Response(response="200", description="OK"),
 * @OA\Response(response="404", description="Not Found"),
 * @OA\Response(response="500", description="Internal Server Error"),
 *     @OA\Parameter(in="path", name="vente", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/x-www-form-urlencoded",
 *             @OA\Schema(
 *                 type="object",
 *                 properties={
 *                     @OA\Property(property="client_id", type="integer"),
 *                     @OA\Property(property="produit", type="string", format="binary"),
 *                 },
 *             ),
 *         ),
 *     ),
 *     tags={"gestion vente"},
*),
 */

/**
 * @OA\GET(
 *     path="/api/employe/detail/{id}",
 *     summary="afficher les details d'un employe",
 *     description="",
 *         security={
 *    {       "BearerAuth": {}}
 *         },
 * @OA\Response(response="200", description="OK"),
 * @OA\Response(response="404", description="Not Found"),
 * @OA\Response(response="500", description="Internal Server Error"),
 *     @OA\Parameter(in="path", name="id", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * ),
 *     tags={"Gestion Utilisateur"},
*),
 */

/**
 * @OA\GET(
 *     path="/api/employe/lister",
 *     summary="lister les employe",
 *     description="",
 *         security={
 *    {       "BearerAuth": {}}
 *         },
 * @OA\Response(response="200", description="OK"),
 * @OA\Response(response="404", description="Not Found"),
 * @OA\Response(response="500", description="Internal Server Error"),
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * ),
 *     tags={"Gestion Utilisateur"},
*),
 */

/**
 * @OA\PUT(
 *     path="/api/employe/edit/{user}",
 *     summary="modifier employe",
 *     description="",
 *         security={
 *    {       "BearerAuth": {}}
 *         },
 * @OA\Response(response="200", description="OK"),
 * @OA\Response(response="404", description="Not Found"),
 * @OA\Response(response="500", description="Internal Server Error"),
 *     @OA\Parameter(in="path", name="user", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/x-www-form-urlencoded",
 *             @OA\Schema(
 *                 type="object",
 *                 properties={
 *                     @OA\Property(property="nom", type="string"),
 *                     @OA\Property(property="prenom", type="string"),
 *                     @OA\Property(property="email", type="string"),
 *                     @OA\Property(property="password", type="string"),
 *                     @OA\Property(property="telephone", type="string"),
 *                     @OA\Property(property="adresse", type="string"),
 *                     @OA\Property(property="etat", type="string"),
 *                     @OA\Property(property="role_id", type="string"),
 *                 },
 *             ),
 *         ),
 *     ),
 *     tags={"Gestion Utilisateur"},
*),
 */

/**
 * @OA\PUT(
 *     path="/api/employe/archive/{user}",
 *     summary="archiveremploye",
 *     description="",
 *         security={
 *    {       "BearerAuth": {}}
 *         },
 * @OA\Response(response="200", description="OK"),
 * @OA\Response(response="404", description="Not Found"),
 * @OA\Response(response="500", description="Internal Server Error"),
 *     @OA\Parameter(in="path", name="user", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/x-www-form-urlencoded",
 *             @OA\Schema(
 *                 type="object",
 *                 properties={
 *                     @OA\Property(property="etat", type="string"),
 *                 },
 *             ),
 *         ),
 *     ),
 *     tags={"Gestion Utilisateur"},
*),
 */

/**
 * @OA\POST(
 *     path="/api/login",
 *     summary="login",
 *     description="",
 *         security={
 *    {       "BearerAuth": {}}
 *         },
 * @OA\Response(response="201", description="Created successfully"),
 * @OA\Response(response="400", description="Bad Request"),
 * @OA\Response(response="401", description="Unauthenticated"),
 * @OA\Response(response="403", description="Unauthorize"),
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="multipart/form-data",
 *             @OA\Schema(
 *                 type="object",
 *                 properties={
 *                     @OA\Property(property="email", type="string"),
 *                     @OA\Property(property="password", type="string"),
 *                 },
 *             ),
 *         ),
 *     ),
 *     tags={"Gestion Utilisateur"},
*),
 */

/**
 * @OA\POST(
 *     path="/api/register",
 *     summary="reegister",
 *     description="",
 *         security={
 *    {       "BearerAuth": {}}
 *         },
 * @OA\Response(response="201", description="Created successfully"),
 * @OA\Response(response="400", description="Bad Request"),
 * @OA\Response(response="401", description="Unauthenticated"),
 * @OA\Response(response="403", description="Unauthorize"),
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="multipart/form-data",
 *             @OA\Schema(
 *                 type="object",
 *                 properties={
 *                     @OA\Property(property="nom", type="string"),
 *                     @OA\Property(property="prenom", type="string"),
 *                     @OA\Property(property="email", type="string"),
 *                     @OA\Property(property="password", type="string"),
 *                     @OA\Property(property="password_confirmation", type="string"),
 *                     @OA\Property(property="telephone", type="string"),
 *                     @OA\Property(property="adresse", type="string"),
 *                     @OA\Property(property="etat", type="string"),
 *                     @OA\Property(property="image", type="string"),
 *                     @OA\Property(property="role_id", type="integer"),
 *                 },
 *             ),
 *         ),
 *     ),
 *     tags={"Gestion Utilisateur"},
*),
 */

