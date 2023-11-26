<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\PhoneNumber;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $contacts = Contact::with(['phoneNumbers:id,phone_number,contact_id'])
            ->get();
        return response()->json($contacts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $this->validateContact($request);
            $contact = Contact::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name
            ]);

            if (!$contact) {
                throw new \Exception('Unable to save contact');
            }

            $phoneNumbers = $request->phone_numbers;
            foreach ($phoneNumbers as $phoneNumber) {
                $contact->phoneNumbers()->create([
                    'phone_number' => $phoneNumber
                ]);
            }
            return response()->json([
                'message' => 'Contact saved successfully',
                'contact' => $contact->load('phoneNumbers:id,phone_number,contact_id')
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Unable to save contact',
                'error' => $e->getMessage()
            ], 500);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        try {
            $contact = Contact::with('phoneNumbers')->findOrFail($id);
            return response()->json($contact);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Unable to find contact',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Search for a contact by phone number.
     * TODO: should return contact with all phone numbers?
     */
    public function findByPhoneNumber(string $phoneNumber): JsonResponse
    {
        try {
            $phoneNumber = $this->getPhoneNumberDigits($phoneNumber);
            $contacts = Contact::with('phoneNumbers:id,phone_number,contact_id')
                ->whereHas('phoneNumbers', function ($query) use ($phoneNumber) {
                    $query->where('phone_number_digits', 'like', '%' . $phoneNumber . '%');
                })
                ->get();

            if ($contacts->isEmpty()) {
                return response()->json([
                    'message' => 'Unable to find contact',
                    'error' => "Phone number $phoneNumber not found"
                ], 404);
            }
            return response()->json($contacts);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Unable to find contact',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {

        try {
            $this->validateContact($request);
            $contact = Contact::findOrFail($id);
            $contact->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name
            ]);

            $phoneNumbers = $request->phone_numbers;
            foreach ($phoneNumbers as $phoneNumber) {
                $contact->phoneNumbers()->create([
                    'phone_number' => $phoneNumber
                ]);
            }
            return response()->json([
                'message' => 'Contact updated successfully',
                'contact' => $contact->load('phoneNumbers:id,phone_number,contact_id')
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Unable to update contact',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $contact = Contact::find($id);
            $phoneNumbers = $contact->phoneNumbers;
            foreach ($phoneNumbers as $phoneNumber) {
                $phoneNumber->delete();
            }
            $contact->delete();
            return response()->json([
                'message' => "Contact $id deleted successfully"
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Unable to delete contact',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get the digits from a phone number.
     */
    protected function getPhoneNumberDigits(string $phoneNumber): string
    {
        return preg_replace('/[^0-9]/', '', $phoneNumber);
    }


    /**
     * Validate the contact and phone numbers request.
     */
    protected function validateContact(Request $request): void
    {
        $phoneNumbers = $request->phone_numbers;
        foreach ($phoneNumbers as $phoneNumber) {
            $phoneNumber = $this->getPhoneNumberDigits($phoneNumber);
            $exists = DB::table('phone_numbers')
                ->where('phone_number_digits', $phoneNumber)
                ->exists();
            if ($exists) {
                throw new \Exception("Phone number $phoneNumber already exists in the database");
            }
        }
        $this->validate($request, [
            'first_name' => 'string',
            'last_name' => 'string',
            'phone_numbers' => 'array',
        ]);
    }
}
