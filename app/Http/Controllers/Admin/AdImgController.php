<?php

namespace App\Http\Controllers\Admin;

use App\Models\AdImg;
use App\Traits\ManagesModelsTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Admin\AdImgRequest;
use App\Http\Resources\Admin\AdImgResource;


class AdImgController extends Controller
{
    use ManagesModelsTrait;

    public function showAll()
  {
      $this->authorize('manage_users');

      $AdImgs = AdImg::get();
      return response()->json([
          'data' => AdImgResource::collection($AdImgs),
          'message' => "Show All AdImgs Successfully."
      ]);
  }


  public function create(AdImgRequest $request)
  {
      $this->authorize('manage_users');

         $AdImg =AdImg::create ([

          ]);
          if ($request->hasFile('img')) {
            $imgPath = $request->file('img')->store(AdImg::storageFolder);
            $AdImg->img =  $imgPath;
        }
         $AdImg->save();
         return response()->json([
          'data' =>new AdImgResource($AdImg),
          'message' => "AdImg Created Successfully."
      ]);

      }


  public function edit(string $id)
  {
      $this->authorize('manage_users');
      $AdImg = AdImg::find($id);

      if (!$AdImg) {
          return response()->json([
              'message' => "AdImg not found."
          ], 404);
      }

      return response()->json([
          'data' =>new AdImgResource($AdImg),
          'message' => "Edit AdImg By ID Successfully."
      ]);
  }



  public function update(AdImgRequest $request, string $id)
  {
      $this->authorize('manage_users');
      $AdImg = AdImg::findOrFail($id);

      if (!$AdImg) {
          return response()->json([
              'message' => "AdImg not found."
          ], 404);
      }

      $AdImg->update([

      ]);

      if ($request->hasFile('img')) {
          if ($AdImg->img) {
              Storage::disk('public')->delete($AdImg->img);
          }
          $imgPath = $request->file('img')->store('AdImgs', 'public');
          $AdImg->img = $imgPath;
      }

      $AdImg->save();

      return response()->json([
          'data' => new AdImgResource($AdImg),
          'message' => "Update AdImg By Id Successfully."
      ]);
  }




  public function destroy(string $id)
  {
      return $this->destroyModel(AdImg::class, AdImgResource::class, $id);
  }

  public function showDeleted()
  {
      return $this->showDeletedModels(AdImg::class, AdImgResource::class);
  }

  public function restore(string $id)
  {
      return $this->restoreModel(AdImg::class, $id);
  }

  public function forceDelete(string $id)
  {
      return $this->forceDeleteModel(AdImg::class, $id);
  }
}
