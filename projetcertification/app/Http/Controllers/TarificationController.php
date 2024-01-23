<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Tarification;
use Illuminate\Http\Request;
use App\Http\Requests\Tarification\EditTarificationRequest;

class TarificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      try {
        return response()->json([
          'status_code' => 200,
          'status_message' => 'tous les tarifications ont été recupéré',
          'data' => Tarification::all(),
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
    public function store(Request $request)
    {
        {
            try {
              $tarification = new Tarification();
              $tarification->prixactuel= $request->prixactuel;
              $tarification->produit_id = $request->produit_id;

              $tarification->save();
        
              return response()->json([
                'status_code' => 200,
                'status_message' => 'tarification a été ajouté',
                'data' => $tarification
              ]);
            } catch (Exception $e) {
              return response()->json($e);
            }
          }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $tarification = Tarification::findOrFail($id);
    
            return response()->json($tarification);
        } catch (Exception) {
            return response()->json(['message' => 'Désolé, pas de tarification trouvé.'], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EditTarificationRequest $request, $id)
    {
        try {
          $tarification = Tarification::find($id);
          $tarification->prixactuel = $request->prixactuel;
          $tarification->produit_id = $request->produit_id;
          $tarification->save();
    
          return response()->json([
            'status_code' => 200,
            'status_message' => 'tarification a été modifié',
            'data' => $tarification
          ]);
        } catch (Exception $e) {
          return response()->json($e);
        }
      
        }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tarification $tarification)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
   
    {
        $produit = Tarification::findOrFail($id);

        $produit->delete();

        return response('tarification bien supprimé', 200);
    }
}