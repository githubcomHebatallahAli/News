<?php

namespace App\Http\Controllers\Admin;

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

        $Category3 = Category3::with('category')->get();
        return response()->json([
            'data' => Category3Resource::collection($Category3),
            'message' => "Show All Category Selected Successfully."
        ]);
    }


    public function create(Category3Request $request)
    {
        $this->authorize('manage_users');

           $Category3 =Category3::create ([
                "category_id" => $request-> category_id
            ]);

           $Category3->save();
           return response()->json([
            'data' =>new Category3Resource($Category3),
            'message' => "Category Selected Created Successfully."
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
       $Category3 =Category3::with('category')->findOrFail($id);

       if (!$Category3) {
        return response()->json([
            'message' => "Category Selected not found."
        ], 404);
    }
       $Category3->update([
        "category_id" => $request-> category_id
        ]);

       $Category3->save();
       return response()->json([
        'data' =>new Category3Resource($Category3),
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
