<?php

namespace Database\Factories;

use App\Models\Produit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Achat>
 */
class AchatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $produit=Produit::factory()->create();
        return[
            'nomachat' => $this->faker->word,
            'prixachat' =>$this->faker->randomNumber(2),
            'montantachat' => $this->faker->numberBetween(1000,80000),
            'quantiteachat' => $this->faker->numberBetween(1,300),
            'produit_id' => $produit->id,
           
        ];
       
    }
}
