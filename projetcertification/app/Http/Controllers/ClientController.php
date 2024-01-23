<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Requests\Client\EditClientRequest;
use App\Http\Requests\Client\CreateClientRequest;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
          return response()->json([
            'status_code' => 200,
            'status_message' => 'tous les clients ont été recupéré',
            'data' => Client::all(),
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
    public function store(CreateClientRequest $request)
    {
        {
            try {
              $client = new Client();
              $client->nom= $request->nom;
              $client->prenom= $request->prenom;
              $client->code_client= $request->code_client;
              $client->telephone= $request->telephone;
              $client->adresse= $request->adresse;
              $client->save();
        
              return response()->json([
                'status_code' => 200,
                'status_message' => 'client a été ajouté',
                'data' => $client
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
            $client = Client::findOrFail($id);
    
            return response()->json($client);
        } catch (Exception) {
            return response()->json(['message' => 'Désolé, pas de client trouvé.'], 404);
        }
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EditClientRequest $request, $id)
    {
         
        try {
        $client = Client::find($id);
        $client->nom= $request->nom;
        $client->prenom= $request->prenom;
        $client->code_client= $request->code_client;
        $client->telephone= $request->telephone;
        $client->adresse= $request->adresse;
        $client->save();
    
          return response()->json([
            'status_code' => 200,
            'status_message' => 'client a été modifié',
            'data' => $client
          ]);
        } catch (Exception $e) {
          return response()->json($e);
        }
      
        }
    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, Client $client)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $client = Client::findOrFail($id);

        $client->delete();

        return response('client  bien supprimé', 200);
    }
}