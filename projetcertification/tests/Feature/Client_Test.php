<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Client;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class Client_Test extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_client(): void
    {
       //ca permet à l'utilisateur de se connecter
       $user = User::factory()->create([
        'telephone' => '+221708314343',
     ]);
    $this->actingAs($user);
    
    // Création d'un client avec une factory
    $client = Client::factory()->make([
        'code_client' => 'N66781',
    ]);

    // Envoi d'une requête HTTP POST vers la route d'enregistrement (api/produits) avec les données du produit
    $response = $this->json('POST', 'api/client/create', $client->toArray());

    // Assertion du statut de la réponse
    $response->assertStatus(200); // 200 indique que la création a réussi
    }
    // tester les lister produits avec un user connecte
    public function test_listerclients(): void 
    {
         $user = User::factory()->create([
            'telephone' => '+221770930343',
         ]);
        
           $this->actingAs($user);
           $response=$this->json('GET', 'api/client/lister');
          $response->assertStatus(200);
    }

    public function test_modifierclient(): void
    {
        $user = User::factory()->create([
            'telephone' => '+221704121143',
         ]);
        $this->actingAs($user);

        $client = Client::factory()->create([
            'telephone' => '+221779000000',
            'code_client' =>'H03451'
        ]);

        $response = $this->json('PUT', url("api/client/edit/2"), [
            'nom' => 'DIOP',
            'prenom' => 'Jeanne',
            'code_client' => 'R98677',
            'telephone' => '765463823',
            'adresse' => 'Fass',
        ]);
    
            $response->assertStatus(200);
    }
    
    
    public function test_supprimeclient()
    {
        $user = User::factory()->create([
            'telephone' => '+221765',
         ]);
        $this->actingAs($user);

        $client= Client::factory()->create();

        //  dd($produit->id);
    
    
        // $this->withoutMiddleware();
            $response = $this->json('DELETE', url("api/client/supprimer/1"));
    
            $response->assertStatus(200);
    
            $this->assertDatabaseMissing('clients', ['id' => 1]);
    }
    
}
