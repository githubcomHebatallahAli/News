<?php

namespace App\Http\Controllers\Admin;

use App\Models\News;
use App\Models\NewsView;
use Illuminate\Http\Request;
use App\Traits\ManagesModelsTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Admin\NewsRequest;
use App\Http\Resources\Admin\NewsResource;


class NewsController extends Controller
{
    use ManagesModelsTrait;

    public function showAll()
    {
        // الحصول على جميع الأخبار مع عدد المشاهدات لكل خبر
        $news = News::withCount('views')->get();


        return response()->json([
            'news' => NewsResource::collection($news),
        ]);
    }

    public function create(NewsRequest $request)
    {
        $this->authorize('manage_users');



           $News =News::create ([

                "title" => $request->title,
                "writer" => $request->writer,
                "event_date" => $request->event_date,
                "url" => $request->url,
                "part1" => $request->part1,
                "part2" => $request->part2,
                "part3" => $request->part3,
                'keyWords' => $request->keyWords,
                "category_id" => $request->category_id,
            ]);
            if ($request->hasFile('img')) {
                $imgPath = $request->file('img')->store(News::storageFolder);
                $News->img =  $imgPath;
            }
           $News->save();
           return response()->json([
            'data' =>new NewsResource($News),
            'message' => "News Created Successfully."
        ]);

        }

    public function edit($id, Request $request)
    {
        $news = News::withCount('views')->findOrFail($id);
        if (!$news) {
            return response()->json([
                'message' => "News not found."
            ], 404);
        }
        $category = $news->category;
        $category->increment('views_count');

        // إعادة تحميل عدد الزيارات للقسم بعد التحديث
        $category->refresh();



        return response()->json([

                    'data' =>new NewsResource($news),
            'message' => "News Edit By Id Successfully."
        ]);
    }

    public function update(NewsRequest $request, string $id)
    {
        $this->authorize('manage_users');
       $News =News::findOrFail($id);

       if (!$News) {
        return response()->json([
            'message' => "News not found."
        ], 404);
    }
       $News->update([
        "title" => $request->title,
        "writer" => $request->writer,
        "event_date" => $request->event_date,
        "url" => $request->url,
        "part1" => $request->part1,
        "part2" => $request->part2,
        "part3" => $request->part3,
        "keyWords" => $request->keyWords,
        "category_id" => $request->category_id,

        ]);

        if ($request->hasFile('img')) {
            if ($News->img) {
                Storage::disk('public')->delete($News->img);
            }
            $imgPath = $request->file('img')->store('News', 'public');
            $News->img = $imgPath;
        }


       $News->save();
       return response()->json([
        'data' =>new NewsResource($News),
        'message' => " Update News By Id Successfully."
    ]);
}

public function destroy(string $id){

    return $this->destroyModel(News::class, NewsResource::class, $id);
    }

        public function showDeleted(){

        return $this->showDeletedModels(News::class, NewsResource::class);
    }

    public function restore(string $id)
    {

        return $this->restoreModel(News::class, $id);
    }

    public function forceDelete(string $id){

        return $this->forceDeleteModel(News::class, $id);
    }
}
