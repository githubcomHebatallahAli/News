<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use App\Http\Resources\CommentResource;
use App\Http\Resources\ContactUsResource;
use App\Http\Resources\AdvertiseHereResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            // 'id'=>$this->id,
            // 'name'=>$this->name,
            // 'email'=>$this->email,
            // 'comments' => CommentNewsResource::collection($this->comments),
            // 'contactUs' => ContactUsResource::collection($this->contactUs),
            // 'advertiseHere' => AdvertiseHereResource::collection($this->advertiseHere),
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'comments' => CommentNewsResource::collection($this->whenLoaded('comments')),
            'contactUs' => ContactUsResource::collection($this->whenLoaded('contactUs')),
            'advertiseHere' => AdvertiseHereResource::collection($this->whenLoaded('advertiseHere')),
        ];
    }
}
