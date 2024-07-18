<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\ContactUs;
use Illuminate\Http\Request;
use App\Traits\ManagesModelsTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContactUsRequest;
use App\Http\Resources\ContactUsResource;

class ContactUsController extends Controller
{
    use ManagesModelsTrait;
    public function showAll()
    {
        $this->authorize('manage_users');
        $usersWithContacts = User::whereHas('contactUs')->get();

        $usersArray = $usersWithContacts->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'contacts' => $user->contactUs->map(function ($contact) {
                    return [
                        'id' => $contact->id,
                        'phone' => $contact->phone,
                        'message' => $contact->message
                            ];
                        }),
                    ];
        })->toArray();

        return response()->json([
            'data' => $usersArray,
            'message' => "Show All Users With Messages Of Contact Us Successfully."
        ]);


    }

    public function edit(string $id)
    {
        $this->authorize('manage_users');

        $ContactUs = ContactUs::find($id);

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
