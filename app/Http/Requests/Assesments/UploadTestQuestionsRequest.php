<?php

namespace App\Http\Requests\Assesments;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UploadTestQuestionsRequest extends FormRequest
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
            'book_id' => 'required|exists:books,id',
            'test_name' => 'required|string|max:255',
            'type' => 'required|in:objective,subjective',
            'description' => 'required|string',
            'questions_sheet' => 'required|file|mimes:xlsx,xls',
        ];
    }
}
