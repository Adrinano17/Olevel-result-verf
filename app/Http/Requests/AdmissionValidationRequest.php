<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdmissionValidationRequest extends FormRequest
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
            'jamb_result_id' => [
                'required',
                'exists:jamb_results,id',
            ],
            'olevel_verification_id' => [
                'required',
                'exists:verification_requests,id',
            ],
            'course_id' => [
                'required',
                'exists:courses,id',
            ],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'jamb_result_id.required' => 'JAMB result is required.',
            'jamb_result_id.exists' => 'Selected JAMB result is invalid.',
            'olevel_verification_id.required' => 'O-Level verification is required.',
            'olevel_verification_id.exists' => 'Selected O-Level verification is invalid.',
            'course_id.required' => 'Course is required.',
            'course_id.exists' => 'Selected course is invalid.',
        ];
    }
}






