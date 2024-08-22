<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SliderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return [
        //     "id" => $this -> id,
        //     'news' => new NewsResource($this->whenLoaded('news')),
        // ];

        return [
            'id' => $this->id,
            'news' => [
                'title' => $this->news->title,
                'description' => $this->news->description,
                'img' => $this->news->img,
                'news_id' => $this->news->id,
                'category_id' => $this->news->category_id,
            ],
        ];
    }
}
