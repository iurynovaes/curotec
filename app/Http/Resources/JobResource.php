<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'type' => $this->type,
            'description' => $this->description,
            'experience_level' => $this->experience_level,
            'remote' => $this->remote,
            'category' => $this->category->name ?? null,
            'location' => $this->location->name ?? null,
            'created_at' => $this->created_at->format('Y-m-d'),
        ];
    }
}
