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
        $this->authorize('manage_users');
        // الحصول على جميع الأخبار مع عدد المشاهدات لكل خبر
        $news = News::withCount('views')->get();


        return response()->json([
            'news' => NewsResource::collection($news),
        ]);
    }

    public function create(NewsRequest $request)
    {
        $this->authorize('manage_users');


        // $this->authorize('create', News::class);

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
                "admin_id" =>$request->admin_id,
                'status' => 'pending'
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
        $this->authorize('manage_users');

        $news = News::withCount('views')->findOrFail($id);
        if (!$news) {
            return response()->json([
                'message' => "News not found."
            ], 404);
        }
        // $this->authorize('edit', News::class);
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
    // $this->authorize('update', News::class);
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
        "admin_id" => $request ->admin_id,
         'status' => 'pending'

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

public function destroy(string $id)
{
    $this->authorize('manage_users');
    // $this->authorize('softDelete', News::class);

    $news = News::find($id);
    if (!$news) {
        return response()->json([
            'message' => "News not found."
        ], 404);
    }

    $news->delete();
    return response()->json([
        'data' => new NewsResource($news),
        'message' => "Soft Delete News By Id Successfully."
    ]);
}

public function showDeleted(){
    $this->authorize('manage_users');
    // $this->authorize('showDeleted', News::class);

    $Newss=News::onlyTrashed()->with('user')->get();
    return response()->json([
        'data' =>NewsResource::collection($Newss),
        'message' => "Show Deleted News Successfully."
    ]);
}

public function restore(string $id)
{
    $this->authorize('manage_users');
    // $this->authorize('restore', News::class);

    $news = News::withTrashed()->where('id', $id)->first();
    if (!$news) {
        return response()->json([
            'message' => "News not found."
        ], 404);
    }

    $news->restore();
    return response()->json([
        'message' => "Restore News By Id Successfully."
    ]);
}


public function forceDelete(string $id)
{
    $this->authorize('manage_users');
    $news = News::withTrashed()->where('id', $id)->first();
    if (!$news) {
        return response()->json([
            'message' => "News not found."
        ], 404);
    }

    // $this->authorize('forceDelete', $news);

    $news->forceDelete();
    return response()->json([
        'message' => "Force Delete News By Id Successfully."
    ]);
}


    public function review(string $id)
    {
        // $this->authorize('review', $news);

        $this->authorize('manage_users');
        $News =News::findOrFail($id);

        if (!$News) {
         return response()->json([
             'message' => "News not found."
         ], 404);
     }

        $News->update(['status' => 'reviewed']);
        return response()->json([
            'data' => new NewsResource($News),
            'message' => "News Reviewed Successfully."
        ]);
    }

    public function reject(string $id)
    {
        // $this->authorize('reject', $news);
        $this->authorize('manage_users');
        $News =News::findOrFail($id);

        if (!$News) {
         return response()->json([
             'message' => "News not found."
         ], 404);
     }

        $News->update(['status' => 'rejected']);

        return response()->json([
            'data' => new NewsResource($News),
            'message' => 'News has been rejected.'
        ]);
    }

    public function publish(string $id)
    {
        $this->authorize('manage_users');
        // $this->authorize('publish', $news);
        $News =News::findOrFail($id);

        if (!$News) {
         return response()->json([
             'message' => "News not found."
         ], 404);
     }

        $News->update(['status' => 'published']);

        return response()->json([
            'data' => new NewsResource($News),
            'message' => "News Published Successfully."
        ]);
    }
}
