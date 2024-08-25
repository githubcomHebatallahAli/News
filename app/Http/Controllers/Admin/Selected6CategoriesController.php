<?php

namespace App\Http\Controllers\Admin;


use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Selected6Categories;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\UserNewsResource;


class Selected6CategoriesController extends Controller
{
    public function updateSelectedCategories(Request $request)
    {
        $this->authorize('manage_users');


        $categoryIds = $request->input('category_ids');


        if (!is_array($categoryIds) || count($categoryIds) !== 6) {
            return response()->json(['error' => 'Please select exactly 6 categories.'], 400);
        }


        $selectedCategory = Selected6Categories::updateOrCreate(
            ['id' => 1],
            ['category_ids' => json_encode($categoryIds)]
        );


        $this->updateNewsForSelectedCategories($categoryIds);


        $categoriesWithNews = Category::whereIn('id', $categoryIds)
            ->with(['news' => function ($query) {
                $query->where('status', 'published')
                    //   ->orderBy('updated_at', 'desc')
                      ->orderBy('created_at', 'desc')
                      ->take(4);
            }])
            ->get();

            return response()->json([
                'data' => $categoriesWithNews->map(function ($category) {
                    return [
                        'category_id' => $category->id,
                        'category_name' => $category->name,
                        'news' => UserNewsResource::collection($category->news)
                    ];
                }),
                'message' => 'Categories and related news updated successfully.'
            ]);
        }

    protected function updateNewsForSelectedCategories($categoryIds)
    {
        $categoriesWithNews = Category::whereIn('id', $categoryIds)
            ->with(['news' => function ($query) {
                $query->where('status', 'published')
                      ->orderBy('updated_at', 'desc')
                      ->orderBy('created_at', 'desc')
                      ->take(4);
            }])
            ->get();
}
}
