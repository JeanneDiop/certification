<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Vente;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class Payement_test extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_payement(): void
    {
        // Allow the user to log in
        $user = User::factory()->create([
            'telephone' => '+221762349067',
        ]);
        $this->actingAs($user);
    
        // Create a client (if needed)
        $vente = Vente::factory()->create();
    
        // Create a sale (Vente) with a factory, specifying the client_id, user_id, and other necessary fields
        $payement = [
            'vente_id' => $vente->id,
            'montantVerser' => 5000,
            'etat'=> 'comptant'
        ];
    
        // Send an HTTP POST request to the registration route (api/Vente/create) with the sale data
        $response = $this->json('POST', "api/payement/create/{$vente->id}", $payement); // Utilisez des accolades pour inclure la variable $vente->id
    
        // Assert the response status
        $response->assertStatus(200); // 200 indicates that the creation was successful
    }
    

        public function test_modifier_payement(): void
{
    // Autoriser l'utilisateur à se connecter
    $user = User::factory()->create([
        'telephone' => '+221764775656',
    ]);
    $this->actingAs($user);

    // Créer un client (si nécessaire)
    $client = Client::factory()->create([
        'telephone' => '+221770112525',
        'code_client'=>'K70013'
    ]);

    // Créer une vente (Vente) avec une factory
    $payement = Payement::factory()->create([
        'user_id' => $user->id,
        'client_id' => $client->id,
        'montant_total' => 180, // Ajuster selon votre logique
    ]);

    // Modifier les données de vente
    $nouveauMontantTotal = 100; // Supposons que le nouveau montant total est 100
    $nouveauxProduits = [
        [ "id" => 2, "quantite" => 5], // Mettre à jour le produit existant ou ajouter de nouveaux produits
        [ "id" => 3, "quantite" => 8]
    ];

    // Envoyer une requête HTTP PUT à la route de modification (api/Vente/update/{id}) avec les données de vente mises à jour
    $response = $this->json('PUT', "api/payement/edit/{$payement->id}", [
        'user_id' => $user->id,
        'client_id' => $client->id,
        'code_client' => $client->code_client, // Inclure le code client dans la requête de modification
        'montant_total' => $nouveauMontantTotal,
        'produit' => $nouveauxProduits,
    ]);

    // Vérifier que le statut de la réponse est un succès
    $response->assertStatus(200); // En supposant qu'une mise à jour réussie renvoie le statut 200
}

public function test_listerpayements(): void 
{
     $user = User::factory()->create([
        'telephone' => '+221775920343',
     ]);
    
       $this->actingAs($user);
       $response=$this->json('GET', 'api/payement/lister');
      $response->assertStatus(200);
}
public function test_supprimepayement()
{
    $user = User::factory()->create([
        'telephone' => '+2217740014141',
     ]);
    $this->actingAs($user);

    $payement = Payement::factory()->create();

        $response = $this->json('DELETE', url("api/payement/supprimer/{$payement->id}"));

        $response->assertStatus(200);

        $this->assertDatabaseMissing('ventes', ['id' => $payement->id]);
}

    }

