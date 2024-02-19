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
        'telephone' => '+221708312343',
     ]);
    $this->actingAs($user);
    
    // Création d'un client avec une factory
    $categorie = Categorie::factory()->make();

    // Envoi d'une requête HTTP POST vers la route d'enregistrement (api/produits) avec les données du produit
    $response = $this->json('POST', 'api/categorie/create', $categorie->toArray());

    // Assertion du statut de la réponse
    $response->assertStatus(200); // 200 indique que la création a réussi
    }

    public function test_modifiercategorie(): void
{
    $user = User::factory()->create([
        'telephone' => '+221700229051',
    ]);
    $this->actingAs($user);

    $categorie = Categorie::factory()->create();

    $response = $this->putjson(("api/categorie/edit/{$categorie->id}"), [
        'nom' => 'fer9',
       
    ]);

    $response->assertStatus(200);

    $this->assertDatabaseHas('categories', [
        'id' => $categorie->id,
        'nom' => 'fer9',
        
    ]);
}

public function test_listercategories(): void 
{
     $user = User::factory()->create([
        'telephone' => '+22176921033',
     ]);
    
       $this->actingAs($user);
       $response=$this->json('GET', 'api/categorie/lister');
      $response->assertStatus(200);
}

public function test_supprimecategorie()
{
    $user = User::factory()->create([
        'telephone' => '+221781903056',
     ]);
    $this->actingAs($user);

    $categorie= Categorie::factory()->create();

    //  dd($produit->id);


    // $this->withoutMiddleware();
        $response = $this->json('DELETE', url("api/categorie/supprimer/{$categorie->id}"));

        $response->assertStatus(200);

        $this->assertDatabaseMissing('categories', ['id' => $categorie->id]);
}
}
