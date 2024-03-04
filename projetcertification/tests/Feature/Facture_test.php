<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Facture;

use App\Models\Payement;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class Facture_test extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_facture(): void
    {
        // Allow the user to log in
        $user = User::factory()->create([
            'telephone' => '+221709660506',
        ]);
        $this->actingAs($user);
    
        $payement = Payement::factory()->create(); // Utilise make() au lieu de create()
        
        // Create a sale (Vente) with a factory, specifying the client_id, user_id, and other necessary fields
        $facture = [
            'user_id' => $user->id,
            'payement_id' => $payement->id,
            'montantVerser' => 3457
        ];
    
        // Send an HTTP POST request to the registration route (api/Vente/create) with the sale data
        $response = $this->json('POST', 'api/facture/create', $facture);
    
        // Assert the response status
        $response->assertStatus(200); // 200 indicates that the creation was successful
    }

    public function test_modifier_facture()
    {
        // Permettre à l'utilisateur de se connecter
        $user = User::factory()->create([
            'telephone' => '+221751630024',
        ]);
        $this->actingAs($user);
    
    
        // Créer un paiementpublic function test_modifier_facture()
{
    // Permettre à l'utilisateur de se connecter
    $user = User::factory()->create([
        'telephone' => '+221775332124',
    ]);
    $this->actingAs($user);

    // Créer un paiement
    $payement = Payement::factory()->create();

    // Créer une facture à modifier
    $facture = Facture::factory()->create([
        'payement_id' => $payement->id,
        'montantVerser' => 4557,
    ]);

    // Nouvelles données pour la facture mise à jour
    $newMontantVerser = 5000;

    // Envoyer une requête HTTP PUT pour mettre à jour la facture
    $response = $this->putJson("api/facture/edit/{$facture->id}", [
        'montantVerser' => $newMontantVerser,
        'payement_id' => $payement->id,
    ]);

    // Vérifier le statut de la réponse
    $response->assertStatus(200); // 200 indique que la mise à jour a réussi

    // Récupérer la facture mise à jour depuis la base de données
    $factureUpdated = Facture::find($facture->id);

    // Vérifier que la facture a été mise à jour dans la base de données avec le nouveau montant
    $this->assertEquals($newMontantVerser, $factureUpdated->montantVerser);
}

        $payement = Payement::factory()->create();
    
        // Créer une facture à modifier
        $facture = Facture::factory()->create([
            'payement_id' => $payement->id,
            'montantVerser' => 4557,
        ]);
    
        // Nouvelles données pour la facture mise à jour
        $newMontantVerser = 5000;
    
        // Envoyer une requête HTTP PUT pour mettre à jour la facture
        $response = $this->putJson("api/facture/edit/{$facture->id}", [
            'montantVerser' => $newMontantVerser,
            'payement_id' => $payement->id,
        ]);
    
        // Vérifier le statut de la réponse
        $response->assertStatus(200); // 200 indique que la mise à jour a réussi
    
        // Vérifier que la facture a été mise à jour dans la base de données
        $this->assertDatabaseHas('factures', [
            'id' => $facture->id,
            'montantVerser' => $newMontantVerser,
        ]);
    }
    

public function test_listerfactures(): void 
{
     $user = User::factory()->create([
        'telephone' => '+221775920643',
     ]);
    
       $this->actingAs($user);
       $response=$this->json('GET', 'api/facture/lister');
      $response->assertStatus(200);
}

public function test_supprimefacture()
{
    $user = User::factory()->create([
        'telephone' => '+22175623443',
     ]);
    $this->actingAs($user);

    $facture = Facture::factory()->create();

    $response = $this->json('DELETE', url("api/facture/supprimer/{$facture->id}"));

    $response->assertStatus(200);

        $this->assertDatabaseMissing('factures', ['id' => $facture->id]);
}

}
