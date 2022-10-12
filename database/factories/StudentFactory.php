<?php

namespace Database\Factories;

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [

            // credentials
            'username' => $this->faker->userName(),
            'password' => Hash::make('password'),

            // name
            'lastname' => $this->faker->lastName(),
            'firstname' => $this->faker->firstName(),
            'middlename' => $this->faker->randomElement([null, $this->faker->lastName()]),

            // basic information
            'gender' => $this->faker->randomElement(['male', 'female']),
            'date_of_birth' => $this->faker->date(),
            'address' => $this->faker->address(),

            // contact information
            'email' => $this->faker->email(),
            'phone_number' => $this->faker->numerify('09########'),

            // enrollment information
            'section' => $this->faker->word(),
            'year_level' => $this->faker->numberBetween(7, 12),

            // picture
            'picture' => null,

            // registration information
            'status' => $this->faker->randomElement(['pending', 'enrolled', 'rejected'])
        ];
    }
}
