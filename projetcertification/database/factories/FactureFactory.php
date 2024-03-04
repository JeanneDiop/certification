<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Payement;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Facture>
 */
class FactureFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'payement_id' => Payement::factory()->create()->id,
            'numerofacture' => strtoupper($this->faker->randomLetter() . $this->faker->randomLetter()) . $this->faker->randomNumber(6, true),
            'montantVerser' => $this->faker->numberBetween(1000,100000),
        ];
    }
}
