<?php

namespace App\Http\Controllers\User;

use App\Models\Ad;
use App\Models\News;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\AdResource;
use App\Http\Resources\Admin\CategoryBestNewsResource;
use App\Http\Resources\Admin\NewsWithCommentsResource;

class ShowByIdController extends Controller
{


    public function showNews($id, Request $request)
    {
        $news = News::with(['comments.user', 'category', 'admin','suggestedNews'])
                    ->findOrFail($id);

        if (!$news) {
            return response()->json([
                'message' => "News not found."
            ], 404);
        }

        $news->incrementViews();

        $category = $news->category;
        $category->increment('views_count');
        $category->refresh();

        return response()->json([
            'data' => new NewsWithCommentsResource($news),
            'message' => "News Show By Id Successfully."
        ]);

    }

    public function showCategory(string $id)
    {

$category = Category::with(['news.admin','news.suggestedNews','bestNews.news.admin','bestNews.news.suggestedNews'])
->withCount('news')->find($id);

        if (!$category) {
            return response()->json([
                'message' => "Category not found."
            ], 404);
        }

        $category->incrementViews();
        return response()->json([
            'data' => new CategoryBestNewsResource($category),
            'message' => "Edit Category  With News,BestNews and News Count By ID Successfully."
        ]);
    }

    public function showAd(string $id)
    {

        $Ad = Ad::with('position')->find($id);

        if (!$Ad) {
            return response()->json([
                'message' => "Ad not found."
            ], 404);
        }

        return response()->json([
            'data' =>new AdResource($Ad),
            'message' => "Show Ad By ID Successfully."
        ]);
    }

}
