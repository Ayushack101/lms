<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
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
            'student_name' => $this->student_name,
            'student_mobile' => $this->student_mobile,
            'address' => $this->address,
            'school_name' => $this->school_name,
            'status' => $this->status,
            'teacher_code' => $this->teacher_code,
            'user_id' => $this->whenLoaded('user'),
            'class_id' => $this->whenLoaded('class'),
            'section_id' => $this->whenLoaded('section'),
            'teacher_id' => $this->whenLoaded('teacher'),
        ];
    }   
}
