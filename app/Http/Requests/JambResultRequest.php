<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class JambResultRequest extends FormRequest
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
            'jamb_reg_number' => [
                'required',
                'string',
                'max:50',
                'regex:/^[A-Z0-9\/\-]+$/i',
            ],
            'jamb_score' => [
                'required',
                'integer',
                'min:0',
                'max:400',
            ],
            'exam_year' => [
                'required',
                'integer',
                'min:2000',
                'max:' . (date('Y') + 1),
            ],
            'subjects' => [
                'required',
                'array',
                'min:4',
                'max:4',
            ],
            'subjects.*.subject' => [
                'required',
                'string',
                'max:100',
            ],
            'subjects.*.score' => [
                'required',
                'integer',
                'min:0',
                'max:100',
            ],
            'first_choice_course_id' => [
                'required',
                'exists:courses,id',
            ],
            'second_choice_course_id' => [
                'nullable',
                'exists:courses,id',
            ],
            'third_choice_course_id' => [
                'nullable',
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
            'jamb_reg_number.required' => 'JAMB registration number is required.',
            'jamb_reg_number.regex' => 'JAMB registration number contains invalid characters.',
            'jamb_score.required' => 'JAMB score is required.',
            'jamb_score.min' => 'JAMB score must be at least 0.',
            'jamb_score.max' => 'JAMB score cannot exceed 400.',
            'subjects.required' => 'JAMB subjects are required.',
            'subjects.min' => 'You must provide exactly 4 subjects.',
            'subjects.max' => 'You must provide exactly 4 subjects.',
            'first_choice_course_id.required' => 'First choice course is required.',
            'first_choice_course_id.exists' => 'Selected first choice course is invalid.',
        ];
    }
}



