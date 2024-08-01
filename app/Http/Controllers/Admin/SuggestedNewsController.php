<?php

namespace App\Http\Controllers\Admin;

use App\Models\SuggestedNews;
use App\Traits\ManagesModelsTrait;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\NewsResource;
use App\Http\Requests\Admin\SuggestedNewsRequest;
use App\Http\Resources\Admin\SuggestedNewsResource;





class SuggestedNewsController extends Controller
{
    use ManagesModelsTrait;

      public function showAll()
    {
        $this->authorize('manage_users');

        $SuggestedNews = SuggestedNews::get();
        return response()->json([
            'data' => SuggestedNewsResource::collection($SuggestedNews),
            'message' => "Show All Suggested News Successfully."
        ]);
    }


    public function create(SuggestedNewsRequest $request)
    {
        $this->authorize('manage_users');

        $newsId = $request->news_id; // ID الخاص بالخبر الأساسي
        $suggestedNewsIds = $request->suggested_news_ids; // مصفوفة من IDs الخاصة بالأخبار المقترحة

        foreach ($suggestedNewsIds as $suggestedNewsId) {
            SuggestedNews::create([
                'news_id' => $newsId,
                'suggested_news_id' => $suggestedNewsId,
            ]);
        }

        return response()->json([
            'message' => "Suggested News Created Successfully."
        ]);
    }


    public function edit(string $id)
    {
        $this->authorize('manage_users');
        $SuggestedNews = SuggestedNews::find($id);

        if (!$SuggestedNews) {
            return response()->json([
                'message' => "Suggested News not found."
            ], 404);
        }

        return response()->json([
            'data' =>new SuggestedNewsResource($SuggestedNews),
            'message' => "Edit Suggested News By ID Successfully."
        ]);
    }



    public function update(SuggestedNewsRequest $request, string $id)
    {
        $this->authorize('manage_users');
       $SuggestedNews =SuggestedNews::findOrFail($id);

       if (!$SuggestedNews) {
        return response()->json([
            'message' => "Suggested News not found."
        ], 404);
    }
       $SuggestedNews->update([
        'news_id'=> $request->news_id,
        ]);

       $SuggestedNews->save();
       return response()->json([
        'data' =>new SuggestedNewsResource($SuggestedNews),
        'message' => " Update Suggested News By Id Successfully."
    ]);

}



    public function destroy(string $id)
    {
        return $this->destroyModel(SuggestedNews::class, SuggestedNewsResource::class, $id);
    }

    public function showDeleted()
    {
        return $this->showDeletedModels(SuggestedNews::class, SuggestedNewsResource::class);
    }

    public function restore(string $id)
    {
        return $this->restoreModel(SuggestedNews::class, $id);
    }

    public function forceDelete(string $id)
    {
        return $this->forceDeleteModel(SuggestedNews::class, $id);
    }

}


