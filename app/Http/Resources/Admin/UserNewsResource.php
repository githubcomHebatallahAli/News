<?php

namespace App\Http\Resources\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserNewsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'news_id' => $this->id,
            'title' => $this->title,
            'img' => $this->img,
            // 'formatted_date' => $this->formatted_date,
            'formatted_date' => Carbon::parse($this->event_date)->format('Y-m-d H:i:s'),

        ];
    }
}
