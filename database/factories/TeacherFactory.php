<?php

namespace Database\Factories;

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeacherFactory extends Factory
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
            'teacher_id' => $this->faker->unique()->numerify('200####'),
            'password' => Hash::make('password'),

            // name
            'lastname'  => $this->faker->lastName(),
            'firstname'  => $this->faker->firstName(),
            'middlename'  => $this->faker->randomElement([$this->faker->lastName(), NULL]),

            // basic information
            'gender' => $this->faker->randomElement(['male', 'female']),
            'date_of_birth' => $this->faker->date(),
            'address' => $this->faker->address(),

            // contact information
            'email' => $this->faker->email(),
            'phone_number' => $this->faker->numerify('09#########'),

            // picture
            'picture' => NULL
        ];
    }
}
