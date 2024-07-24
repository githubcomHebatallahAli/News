<?php

namespace App\Http\Controllers\Admin;


use App\Models\ContactUs;

use App\Traits\ManagesModelsTrait;
use App\Http\Controllers\Controller;

use App\Http\Resources\ContactUsResource;

class ContactUsController extends Controller
{
    use ManagesModelsTrait;
    public function showAll()
    {
        $this->authorize('manage_users');

        $ContactUs = ContactUs::with('user')->get();

        if (!$ContactUs) {
            return response()->json([
                'message' => "ContactUs not found."
            ], 404);
        }

        return response()->json([
            'data' =>ContactUsResource::collection($ContactUs),
            'message' => "Show all contact with user  Successfully."
        ]);

    }

    public function edit(string $id)
    {
        $this->authorize('manage_users');

        $ContactUs = ContactUs::with('user')->find($id);

        if (!$ContactUs) {
            return response()->json([
                'message' => "ContactUs not found."
            ], 404);
        }

        return response()->json([
            'data' =>new ContactUsResource($ContactUs),
            'message' => "Edit ContactUs By ID Successfully."
        ]);
    }

    public function destroy(string $id){

        return $this->destroyModel(ContactUs::class, ContactUsResource::class, $id);
        }

            public function showDeleted(){

            return $this->showDeletedModels(ContactUs::class, ContactUsResource::class);
        }

        public function restore(string $id)
        {

            return $this->restoreModel(ContactUs::class, $id);
        }

        public function forceDelete(string $id){

            return $this->forceDeleteModel(ContactUs::class, $id);
        }



}
