<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\Admin\NewsResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Auth\UserRegisterResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
          return [

            'comment' => [
                'id' => $this->id,
                'comment' => $this->comment,
                'status' => $this->status,
                'user' => new UserRegisterResource($this->user),
                // 'news'=> new NewsResource($this->news),
                'news' => new NewsResource($this->whenLoaded('news')),
            ],
        ];
    }
}
