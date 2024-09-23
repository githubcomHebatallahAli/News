<?php

namespace App\Http\Controllers\User;

use App\Models\Ad;
use Carbon\Carbon;
use App\Models\News;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\AdResource;
use App\Http\Resources\Admin\CategoryBestNewsResource;
use App\Http\Resources\Admin\NewsWithCommentsResource;

class ShowByIdController extends Controller
{


    public function showNews($id)
    {
        $news = News::with(['comments.user', 'category', 'admin',
        'suggestedNews.suggestedNews.admin',
        'suggestedNews.suggestedNews.category'])
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


// public function showNewsByCategory(Request $request, $categoryId)
// {
//     $limit = $request->input('limit', 6);
//     $category = Category::select('id', 'name')->find($categoryId);
//     if (!$category) {
//         return response()->json(['message' => 'Category not found.'], 404);
//     }


//     $news = News::where('category_id', $categoryId)
//                 ->where('status', 'Published')
//                 ->select('id as news_id', 'title', 'img', 'writer')
//                 ->orderBy('created_at', 'desc')
//                 ->limit($limit)
//                 ->get();

//     return response()->json([
//         'category' => [
//             'id' => $category->id,
//             'name' => $category->name,
//         ],
//         'news' => $news,
//         'message' => "News Retrieved Successfully.",
//     ]);
// }


public function showNewsByCategory(Request $request, $categoryId)
{
    $limit = $request->input('limit', 6);
    $category = Category::select('id', 'name')->find($categoryId);
    if (!$category) {
        return response()->json(['message' => 'Category not found.'], 404);
    }

    $news = News::where('category_id', $categoryId)
                ->where('status', 'Published')
                ->select('id as news_id', 'title', 'img', 'writer','created_at')
                ->orderBy('created_at', 'desc')
                ->limit($limit)
                ->get()
                ->map(function ($newsItem) {
                    return [
                        'news_id' => $newsItem->news_id,
                        'title' => $newsItem->title,
                        'img' => $newsItem->img,
                        'writer' => $newsItem->writer,
                        'formatted_date' => Carbon::parse($newsItem->created_at)->format('M d, Y H:i:s'),
                    ];
                });

    return response()->json([
        'category' => [
            'id' => $category->id,
            'name' => $category->name,
        ],
        'news' => $news,
        'message' => "News Retrieved Successfully.",
    ]);
}


}
