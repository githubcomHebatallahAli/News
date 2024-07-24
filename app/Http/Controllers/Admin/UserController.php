<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\ManagesModelsTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UserRegisterRequest;
use App\Http\Resources\Auth\UserRegisterResource;

class UserController extends Controller
{
    use ManagesModelsTrait;

    public function showAll()
  {
      $this->authorize('manage_users');

      $Users = User::get();
      return response()->json([
          'data' => UserRegisterResource::collection($Users),
          'message' => "Show All Users Successfully."
      ]);
  }


  public function edit(string $id)
  {
      $this->authorize('manage_users');
      $User = User::find($id);

      if (!$User) {
          return response()->json([
              'message' => "User not found."
          ], 404);
      }

      return response()->json([
          'data' =>new UserRegisterResource($User),
          'message' => "Edit User By ID Successfully."
      ]);
  }

  public function destroy(string $id)
  {
      return $this->destroyModel(User::class, UserRegisterResource::class, $id);
  }

  public function showDeleted()
  {
      return $this->showDeletedModels(User::class, UserRegisterResource::class);
  }

  public function restore(string $id)
  {
      return $this->restoreModel(User::class, $id);
  }

  public function forceDelete(string $id)
  {
      return $this->forceDeleteModel(User::class, $id);
  }
}
