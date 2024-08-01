<?php

namespace App\Http\Controllers\User;

use App\Models\Comment;
use App\Models\ContactUs;
use App\Models\AdvertiseHere;
use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Http\Requests\ContactUsRequest;
use App\Http\Resources\CommentResource;
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

            public function createComment(CommentRequest $request)
            {

                   $Comment =Comment::create ([
                        'user_id' => $request->user_id,
                        'news_id' => $request->news_id,
                        "comment" => $request->comment,
                        "status" => $request->status
                    ]);
                    $Comment->load('news.category', 'news.suggestedNews','news.admin');
                    $Comment->save();

                    return response()->json([
                        'data' => new CommentResource( $Comment),
                        'message' => 'Comment Created Successfully.'
                    ]);
                }


}
