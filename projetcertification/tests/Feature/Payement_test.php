<?php

namespace Tests\Payement;

use Tests\TestCase;
use App\Models\User;
use App\Models\Vente;
use App\Models\Payement;
use App\Models\Client;
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
            'etat'=> 'comptant',
            'montant_restant'=> '0'
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
            'telephone' => '+22176061000',
        ]);
        $this->actingAs($user);
    
        // Créer une vente (Vente) avec une factory
        $vente = Vente::factory()->create();
    
        // Créer un paiement associé à la vente
        $paiement = Payement::factory()->create([
            'vente_id' => $vente->id,
            'montant_payement' => 5000,
        ]);
    
        // Envoyer une requête HTTP PUT à la route de modification (api/payement/edit/{vente}) avec les données de paiement mises à jour
        $response = $this->json( 'POST',"api/payement/edit/{$vente->id}", [
            'montant_payement' => 6000, // Montant à mettre à jour
        ]);
    
        // Vérifier que le statut de la réponse est un succès
        $response->assertStatus(200); // En supposant qu'une mise à jour réussie renvoie le statut 200
    
        // Vérifier que les données de paiement ont été correctement mises à jour
        $response->assertJson([
            'message' => 'Paiement modifier avec succès',
            'client_id' => $vente->client_id,
            'montant_payement' => 6000, // Montant mis à jour
            'payement' => [
                'id' => $paiement->id,
                'vente_id' => $vente->id,
                'montant_payement' => 6000, // Montant mis à jour
                // Ajoutez d'autres champs de paiement ici si nécessaire
            ],
        ]);
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


