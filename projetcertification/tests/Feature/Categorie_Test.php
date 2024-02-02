<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;

use App\Models\Categorie;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class Categorie_Test extends TestCase
{
    /**
     * A basic feature test example.
     */

    public function test_categorie(): void
    {
       //ca permet à l'utilisateur de se connecter
       $user = User::factory()->create([
        'telephone' => '+221708314343',
     ]);
    $this->actingAs($user);
    
    // Création d'un client avec une factory
    $categorie = Categorie::factory()->make();

    // Envoi d'une requête HTTP POST vers la route d'enregistrement (api/produits) avec les données du produit
    $response = $this->json('POST', 'api/categorie/create', $categorie->toArray());

    // Assertion du statut de la réponse
    $response->assertStatus(200); // 200 indique que la création a réussi
    }
}
