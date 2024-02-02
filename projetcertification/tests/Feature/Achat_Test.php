<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Achat;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class Achat_Test extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_achat(): void
    
    {
        //ca permet à l'utilisateur de se connecter
        $user = User::factory()->create([
            'telephone' => '+221768104340',
         ]);
        $this->actingAs($user);
        
        // Création d'un produit avec une factory
        $produit = Achat::factory()->make();

        // Envoi d'une requête HTTP POST vers la route d'enregistrement (api/produits) avec les données du produit
        $response = $this->json('POST', 'api/achat/create', $produit->toArray());

        // Assertion du statut de la réponse
        $response->assertStatus(200); // 200 indique que la création a réussi

}


public function test_modifierachat(): void
{
    $user = User::factory()->create([
        'telephone' => '+221704200151',
    ]);
    $this->actingAs($user);

    $achat = Achat::factory()->create();

    $response = $this->putjson(("api/achat/edit/{$achat->id}"), [
        'nomachat' => 'achatfer9',
        'prixachat' => '5000',
        'montantachat' => '289078',
        'quantiteachat' => '45',
        'produit_id' => '2',
    ]);

    $response->assertStatus(200);

    $this->assertDatabaseHas('achats', [
        'id' => $achat->id,
        'nomachat' => 'achatfer9',
        'prixachat' => '5000',
        'montantachat' => '289078',
        'quantiteachat' => '45',
        'produit_id' => '2',
    ]);
}

  // tester les lister produits avec un user connecte
    public function test_listerachats(): void 
    {
         $user = User::factory()->create([
            'telephone' => '+221776920343',
         ]);
        
           $this->actingAs($user);
           $response=$this->json('GET', 'api/achat/lister');
          $response->assertStatus(200);
    }

    public function test_supprimeachat()
    {
        $user = User::factory()->create([
            'telephone' => '+2217741214143',
         ]);
        $this->actingAs($user);

        $achat = Achat::factory()->create();

        //  dd($produit->id);
    
    
        // $this->withoutMiddleware();
            $response = $this->json('DELETE', url("api/achat/supprimer/{$achat->id}"));
    
            $response->assertStatus(200);
    
            $this->assertDatabaseMissing('achats', ['id' => $achat->id]);
    }
}
