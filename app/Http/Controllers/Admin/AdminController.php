<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Traits\ManagesModelsTrait;
use App\Http\Controllers\Controller;
use App\Http\Resources\Auth\AdminRegisterResource;

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
