<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VerificationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Authorization handled in controller
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'exam_number' => [
                'required',
                'string',
                'max:50',
                'regex:/^[A-Z0-9\/\-]+$/i', // Alphanumeric, slashes, and hyphens
            ],
            'exam_year' => [
                'required',
                'integer',
                'min:2000',
                'max:' . (date('Y') + 1),
            ],
            'exam_body' => [
                'required',
                Rule::in(['WAEC', 'NECO']),
            ],
            'result_type' => [
                'required',
                'string',
                'max:50',
                Rule::in(['SSCE', 'GCE', 'MAY/JUN', 'NOV/DEC']),
            ],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'exam_number.required' => 'Exam number is required.',
            'exam_number.regex' => 'Exam number contains invalid characters.',
            'exam_year.required' => 'Exam year is required.',
            'exam_year.min' => 'Exam year must be 2000 or later.',
            'exam_year.max' => 'Exam year cannot be in the future.',
            'exam_body.required' => 'Exam body is required.',
            'exam_body.in' => 'Exam body must be WAEC or NECO.',
            'result_type.required' => 'Result type is required.',
            'result_type.in' => 'Invalid result type.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Trim and uppercase exam number
        if ($this->has('exam_number')) {
            $this->merge([
                'exam_number' => strtoupper(trim($this->exam_number)),
            ]);
        }
    }
}




