<?php

namespace App\Http\Controllers\Admin;

use App\Models\Advertisement;
use App\Traits\ManagesModelsTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Admin\AdvertisementRequest;
use App\Http\Resources\Admin\AdvertisementResource;


class AdvertisementController extends Controller
{
    use ManagesModelsTrait;

    public function showAll()
  {
      $this->authorize('manage_users');

      $Advertisements = Advertisement::with('position')
      ->get();
      return response()->json([
          'data' => AdvertisementResource::collection($Advertisements),
          'message' => "Show All Advertisements Successfully."
      ]);
  }


  public function create(AdvertisementRequest $request)
  {
      $this->authorize('manage_users');

         $Advertisement =Advertisement::create ([
              "url" => $request-> url,
              "ad_position_id" => $request-> ad_position_id,
          ]);
          if ($request->hasFile('img')) {
            $imgPath = $request->file('img')->store(Advertisement::storageFolder);
            $Advertisement->img =  $imgPath;
        }

          $Advertisement->loAdvertisement('position');

         $Advertisement->save();
         return response()->json([
          'data' =>new AdvertisementResource($Advertisement),
          'message' => "Advertisement Created Successfully."
      ]);

      }


  public function edit(string $id)
  {
      $this->authorize('manage_users');
      $Advertisement = Advertisement::with('position')
      ->find($id);

      if (!$Advertisement) {
          return response()->json([
              'message' => "Advertisement not found."
          ], 404);
      }

      return response()->json([
          'data' =>new AdvertisementResource($Advertisement),
          'message' => "Edit Advertisement By ID Successfully."
      ]);
  }



  public function update(AdvertisementRequest $request, string $id)
  {
      $this->authorize('manage_users');
      $Advertisement = Advertisement::findOrFail($id);

      if (!$Advertisement) {
          return response()->json([
              'message' => "Advertisement not found."
          ], 404);
      }

      $Advertisement->update([
        "url" => $request-> url,
        "ad_position_id" => $request-> ad_position_id,
      ]);
      if ($request->hasFile('img')) {
        if ($Advertisement->img) {
            Storage::disk('public')->delete($Advertisement->img);
        }
        $imgPath = $request->file('img')->store('Advertisements', 'public');
        $Advertisement->img = $imgPath;
    }


      $Advertisement->loAdvertisement('position');
      $Advertisement->save();

      return response()->json([
          'data' => new AdvertisementResource($Advertisement),
          'message' => "Update Advertisement By Id Successfully."
      ]);
  }


  public function destroy(string $id)
  {
      return $this->destroyModel(Advertisement::class, AdvertisementResource::class, $id);
  }

  public function showDeleted()
  {
      return $this->showDeletedModels(Advertisement::class, AdvertisementResource::class);
  }

  public function restore(string $id)
  {
      return $this->restoreModel(Advertisement::class, $id);
  }

  public function forceDelete(string $id)
  {
      return $this->forceDeleteModel(Advertisement::class, $id);
  }
}
