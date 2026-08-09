<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GameResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'cover_url' => $this->coverUrl(),
            'price' => $this->price,
            'price_label' => $this->priceLabel(),
            'rating' => $this->rating,
            'released_at' => $this->released_at->toDateString(),
            'is_featured' => $this->is_featured,
            'category' => new CategoryResource($this->whenLoaded('category')),
            'platforms' => PlatformResource::collection($this->whenLoaded('platforms')),
        ];
    }
}
