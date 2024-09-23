<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\News;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\AdminProfileResource;
use App\Http\Resources\Auth\AdminRegisterResource;


class AdminProfileController extends Controller
{
    public function showAll()
    {
        $this->authorize('manage_users');
        // $admins = Admin::with( 'news.category',
        // 'news.suggestedNews.suggestedNews.admin',
        // 'news.suggestedNews.suggestedNews.category',
        // 'role')->get();

        // return response()->json([
        //     'admins' => $admins->map(function ($admin) {
        //         return [
        //             'author' => new AdminRegisterResource($admin),
        //             'news' => AdminProfileResource::collection($admin->news)
        //         ];
        //     })
        // ]);

            $admins = Admin::withCount('news')->get();

    return response()->json([
        'admins' => $admins->map(function ($admin) {
            return [
                'auther' => new AdminRegisterResource($admin),
                'news_count' => $admin->news_count
            ];
        })
    ]);
    }




    public function edit(string $id)
    {
        $this->authorize('manage_users');
            // $admin = Admin::with( 'news.category',
            // 'news.suggestedNews.suggestedNews.admin',
            // 'news.suggestedNews.suggestedNews.category',
            // 'role')->findOrFail($id);

            // return response()->json([
            //     'auther' => new AdminRegisterResource($admin),
            //     'news' => AdminProfileResource::collection($admin->news)
            // ]);

            $admin = Admin::with([
                'news' => function ($query) {
                    $query->select('id as news_id', 'category_id', 'title', 'admin_id')
                          ->with('category:id,name');
                }
            ])->findOrFail($id);

            return response()->json([
                'auther' => new AdminRegisterResource($admin),
                'news' => $admin->news->map(function ($news) {
                    return [
                        'news_id' => $news->news_id,
                        'title' => $news->title,
                        'category_id' => $news->category_id,
                        'category_name' => $news->category->name ?? null,
                    ];
                })
            ]);
        }


        public function editAdminProfileWithpublishedNews(Request $request, $adminId)
{
    $this->authorize('manage_users');
    $limit = $request->input('limit', 15);

    $admin = Admin::findOrFail($adminId);
    $newsQuery = News::where('admin_id', $admin->id)
        ->whereIn('status', ['published'])
        ->with('category:id,name')
        ->select('id as news_id', 'category_id', 'title', 'img','status' ,'writer', 'created_at', 'news_views_count')
        ->orderBy('created_at', 'desc');

    $newsPaginated = $newsQuery->paginate($limit);

    $newsItems = $newsPaginated->items();
    $newsItems = collect($newsItems)->map(function ($item) {
        return [
            'news_id' => $item['news_id'],
            'category_id' => $item['category_id'],
            'category_name' => $item['category']['name'] ?? null,
            'title' => $item['title'],
            'status' => $item['status'],
            'img' => $item['img'],
            'writer' => $item['writer'],
            'formatted_date' => Carbon::parse($item['created_at'])->timezone('Africa/Cairo')->format('M d, Y H:i:s'),
            'news_views_count' => $item['news_views_count'],
        ];
    })->all();

    return response()->json([
        'admin' => new AdminRegisterResource($admin),
        'news' => $newsItems,
        'pagination' => [
            'total' => $newsPaginated->total(),
            'count' => $newsPaginated->count(),
            'per_page' => $newsPaginated->perPage(),
            'current_page' => $newsPaginated->currentPage(),
            'total_pages' => $newsPaginated->lastPage(),
        ],
        'message' => "Admin profile with related publised news retrieved successfully.",
    ]);
}

// ====

public function editAdminProfileWithPendingNews(Request $request, $adminId)
{
    $this->authorize('manage_users');
    $limit = $request->input('limit', 15);

    $admin = Admin::findOrFail($adminId);
    $newsQuery = News::where('admin_id', $admin->id)
        ->whereIn('status', ['pending'])
        ->with('category:id,name')
        ->select('id as news_id', 'category_id', 'title', 'img','status' ,'writer', 'created_at')
        ->orderBy('created_at', 'desc');

    $newsPaginated = $newsQuery->paginate($limit);

    $newsItems = $newsPaginated->items();
    $newsItems = collect($newsItems)->map(function ($item) {
        return [
            'news_id' => $item['news_id'],
            'category_id' => $item['category_id'],
            'category_name' => $item['category']['name'] ?? null,
            'title' => $item['title'],
            'status' => $item['status'],
            'img' => $item['img'],
            'writer' => $item['writer'],
            'formatted_date' => Carbon::parse($item['created_at'])->timezone('Africa/Cairo')->format('M d, Y H:i:s'),

        ];
    })->all();

    return response()->json([
        'admin' => new AdminRegisterResource($admin),
        'news' => $newsItems,
        'pagination' => [
            'total' => $newsPaginated->total(),
            'count' => $newsPaginated->count(),
            'per_page' => $newsPaginated->perPage(),
            'current_page' => $newsPaginated->currentPage(),
            'total_pages' => $newsPaginated->lastPage(),
        ],
        'message' => "Admin profile with related pending news retrieved successfully.",
    ]);
}
public function editAdminProfileWithRejectedNews(Request $request, $adminId)
{
    $this->authorize('manage_users');
    $limit = $request->input('limit', 15);

    $admin = Admin::findOrFail($adminId);
    $newsQuery = News::where('admin_id', $admin->id)
        ->whereIn('status', ['rejected'])
        ->with('category:id,name')
        ->select('id as news_id', 'category_id', 'title', 'img','status' ,'writer', 'created_at')
        ->orderBy('created_at', 'desc');

    $newsPaginated = $newsQuery->paginate($limit);

    $newsItems = $newsPaginated->items();
    $newsItems = collect($newsItems)->map(function ($item) {
        return [
            'news_id' => $item['news_id'],
            'category_id' => $item['category_id'],
            'category_name' => $item['category']['name'] ?? null,
            'title' => $item['title'],
            'status' => $item['status'],
            'img' => $item['img'],
            'writer' => $item['writer'],
            'formatted_date' => Carbon::parse($item['created_at'])->timezone('Africa/Cairo')->format('M d, Y H:i:s'),

        ];
    })->all();

    return response()->json([
        'admin' => new AdminRegisterResource($admin),
        'news' => $newsItems,
        'pagination' => [
            'total' => $newsPaginated->total(),
            'count' => $newsPaginated->count(),
            'per_page' => $newsPaginated->perPage(),
            'current_page' => $newsPaginated->currentPage(),
            'total_pages' => $newsPaginated->lastPage(),
        ],
        'message' => "Admin profile with related rejected news retrieved successfully.",
    ]);
}

public function editAdminProfileWithReviewedNews(Request $request, $adminId)
{
    $this->authorize('manage_users');
    $limit = $request->input('limit', 15);

    $admin = Admin::findOrFail($adminId);
    $newsQuery = News::where('admin_id', $admin->id)
        ->whereIn('status', ['reviewed'])
        ->with('category:id,name')
        ->select('id as news_id', 'category_id', 'title', 'img','status' ,'writer', 'created_at')
        ->orderBy('created_at', 'desc');

    $newsPaginated = $newsQuery->paginate($limit);

    $newsItems = $newsPaginated->items();
    $newsItems = collect($newsItems)->map(function ($item) {
        return [
            'news_id' => $item['news_id'],
            'category_id' => $item['category_id'],
            'category_name' => $item['category']['name'] ?? null,
            'title' => $item['title'],
            'status' => $item['status'],
            'img' => $item['img'],
            'writer' => $item['writer'],
            'formatted_date' => Carbon::parse($item['created_at'])->timezone('Africa/Cairo')->format('M d, Y H:i:s'),

        ];
    })->all();

    return response()->json([
        'admin' => new AdminRegisterResource($admin),
        'news' => $newsItems,
        'pagination' => [
            'total' => $newsPaginated->total(),
            'count' => $newsPaginated->count(),
            'per_page' => $newsPaginated->perPage(),
            'current_page' => $newsPaginated->currentPage(),
            'total_pages' => $newsPaginated->lastPage(),
        ],
        'message' => "Admin profile with related rejected news retrieved successfully.",
    ]);
}


