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

    public function test_modifierproduit(): void
    {
        $user = User::factory()->create([
            'telephone' => '+221704126153',
         ]);
        $this->actingAs($user);

        $produit = Produit::factory()->create();
    
    
        // $this->withoutMiddleware();
        $response = $this->json('PUT', url("api/produit/edit/{$produit->id}"), [
            'nomproduit' => 'fer9',
            'image' => 'image.png',
            'prixU' => '2890',
            'quantite' => '45',
            'quantiteseuil' => '10',
            'etat' => 'en_stock',
            'categorie_id' => '1'
        ]);
    
            $response->assertStatus(200);

            $this->assertDatabaseHas('produits',[
                'nomproduit' => 'fer9',
                'image' => 'image.png',
                'prixU' => '2890',
                'quantite' => '45',
                'quantiteseuil' => '10',
                'etat' => 'en_stock',
                'categorie_id' => '1'

            ]);
    }
    

    //tester les lister les produits
    public function test_listerproduit(): void
    {

        $response = $this->json('GET','api/produits/lister');

        $response->assertStatus(200);
    }
    
    public function test_supprimeproduit()
    {
        $user = User::factory()->create([
            'telephone' => '+2217721214343',
         ]);
        $this->actingAs($user);

        $produit = Produit::factory()->create();

            $response = $this->json('DELETE', url("api/produit/supprimer/{$produit->id}"));
    
            $response->assertStatus(200);
    
            $this->assertDatabaseMissing('produits', ['id' => $produit->id]);
    }
    

}
