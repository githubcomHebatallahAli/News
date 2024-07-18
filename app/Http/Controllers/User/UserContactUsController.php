<?php

namespace App\Http\Controllers\User;

use App\Models\ContactUs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContactUsRequest;
use App\Http\Resources\ContactUsResource;

class UserContactUsController extends Controller
{
    public function create(ContactUsRequest $request)
    {

           $ContactUs =ContactUs::create ([

                "name" => $request->name,
                "email" => $request->email,
                "phone" => $request->phone,
                "message" => $request->message
            ]);
           $ContactUs->save();
           return response()->json([
            'data' =>new ContactUsResource($ContactUs),
            'message' => "ContactUs Created Successfully."
        ]);

        }


    public function edit(string $id)
    {

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



    public function update(ContactUsRequest $request, string $id)
    {
        $this->authorize('manage_users');
       $ContactUs =ContactUs::findOrFail($id);

       if (!$ContactUs) {
        return response()->json([
            'message' => "ContactUs not found."
        ], 404);
    }
       $ContactUs->update([
                "name" => $request->name,
                "email" => $request->email,
                "phone" => $request->phone,
                "message" => $request->message
        ]);

       $ContactUs->save();
       return response()->json([
        'data' =>new ContactUsResource($ContactUs),
        'message' => " Update ContactUs By Id Successfully."
    ]);
}

public function forceDelete(string $id){

    $contactUs=ContactUs::withTrashed()->where('id',$id)->first();
    if (!$contactUs) {
        return response()->json([
            'message' => "A Contact Us not found."
        ], 404);
    }

        $contactUs->forceDelete();
    return response()->json([
        'message' => " Force Delete Contact Us By Id Successfully."
    ]);
}
}
