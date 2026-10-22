<?php

namespace App\Http\Requests\TeacherCoding;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class TeacherCodingUpdateRequest extends FormRequest
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
            //
            'title' => 'required|string|max:255',
            'language'=> 'required|in:html,python,java,mysql,scratch lab,phet simulation,onlyoffice,c,cpp,javascript',
            'teacher_id' => 'required|exists:teachers,id',
            'book_id' => 'required|exists:books,id',
            'class_id' => 'required|exists:classes,id',
            'section_id' => 'required|exists:sections,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'questions' => 'required|string',
            'description' => 'required|string',
        ];
    }
}
