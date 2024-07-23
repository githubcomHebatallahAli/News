<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Models\AdminProfile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Admin\AdminProfileRequest;
use App\Http\Resources\Admin\AdminProfileResource;
use App\Http\Resources\Auth\AdminRegisterResource;

class AdminProfileController extends Controller
{
    public function showAll()
    {
        $this->authorize('manage_users');
        $adminProfiles = AdminProfile::with(['admin.news'])->get();
        return response()->json([
            'data' => AdminProfileResource::collection( $adminProfiles),
            'message' => "Show All Admin Profile Successfully."
        ]);
    }

    public function create(AdminProfileRequest $request)
    {
        $this->authorize('manage_users');
           $AdminProfile =AdminProfile::create ([
            "admin_id" => auth()->id(),
            ]);
            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')->store(AdminProfile::storageFolder);
                $AdminProfile->photo =  $photoPath;
            }
           $AdminProfile->save();
           return response()->json([
            'data' =>new AdminProfileResource($AdminProfile),
            'message' => "Admin Profile Created Successfully."
        ]);

        }


    public function edit(string $id)
    {
        // $this->authorize('manage_users');
        // $AdminProfile = AdminProfile::with(['admin.news'])->find($id);
        // if (!$AdminProfile) {
        //     return response()->json([
        //         'message' => "AdminProfile not found."
        //     ], 404);
        // }
        // return response()->json([
        //     'data' =>new AdminProfileResource($AdminProfile),
        //     'message' => "Show Admin Profile By ID Successfully."
        // ]);

        // {
            $admin = Admin::with('news','role')->findOrFail($id);

            return response()->json([
                'name' => $admin->name,
                'email' => $admin->email,
                'news' => $admin->news
            ]);
        }

    //     $admin = Admin::findOrFail($id);
    //     return new AdminProfileResource($admin);



    public function update(Request $request, string $id)
    {
        $this->authorize('manage_users');
       $AdminProfile =AdminProfile::findOrFail($id);
       if (!$AdminProfile) {
        return response()->json([
            'message' => "Admin Profile not found."
        ], 404);
    }
       $AdminProfile->update([
        "admin_id" => auth()->id(),
        ]);
        if ($request->hasFile('photo')) {
            if ($AdminProfile->photo) {
                Storage::disk('public')->delete($AdminProfile->photo);
            }
            $photoPath = $request->file('photo')->store('AdminProfile', 'public');
            $AdminProfile->photo = $photoPath;
        }

       $AdminProfile->save();
       return response()->json([
        'data' =>new AdminProfileResource($AdminProfile),
        'message' => " Update Admin Profile By Id Successfully."
    ]);
}

public function destroy(string $id){

    return $this->destroyModel(AdminProfile::class, AdminProfileResource::class, $id);
    }

        public function showDeleted(){

        return $this->showDeletedModels(AdminProfile::class, AdminProfileResource::class);
    }

    public function restore(string $id)
    {

        return $this->restoreModel(AdminProfile::class, $id);
    }

    public function forceDelete(string $id){

        return $this->forceDeleteModel(AdminProfile::class, $id);
    }
}
