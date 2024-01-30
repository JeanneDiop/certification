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
            $user = User::factory()->create();
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
        $response = $this->json('GET','api/produit/lister');

        $response->assertStatus(200);
    }


    //tester les lister produits avec un user connecte
    public function test_listerproduits(): void 
    {
           $user= User::factory()->create();
           $this->actingAs($user);
           $response=$this->json('GET', 'api/produit/lister');
           $response->assertStatus(200);
    }


    public function test_supprimeproduit()
    {
        $user = User::factory()->create();
        $produit = Produit::factory()->create(['user_id' => $user->id]);
    
        $this->actingAs($user);
    
        if ($produit->user_id === $user->id) {
            $response = $this->json('DELETE', url("produit/supprimer/{$produit->id}"));
    
            $response->assertStatus(200);
    
            $this->assertDatabaseMissing('produits', ['id' => $produit->id]);
        }
    }
    
    
    
    //     public function test_supprimerproduit()
    // {
    //     $prop = User::factory()->proprietaire()->create();
    //     $annonce = Annonce::factory()->create(['user_id' => $prop->id]);

    //     $this->actingAs($prop);

    //     if($annonce->user_id === $prop->id){
    //         $response = $this->json('DELETE', 'api/annonceDestroy' . $annonce->id);

    //         $response->assertStatus(200);

    //         $this->assertDatabaseMissing('annonces', ['id' => $annonce->id]);
    //     }

   // }

}
