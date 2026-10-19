<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CodingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'language' => $this->language,
            'teacher_id' => $this->teacher_id,
            'book_id' => $this->book_id,
            'class_id' => $this->class_id,
            'section_id' => $this->section_id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'questions' => $this->questions,
            'description' => $this->description,


            'teacher' => $this->whenLoaded('teacher'),
            'book' => $this->whenLoaded('book'),
            'class' => $this->whenLoaded('class'),
            'section' => $this->whenLoaded('section'),
            'studentCodingLabAttempts' => $this->whenLoaded('studentCodingLabAttempts'),
        ];
    }
}
