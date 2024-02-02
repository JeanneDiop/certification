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
    // public function test_register_user(): void

    // {
    //     //Création d'un utilisateur avec une factory
    //     $user = User::factory()->create();

      
    //     //Envoi d'une requête HTTP POST vers la route d'enregistrement (api/register) avec les données de l'utilisateur
    //     $response = $this->json('POST','api/register', $user->toArray());
    //    //Assertion du statut de la réponse
    //     $response->assertStatus(200);

   
    // }

    // tester les lister les employes avec un user connecte
    public function test_listeremploye(): void 
    {
        $user = User::factory()->create([
            'telephone' => '+221766724341',
         ]);
        
           $this->actingAs($user);
           $response=$this->json('GET', 'api/employe/lister');
           $response->assertStatus(200);
    }
}

    

