<?php

namespace App\Http\Controllers\Admin;

use App\Models\Comment;
use App\Traits\ManagesModelsTrait;
use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;


class CommentController extends Controller
{
    use ManagesModelsTrait;
    public function showAll()
    {
        $this->authorize('manage_users');
        $Comments = Comment::with('user')->get();
        return response()->json([
            'data' => CommentResource::collection($Comments),
            'message' => "Show All Comments Successfully."
        ]);

    }

    public function edit(string $id)
    {
        $this->authorize('manage_users');

        $Comment = Comment::with('news.category', 'news.admin')->find($id);

        if (!$Comment) {
            return response()->json([
                'message' => "Comment not found."
            ], 404);
        }

        return response()->json([
            'data' =>new CommentResource($Comment),
            'message' => "Edit Comment By ID Successfully."
        ]);
    }


    public function approve(string $id)
    {
        $this->authorize('manage_users');
        $Comment =Comment::findOrFail($id);

        if (!$Comment) {
         return response()->json([
             'message' => "Comment not found."
         ], 404);
     }


        $Comment->update(['status' => 'approved']);
        return response()->json([
            'data' => new CommentResource($Comment),
            'message' => "Comment Approved Successfully."
        ]);
    }

    public function reject(string $id)
    {

        $this->authorize('manage_users');
        $Comment =Comment::findOrFail($id);

        if (!$Comment) {
         return response()->json([
             'message' => "Comment not found."
         ], 404);
     }
       

        $Comment->update(['status' => 'rejected']);

        return response()->json([
            'data' => new CommentResource($Comment),
            'message' => 'Comment has been rejected.'
        ]);
    }

    public function destroy(string $id){

        return $this->destroyModel(Comment::class, CommentResource::class, $id);
        }

            public function showDeleted(){

            return $this->showDeletedModels(Comment::class, CommentResource::class);
        }

        public function restore(string $id)
        {

            return $this->restoreModel(Comment::class, $id);
        }

        public function forceDelete(string $id){

            return $this->forceDeleteModel(Comment::class, $id);
        }

}


