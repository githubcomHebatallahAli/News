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

           $ContactUs =ContactUs::create ([
                'user_id' => $request->user_id,
                "phone" => $request->phone,
                "message" => $request->message
            ]);

            $ContactUs->load('user');

            $ContactUs->save();

            return response()->json([
                'data' => new ContactUsResource( $ContactUs),
                'message' => 'ContactUs Created Successfully.'
            ]);
        }

        public function createAdvertiseHere(AdvertiseHereRequest $request)
        {

               $AdvertiseHere =AdvertiseHere::create ([
                    'user_id' => $request->user_id,
                    "phone" => $request->phone,
                    "message" => $request->message
                ]);

                $AdvertiseHere->load('user');

                $AdvertiseHere->save();

                return response()->json([
                    'data' => new  AdvertiseHereResource(  $AdvertiseHere),
                    'message' => 'AdvertiseHere Created Successfully.'
                ]);
            }


}
