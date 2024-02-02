<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\historiquevente;

class HistoriqueventeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
            try {
              return response()->json([
                'status_code' => 200,
                'status_message' => 'tous les historiquesventes ont été recupéré',
                'data' => Historiquevente::all(),
              ]);
            } catch (Exception $e) {
              return response()->json($e);
            }
    }

    public function listerhistoriqueparvente($vente_id)
{
    try {
        $historiques = Historiquevente::where('vente_id', $vente_id)->get();

        return response()->json([
            'status_code' => 200,
            'status_message' => 'Historiques de vente pour la vente_id '.$vente_id.' récupérés avec succès',
            'data' => $historiques,
        ]);
    } catch (Exception $e) {
        return response()->json([
            'status_code' => 500,
            'status_message' => 'Erreur lors de la récupération des historiques de vente',
            'error' => $e->getMessage(),
        ], 500);
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(historiquevente $historiquevente)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(historiquevente $historiquevente)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, historiquevente $historiquevente)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(historiquevente $historiquevente)
    {
        //
    }
}
