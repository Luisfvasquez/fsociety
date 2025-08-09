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
            'id' => $this->id,
            'name' => $this->name,
            'sale_price' => $this->sale_price,
            'date_of_entry' => $this->date_of_entry,
            'due_date' => $this->due_date,
            'category_id' => CategoryResource::make($this->whenLoaded('category')),
            'image' => $this->image,
            /* 'description' => $this->description, */
        ];
    }
}
