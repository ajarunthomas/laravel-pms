<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\orderDetailResource;

class orderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'order_number' => $this->order_number,
            'order_time' => date('Y-m-d H:i:s', strtotime($this->created_at)),
            'items' => orderDetailResource::collection($this->details),
            'status' => $this->status
        ];
    }
}
