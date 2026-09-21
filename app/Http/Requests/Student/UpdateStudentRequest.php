<?php

namespace App\Http\Requests\Student;

use App\Models\Student;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateStudentRequest extends FormRequest
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

        $student = Student::find($this->route('id'));

        return [
            'student_name' => 'required|string|max:255',
            'student_mobile' => 'required|string|max:10|unique:students,student_mobile,' . $this->route('id'),
            'student_password' => 'nullable|string|min:8|confirmed',
            'student_email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($student?->user_id)], // user
            'address' => 'required|string',
            'school_name' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
            'class_id' => 'required|exists:classes,id',
            'section_id' => 'required|exists:sections,id',
            'teacher_id' => 'required|exists:teachers,id',
        ];
    }
}
