<?php

namespace App\Http\Controllers\User;

use App\Models\Ad;
use App\Models\News;
use App\Models\TNews;
use App\Models\Slider;
use App\Models\Comment;
use App\Models\Category;
use App\Models\TrendingNews;
use Illuminate\Http\Request;
use App\Models\Advertisement;
use Illuminate\Support\Facades\DB;
use App\Models\Selected3Categories;
use App\Models\Selected6Categories;
use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Http\Resources\Admin\AdResource;

use App\Http\Resources\Admin\NewsResource;
use App\Http\Resources\Admin\TNewsResource;
use App\Http\Resources\Admin\SliderResource;
use App\Http\Resources\Admin\UserNewsResource;
use App\Http\Resources\Admin\UserTNewsResource;
use App\Http\Resources\Admin\CategoryUserResource;
use App\Http\Resources\Admin\TrendingNewsResource;
use App\Http\Resources\Admin\AdvertisementResource;
use App\Http\Resources\Admin\CategoryBestNewsResource;

class ShowAllController extends Controller
{
    public function showAllCategory()
    {
        $category = Category::with(['news.admin',
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


         public function showAllNewCategory()
     {
         $category = Category::get();
                      return response()->json([
                       'data' =>  CategoryUserResource::collection($category),
                       'message' => "Show All Category Successfully."
                   ]);
     }



    public function showAllSlider()
    {
        $latestNewsByCategory = News::select('id as news_id', 'title', 'description', 'img', 'category_id')
        ->whereIn('id', function ($query) {
            $query->selectRaw('MAX(id)')
                ->from('news')
                ->where('status', 'published')
                ->groupBy('category_id');
        })
        ->orderBy('created_at', 'desc')
        ->get();


    $sliders = $latestNewsByCategory->map(function ($news) {
        return [
            'news_id' => $news->news_id,
            'title' => $news->title,
            'description' => $news->description,
            'img' => $news->img,
            'category_id' => $news->category_id
        ];
    });

    return response()->json([
        'data' => $sliders,
        'message' => "Sliders Retrieved Successfully."
    ]);
    }

    public function showAllLatest4NewsFrom6Selected()
    {
        $selectedCategories = Selected6Categories::first();

        if (!$selectedCategories) {
            return response()->json(['error' => 'No categories selected.'], 400);
        }

        $categoryIds = json_decode($selectedCategories->category_ids);
        $categoriesWithNews = Category::whereIn('id', $categoryIds)
            ->with(['news' => function ($query) {
                $query->where('status', 'published')
                      ->orderBy('created_at', 'desc')
                      ->take(4);
            }])
            ->get();

            $categoriesWithNewsData = $categoriesWithNews->map(function ($category) {
                return [
                    'category_id' => $category->id,
                    'category_name' => $category->name,
                    'news' => UserNewsResource::collection($category->news)
                ];
            });

            return response()->json([
                'data' => $categoriesWithNewsData,
                'message' => "Categories with Latest 4 News Retrieved Successfully."
            ]);
        }



        public function showAllLatest6NewsFrom3Selected()
        {
            $selectedCategories = Selected3Categories::first();

            if (!$selectedCategories) {
                return response()->json(['error' => 'No categories selected.'], 400);
            }

            $categoryIds = json_decode($selectedCategories->category_ids);
            $categoriesWithNews = Category::whereIn('id', $categoryIds)
                ->with(['news' => function ($query) {
                    $query->where('status', 'published')
                          ->orderBy('created_at', 'desc')
                          ->take(6);
                }])
                ->get();

                $categoriesWithNewsData = $categoriesWithNews->map(function ($category) {
                    return [
                        'category_id' => $category->id,
                        'category_name' => $category->name,
                        'news' => UserNewsResource::collection($category->news)
                    ];
                });

                return response()->json([
                    'data' => $categoriesWithNewsData,
                    'message' => "Categories with Latest 6 News Retrieved Successfully."
                ]);
            }

    public function showAllTNews()
    {
        $TNews = TNews::with('news.category','news.admin')->get();
        return response()->json([
            'data' => TNewsResource::collection($TNews),
            'message' => "Show All TNews Successfully."
        ]);
    }

    public function showAllNewTNews()
    {
        $tNews = TNews::with(['news:id,category_id,title'])->get();

        return response()->json([
            'data' => UserTNewsResource::collection($tNews),
            'message' => "All TNews Retrieved Successfully."
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

    public function showAllAdvertisement()
    {
            $Advertisements = Advertisement::with('position')
            ->get();
            return response()->json([
                'data' => AdvertisementResource::collection($Advertisements),
                'message' => "Show All Advertisements Successfully."
            ]);
        }


    public function showAllNews()
    {

        $news = News::with(['admin', 'category',
         'suggestedNews.suggestedNews.admin',
        'suggestedNews.suggestedNews.category'])
        ->get();
        return response()->json([
            'news' => NewsResource::collection($news),
        ]);
    }

    public function showAllallNews()
    {
        $publishedNews = News::where('status', 'published')
        ->select('title', 'id as news_id', 'category_id')
        ->get();

    return response()->json([
        'data' => $publishedNews,
        'message' => "Published news retrieved successfully."
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

    public function mostReadNews()
    {
        $mostReadNews = News::where('status', 'published')
        ->orderBy('news_views_count', 'desc')
        ->take(6)->get();

        return response()->json($mostReadNews);
    }




}
