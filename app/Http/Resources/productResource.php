<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class productResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description == null ? '' : $this->description,
            'category_name' => categoryResource::collection($this->category)->pluck('name'),
            'category' => categoryResource::collection($this->category),
            'price' => $this->price,
            'stock_quantity' => $this->stock_quantity
        ];
    }
}
