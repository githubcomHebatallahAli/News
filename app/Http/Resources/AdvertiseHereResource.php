<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Auth\UserRegisterResource;

class AdvertiseHereResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
   
        return [
            'user' => new UserRegisterResource($this->whenLoaded('user')),
            'AdvertiseHere' => [
                'id' => $this->id,
                'phone' => $this->phone,
                'message' => $this->message,
            ],
        ];
    }
}
