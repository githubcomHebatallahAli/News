<?php

namespace App\Http\Controllers\Admin;

use App\Models\BestNews;
use Illuminate\Http\Request;
use App\Traits\ManagesModelsTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BestNewsRequest;
use App\Http\Resources\Admin\BestNewsResource;

class BestNewsController extends Controller
{
    use ManagesModelsTrait;
    public function showAll()
    {
        $this->authorize('manage_users');
        $BestNews = BestNews::with( 'news.category',
        'news.suggestedNews.suggestedNews.admin',
        'news.suggestedNews.suggestedNews.category',)->get();
        return response()->json([
            'data' => BestNewsResource::collection($BestNews),
            'message' => "Show All Best news Successfully."
        ]);
    }


    public function create(BestNewsRequest $request)
    {
        $this->authorize('manage_users');
           $BestNews =BestNews::create ([
                'news_id' => $request->news_id,
            ]);
            $BestNews->load( 'news.category',
            'news.suggestedNews.suggestedNews.admin',
            'news.suggestedNews.suggestedNews.category',);
           $BestNews->save();
           return response()->json([
            'data' =>new BestNewsResource($BestNews),
            'message' => "Best News Created Successfully."
        ]);

        }





    public function edit(string $id)
    {
        $this->authorize('manage_users');
        $BestNews = BestNews::with( 'news.category',
        'news.suggestedNews.suggestedNews.admin',
        'news.suggestedNews.suggestedNews.category',)->find($id);
        if (!$BestNews) {
            return response()->json([
                'message' => "BestNews not found."
            ], 404);
        }
        return response()->json([
            'data' =>new BestNewsResource($BestNews),
            'message' => "Edit Best news By ID Successfully."
        ]);

    }

    public function update(Request $request, string $id)
    {
        $this->authorize('manage_users');
       $BestNews =BestNews::findOrFail($id);
       if (!$BestNews) {
        return response()->json([
            'message' => "Best News not found."
        ], 404);
    }
       $BestNews->update([
        'news_id' => $request->news_id,
        ]);
        $BestNews->load( 'news.category',
        'news.suggestedNews.suggestedNews.admin',
        'news.suggestedNews.suggestedNews.category',);

       $BestNews->save();
       return response()->json([
        'data' =>new BestNewsResource($BestNews),
        'message' => " Update  Best news By Id Successfully."
    ]);
}

public function destroy(string $id){

    return $this->destroyModel(BestNews::class, BestNewsResource::class, $id);
    }

        public function showDeleted(){

        return $this->showDeletedModels(BestNews::class, BestNewsResource::class);
    }

    public function restore(string $id)
    {

        return $this->restoreModel(BestNews::class, $id);
    }

    public function forceDelete(string $id){

        return $this->forceDeleteModel(BestNews::class, $id);
    }
}
