<?php

namespace App\Http\Controllers\Admin;

use App\Models\News;
use Illuminate\Http\Request;
use App\Models\SuggestedNews;
use Illuminate\Http\JsonResponse;
use App\Traits\ManagesModelsTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Admin\NewsRequest;
use App\Http\Resources\Admin\NewsResource;
use App\Http\Requests\Admin\SuggestedNewsRequest;


class NewsController extends Controller
{
    use ManagesModelsTrait;

    public function showAll()
    {
        $this->authorize('manage_users');
        // $this->authorize('showAll', News::class);

        $news = News::with(['admin', 'category','suggestedNews'])->get();
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
                "description" => $request -> description,
                "writer" => $request->writer,
                "event_date" => $request->event_date,
                "videoUrl"=> $request-> videoUrl,
                "videoLabel" => $request-> videoLabel,
                "url" => $request->url,
                "part1" => $request->part1,
                "part2" => $request->part2,
                "part3" => $request->part3,
                'keyWords' => $request->keyWords,
                "category_id" => $request->category_id,
                "admin_id" => auth()->id(),
                "status" => $request-> status,
                "adsenseCode" => $request -> adsenseCode
            ]);
            if ($request->hasFile('img')) {
                $imgPath = $request->file('img')->store(News::storageFolder);
                $News->img =  $imgPath;
            }

            $News->load('admin', 'category');
           $News->save();
        //    if ($request->filled('suggestedNews_ids')) {
        //     $News->suggestedNews()->sync($request->suggestedNews_ids);
        // }
           return response()->json([
            'data' =>new NewsResource($News),
            'message' => "News Created Successfully."
        ]);
        }





// public function addNewsToSuggested($newsId, Request $request)
// {
//     $this->authorize('manage_users');

//     $news = News::findOrFail($newsId);

//     $request->validate([
//         'suggestedNews_ids' => 'required|array',
//         'suggestedNews_ids.*' => 'exists:suggested_news,id',
//     ]);



//     $news->suggestedNews()->sync($request->suggestedNews_ids);

//     $news->load('suggestedNews');

//     return response()->json([
//         'data' => new NewsResource($news),
//         'message' => "Suggested News add to News successfully."
//     ], 200);
// }
public function addNewsToSuggested(SuggestedNewsRequest $request): JsonResponse
{
    $this->authorize('manage_users');
$newsId = $request->news_id;
$suggestedNewsIds = $request->suggested_news_ids;

// إضافة البيانات إلى قاعدة البيانات
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

        public function addSingleSuggestedNews($newsId, $suggestedNewsId)
{
    $this->authorize('manage_users');

    $news = News::findOrFail($newsId);
    $suggestedNews = News::findOrFail($suggestedNewsId);

    $news->suggestedNews()->attach($suggestedNews->id);

    $news->load('suggestedNews');

    return response()->json([
        'data' => new NewsResource($news),
        'message' => "News added To Suggested News successfully."
    ], 200);
}


        public function uploadImage(Request $request)
        {
            $this->authorize('manage_users');
            $request->validate([
                'subImg' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $image = $request->file('subImg');
            $path = $image->store('subImg', 'public');

            return response()->json(['url' => Storage::url($path)], 201);
        }

    public function edit($id, Request $request)
    {
        $this->authorize('manage_users');

        $news = News::with(['admin', 'category' ])->findOrFail($id);

        if (!$news) {
            return response()->json([
                'message' => "News not found."
            ], 404);
        }
        // $this->authorize('edit', $news);
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
    // $this->authorize('update', $News);
       $News->update([
        "title" => $request->title,
        "description" => $request -> description,
        "writer" => $request->writer,
        "event_date" => $request->event_date,
        "videoUrl"=> $request-> videoUrl,
        "videoLabel" => $request-> videoLabel,
        "url" => $request->url,
        "part1" => $request->part1,
        "part2" => $request->part2,
        "part3" => $request->part3,
        "keyWords" => $request->keyWords,
        "category_id" => $request->category_id,
        "admin_id" => auth()->id(),
        "status" => $request-> status,
        "adsenseCode" => $request -> adsenseCode
        ]);

        if ($request->hasFile('img')) {
            if ($News->img) {
                Storage::disk('public')->delete($News->img);
            }
            $imgPath = $request->file('img')->store('News', 'public');
            $News->img = $imgPath;
        }


        $News->load('admin', 'category');


       $News->save();
    //    if ($request->filled('suggestedNews_ids')) {
    //     $News->suggestedNews()->sync($request->suggestedNews_ids);
    // }
       return response()->json([
        'data' =>new NewsResource($News),
        'message' => " Update News By Id Successfully."
    ]);
}

public function destroy(string $id)
{
    $this->authorize('manage_users');

    $news = News::find($id);
    if (!$news) {
        return response()->json([
            'message' => "News not found."
        ], 404);
    }
        // $this->authorize('softDelete', $news);

    $news->delete();
    return response()->json([
        'data' => new NewsResource($news),
        'message' => "Soft Delete News By Id Successfully."
    ]);
}

public function showDeleted(){
    $this->authorize('manage_users');
    // $this->authorize('showDeleted', News::class);

    $News=News::onlyTrashed()->get();
    return response()->json([
        'data' =>NewsResource::collection($News),
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
        $this->authorize('manage_users');
        $News =News::findOrFail($id);

        if (!$News) {
         return response()->json([
             'message' => "News not found."
         ], 404);
     }
    //    $this->authorize('review', $News);

        $News->update(['status' => 'reviewed']);
        return response()->json([
            'data' => new NewsResource($News),
            'message' => "News Reviewed Successfully."
        ]);
    }

    public function reject(string $id)
    {
        $this->authorize('manage_users');
        $News =News::findOrFail($id);

        if (!$News) {
         return response()->json([
             'message' => "News not found."
         ], 404);
     }
        // $this->authorize('reject',$News);

        $News->update(['status' => 'rejected']);

        return response()->json([
            'data' => new NewsResource($News),
            'message' => 'News has been rejected.'
        ]);
    }

    public function publish(string $id)
    {
        $this->authorize('manage_users');

        $News =News::findOrFail($id);


        if (!$News) {
         return response()->json([
             'message' => "News not found."
         ], 404);
     }
    //  $this->authorize('publish', $News);

        $News->update(['status' => 'published']);

        return response()->json([
            'data' => new NewsResource($News),
            'message' => "News Published Successfully."
        ]);
    }

    public function mostReadNews()
    {
        $this->authorize('manage_users');
        $mostReadNews = News::where('status', 'published')
        ->orderBy('news_views_count', 'desc')
        ->take(6)->get();

        return response()->json($mostReadNews);
    }
}
