<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Facture;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class Facture_test extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_facture(): void
        {
            // Allow the user to log in
            $user = User::factory()->create([
                'telephone' => '+221778906750',
            ]);
            $this->actingAs($user);
        
            // Create a client (if needed)
            $client = Client::factory()->create([
                'telephone' => '+221767007000',
                'code_client' => 'T00026'
            ]);
        
            // Create a sale (Vente) with a factory, specifying the client_id, user_id, and other necessary fields
            $facture = [
                'user_id' => $user->id,
                'client_id' => $client->id,
                'montant_total' => 0, // Adjust this according to your logic
                'produit' =>  [
                    [ "id" => 2, "quantite" => 12],
                    [ "id" => 3, "quantite" => 14]
                ],
            ];
        
            // Send an HTTP POST request to the registration route (api/Vente/create) with the sale data
            $response = $this->json('POST', 'api/facture/create', $facture);
        
            // Assert the response status
            $response->assertStatus(200); // 200 indicates that the creation was successful
        }

        public function test_modifier_facture(): void
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
    $facture = Facture::factory()->create([
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
    $response = $this->json('PUT', "api/facture/edit/{$facture->id}", [
        'user_id' => $user->id,
        'client_id' => $client->id,
        'code_client' => $client->code_client, // Inclure le code client dans la requête de modification
        'montant_total' => $nouveauMontantTotal,
        'produit' => $nouveauxProduits,
    ]);

    // Vérifier que le statut de la réponse est un succès
    $response->assertStatus(200); // En supposant qu'une mise à jour réussie renvoie le statut 200
}

public function test_listerfactures(): void 
{
     $user = User::factory()->create([
        'telephone' => '+221775920343',
     ]);
    
       $this->actingAs($user);
       $response=$this->json('GET', 'api/facture/lister');
      $response->assertStatus(200);
}
public function test_supprimefacture()
{
    $user = User::factory()->create([
        'telephone' => '+2217740014141',
     ]);
    $this->actingAs($user);

    $facture = Facture::factory()->create();

        $response = $this->json('DELETE', url("api/facture/supprimer/{$facture->id}"));

        $response->assertStatus(200);

        $this->assertDatabaseMissing('ventes', ['id' => $facture->id]);
}
}
