<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;

use App\Traits\ManagesModelsTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryRequest;
use App\Http\Resources\Admin\CategoryResource;

class CategoryController extends Controller
{
    use ManagesModelsTrait;
    public function showAll()
    {
        $this->authorize('manage_users');

        $Categorys = Category::get();
        return response()->json([
            'data' => CategoryResource::collection($Categorys),
            'message' => "Show All Categorys Successfully."
        ]);
    }


    public function create(CategoryRequest $request)
    {
        $this->authorize('manage_users');

           $Category =Category::create ([

                "name" => $request->name
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
        $Category = Category::find($id);

        if (!$Category) {
            return response()->json([
                'message' => "Category not found."
            ], 404);
        }

        return response()->json([
            'data' =>new CategoryResource($Category),
            'message' => "Edit Category By ID Successfully."
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
        "name" => $request->name
        ]);

       $Category->save();
       return response()->json([
        'data' =>new CategoryResource($Category),
        'message' => " Update Category By Id Successfully."
    ]);
}

public function destroy(string $id){
//     $this->authorize('manage_users');
//     $Category =Category::find($id);
//     if (!$Category) {
//      return response()->json([
//          'message' => "Category not found."
//      ], 404);
//  }

//     $Category->delete($id);
//     return response()->json([
//         'data' =>new CategoryResource($Category),
//         'message' => " Soft Delete Category By Id Successfully."
//     ]);
return $this->destroyModel(Category::class, CategoryResource::class, $id);
}

    public function showDeleted(){
    //     $this->authorize('manage_users');
    // $Categorys=Category::onlyTrashed()->get();
    // return response()->json([
    //     'data' =>CategoryResource::collection($Categorys),
    //     'message' => "Show Deleted Categorys Successfully."
    // ]);
    return $this->showDeletedModels(Category::class, CategoryResource::class);
}

public function restore(string $id)
{
    //    $this->authorize('manage_users');
    // $Category = Category::withTrashed()->where('id', $id)->first();
    // if (!$Category) {
    //     return response()->json([
    //         'message' => "Category not found."
    //     ], 404);
    // }

    // $Category->restore();
    // return response()->json([
    //     'message' => "Restore Category By Id Successfully."
    // ]);
    return $this->restoreModel(Category::class, $id);
}

public function forceDelete(string $id){
    // $this->authorize('manage_users');
    // $Category=Category::withTrashed()->where('id',$id)->first();
    // if (!$Category) {
    //     return response()->json([
    //         'message' => "Category not found."
    //     ], 404);
    // }


    // $Category->forceDelete();
    // return response()->json([
    //     'message' => " Force Delete Category By Id Successfully."
    // ]);
    return $this->forceDeleteModel(Category::class, $id);
}
}
