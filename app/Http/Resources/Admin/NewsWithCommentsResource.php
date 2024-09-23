<?php

namespace App\Http\Resources\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Auth\AdminRegisterResource;

class NewsWithCommentsResource extends JsonResource
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
            'description' => $this -> description,
            'writer' => $this -> writer,
            'event_date' => $this -> event_date,
            'img' => $this -> img,
            'videoUrl' => $this -> videoUrl,
            'videoLabel' => $this -> videoLabel,
            'url' => $this -> url,
            'part1' => $this -> part1,
            'part2' => $this -> part2,
            'part3' => $this -> part3,
            'keyWords' => $this -> keyWords,
            'news_views_count' => $this->news_views_count,
            // 'formatted_date' => $this->formatted_date,
             'formatted_date' => Carbon::parse($this->created_at)->format('M d, Y H:i:s'),
            'status' => $this -> status,
            'adsenseCode' => $this -> adsenseCode ,
            'admin' => new AdminRegisterResource($this->whenLoaded('admin')),
            'category' => new CategoryResource($this->whenLoaded('category')),
            'suggestedNews' => SuggestedNewsResource::collection($this->whenLoaded('suggestedNews')),
          'comments' => $this->whenLoaded('comments', function () {
            return NewsUserCommentsResource::collection($this->comments);
        }),
          ];
    }
}
