<?php

namespace App\Http\Controllers\User;

use App\Models\ContactUs;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContactUsRequest;
use App\Http\Resources\ContactUsResource;

class CreateController extends Controller
{
    public function createContactUs(ContactUsRequest $request)
    {

           $ContactUs =ContactUs::create ([
                'user_id' => $request->user()->id,
                "phone" => $request->phone,
                "message" => $request->message
            ]);
           $ContactUs->save();
           return response()->json([
            'data' =>new ContactUsResource($ContactUs),
            'message' => "ContactUs Created Successfully."
        ]);

        }

}
