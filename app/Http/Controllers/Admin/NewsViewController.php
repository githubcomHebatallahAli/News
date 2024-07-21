<?php

namespace App\Http\Controllers\Admin;

use App\Models\News;
use App\Models\NewsView;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NewsViewController extends Controller
{
    public function create(Request $request)
    {
        $newsId = $request->input('news_id');
        $news = News::find($newsId);

        if (!$news) {
            return response()->json(['message' => 'News not found.'], 404);
        }

        // سجل الزيارة
        NewsView::create([
            'news_id' => $newsId,
            'ip_address' => $request->ip() // سجل عنوان الـ IP
        ]);

        // قم بزيادة عدد المشاهدات في نموذج News
        $news->incrementViews();

        return response()->json([
            'message' => 'News view recorded successfully.',
            'data' => $news
        ]);
    }
}
