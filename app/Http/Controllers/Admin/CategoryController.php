<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;

use App\Traits\ManagesModelsTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\Admin\CategoryRequest;
use App\Http\Resources\Admin\CategoryResource;

class CategoryController extends Controller
{
    use ManagesModelsTrait;
    public function showAll()
    {
        $this->authorize('manage_users');

        $categories = Category::withCount('news')->get();
        return response()->json([
            'data' => CategoryResource::collection($categories),
            'message' => "Show All Categories With News Count Successfully."
        ]);
    }


    public function create(CategoryRequest $request)
    {
        // $this->authorize('manage_users');
        if (Gate::denies('manage_users', auth()->guard('admin')->user())) {
            return response()->json([
                'message' => 'Unauthorized User'
            ], 403);
        }

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
            $category = Category::withCount('news')->find($id);

            if (!$category) {
                return response()->json([
                    'message' => "Category not found."
                ], 404);
            }

            $category->incrementViews();

            return response()->json([
                'data' => new CategoryResource($category),
                'message' => "Edit Category  With News Count By ID Successfully."
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
