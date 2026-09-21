<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
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
            'book_name' => $this->book_name,
            'subject' => $this->whenLoaded('subject'),
            'class' => $this->whenLoaded('class'),
            'contents' => $this->whenLoaded('contents'),
        ];
    }
}
