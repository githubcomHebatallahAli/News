<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryBestNewsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            'id' => $this->id,
            'name' => $this->name,
            'url' => $this -> url,
            'views_count' => $this->views_count,
            'news_count' => $this->news_count,
            'news' =>  NewsAdminResource::collection($this->news),
            'bestNews' => BestNewsResource::collection($this->bestNews)];
    }
}
