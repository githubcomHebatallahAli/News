<?php

namespace App\Http\Controllers\User;

use App\Models\News;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Http\Resources\Admin\NewsResource;
use App\Http\Resources\Admin\CommentNewsResource;
use App\Http\Resources\Admin\CategoryBestNewsResource;
use App\Http\Resources\Admin\NewsWithCommentsResource;

class ShowByIdController extends Controller
{
    // public function showNews($id, Request $request)
    // {
    //     $news = News::withCount('views')->findOrFail($id);
    //     if (!$news) {
    //         return response()->json([
    //             'message' => "News not found."
    //         ], 404);
    //     }

    //     $category = $news->category;
    //     $category->increment('views_count');

    //     // إعادة تحميل عدد الزيارات للقسم بعد التحديث
    //     $category->refresh();
    //     return response()->json([
    //         'data' =>new NewsResource($news),
    //         'message' => "News Show By Id Successfully."
    //     ]);
    // }

    public function showNews($id, Request $request)
    {
        // $news = News::with(['comments.user', 'category', 'admin']) // تحميل التعليقات والمستخدمين المرتبطين بها
        //             ->withCount('views')
        //             ->findOrFail($id);

        // if (!$news) {
        //     return response()->json([
        //         'message' => "News not found."
        //     ], 404);
        // }

        // $category = $news->category;
        // $category->increment('views_count');

        // // إعادة تحميل عدد الزيارات للقسم بعد التحديث
        // $category->refresh();

        // return response()->json([
        //     'data' => new NewsWithCommentsResource($news),
        //     'message' => "News Show By Id Successfully."
        // ]);
        $news = News::with(['comments.user', 'category', 'admin'])
        ->withCount('views')
        ->findOrFail($id);

// في حالة عدم العثور على الخبر، إرسال استجابة بالخطأ 404
if (!$news) {
return response()->json([
    'message' => "News not found."
], 404);
}

// زيادة عدد الزيارات للفئة المرتبطة بالخبر
$category = $news->category;
$category->increment('views_count');

// إعادة تحميل عدد الزيارات للقسم بعد التحديث
$category->refresh();

// إرسال استجابة بنجاح مع البيانات الخاصة بالخبر
return response()->json([
'data' => new NewsWithCommentsResource($news),
'message' => "News Show By Id Successfully."
]);
    }

    public function showCategory(string $id)
    {

$category = Category::with(['news.admin', 'bestNews.news.admin'])
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
}
