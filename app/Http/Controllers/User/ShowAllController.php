<?php

namespace App\Http\Controllers\User;

use App\Models\News;
use App\Models\TNews;
use App\Models\Slider;
use App\Models\Comment;
use App\Models\Category;
use App\Models\Advertisment;
use App\Models\TrendingNews;
use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Http\Resources\Admin\NewsResource;
use App\Http\Resources\Admin\TNewsResource;
use App\Http\Resources\Admin\SliderResource;
use App\Http\Resources\Admin\CategoryResource;
use App\Http\Resources\Admin\AdvertismentResource;
use App\Http\Resources\Admin\TrendingNewsResource;
use App\Http\Resources\Admin\CategoryBestNewsResource;


class ShowAllController extends Controller
{
    // public function showAllCategory()
    // {

    //     $categories = Category::with(['news.admin', 'bestNews.news.admin'])
    //         ->withCount('news')
    //         ->get();

    //     return response()->json([
    //         'data' => CategoryBestNewsResource::collection($categories),
    //         'message' => "Show All Categories With News, BestNews, and News Count Successfully."
    //     ]);
    // }

       public function showAllCategory()
    {


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

    public function showAllSlider()
    {

        $Sliders = Slider::get();
        return response()->json([
            'data' => SliderResource::collection(  $Sliders),
            'message' => "Show All Sliders Successfully."
        ]);
    }


    public function showAllTNews()
    {
        $TNews = TNews::get();
        return response()->json([
            'data' => TNewsResource::collection($TNews),
            'message' => "Show All TNews Successfully."
        ]);
    }


    public function showAllTrendingNews()
    {
        $TrendingNews = TrendingNews::get();
        return response()->json([
            'data' => TrendingNewsResource::collection($TrendingNews),
            'message' => "Show All TrendingNews Successfully."
        ]);
    }

    public function showAllAdvertisment()
    {

        $Advertisments = Advertisment::get();
        return response()->json([
            'data' => AdvertismentResource::collection($Advertisments),
            'message' => "Show All Advertisments Successfully."
        ]);
    }

    public function showAllNews()
    {
        // الحصول على جميع الأخبار مع عدد المشاهدات لكل خبر
        $news = News::withCount('views')->get();


        return response()->json([
            'news' => NewsResource::collection($news),
        ]);
    }

    public function showAllComments()
    {
        $Comments = Comment::get();
        return response()->json([
            'data' => CommentResource::collection($Comments),
            'message' => "Show All Comments Successfully."
        ]);
    }




}
