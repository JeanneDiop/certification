<?php

namespace App\Http\Controllers\API;

use Exception;

use App\Models\Facture;
use Illuminate\Http\Request;
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
    public function store(CreateFactureRequest $request)
    {
        try
        {
               

               $facture = new Facture();
               $facture->numerofacture = $request->numerofacture;
               $facture->payement_id = $request->payement_id;
               $facture->save();


               return response()->json([
                   'status_code' => 200,
                   'status_message' => 'facture a été ajouté',
                   'data' => $facture
               ]);
           } catch (Exception $e) {
               return response()->json($e);
           }
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
            $facture = Facture::find($facture);
            $facture->numerofacture = $request->numerofacture;
            $facture->payement_id = $request->payement_id;
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
    public function destroy(Facture $facture)
    {
        try{
            $facture= Facture::findOrFail($facture);
    
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
