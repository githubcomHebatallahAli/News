<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentNewsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'comment' =>[
                'id' => $this->id,
                'comment' => $this->comment,
                'status' => $this->status,
                'news'=> new NewsResource($this->news),
            ],

            ];

}
}
