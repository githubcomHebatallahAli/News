<?php

namespace App\Http\Controllers\Admin;

use App\Models\Ad;
use App\Traits\ManagesModelsTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdRequest;
use App\Http\Resources\Admin\AdResource;


class AdController extends Controller
{
    use ManagesModelsTrait;

    public function showAll()
  {
      $this->authorize('manage_users');

      $Ads = Ad::with('position')->get();
      return response()->json([
          'data' => AdResource::collection($Ads),
          'message' => "Show All Ads Successfully."
      ]);
  }


  public function create(AdRequest $request)
  {
      $this->authorize('manage_users');

         $Ad =Ad::create ([
              "code" => $request-> code,
              "ad_position_id" => $request-> ad_position_id,
          ]);

          $Ad->load('position');

         $Ad->save();
         return response()->json([
          'data' =>new AdResource($Ad),
          'message' => "Ad Created Successfully."
      ]);

      }


  public function edit(string $id)
  {
      $this->authorize('manage_users');
      $Ad = Ad::with('position')->find($id);

      if (!$Ad) {
          return response()->json([
              'message' => "Ad not found."
          ], 404);
      }

      return response()->json([
          'data' =>new AdResource($Ad),
          'message' => "Edit Ad By ID Successfully."
      ]);
  }



  public function update(AdRequest $request, string $id)
  {
      $this->authorize('manage_users');
      $Ad = Ad::findOrFail($id);

      if (!$Ad) {
          return response()->json([
              'message' => "Ad not found."
          ], 404);
      }

      $Ad->update([
          'code' => $request->code,
          "ad_position_id" => $request-> ad_position_id,
      ]);


      $Ad->load('position');
      $Ad->save();

      return response()->json([
          'data' => new AdResource($Ad),
          'message' => "Update Ad By Id Successfully."
      ]);
  }


  public function destroy(string $id)
  {
      return $this->destroyModel(Ad::class, AdResource::class, $id);
  }

  public function showDeleted()
  {
      return $this->showDeletedModels(Ad::class, AdResource::class);
  }

  public function restore(string $id)
  {
      return $this->restoreModel(Ad::class, $id);
  }

  public function forceDelete(string $id)
  {
      return $this->forceDeleteModel(Ad::class, $id);
  }
}
