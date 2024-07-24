<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class CommentController extends Controller
{
    use ManagesModelsTrait;
    public function showAll()
    {
        $this->authorize('manage_users');

        $Comment = Comment::with('user')->get();

        if (!$Comment) {
            return response()->json([
                'message' => "Comment not found."
            ], 404);
        }

        return response()->json([
            'data' =>CommentResource::collection($Comment),
            'message' => "Show all comments with user Successfully."
        ]);

    }

    public function edit(string $id)
    {
        $this->authorize('manage_users');

        $Comment = Comment::with('user')->find($id);

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

}
