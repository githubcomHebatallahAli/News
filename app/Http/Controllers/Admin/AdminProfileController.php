<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\AdminProfileResource;
use App\Http\Resources\Auth\AdminRegisterResource;

class AdminProfileController extends Controller
{
    public function showAll()
    {
        $this->authorize('manage_users');
        $admins = Admin::with(['news.category','news.suggestedNews', 'role'])->get();

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
            $admin = Admin::with(['news.category','news.suggestedNews', 'role'])->findOrFail($id);

            return response()->json([
                'auther' => new AdminRegisterResource($admin),
                'news' => AdminProfileResource::collection($admin->news)
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
        $admins = Admin::onlyTrashed()->with(['news.category','news.suggestedNews' ,'role'])->get();

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
