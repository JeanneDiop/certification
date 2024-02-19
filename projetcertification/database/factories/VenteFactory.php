<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Produit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vente>
 */
class VenteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
     {
        $client = Client::factory()->create();
       // $produit = Produit::factory()->create();

        return [
            'client_id' => $client->id,
            'montant_total'=> $this->faker->numberBetween(1000,80000),
           // 'quantite' => $this->faker->randomNumber(2),
            // Autres champs de votre modèle Vente
        ];
    }
}
