<?php

namespace Database\Factories;

use App\Models\Categorie;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Produit>
 */
class ProduitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categorie=Categorie::factory()->create();
        return[
            'nomproduit' => $this->faker->word,
            'image' => $this->faker->imageUrl(),
            'quantite' => $this->faker->numberBetween(1,100),
            'quantiteseuil' => $this->faker->numberBetween(1,10),
            'prixU' => $this->faker->randomNumber(2), // Génère un nombre entier avec 2 chiffres
            'etat' => 'en_stock',
            'categorie_id' => $categorie->id,
           
        ];
       
    }
}
