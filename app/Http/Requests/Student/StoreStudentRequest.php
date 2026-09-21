<?php

namespace App\Http\Requests\Student;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRequest extends FormRequest
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
            'student_name' => 'required|string|max:255',
            'student_mobile' => 'required|string|max:10|unique:students,student_mobile',
            'student_password' => 'required|string|min:8|confirmed', // user
            'student_email' => 'required|string|email|max:255|unique:users,email', // user
            'address' => 'required|string',
            'school_name' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
            'class_id' => 'required|exists:classes,id',
            'section_id' => 'required|exists:sections,id',
            'teacher_code' => 'required|exists:teachers,teacher_code',
        ];
    }
}
