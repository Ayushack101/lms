<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CalendarResource extends JsonResource
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
            'description' => $this->description,
            'teacher_id' => $this->teacher_id,
            'book_id' => $this->book_id,
            'class_id' => $this->class_id,
            'section_id' => $this->section_id,
            'type' => $this->type,
            'date' => $this->date,
            'start_time' => $this->start_time,
            'status' => $this->status,

            'teacher' => $this->whenLoaded('teacher'),
            'book' => $this->whenLoaded('book'),
            'class' => $this->whenLoaded('class'),
            'section' => $this->whenLoaded('section'),



        ];
    }
}
