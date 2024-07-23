<?php

namespace App\Http\Resources\Admin;

use App\Http\Resources\Auth\AdminRegisterResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NewsResource extends JsonResource
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
            'title' => $this -> title,
            'writer' => $this -> writer,
            'event_date' => $this -> event_date,
            'img' => $this -> img,
            'url' => $this -> url,
            'part1' => $this -> part1,
            'part2' => $this -> part2,
            'part3' => $this -> part3,
            'keyWords' => $this -> keyWords,
            'news_views_count' => $this->news_views_count,
            'status' => $this -> status,
            
            'admin' => new AdminRegisterResource($this->admin),
            'category' => new CategoryResource($this->category)
        ];
    }
}
