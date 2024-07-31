<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TNewsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this -> id,
            'trending_news' => new TrendingNewsResource($this->whenLoaded('trendingNews')),
            'news' => new NewsResource($this->whenLoaded('news')),

        ];
    }
}
