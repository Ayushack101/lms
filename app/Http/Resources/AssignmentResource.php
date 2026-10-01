<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AssignmentResource extends JsonResource
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
            'teacher_id' => $this->teacher_id,
            'book_id' => $this->book_id,
            'class_id' => $this->class_id,
            'section_id' => $this->section_id,
            'assignment_name' => $this->assignment_name,
            'end_date' => $this->end_date,

            'teacher' => $this->whenLoaded('teacher'),
            'book' => $this->whenLoaded('book'),
            'class' => $this->whenLoaded('class'),
            'section' => $this->whenLoaded('section'),
            'questions' => $this->whenLoaded('assignmentQuestions'),
        ];
    }
}
