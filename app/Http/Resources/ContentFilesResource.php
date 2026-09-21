<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContentFilesResource extends JsonResource
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
            'file_type' => $this->file_type,
            'file_path' => $this->file_path,
            'extract_path' => $this->extract_path,
            'file_url' => $this->file_url,
            'extract_url' => $this->extract_url,
            'entry_file' => $this->entry_file,
            'description' => $this->description,
            'thumbnail' => $this->thumbnail,
            'book_id' => $this->book_id,
            'content_id' => $this->content_id,
        ];
    }
}
