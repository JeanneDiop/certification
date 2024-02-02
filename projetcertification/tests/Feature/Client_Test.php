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
        'telephone' => '+221708314243',
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
            'telephone' => '+221770935343',
         ]);
        
           $this->actingAs($user);
           $response=$this->json('GET', 'api/client/lister');
          $response->assertStatus(200);
    }

    public function test_modifierclient(): void
    {
        $user = User::factory()->create([
            'telephone' => '+221770048221',
        ]);
        $this->actingAs($user);
    
        $client = Client::factory()->create([
            'telephone' => '+221707041201',
            'code_client' => 'T66453'
        ]);
    
        $response = $this->putJson("api/client/edit/$client->id", [
            'nom' => 'DIOP',
            'prenom' => 'Jeanne',
            'code_client' => 'P23430',  
            'telephone' => '+221761011211',
            'adresse' => 'Fass',
        ]);
    
        $response->assertStatus(200);
    
        // Utilisez la méthode first() pour récupérer le client créé
        $this->assertDatabaseHas('clients', [
            'id' => $client->id,
            'nom' => 'DIOP',
            'prenom' => 'Jeanne',
            'code_client' => 'P23430',  
            'telephone' => '+221761011211',
            'adresse' => 'Fass'
        ]);
    }
    
    
    
    public function test_supprimeclient()
    {
        $user = User::factory()->create([
            'telephone' => '+221761903856',
         ]);
        $this->actingAs($user);

        $client= Client::factory()->create([
            'telephone' => '704503021',
            'code_client' => 'R90060'
        ]);

        //  dd($produit->id);
    
    
        // $this->withoutMiddleware();
            $response = $this->json('DELETE', url("api/client/supprimer/{$client->id}"));
    
            $response->assertStatus(200);
    
            $this->assertDatabaseMissing('clients', ['id' => $client->id]);
    }
    
}
