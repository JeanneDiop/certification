<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class Client_Test extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
       //ca permet à l'utilisateur de se connecter
       $user = User::factory()->create([
        'telephone' => '+221788304343',
     ]);
    $this->actingAs($user);
    
    // Création d'un produit avec une factory
    $produit = Produit::factory()->make();

    // Envoi d'une requête HTTP POST vers la route d'enregistrement (api/produits) avec les données du produit
    $response = $this->json('POST', 'api/produit/create', $produit->toArray());

    // Assertion du statut de la réponse
    $response->assertStatus(200); // 200 indique que la création a réussi
    }
}
