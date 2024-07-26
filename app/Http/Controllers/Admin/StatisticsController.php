<?php

namespace App\Http\Controllers\Admin;

use App\Models\News;
use App\Models\User;
use App\Models\Comment;
use App\Models\ContactUs;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AdvertiseHere;
use App\Models\BestNews;
use App\Models\Category;

class StatisticsController extends Controller
{
    public function showStatistics()
    {
        $this->authorize('manage_users');
        $newsCount = News::count();
        $usersCount = User::count();
        $commentsCount = Comment::count();
        $advertiseHereCount = AdvertiseHere::count();
        $categoriesCount = Category::count();
        $contactsCount = ContactUs::count();
        $adminsCount = Admin::count();
        $bestNewsCount = BestNews::count();
        $totalNewsViewsCount = News::sum('news_views_count');
        $totalViewsCount = Category::sum('views_count');

        $statistics = [
            'News_count' => $newsCount,
            'Users_count' => $usersCount,
            'Comments_count' => $commentsCount,
            'AdvertiseHere_count' => $advertiseHereCount,
            'Categories_count' => $categoriesCount,
            'ContactUs_count' => $contactsCount,
            'Admins_count' => $adminsCount,
            'BestNews_count'=> $bestNewsCount,
            'News_views_count' => $totalNewsViewsCount,
            'Views_count' => $totalViewsCount
        ];

        return response()->json($statistics);
    }
}
