<?php

namespace Database\Factories;

use App\Models\Contact;
use App\Models\Phone;

use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    protected $model = Contact::class;

    public function definition()
    {
        $contact = [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
        ];
        return $contact;
    }

}
