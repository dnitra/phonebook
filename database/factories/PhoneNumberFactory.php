<?php

namespace Database\Factories;

use App\Models\PhoneNumber;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */

class PhoneNumberFactory extends Factory
{
    protected $model = PhoneNumber::class;

    public function definition()
    {
        return [
            'phone_number' => $this->faker->phoneNumber(),
        ];
    }
}
