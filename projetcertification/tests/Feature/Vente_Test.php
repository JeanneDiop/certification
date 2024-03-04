<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Str;
use App\Models\Vente;
use App\Models\Client;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class Vente_Test extends TestCase
{
    /**
     * A basic feature test example.
     */
    // public function test_vente(): void
    
    // {
    //     // Allow the user to log in
    //     $user = User::factory()->create([
    //         'telephone' => '+221767910093',
    //     ]);
    //     $this->actingAs($user);
    
    //     // Create a client (if needed)
    //     $client = Client::factory()->create([
    //         'telephone' => '+221767801020',
    //         'code_client' => 'T04610'
    //     ]);
    
    //     // Create a sale (Vente) with a factory, specifying the client_id and user_id
    //     $vente = [
    //         'client_id' => $client->id,
    //         'produit' =>  [
    //             [ "id"=>4, "quantite"=> 12],
    //             [ "id"=> 3, "quantite"=>14]
    //         ],
    //     ];
    
    //     // Send an HTTP POST request to the registration route (api/Vente/create) with the sale data
    //     $response = $this->json('POST', 'api/vente/create', $vente);
    
    //     // Assert the response status
    //     $response->assertStatus(200); // 200 indicates that the creation was successful
    // }

    public function test_vente(): void
{
    // Allow the user to log in
    $user = User::factory()->create([
        'telephone' => '+221700906750',
    ]);
    $this->actingAs($user);

    // Create a client (if needed)
    $client = Client::factory()->create([
        'telephone' => '+221707017000',
        'code_client' => 'T00316'
    ]);

    // Create a sale (Vente) with a factory, specifying the client_id, user_id, and other necessary fields
    $vente = [
        'user_id' => $user->id,
        'client_id' => $client->id,
        'montant_total' => 0, // Adjust this according to your logic
        'produit' =>  [
            [ "id" => 15, "quantite" => 12],
            [ "id" => 16, "quantite" => 14]
        ],
    ];

    // Send an HTTP POST request to the registration route (api/Vente/create) with the sale data
    $response = $this->json('POST', 'api/vente/create', $vente);

    // Assert the response status
    $response->assertStatus(200); // 200 indicates that the creation was successful
}


public function test_modifier_vente(): void
{
    // Autoriser l'utilisateur à se connecter
    $user = User::factory()->create([
        'telephone' => '+221704771856',
    ]);
    $this->actingAs($user);

    // Créer un client (si nécessaire)
    $client = Client::factory()->create([
        'telephone' => '+221770230525',
        'code_client'=>'S00593'
    ]);

    // Créer une vente (Vente) avec une factory
    $vente = Vente::factory()->create([
        'user_id' => $user->id,
        'client_id' => $client->id,
        'montant_total' => 180, // Ajuster selon votre logique
    ]);

    // Modifier les données de vente
    $nouveauMontantTotal = 100; // Supposons que le nouveau montant total est 100
    $nouveauxProduits = [
        [ "id" => 15, "quantite" => 1], // Mettre à jour le produit existant ou ajouter de nouveaux produits
        [ "id" => 16, "quantite" => 2]
    ];

    // Envoyer une requête HTTP PUT à la route de modification (api/Vente/update/{id}) avec les données de vente mises à jour
    $response = $this->json('PUT', "api/vente/edit/{$vente->id}", [
        'user_id' => $user->id,
        'client_id' => $client->id,
        'code_client' => $client->code_client, // Inclure le code client dans la requête de modification
        'montant_total' => $nouveauMontantTotal,
        'produit' => $nouveauxProduits,
    ]);

    // Vérifier que le statut de la réponse est un succès
    $response->assertStatus(200); // En supposant qu'une mise à jour réussie renvoie le statut 200
}

public function test_listerventes(): void 
{
     $user = User::factory()->create([
        'telephone' => '+221705920343',
     ]);
    
       $this->actingAs($user);
       $response=$this->json('GET', 'api/vente/lister');
      $response->assertStatus(200);
}

public function test_supprimevente()
{
    $user = User::factory()->create([
        'telephone' => '+221764034141',
     ]);
    $this->actingAs($user);

    $vente = Vente::factory()->create();

        $response = $this->json('DELETE', url("api/vente/supprimer/{$vente->id}"));

        $response->assertStatus(200);

        $this->assertDatabaseMissing('ventes', ['id' => $vente->id]);
}

}
    
