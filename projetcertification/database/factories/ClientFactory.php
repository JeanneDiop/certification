<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
       
        return[
            'nom' => $this->faker->word,
            'prenom' => $this->faker->word,
            'code_client' => 'N92765',
            'telephone' => '+221705003208',
            'adresse' => $this->faker->word,
        ];
    }
}
