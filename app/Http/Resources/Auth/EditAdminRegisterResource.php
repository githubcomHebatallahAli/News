<?php

namespace App\Http\Resources\Auth;

use Illuminate\Http\Request;
use App\Http\Resources\Admin\RoleResource;
use Illuminate\Http\Resources\Json\JsonResource;

class EditAdminRegisterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'email'=>$this->email,
            'password'=>$this->password,
            'role' => new RoleResource($this->role),
            'adsenseCode' => $this -> adsenseCode ,
            'status' => $this -> status
        ];
    }
}
