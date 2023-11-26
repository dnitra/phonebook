<?php

namespace Database\Seeders;

use App\Models\Contact;

use App\Models\PhoneNumber;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Contact::factory()->count(300)->create()->each(function ($contact) {
            $contact->phoneNumbers()->saveMany(PhoneNumber::factory()->count(rand(1, 3))->make());
        });
    }
}
