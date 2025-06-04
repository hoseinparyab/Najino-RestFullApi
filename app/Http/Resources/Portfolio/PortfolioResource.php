<?php

namespace App\Http\Resources\Portfolio;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PortfolioResource extends JsonResource
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
            'site_address' => $this->site_address,
            'our_job' => $this->our_job,
            'cover_image' => $this->cover_image ? asset('storage/' . $this->cover_image) : null,
            'images' => $this->images ? asset('storage/' . $this->images) : null,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
