<?php

namespace App\Http\Requests\Teacher;

use App\Models\Teacher;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTeacherRequest extends FormRequest
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
        $teacher = Teacher::find($this->route('id'));

        return [
            'teacher_name' => 'required|string|max:255', // user
            'teacher_password' => 'nullable|string|min:8|confirmed', // user
            'teacher_email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($teacher?->user_id),
            ], // user
            'teacher_mobile' => 'required|string|max:10|unique:teachers,teacher_mobile,' . $this->route('id'),
            'school_name' => 'required|string|max:255',
            'school_address' => 'required|string',
            'personal_address' => 'required|string',
            'principal_name' => 'required|string|max:255',
            'dob' => 'required|date',
            'session_start' => 'required|string|max:255',
            'representative_name' => 'required|string|max:255',
            'representative_contact' => 'required|string|max:10',
            'status' => 'required|in:active,inactive',
            'board_id' => 'required|exists:boards,id',
            'class_ids' => 'required|array',
            'class_ids.*' => 'exists:classes,id',
            'subject_books' => 'required|array|min:1',
            'subject_books.*.subject_id' => 'required|exists:subjects,id',
            'subject_books.*.book_ids' => 'required|array|min:1',
            'subject_books.*.book_ids.*' => 'exists:books,id',
        ];
    }
}
