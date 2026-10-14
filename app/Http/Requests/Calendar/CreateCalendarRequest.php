<?php

namespace App\Http\Requests\Calendar;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateCalendarRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'teacher_id' => 'required|exists:teachers,id',
            'book_id' => 'required|exists:books,id',
            'class_id' => 'required|exists:classes,id',
            'section_id' => 'required|exists:sections,id',
            'type' => 'required|in:assignment,assessment,coding lab',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'status' => 'required|in:active,inactive',
        ];
    }
}
