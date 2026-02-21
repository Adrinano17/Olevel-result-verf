<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'date_of_birth' => ['required', 'date', 'before:today'],
            'gender' => ['required', 'in:male,female,other'],
            'phone_number' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string', 'max:500'],
            'state_of_origin' => ['required', 'string', 'max:255'],
            'local_government_area' => ['required', 'string', 'max:255'],
            'nationality' => ['nullable', 'string', 'max:255'],
            'next_of_kin_name' => ['required', 'string', 'max:255'],
            'next_of_kin_phone' => ['required', 'string', 'max:20'],
            'next_of_kin_address' => ['required', 'string', 'max:500'],
            'next_of_kin_relationship' => ['required', 'string', 'max:255'],
            'emergency_contact_name' => ['nullable', 'string', 'max:255'],
            'emergency_contact_phone' => ['nullable', 'string', 'max:20'],
            'emergency_contact_address' => ['nullable', 'string', 'max:500'],
            'emergency_contact_relationship' => ['nullable', 'string', 'max:255'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'first_name.required' => 'First name is required.',
            'last_name.required' => 'Last name is required.',
            'date_of_birth.required' => 'Date of birth is required.',
            'date_of_birth.before' => 'Date of birth must be in the past.',
            'gender.required' => 'Gender is required.',
            'phone_number.required' => 'Phone number is required.',
            'address.required' => 'Address is required.',
            'state_of_origin.required' => 'State of origin is required.',
            'local_government_area.required' => 'Local government area is required.',
            'next_of_kin_name.required' => 'Next of kin name is required.',
            'next_of_kin_phone.required' => 'Next of kin phone is required.',
            'next_of_kin_address.required' => 'Next of kin address is required.',
            'next_of_kin_relationship.required' => 'Next of kin relationship is required.',
        ];
    }
}
