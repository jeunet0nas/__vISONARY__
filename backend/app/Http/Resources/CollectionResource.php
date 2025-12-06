<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CollectionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'collection_id' => $this->collection_id,
            'collection_name' => $this->collection_name,
            'slug' => $this->slug,
            'released' => $this->released,
            'collection_desc' => $this->collection_desc,
            'banner_img' => asset($this->banner_img),
            'products' => ProductResource::collection($this->whenLoaded('products')),
        ];
    }
}
