<?php

namespace App\Http\Controllers\Admin;

use App\Models\TrendingNews;
use App\Traits\ManagesModelsTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TrendingNewsRequest;
use App\Http\Resources\Admin\TrendingNewsResource;


class TrendingNewsController extends Controller
{
    use ManagesModelsTrait;
    public function showAll()
    {
        $this->authorize('manage_users');

        $TrendingNews = TrendingNews::get();
        return response()->json([
            'data' => TrendingNewsResource::collection($TrendingNews),
            'message' => "Show All TrendingNews Successfully."
        ]);
    }


    public function create(TrendingNewsRequest $request)
    {
        $this->authorize('manage_users');

           $TrendingNews =TrendingNews::create ([

                "title" => $request->title,
                "content" => $request->content,
            ]);
           $TrendingNews->save();
           return response()->json([
            'data' =>new TrendingNewsResource($TrendingNews),
            'message' => "TrendingNews Created Successfully."
        ]);

        }


    public function edit(string $id)
    {
        $this->authorize('manage_users');
        $TrendingNews = TrendingNews::find($id);

        if (!$TrendingNews) {
            return response()->json([
                'message' => "TrendingNews not found."
            ], 404);
        }

        return response()->json([
            'data' =>new TrendingNewsResource($TrendingNews),
            'message' => "Edit TrendingNews By ID Successfully."
        ]);
    }



    public function update(TrendingNewsRequest $request, string $id)
    {
        $this->authorize('manage_users');
       $TrendingNews =TrendingNews::findOrFail($id);

       if (!$TrendingNews) {
        return response()->json([
            'message' => "TrendingNews not found."
        ], 404);
    }
       $TrendingNews->update([
        "title" => $request-> title,
        "content" => $request-> content
        ]);

       $TrendingNews->save();
       return response()->json([
        'data' =>new TrendingNewsResource($TrendingNews),
        'message' => " Update TrendingNews By Id Successfully."
    ]);
}

public function destroy(string $id){

return $this->destroyModel(TrendingNews::class, TrendingNewsResource::class, $id);
}

    public function showDeleted(){

    return $this->showDeletedModels(TrendingNews::class, TrendingNewsResource::class);
}

public function restore(string $id)
{

    return $this->restoreModel(TrendingNews::class, $id);
}

public function forceDelete(string $id){

    return $this->forceDeleteModel(TrendingNews::class, $id);
}
}
