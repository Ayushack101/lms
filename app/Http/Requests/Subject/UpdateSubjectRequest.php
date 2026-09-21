<?php

namespace App\Http\Requests\Subject;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSubjectRequest extends FormRequest
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
            'subject_name' => 'required|string|max:255|unique:subjects,subject_name,' . $this->route('id'),
            'subject_code' => 'required|string|max:10|unique:subjects,subject_code,' . $this->route('id'),
            'board_id' => 'required|exists:boards,id',
        ];
    }
}
