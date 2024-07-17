<?php

namespace App\Http\Controllers\Admin;

use App\Models\Advertisment;
use App\Traits\ManagesModelsTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Admin\AdvertismentRequest;
use App\Http\Resources\Admin\AdvertismentResource;


class AdvertismentController extends Controller
{
    use ManagesModelsTrait;

    public function showAll()
  {
      $this->authorize('manage_users');

      $Advertisments = Advertisment::get();
      return response()->json([
          'data' => AdvertismentResource::collection($Advertisments),
          'message' => "Show All Advertisments Successfully."
      ]);
  }


  public function create(AdvertismentRequest $request)
  {
      $this->authorize('manage_users');

         $Advertisment =Advertisment::create ([
              "url" => $request-> url,
          ]);
          if ($request->hasFile('img')) {
            $imgPath = $request->file('img')->store(Advertisment::storageFolder);
            $Advertisment->poster =  $imgPath;
        }
         $Advertisment->save();
         return response()->json([
          'data' =>new AdvertismentResource($Advertisment),
          'message' => "Advertisment Created Successfully."
      ]);

      }


  public function edit(string $id)
  {
      $this->authorize('manage_users');
      $Advertisment = Advertisment::find($id);

      if (!$Advertisment) {
          return response()->json([
              'message' => "Advertisment not found."
          ], 404);
      }

      return response()->json([
          'data' =>new AdvertismentResource($Advertisment),
          'message' => "Edit Advertisment By ID Successfully."
      ]);
  }



  public function update(AdvertismentRequest $request, string $id)
  {
      $this->authorize('manage_users');
     $Advertisment =Advertisment::findOrFail($id);

     if (!$Advertisment) {
      return response()->json([
          'message' => "Advertisment not found."
      ], 404);
  }
     $Advertisment->update([
        "title" => $request-> title,
        "content" => $request-> content,
        "url" => $request-> url,
      ]);
      if ($request->hasFile('img')) {
        if ($Advertisment->img) {
            Storage::disk('public')->delete($Advertisment->img);
        }
        $imgPath = $request->file('img')->store('img', 'public');
        $Advertisment->img = $imgPath;
    }

     $Advertisment->save();
     return response()->json([
      'data' =>new AdvertismentResource($Advertisment),
      'message' => " Update Advertisment By Id Successfully."
  ]);

}



  public function destroy(string $id)
  {
      return $this->destroyModel(Advertisment::class, AdvertismentResource::class, $id);
  }

  public function showDeleted()
  {
      return $this->showDeletedModels(Advertisment::class, AdvertismentResource::class);
  }

  public function restore(string $id)
  {
      return $this->restoreModel(Advertisment::class, $id);
  }

  public function forceDelete(string $id)
  {
      return $this->forceDeleteModel(Advertisment::class, $id);
  }
}
