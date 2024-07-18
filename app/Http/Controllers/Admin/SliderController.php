<?php

namespace App\Http\Controllers\Admin;

use App\Models\Slider;
use App\Traits\ManagesModelsTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Admin\SliderRequest;
use App\Http\Resources\Admin\SliderResource;


class SliderController extends Controller
{
    use ManagesModelsTrait;

    public function showAll()
  {
      $this->authorize('manage_users');

      $Sliders = Slider::get();
      return response()->json([
          'data' => SliderResource::collection($Sliders),
          'message' => "Show All Sliders Successfully."
      ]);
  }


  public function create(SliderRequest $request)
  {
      $this->authorize('manage_users');

         $Slider =Slider::create ([

              "title" => $request-> title,
              "content" => $request-> content,
              "url" => $request-> url,
          ]);
          if ($request->hasFile('img')) {
            $imgPath = $request->file('img')->store(Slider::storageFolder);
            $Slider->img =  $imgPath;
        }
         $Slider->save();
         return response()->json([
          'data' =>new SliderResource($Slider),
          'message' => "Slider Created Successfully."
      ]);

      }


  public function edit(string $id)
  {
      $this->authorize('manage_users');
      $Slider = Slider::find($id);

      if (!$Slider) {
          return response()->json([
              'message' => "Slider not found."
          ], 404);
      }

      return response()->json([
          'data' =>new SliderResource($Slider),
          'message' => "Edit Slider By ID Successfully."
      ]);
  }



  public function update(SliderRequest $request, string $id)
  {
      $this->authorize('manage_users');
     $Slider =Slider::findOrFail($id);

     if (!$Slider) {
      return response()->json([
          'message' => "Slider not found."
      ], 404);
  }
     $Slider->update([
        "title" => $request-> title,
        "content" => $request-> content,
        "url" => $request-> url,
      ]);
      if ($request->hasFile('img')) {
        if ($Slider->img) {
            Storage::disk('public')->delete($Slider->img);
        }
        $imgPath = $request->file('img')->store('Sliders', 'public');
        $Slider->img = $imgPath;

    }

     $Slider->save();
     return response()->json([
      'data' =>new SliderResource($Slider),
      'message' => " Update Slider By Id Successfully."
  ]);

}



  public function destroy(string $id)
  {
      return $this->destroyModel(Slider::class, SliderResource::class, $id);
  }

  public function showDeleted()
  {
      return $this->showDeletedModels(Slider::class, SliderResource::class);
  }

  public function restore(string $id)
  {
      return $this->restoreModel(Slider::class, $id);
  }

  public function forceDelete(string $id)
  {
      return $this->forceDeleteModel(Slider::class, $id);
  }

}
