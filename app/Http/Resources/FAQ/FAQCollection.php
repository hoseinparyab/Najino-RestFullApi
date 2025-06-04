<?php

namespace App\Http\Resources\FAQ;

use Illuminate\Http\Resources\Json\ResourceCollection;

class FAQCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'data' => FAQResource::collection($this->collection),
            'links' => [
                'self' => 'link-value',
            ],
        ];
    }
}
