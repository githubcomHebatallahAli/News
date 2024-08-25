<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Traits\ManagesModelsTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UpdateAdminRegister;
use App\Http\Resources\Auth\AdminRegisterResource;
use App\Http\Requests\Auth\UpdateAdminRegisterRequest;
use App\Http\Resources\Auth\EditAdminRegisterResource;

class AdminController extends Controller
{
    use ManagesModelsTrait;

    public function showAll()
  {
      $this->authorize('manage_users');

      $Admins = Admin::get();
      return response()->json([
          'data' => AdminRegisterResource::collection($Admins),
          'message' => "Show All Admins Successfully."
      ]);
  }


  public function edit(string $id)
  {
      $this->authorize('manage_users');
      $Admin = Admin::find($id);

      if (!$Admin) {
          return response()->json([
              'message' => "Admin not found."
          ], 404);
      }

      return response()->json([
          'data' =>new AdminRegisterResource($Admin),
          'message' => "Edit Admin By ID Successfully."
      ]);
  }

  public function update(UpdateAdminRegisterRequest $request, string $id)
  {
      $this->authorize('manage_users');
      $Admin = Admin::findOrFail($id);

      if (!$Admin) {
          return response()->json([
              'message' => "Admin not found."
          ], 404);
      }

      
      if ($request->filled('name')) {
          $Admin->name = $request->name;
      }

      if ($request->filled('email')) {
          $Admin->email = $request->email;
      }

      $Admin->role_id = $request->role_id;
      $Admin->adsenseCode = $request->adsenseCode;
      $Admin->status = $request->status;

      $Admin->save();

      return response()->json([
          'data' => new AdminRegisterResource($Admin),
          'message' => "Update Admin By Id Successfully."
      ]);
}







  public function destroy(string $id)
  {
      return $this->destroyModel(Admin::class, AdminRegisterResource::class, $id);
  }

  public function showDeleted()
  {
      return $this->showDeletedModels(Admin::class, AdminRegisterResource::class);
  }

  public function restore(string $id)
  {
      return $this->restoreModel(Admin::class, $id);
  }

  public function forceDelete(string $id)
  {
      return $this->forceDeleteModel(Admin::class, $id);
  }
}
