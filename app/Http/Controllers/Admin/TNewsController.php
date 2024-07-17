<?php

namespace App\Http\Controllers\Admin;

use App\Models\TNews;
use App\Traits\ManagesModelsTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TNewsRequest;
use App\Http\Resources\Admin\TNewsResource;

class TNewsController extends Controller
{
    use ManagesModelsTrait;
    public function showAll()
    {
        $this->authorize('manage_users');

        $TNews = TNews::get();
        return response()->json([
            'data' => TNewsResource::collection($TNews),
            'message' => "Show All TNews Successfully."
        ]);
    }


    public function create(TNewsRequest $request)
    {
        $this->authorize('manage_users');

           $TNews =TNews::create ([
                "content" => $request->content,
                "trending_news_id" => $request-> trending_news_id
            ]);
           $TNews->save();
           return response()->json([
            'data' =>new TNewsResource($TNews),
            'message' => "TNews Created Successfully."
        ]);

        }


    public function edit(string $id)
    {
        $this->authorize('manage_users');
        $TNews = TNews::find($id);

        if (!$TNews) {
            return response()->json([
                'message' => "TNews not found."
            ], 404);
        }

        return response()->json([
            'data' =>new TNewsResource($TNews),
            'message' => "Edit TNews By ID Successfully."
        ]);
    }

    public function update(TNewsRequest $request, string $id)
    {
        $this->authorize('manage_users');
       $TNews =TNews::findOrFail($id);

       if (!$TNews) {
        return response()->json([
            'message' => "TNews not found."
        ], 404);
    }
       $TNews->update([
        "content" => $request->content,
        "trending_news_id" => $request-> trending_news_id
        ]);

       $TNews->save();
       return response()->json([
        'data' =>new TNewsResource($TNews),
        'message' => " Update TNews By Id Successfully."
    ]);
}

public function destroy(string $id){

return $this->destroyModel(TNews::class, TNewsResource::class, $id);
}

    public function showDeleted(){

    return $this->showDeletedModels(TNews::class, TNewsResource::class);
}

public function restore(string $id)
{
    return $this->restoreModel(TNews::class, $id);
}

public function forceDelete(string $id){

    return $this->forceDeleteModel(TNews::class, $id);
}
}
