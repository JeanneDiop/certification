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
            'code_client' => $this->faker->unique()->regexify('G\d{5}'),
            'telephone' => '+221' . substr($this->faker->phoneNumber, 1),
            'adresse' => $this->faker->word,
        ];
    }
}
