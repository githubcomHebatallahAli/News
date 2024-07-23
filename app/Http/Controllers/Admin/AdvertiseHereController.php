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

        $this->authorize('manage_users');

        $advertiseHere = AdvertiseHere::with('user')->get();

        if ($advertiseHere->isEmpty()) {
            return response()->json([
                'message' => "No AdvertiseHere messages found."
            ], 404);
        }

        return response()->json([
            'data' => AdvertiseHereResource::collection($advertiseHere),
            'message' => "Show all AdvertiseHere messages with user details successfully."
        ]);



    }

    public function edit(string $id)
    {
        $this->authorize('manage_users');

        $AdvertiseHere = AdvertiseHere::with('user')->find($id);

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
