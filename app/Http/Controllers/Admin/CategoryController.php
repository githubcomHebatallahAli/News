<?php

namespace App\Http\Controllers\Admin;



use App\Models\Category;
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



