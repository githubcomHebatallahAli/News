<?php

namespace App\Http\Controllers\User;

use App\Models\ContactUs;
use App\Models\AdvertiseHere;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContactUsRequest;
use App\Http\Resources\ContactUsResource;
use App\Http\Requests\AdvertiseHereRequest;
use App\Http\Resources\AdvertiseHereResource;

class CreateController extends Controller
{
    public function createContactUs(ContactUsRequest $request)
    {

           $AdvertiseHere =ContactUs::create ([
                'user_id' => $request->user_id,
                "phone" => $request->phone,
                "message" => $request->message
            ]);

            $AdvertiseHere->save();

            return response()->json([
                'data' => new AdvertiseHereResource($AdvertiseHere),
                'message' => 'AdvertiseHere Created Successfully.'
            ]);
        }

        public function createAdvertiseHere(AdvertiseHereRequest $request)
        {

               $AdvertiseHere =AdvertiseHere::create ([
                    'user_id' => $request->user_id,
                    "phone" => $request->phone,
                    "message" => $request->message
                ]);

                $AdvertiseHere->save();

                return response()->json([
                    'data' => new ContactUsResource(  $AdvertiseHere),
                    'message' => 'ContactUs Created Successfully.'
                ]);
            }


}
