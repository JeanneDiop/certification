<?php

namespace Database\Factories;

use App\Models\Vente;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payement>
 */
class PayementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $vente = Vente::factory()->create();
        return [
            'vente_id' => $vente->id,
            'montant_payement' => $this->faker->numberBetween(1000,100000),
            'montant_restant' => $this->faker->numberBetween(1000,100000),
            'etat' => $this->faker->randomElement(['comptant', 'acompte']),
        ];
    }
}