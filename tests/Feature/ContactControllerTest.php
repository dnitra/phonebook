<?php

namespace Feature;

use App\Models\Contact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ContactControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_the_application_returns_a_successful_response_to_the_contacts_route(): void
    {
        $response = $this->get('/api/v1/contacts');
        $response->assertStatus(200);
    }


    public function test_the_store_method_creates_a_new_contact_with_phone_numbers(): void
    {
        $contact = Contact::factory()->make();
        $phoneNumbers = [
            $this->faker->phoneNumber(),
            $this->faker->phoneNumber(),
            $this->faker->phoneNumber()
        ];
        $response = $this->postJson('/api/v1/contacts', [
            'first_name' => $contact->first_name,
            'last_name' => $contact->last_name,
            'phone_numbers' => $phoneNumbers
        ]);
        $response->assertStatus(201);
        $response->assertJsonStructure([
            'message',
            'contact' => [
                'id',
                'first_name',
                'last_name',
                'phone_numbers' => [
                    '*' => [
                        'id',
                        'phone_number',
                        'contact_id'
                    ]
                ]
            ]
        ]);
    }

    public function test_the_store_method_returns_an_error_when_the_contact_is_not_saved(): void
    {
        $response = $this->postJson('/api/v1/contacts', [
            'errorTest' => 'error'
        ]);
        $response->assertStatus(500);
        $response->assertJsonStructure([
            'message',
            'error'
        ]);
    }

    public function test_the_show_method_returns_a_contact_with_phone_numbers(): void
    {
        $contact = Contact::factory()->create();
        $phoneNumbers = [
            $this->faker->phoneNumber(),
            $this->faker->phoneNumber(),
            $this->faker->phoneNumber()
        ];
        foreach ($phoneNumbers as $phoneNumber) {
            $contact->phoneNumbers()->create([
                'phone_number' => $phoneNumber
            ]);
        }
        $response = $this->getJson('/api/v1/contacts/' . $contact->id);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'id',
            'first_name',
            'last_name',
            'phone_numbers' => [
                '*' => [
                    'id',
                    'phone_number',
                    'contact_id'
                ]
            ]
        ]);
    }

    public function test_the_show_method_returns_an_error_when_the_contact_is_not_found(): void
    {
        $response = $this->getJson('/api/v1/contacts/1');
        $response->assertStatus(404);
        $response->assertJsonStructure([
            'message',
            'error'
        ]);
    }

    public function test_the_search_method_returns_a_contact_with_phone_numbers(): void
    {
        $contact = Contact::factory()->create();
        $phoneNumbers = [
            $this->faker->phoneNumber(),
            $this->faker->phoneNumber(),
            $this->faker->phoneNumber()
        ];
        foreach ($phoneNumbers as $phoneNumber) {
            $contact->phoneNumbers()->create([
                'phone_number' => $phoneNumber
            ]);
        }
        $response = $this->getJson('/api/v1/contacts/phone/' . $phoneNumbers[0]);
        $response->assertStatus(200);
    }

    public function test_the_search_method_returns_an_error_when_the_contact_is_not_found(): void
    {
        $response = $this->getJson('/api/v1/contacts/phone/1');
        $response->assertStatus(404);
        $response->assertJsonStructure([
            'message',
            'error'
        ]);
    }

    public function test_the_update_method_updates_a_contact_with_phone_numbers(): void
    {
        $contact = Contact::factory()->create();
        $phoneNumbers = [
            $this->faker->phoneNumber(),
            $this->faker->phoneNumber(),
            $this->faker->phoneNumber()
        ];
        foreach ($phoneNumbers as $phoneNumber) {
            $contact->phoneNumbers()->create([
                'phone_number' => $phoneNumber
            ]);
        }
        $response = $this->putJson('/api/v1/contacts/'.$contact->id, [
            'first_name' => $contact->first_name,
            'last_name' => $contact->last_name,
            //new phone number
            'phone_numbers' => [
                $this->faker->phoneNumber(),
                $this->faker->phoneNumber(),
                $this->faker->phoneNumber()
            ]
        ]);
        $response->assertStatus(201);
        $response->assertJsonStructure([
            'message',
            'contact' => [
                'id',
                'first_name',
                'last_name',
                'phone_numbers' => [
                    '*' => [
                        'id',
                        'phone_number',
                        'contact_id'
                    ]
                ]
            ]
        ]);
    }

    public function test_the_update_method_returns_an_error_when_the_contact_is_not_found(): void
    {
        $response = $this->putJson('/api/v1/contacts/1', [
            'errorTest' => 'error'
        ]);
        $response->assertStatus(500);
        $response->assertJsonStructure([
            'message',
            'error'
        ]);
    }

    public function test_the_destroy_method_deletes_a_contact_with_phone_numbers(): void
    {
        $contact = Contact::factory()->create();
        $phoneNumbers = [
            $this->faker->phoneNumber(),
            $this->faker->phoneNumber(),
            $this->faker->phoneNumber()
        ];
        foreach ($phoneNumbers as $phoneNumber) {
            $contact->phoneNumbers()->create([
                'phone_number' => $phoneNumber
            ]);
        }
        $response = $this->deleteJson('/api/v1/contacts/'.$contact->id);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'message'
        ]);
    }

    public function test_the_destroy_method_returns_an_error_when_the_contact_is_not_found(): void
    {
        $response = $this->deleteJson('/api/v1/contacts/1');
        $response->assertStatus(500);
        $response->assertJsonStructure([
            'message',
            'error'
        ]);
    }

    public function test_the_destroy_method_returns_an_error_when_the_contact_is_not_deleted(): void
    {
        $contact = Contact::factory()->create();
        $response = $this->deleteJson('/api/v1/contacts/testError');
        $response->assertStatus(500);
        $response->assertJsonStructure([
            'message',
            'error'
        ]);
    }
}
