<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;

use App\Traits\ManagesModelsTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\Admin\CategoryRequest;
use App\Http\Resources\Admin\CategoryResource;
use App\Http\Resources\Admin\AdminProfileResource;
use App\Http\Resources\Admin\CategoryBestNewsResource;

class CategoryController extends Controller
{
    use ManagesModelsTrait;
    public function showAll()
    {
        $this->authorize('manage_users');

        $categories = Category::with(['news'])->withCount('news')->get();

        // تحويل الأقسام والأخبار إلى تنسيق مناسب
        $result = $categories->map(function ($category) {
            return [
                'category' => [
                    'id' => $category->id,
                    'name' => $category->name,
                    'views_count' => $category->views_count,
                    'news_count' => $category->news_count,
                    'url' => $category->url,
                ],
                'news' => $category->news->map(function ($newsItem) {
                    return [
                        'id' => $newsItem->id,
                        'title' => $newsItem->title,
                        'writer' => $newsItem->writer,
                        'event_date' => $newsItem->event_date,
                        'img' => $newsItem->img,
                        'url' => $newsItem->url,
                        'part1' => $newsItem->part1,
                        'part2' => $newsItem->part2,
                        'part3' => $newsItem->part3,
                        'keyWords' => $newsItem->keyWords,
                        'news_views_count' => $newsItem->news_views_count,
                        'status' => $newsItem->status,
                    ];
                })
            ];
        });

        return response()->json([
            'data' => $result,
            'message' => "All Categories with their news retrieved successfully."
        ]);
    }


    public function create(CategoryRequest $request)
    {
        $this->authorize('manage_users');


           $Category =Category::create ([

                "name" => $request->name,
                "url" => $request->url,

            ]);
           $Category->save();
           return response()->json([
            'data' =>new CategoryResource($Category),
            'message' => "Category Created Successfully."
        ]);

        }


        public function edit(string $id)
        {
            $this->authorize('manage_users');
  $category = Category::with(['news.admin', 'bestNews.news.admin'])
  ->withCount('news')->find($id);

            if (!$category) {
                return response()->json([
                    'message' => "Category not found."
                ], 404);
            }

            $category->incrementViews();


            return response()->json([
                //  'category' => new CategoryResource($category),
                'data' =>  CategoryBestNewsResource::collection($category),
                'message' => "Edit Category  With News,BestNews and News Count By ID Successfully."
            ]);
        }




    public function update(CategoryRequest $request, string $id)
    {
        $this->authorize('manage_users');
       $Category =Category::findOrFail($id);

       if (!$Category) {
        return response()->json([
            'message' => "Category not found."
        ], 404);
    }
       $Category->update([
        "name" => $request->name,
        "url" => $request->url,
        ]);

       $Category->save();
       return response()->json([
        'data' =>new CategoryResource($Category),
        'message' => " Update Category By Id Successfully."
    ]);
}

public function destroy(string $id){

return $this->destroyModel(Category::class, CategoryResource::class, $id);
}

    public function showDeleted(){

    return $this->showDeletedModels(Category::class, CategoryResource::class);
}

public function restore(string $id)
{

    return $this->restoreModel(Category::class, $id);
}

public function forceDelete(string $id){

    return $this->forceDeleteModel(Category::class, $id);
}
}
