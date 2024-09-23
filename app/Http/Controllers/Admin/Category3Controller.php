<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\News;
use App\Models\Category3;
use Illuminate\Http\Request;
use App\Traits\ManagesModelsTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Category3Request;
use App\Http\Resources\Admin\Category3Resource;

class Category3Controller extends Controller
{
    use ManagesModelsTrait;
    public function showAll()
    {
        $this->authorize('manage_users');

        $categories = Category3::with('category', 'news')->get();


        $response = $categories->map(function ($category3) {

            $latestNews = $category3->news()
                ->where('status', 'published')
                ->latest()
                ->take(6)
                ->get()
                ->map(function ($news) {
                    return [
                        'news_id' => $news->id,
                        'title' => $news->title,
                        'img' => $news->img,
                        'formatted_date' => Carbon::parse($news->event_date)->format('Y-m-d H:i:s'),
                    ];
                });


            return [
                'data' => [
                    'id' => $category3->id,
                    'category_name' => $category3->category->name,
                ],
                'latest_news' => $latestNews,
            ];
        });

        return response()->json([
            'data' => $response,
            'message' => "Show all selected categories with latest news."
        ]);
    }


    public function create(Category3Request $request)
    {
        $this->authorize('manage_users');


        $Category3 = Category3::create([
            "category_id" => $request->category_id
        ]);
        $Category3->load('category');


        $latestNews = News::where('category_id', $request->category_id)
                          ->where('status', 'published')
                          ->latest()
                          ->take(6)
                          ->get();


        $Category3->news()->attach($latestNews->pluck('id'));

        $newsData = $latestNews->map(function ($news) {
            return [
                'news_id' => $news->id,
                'title' => $news->title,
                'img' => $news->img,
                'formatted_date' => Carbon::parse($news->event_date)->format('Y-m-d H:i:s'),
            ];
        });


            return response()->json([
                'data' =>new Category3Resource($Category3),
                'latest_news' => $newsData,
                'message' => "Category Selected Created Successfully and Latest Published News Attached."

            ]);


    }




    public function edit(string $id)
    {
        $this->authorize('manage_users');
        $Category3 = Category3::with('category')->find($id);

        if (!$Category3) {
            return response()->json([
                'message' => "Category Selected not found."
            ], 404);
        }

        return response()->json([
            'data' =>new Category3Resource($Category3),
            'message' => "Edit Category Selected By ID Successfully."
        ]);
    }

    public function update(Category3Request $request, string $id)
    {
        $this->authorize('manage_users');
       $Category3 =Category3::findOrFail($id);

       if (!$Category3) {
        return response()->json([
            'message' => "Category Selected not found."
        ], 404);
    }
       $Category3->update([
        "category_id" => $request-> category_id
        ]);

        $Category3->load('category');


        $latestNews = News::where('category_id', $request->category_id)
                          ->where('status', 'published')
                          ->latest()
                          ->take(6)
                          ->get();


        // $Category3->news()->attach($latestNews->pluck('id'));
        $Category3->news()->sync($latestNews->pluck('id'));

        $newsData = $latestNews->map(function ($news) {
            return [
                'news_id' => $news->id,
                'title' => $news->title,
                'img' => $news->img,
                'formatted_date' => Carbon::parse($news->event_date)->format('Y-m-d H:i:s'),
            ];
        });

       $Category3->save();
       return response()->json([
        'data' =>new Category3Resource($Category3),
        'latest_news' => $newsData,
        'message' => " Update Category Selected By Id Successfully."
    ]);
}

public function destroy(string $id){

return $this->destroyModel(Category3::class, Category3Resource::class, $id);
}

    public function showDeleted(){

    return $this->showDeletedModels(Category3::class, Category3Resource::class);
}

public function restore(string $id)
{
    return $this->restoreModel(Category3::class, $id);
}

public function forceDelete(string $id){

    return $this->forceDeleteModel(Category3::class, $id);
}
}
