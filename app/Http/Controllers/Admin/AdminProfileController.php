<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Models\AdminProfile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\Admin\NewsResource;
use App\Http\Resources\Admin\CategoryResource;
use App\Http\Requests\Admin\AdminProfileRequest;
use App\Http\Resources\Admin\AdminProfileResource;
use App\Http\Resources\Auth\AdminRegisterResource;

class AdminProfileController extends Controller
{
    public function showAll()
    {
        $this->authorize('manage_users');
        $admins = Admin::with(['news.category', 'role'])->get();

        // تحويل البيانات إلى استجابة JSON
        return response()->json([
            'admins' => $admins->map(function ($admin) {
                return [
                    'author' => new AdminRegisterResource($admin),
                    'news' => AdminProfileResource::collection($admin->news)
                ];
            })
        ]);
    }




    public function edit(string $id)
    {
        $this->authorize('manage_users');
            $admin = Admin::with(['news.category', 'role'])->findOrFail($id);

            return response()->json([
                'auther' => new AdminRegisterResource($admin),
                'news' => AdminProfileResource::collection($admin->news)
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
        $admins = Admin::onlyTrashed()->with(['news.category', 'role'])->get();

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
    $admin = Admin::onlyTrashed()->findOrFail($id);
    $admin->restore();

    return response()->json([
        'message' => 'Admin restored successfully'
    ]);
}


public function forceDelete(string $id)
{
    $admin = Admin::onlyTrashed()->findOrFail($id);
    $admin->forceDelete();

    return response()->json([
        'message' => 'Admin force deleted successfully'
    ]);
}

}
