<?php

namespace App\Http\Controllers\User;

use App\Models\TNews;
use App\Models\Category;
use App\Models\TrendingNews;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\TNewsResource;
use App\Http\Resources\Admin\CategoryResource;
use App\Http\Resources\Admin\TrendingNewsResource;


class ShowAllController extends Controller
{
    public function showAllCategory()
    {

        $Categorys = Category::get();
        return response()->json([
            'data' => CategoryResource::collection($Categorys),
            'message' => "Show All Categorys Successfully."
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


}
