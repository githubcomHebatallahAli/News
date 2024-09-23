<?php

namespace App\Http\Controllers\Admin;



use Carbon\Carbon;
use App\Models\News;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Traits\ManagesModelsTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryRequest;
use App\Http\Resources\Admin\CategoryResource;
use App\Http\Resources\Admin\CategoryBestNewsResource;

class CategoryController extends Controller
{
    use ManagesModelsTrait;
    public function showAll()
    {
        $this->authorize('manage_users');

        $category = Category::with([    'news.admin',
        'news.suggestedNews.suggestedNews.admin',
        'news.suggestedNews.suggestedNews.category',
        'bestNews.news.admin',
        'bestNews.news.suggestedNews.suggestedNews'])
        ->withCount('news')->get();


                  return response()->json([
                      'data' =>  CategoryBestNewsResource::collection($category),
                      'message' => "Edit Category  With News,BestNews and News Count By ID Successfully."
                  ]);
    }

    public function showAllCategory()
    {
        $this->authorize('manage_users');

        $category = Category::withCount('news')->get();

                  return response()->json([
                      'data' =>  CategoryResource::collection($category),
                      'message' => "Edit Category  With News,BestNews and News Count By ID Successfully."
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
  $category = Category::with(['news.admin',
  'news.suggestedNews.suggestedNews.admin',
  'news.suggestedNews.suggestedNews.category',
  'bestNews.news.admin',
  'bestNews.news.suggestedNews.suggestedNews'])
  ->withCount('news')->find($id);

            if (!$category) {
                return response()->json([
                    'message' => "Category not found."
                ], 404);
            }

            return response()->json([
                'data' => new CategoryBestNewsResource($category),
                'message' => "Edit Category  With News,BestNews and News Count By ID Successfully."
            ]);
        }


public function showNewsByCategory(Request $request, $categoryId)
{
    $limit = $request->input('limit', 15);
    $category = Category::select('id', 'name')->find($categoryId);

    if (!$category) {
        return response()->json(['message' => 'Category not found.'], 404);
    }

    $news = News::where('category_id', $categoryId)
                ->where('status', 'Published')
                ->select('id as news_id', 'title', 'img', 'writer', 'created_at')
                ->orderBy('created_at', 'desc')
                ->paginate($limit);


    $newsItems = $news->items();
    $newsItems = collect($newsItems)->map(function ($item) {
        return [
            'news_id' => $item['news_id'],
            'title' => $item['title'],
            'img' => $item['img'],
            'writer' => $item['writer'],
            'formatted_date' => Carbon::parse($item['created_at'])->format('M d, Y H:i:s'),
        ];
    })->all();

    return response()->json([
        'category' => [
            'id' => $category->id,
            'category_name' => $category->name,
        ],
        'news' => $newsItems,
        'pagination' => [
            'totalNews' => $news->total(),
            'countNewsInThisPage' => $news->count(),
            'maxNumOfNews_per_page' => $news->perPage(),
            'current_page' => $news->currentPage(),
            'total_pages' => $news->lastPage(),
        ],
        'message' => "News Retrieved Successfully.",
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



