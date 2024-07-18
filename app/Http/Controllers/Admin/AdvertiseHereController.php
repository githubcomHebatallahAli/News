<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\AdvertiseHere;
use App\Traits\ManagesModelsTrait;
use App\Http\Controllers\Controller;
use App\Http\Resources\AdvertiseHereResource;


class AdvertiseHereController extends Controller
{
    use ManagesModelsTrait;
    public function showAll()
    {
        $this->authorize('manage_users');
        $usersWithAdvertisments = User::whereHas('AdvertiseHere')->get();

        $usersArray = $usersWithAdvertisments->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'contacts' => $user->AdvertiseHere->map(function ($advertise) {
                    return [
                        'id' => $advertise->id,
                        'phone' => $advertise->phone,
                        'message' => $advertise->message
                            ];
                        }),
                    ];
        })->toArray();

        return response()->json([
            'data' => $usersArray,
            'message' => "Show All Users With Messages Of Advertise Here Successfully."
        ]);


    }

    public function edit(string $id)
    {
        $this->authorize('manage_users');

        $AdvertiseHere = AdvertiseHere::find($id);

        if (!$AdvertiseHere) {
            return response()->json([
                'message' => "AdvertiseHere not found."
            ], 404);
        }

        return response()->json([
            'data' =>new AdvertiseHereResource($AdvertiseHere),
            'message' => "Edit AdvertiseHere By ID Successfully."
        ]);
    }

    public function destroy(string $id){

        return $this->destroyModel(AdvertiseHere::class, AdvertiseHereResource::class, $id);
        }

            public function showDeleted(){

            return $this->showDeletedModels(AdvertiseHere::class, AdvertiseHereResource::class);
        }

        public function restore(string $id)
        {

            return $this->restoreModel(AdvertiseHere::class, $id);
        }

        public function forceDelete(string $id){

            return $this->forceDeleteModel(AdvertiseHere::class, $id);
        }

}
