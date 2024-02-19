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
       
        return [
            'nom' => $this->faker->word,
            'prenom' => $this->faker->word,
            'code_client' => 'T00043',
            'telephone' => '+221769852450',
            'adresse' => $this->faker->word,
        ];
    }
}
