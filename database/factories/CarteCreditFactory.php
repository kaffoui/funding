<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CarteCreditFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id'  => User::factory(),
            'numero'  => $this->faker->creditCardNumber(),
            'titulaire' => $this->faker->firstName(),
            'type'     => $this->faker->creditCardType(),
            'date_validite' => $this->faker->creditCardExpirationDate(),
            'statut' => 'actif',

        ];
    }
}
