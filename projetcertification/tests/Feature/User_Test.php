<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class User_Test extends TestCase
{
    /**
     * A basic feature test example.
     */
   // use RefreshDatabase;
    public function test_register_user(): void

    {
        //Création d'un utilisateur avec une factory
        $user = User::factory()->create();

      
        //Envoi d'une requête HTTP POST vers la route d'enregistrement (api/register) avec les données de l'utilisateur
        $response = $this->json('POST','api/register', $user->toArray());
       //Assertion du statut de la réponse
        $response->assertStatus(200);

   
    }
    public function test_modifier_register(): void
    {
  // Création d'un utilisateur avec une factory et enregistrement dans la base de données
    $user = User::factory()->create();

    // Envoi d'une requête HTTP POST vers la route d'enregistrement (api/register) avec les données de l'utilisateur
    $response = $this->json('POST', 'api/register', $user->toArray());

    // Assertion du statut de la réponse
    $response->assertStatus(200);

    // Assertions supplémentaires pour vérifier que l'utilisateur a été correctement enregistré dans la base de données
    $this->assertDatabaseHas('users', [
        'email' => $user->email,
        // Ajoutez d'autres attributs à vérifier si nécessaire
    ]);
}

    }

