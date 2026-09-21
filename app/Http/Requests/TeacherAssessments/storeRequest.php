<?php

namespace App\Http\Requests\TeacherAssessments;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class storeRequest extends FormRequest
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
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
        'teacher_id' => 'required|exists:teachers,id',
        'test_template_id' => 'required|exists:test_templates,id',
        'class_id' => 'required|exists:classes,id',
        'section_id' => 'required|exists:sections,id',
        'book_id' => 'required|exists:books,id',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'status' => 'nullable|in:active,pending',
        ];
    }
}
