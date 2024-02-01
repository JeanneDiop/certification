<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Produit;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class Produit_Test extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_produit(): void
    
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

    //tester les lister les produits
    public function test_listerproduit(): void
    {

        $response = $this->json('GET','api/produits/lister');

        $response->assertStatus(200);
    }
    // public function test_listerproduit2(): void
    // {
    //     $user = User::factory()->create([
    //         'telephone' => '+221773855461',
    //      ]);
    //     $this->actingAs($user); // Authentifiez l'utilisateur
    
    //     $produit1 = Produit::all();
        
    //     $response = $this->json('GET', 'api/produit/lister');
     
    //     // $response->assertStatus(200);
     
    //     $response->assertStatus(200)
    //     ->assertJson([
    //         'message' => 'tout les produits listés',
    //         'data' => $produit1->toArray(),
    //     ]);
    // }
    

    // tester les lister produits avec un user connecte
    // public function test_listerproduits(): void 
    // {
    //     $user = User::factory()->create([
    //         'telephone' => '+221776924343',
    //      ]);
        
    //        $this->actingAs($user);
    //        $response=$this->json('GET', 'api/produit/lister');
    //        $response->assertStatus(200);
    // }


    public function test_supprimeproduit()
    {
        $user = User::factory()->create([
            'telephone' => '+2217741214343',
         ]);
        $this->actingAs($user);

        $produit = Produit::factory()->create();

        //  dd($produit->id);
    
    
        // $this->withoutMiddleware();
            $response = $this->json('DELETE', url("api/produit/supprimer/2"));
    
            $response->assertStatus(200);
    
            $this->assertDatabaseMissing('produits', ['id' => 2]);
    }
    

}
