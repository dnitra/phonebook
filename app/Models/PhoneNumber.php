<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhoneNumber extends Model
{
    use HasFactory;

    protected $fillable = ['phone_number', 'contact_id'];
    protected $hidden = ['created_at', 'updated_at'];

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
    public function setPhoneNumberAttribute($value)
    {
        $this->attributes['phone_number'] = $value;
        $this->attributes['phone_number_digits'] = preg_replace('/[^0-9]/', '', $value);
    }
    //only return the phone number and id
    //where to use scopeSelectPhoneNumber?
    //in the controller
    //how?
    //Contact::with('phoneNumbers:contact_id,phone_number')->get();
}
