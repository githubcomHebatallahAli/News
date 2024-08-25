<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Category3Resource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
  return[
    "id" => $this->id,
    'category_name' => $this->whenLoaded('category', function () {
        return $this->category->name;
    }),
  ];

    }
}
