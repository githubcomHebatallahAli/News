<?php

namespace App\Http\Controllers\Admin;


use Carbon\Carbon;
use App\Models\News;
use App\Models\Slider;
use Illuminate\Http\Request;
use App\Models\SuggestedNews;
use App\Traits\ManagesModelsTrait;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Admin\NewsRequest;
use App\Http\Resources\Admin\NewsResource;
use App\Http\Requests\Admin\UpdateNewsRequest;



class NewsController extends Controller
{
    use ManagesModelsTrait;

    public function showAll()
    {
        $this->authorize('manage_users');
        // $this->authorize('showAll', News::class);

        $news = News::with(['admin', 'category',
         'suggestedNews.suggestedNews.admin',
        'suggestedNews.suggestedNews.category'])
        ->get();
        return response()->json([
            'news' => NewsResource::collection($news),
        ]);
    }




public function create(NewsRequest $request)
{

    $this->authorize('manage_users');


    $eventDate = $request->input('event_date') ?: Carbon::now('Africa/Cairo');

    $news = News::create([
        'title' => $request->title,
        'description' => $request->description,
        'writer' => $request->writer,
        'event_date' => $eventDate,
        'url' => $request->url,
        'videoUrl' => $request->videoUrl,
        'videoLabel' => $request->videoLabel,
        'part1' => $request->part1,
        'part2' => $request->part2,
        'part3' => $request->part3,
        'status' => $request->status,
        'adsenseCode' => $request->adsenseCode,
        'keyWords' => $request->keyWords,
        'category_id' => $request->category_id,
        'admin_id' => auth()->id(),
    ]);

    if ($request->hasFile('img')) {
        $imgPath = $request->file('img')->store(News::storageFolder);
        $news->img =  $imgPath;

    }

    $suggestedNewsIds = json_decode($request->input('suggested_news_ids', '[]'), true);
    if (is_array($suggestedNewsIds)) {
        foreach ($suggestedNewsIds as $suggestedNewsId) {

            if (is_numeric($suggestedNewsId)) {
                SuggestedNews::create([
                    'news_id' => $news->id,
                    'suggested_news_id' => $suggestedNewsId,


                ]);
            }
        }
    }

    $news->load([
        'admin',
        'category',
        'suggestedNews.suggestedNews.admin',
        'suggestedNews.suggestedNews.category'
    ]);
    $news->save();

    $this->updateSliders();

    return response()->json([
        'data' =>new NewsResource ($news),
        'message' => "News Created Successfully."
    ]);
}

protected function updateSliders()
{
    $latestNewsByCategory = DB::table('news')
        ->select('id as news_id', 'title', 'description', 'img', 'category_id', DB::raw('MAX(created_at) as latest_created_at'))
        ->groupBy('category_id', 'title', 'description', 'img', 'id')
        ->where('status', 'published')
        ->orderBy('latest_created_at', 'desc')
        ->get();


    foreach ($latestNewsByCategory as $news) {
        $existingSlider = Slider::where('news_id', $news->news_id)->first();
        if (!$existingSlider) {
            Slider::create([
                'news_id' => $news->news_id,
                'title' => $news->title,
                'description' => $news->description,
                'img' => $news->img,
                'category_id' => $news->category_id
            ]);
        } else {
            $existingSlider->update([
                'title' => $news->title,
                'description' => $news->description,
                'img' => $news->img,
                'category_id' => $news->category_id
            ]);
        }
    }
}


        public function uploadImage(Request $request)
        {
            $this->authorize('manage_users');
            $request->validate([
                'subImg' => 'required|image|mimes:jpeg,png,jpg,gif',
            ]);

            $image = $request->file('subImg');
            $path = $image->store('subImg', 'public');

            return response()->json(['url' => Storage::url($path)], 201);
        }

    public function edit($id)
    {
        $this->authorize('manage_users');

        $news = News::with(['admin', 'category',
         'suggestedNews.suggestedNews.admin',
          'suggestedNews.suggestedNews.category' ])
        ->findOrFail($id);

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

    public function update(UpdateNewsRequest $request, string $id)
    {

        $this->authorize('manage_users');
        $eventDate = $request->input('event_date') ?: Carbon::now('Africa/Cairo');
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
        'event_date' => $eventDate,
        "videoUrl"=> $request-> videoUrl,
        "videoLabel" => $request-> videoLabel,
        "url" => $request->url,
        "part1" => $request->part1,
        "part2" => $request->part2,
        "part3" => $request->part3,
        "keyWords" => $request->keyWords,
        "category_id" => $request->category_id,
        "admin_id" => $request->admin_id,
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

    $suggestedNewsIds = json_decode($request->input('suggested_news_ids', '[]'), true);
    if (is_array($suggestedNewsIds)) {
        foreach ($suggestedNewsIds as $suggestedNewsId) {
            if (is_numeric($suggestedNewsId)) {
                SuggestedNews::create([
                    'news_id' => $News->id,
                    'suggested_news_id' => $suggestedNewsId,
                ]);
            }
        }
    }

    $News->load([
        'admin',
        'category',
        'suggestedNews.suggestedNews.admin',
        'suggestedNews.suggestedNews.category'
    ]);

       $News->save();

       $this->updateSliders();

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

    public function updateAdminId(UpdateNewsRequest $request, string $id)
{
    $this->authorize('manage_users');

    $News = News::findOrFail($id);

    if (!$News) {
        return response()->json([
            'message' => "News not found."
        ], 404);
    }



    $News->update([
        'admin_id' => $request->admin_id,
    ]);


    $News->load([
        'admin',
        'category',
        'suggestedNews.suggestedNews.admin',
        'suggestedNews.suggestedNews.category'
    ]);

    $News->save();

    return response()->json([
        'data' => new NewsResource($News),
        'message' => "Admin ID updated successfully."
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
