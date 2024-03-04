<?php

namespace App\Http\Controllers\API;

use Exception;

use App\Models\Vente;
use App\Models\Client;
use App\Models\Facture;
use App\Models\Produit;
use App\Models\Payement;
use Illuminate\Http\Request;
use App\Models\historiquevente;
use App\Http\Controllers\Controller;
use App\Http\Requests\Facture\EditFactureRequest;
use App\Http\Requests\Facture\CreateFactureRequest;

class FactureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return response()->json([
                'status_code' => 200,
                'status_message' => 'tous les factures ont été recupéré',
                'data' => Facture::all(),
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
  

     private function generernumerofacture() {
        // Génère deux lettres majuscules aléatoires
        $lettres = chr(rand(65, 90)) . chr(rand(65, 90));
        
        // Génère six chiffres aléatoires
        $chiffres = sprintf("%06d", rand(0, 999999));
        
        // Retourne le numéro de facture composé des deux lettres et des six chiffres
        return $lettres . $chiffres;
    }

     public function store(CreateFactureRequest $request){
        $facture = new Facture();

        $facture->payement_id = $request->payement_id;

        $facture->montantVerser = $request->montantVerser;

        $facture->numerofacture = $this->generernumerofacture();

        $facture->save();

        return response()->json([
            'data' => $facture
        ]);

     }


    /**
     * Display the specified resource.
     */
    public function show(Facture $facture)
    {
        try {
            $facture = Facture::findOrFail($facture);

            return response()->json($facture);
        } catch (Exception) {
            return response()->json(['message' => 'Désolé, pas de facture trouvé.'], 404);
        }
    }

    public function getFactureById(Facture $facture) {

        $payement= Payement::where('id',$facture->payement_id)->first();
        $vente=Vente::where('id',$payement->vente_id)->first();
        $client=Client::where('id',$vente->client_id)->first();

        $historiques= historiquevente::where('vente_id',$vente->id)->get();
        $produits=[];
        foreach ($historiques as $historique) {
            $produit=Produit::find($historique->produit_id);
    
            $produits[]=[
                'nomproduit'=>$produit->nomproduit,
                'prixunitaire'=>$produit->prixU,
                'quantitevendu'=>$historique['quantite_vendu'],
            ];
        }
        return response()->json([
            "client" => $client,
            'facture'=>$facture,
            'vente'=>$vente,
            'payement'=>$payement,
            'produit'=>$produits
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Facture $facture)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EditFactureRequest $request, Facture $facture)
    {
        try {
            $facture->payement_id = $request->payement_id;
            $facture->montantVerser = $request->montantVerser;
            
            if ($request->has('numerofacture')) {
                $facture->numerofacture = $request->numerofacture;
            } else {
                $facture->numerofacture = $this->generernumerofacture();
            }
    
            $facture->update();
    
            return response()->json([
                'status_code' => 200,
                'status_message' => 'facture a été modifié',
                'data' => $facture
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
        try {
            $facture = Facture::findOrFail($id);

            $facture->delete();

            return response()->json([
                'status_code' => 200,
                'status_message' => 'facture a été bien supprimer',
                'data' => $facture
            ]);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }


}
