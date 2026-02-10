<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostUtmeResultRequest extends FormRequest
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
            'post_utme_reg_number' => [
                'required',
                'string',
                'max:50',
                'regex:/^[A-Z0-9\/\-]+$/i',
            ],
            'post_utme_score' => [
                'required',
                'integer',
                'min:0',
                'max:100',
            ],
            'exam_year' => [
                'required',
                'integer',
                'min:2000',
                'max:' . (date('Y') + 1),
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
            'post_utme_reg_number.required' => 'Post-UTME registration number is required.',
            'post_utme_score.required' => 'Post-UTME score is required.',
            'post_utme_score.min' => 'Post-UTME score must be at least 0.',
            'post_utme_score.max' => 'Post-UTME score cannot exceed 100.',
            'course_id.required' => 'Course is required.',
            'course_id.exists' => 'Selected course is invalid.',
        ];
    }
}



