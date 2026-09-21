<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeacherResource extends JsonResource
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
            'teacher_name' => $this->teacher_name,
            'teacher_mobile' => $this->teacher_mobile,
            'teacher_code' => $this->teacher_code,
            'school_name' => $this->school_name,
            'school_address' => $this->school_address,
            'personal_address' => $this->personal_address,
            'principal_name' => $this->principal_name,
            'dob' => $this->dob,
            'session_start' => $this->session_start,
            'representative_name' => $this->representative_name,
            'representative_contact' => $this->representative_contact,
            'status' => $this->status,
            'user' => $this->whenLoaded('user'),
            'board' => $this->whenLoaded('board'),
            'classes' => $this->whenLoaded('classes'),
            'subjects' => $this->whenLoaded('subjects'),
            'books' => $this->whenLoaded('books'),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
