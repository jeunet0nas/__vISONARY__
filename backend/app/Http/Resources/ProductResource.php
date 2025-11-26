<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'product_id' => $this->product_id,
            'product_name' => $this->product_name,
            'slug' => $this->slug,
            'shape' => $this->shape,
            'material' => $this->material,
            'released_at' => $this->released_at,
            'product_qty' => $this->product_qty,
            'product_price' => $this->product_price,
            'product_desc' => $this->product_desc,
            'thumbnail' => $this->thumbnail ? asset($this->thumbnail) : null,
            'first_img' => $this->first_img ? asset($this->first_img) : null,
            'second_img' => $this->second_img ? asset($this->second_img) : null,
            'third_img' => $this->third_img ? asset($this->third_img) : null,
            'fourth_img' => $this->fourth_img ? asset($this->fourth_img) : null,
            'status' => $this->status,
            'collection_id' => $this->collection_id,
            'collection_name' => $this->collection?->collection_name,
            'reviews' => $this->reviews
        ];
    }
}
