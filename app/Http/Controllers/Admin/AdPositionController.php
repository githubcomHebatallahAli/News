<?php

namespace App\Http\Controllers\Admin;

use App\Models\AdPosition;

use App\Traits\ManagesModelsTrait;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\AdPositionResource;


class AdPositionController extends Controller
{
    use ManagesModelsTrait;

    public function showAll()
  {
      $this->authorize('manage_users');

      $AdPositions = AdPosition::get();
      return response()->json([
          'data' => AdPositionResource::collection($AdPositions),
          'message' => "Show All AdPositions Successfully."
      ]);
  }


  public function edit(string $id)
  {
      $this->authorize('manage_users');
      $AdPosition = AdPosition::find($id);

      if (!$AdPosition) {
          return response()->json([
              'message' => "AdPosition not found."
          ], 404);
      }

      return response()->json([
          'data' =>new AdPositionResource($AdPosition),
          'message' => "Edit AdPosition By ID Successfully."
      ]);
  }

  public function destroy(string $id)
  {
      return $this->destroyModel(AdPosition::class, AdPositionResource::class, $id);
  }

  public function showDeleted()
  {
      return $this->showDeletedModels(AdPosition::class, AdPositionResource::class);
  }

  public function restore(string $id)
  {
      return $this->restoreModel(AdPosition::class, $id);
  }

  public function forceDelete(string $id)
  {
      return $this->forceDeleteModel(AdPosition::class, $id);
  }


}
