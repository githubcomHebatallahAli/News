<?php

namespace App\Http\Controllers\User;

use App\Models\Ad;
use App\Models\News;
use App\Models\TNews;
use App\Models\Slider;
use App\Models\Comment;
use App\Models\Category;
use App\Models\Advertisment;
use App\Models\TrendingNews;
use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Http\Resources\Admin\AdResource;
use App\Http\Resources\Admin\NewsResource;
use App\Http\Resources\Admin\TNewsResource;
use App\Http\Resources\Admin\SliderResource;
use App\Http\Resources\Admin\AdvertismentResource;
use App\Http\Resources\Admin\TrendingNewsResource;
use App\Http\Resources\Admin\CategoryBestNewsResource;


class ShowAllController extends Controller
{
    public function showAllCategory()
    {

        $categories = Category::with(['news.admin', 'bestNews.news.admin'])
            ->withCount('news')
            ->get();

        return response()->json([
            'data' => CategoryBestNewsResource::collection($categories),
            'message' => "Show All Categories With News, BestNews, and News Count Successfully."
        ]);
    }



    public function showAllSlider()
    {

        $Sliders = Slider::with('news.category', 'news.admin')->get();
        return response()->json([
            'data' => SliderResource::collection(  $Sliders),
            'message' => "Show All Sliders Successfully."
        ]);
    }


    public function showAllTNews()
    {
        $TNews = TNews::with('news.category', 'news.admin')->get();
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

        $news = News::with(['admin', 'category'])->get();

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

    public function showAllAds()
    {


        $Ads = Ad::with('position')->get();
        return response()->json([
            'data' => AdResource::collection($Ads),
            'message' => "Show All Ads Successfully."
        ]);
    }




}
