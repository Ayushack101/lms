<?php

namespace App\Http\Requests\BookContentFile;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreBookContentFileRequest extends FormRequest
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
            'description' => 'string|nullable',
            'thumbnail' => 'required|image|mimes:jpg,jpeg,png,webp|max:102400',
            'book_id' => 'required|exists:books,id',
            'content_id' => 'required|exists:contents,id',
            'board_id' => 'required|exists:boards,id',
            'subject_id' => 'required|exists:subjects,id',
        ];
    }
}