        public function notActive(string $id)
        {
            $admin =Admin::findOrFail($id);

            if (!$admin) {
             return response()->json([
                 'message' => "Admin not found."
             ], 404);
         }
            $this->authorize('notActive',$admin);

            $admin->update(['status' => 'notActive']);

            return response()->json([
                'data' => new AdminRegisterResource($admin),
                'message' => 'Admin has been Not Active.'
            ]);
        }
        public function active(string $id)
        {
            $admin =Admin::findOrFail($id);

            if (!$admin) {
             return response()->json([
                 'message' => "Admin not found."
             ], 404);
         }
            $this->authorize('active',$admin);

            $admin->update(['status' => 'active']);

            return response()->json([
                'data' => new AdminRegisterResource($admin),
                'message' => 'Admin has been Active.'
            ]);
        }

        public function destroy(string $id)
{
    $admin = Admin::findOrFail($id);
    $admin->delete();

    return response()->json([
        'message' => 'Admin soft deleted successfully'
    ]);
}

    public function showDeleted()
    {
        $this->authorize('manage_users');
        $admins = Admin::onlyTrashed()->with( 'news.category',
        'news.suggestedNews.suggestedNews.admin',
        'news.suggestedNews.suggestedNews.category',
        'role')->get();

        return response()->json([
            'admins' => $admins->map(function ($admin) {
                return [
                    'author' => new AdminRegisterResource($admin),
                    'news' => AdminProfileResource::collection($admin->news)
                ];
            })
        ]);
    }


    public function restore(string $id)
{
     $this->authorize('manage_users');
    $admin = Admin::onlyTrashed()->findOrFail($id);
    $admin->restore();

    return response()->json([
        'message' => 'Admin restored successfully'
    ]);
}


public function forceDelete(string $id)
{
    $this->authorize('manage_users');
    $admin = Admin::onlyTrashed()->findOrFail($id);
    $admin->forceDelete();

    return response()->json([
        'message' => 'Admin force deleted successfully'
    ]);
}

}
