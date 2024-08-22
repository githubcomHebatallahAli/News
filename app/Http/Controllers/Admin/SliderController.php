<?php

namespace App\Http\Controllers\Admin;

use App\Models\Slider;
use App\Traits\ManagesModelsTrait;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SliderRequest;
use App\Http\Resources\Admin\SliderResource;


class SliderController extends Controller
{
    // use ManagesModelsTrait;

//     public function showAll()
//   {
//       $this->authorize('manage_users');

//       $Sliders = Slider::with('news.category', 'news.admin')->get();
//       return response()->json([
//           'data' => SliderResource::collection($Sliders),
//           'message' => "Show All Sliders Successfully."
//       ]);
//   }


//   public function create(SliderRequest $request)
//   {
//       $this->authorize('manage_users');

//          $Slider =Slider::create ([
//               "news_id" => $request-> news_id
//           ]);
//           $Slider->load('news.category','news.admin');
//          $Slider->save();
//          return response()->json([
//           'data' =>new SliderResource($Slider),
//           'message' => "Slider Created Successfully."
//       ]);

//       }

// public function create()
// {
//     $this->authorize('manage_users');

//     // جلب آخر خبر لكل قسم مع الحقول المطلوبة فقط
//     $latestNewsByCategory = DB::table('news')
//         ->select('id as news_id', 'title', 'description', 'img', 'category_id', DB::raw('MAX(created_at) as latest_created_at'))
//         ->groupBy('category_id', 'title', 'description', 'img', 'id')
//         ->orderBy('latest_created_at', 'desc')
//         ->get();

//     // إنشاء سلايدر لكل خبر أحدث
//     foreach ($latestNewsByCategory as $news) {
//         // التحقق من وجود سلايدر بالفعل لهذا الخبر
//         $existingSlider = Slider::where('news_id', $news->news_id)->first();
//         if (!$existingSlider) {
//             Slider::create([
//                 'news_id' => $news->news_id,
//                 'title' => $news->title,
//                 'description' => $news->description,
//                 'img' => $news->img,
//                 'category_id' => $news->category_id
//             ]);
//         }
//     }

//     // تحميل واسترجاع السلايدرز
//     $sliders = Slider::with(['news.category'])->get();

//     return response()->json([
//         'data' => SliderResource::collection($sliders),
//         'message' => "Sliders Created and Retrieved Successfully."
//     ]);
// }



//   public function edit(string $id)
//   {
//       $this->authorize('manage_users');
//       $Slider = Slider::with('news.category','news.admin')->find($id);

//       if (!$Slider) {
//           return response()->json([
//               'message' => "Slider not found."
//           ], 404);
//       }

//       return response()->json([
//           'data' =>new SliderResource($Slider),
//           'message' => "Edit Slider By ID Successfully."
//       ]);
//   }



// //   public function update(SliderRequest $request, string $id)
// //   {
// //       $this->authorize('manage_users');
// //      $Slider =Slider::findOrFail($id);

// //      if (!$Slider) {
// //       return response()->json([
// //           'message' => "Slider not found."
// //       ], 404);
// //   }
// //      $Slider->update([
// //         "news_id" => $request-> news_id

// //       ]);

// //       $Slider->load('news.category', 'news.admin');


// //      $Slider->save();
// //      return response()->json([
// //       'data' =>new SliderResource($Slider),
// //       'message' => " Update Slider By Id Successfully."
// //   ]);

// // }

// protected function updateSliders()
// {
//     // جلب آخر خبر لكل قسم مع الحقول المطلوبة فقط
//     $latestNewsByCategory = DB::table('news')
//         ->select('id as news_id', 'title', 'description', 'img', 'category_id', DB::raw('MAX(created_at) as latest_created_at'))
//         ->groupBy('category_id', 'title', 'description', 'img', 'id')
//         ->orderBy('latest_created_at', 'desc')
//         ->get();

//     // إنشاء أو تحديث السلايدرز لكل خبر أحدث
//     foreach ($latestNewsByCategory as $news) {
//         $existingSlider = Slider::where('news_id', $news->news_id)->first();
//         if (!$existingSlider) {
//             Slider::create([
//                 'news_id' => $news->news_id,
//                 'title' => $news->title,
//                 'description' => $news->description,
//                 'img' => $news->img,
//                 'category_id' => $news->category_id
//             ]);
//         } else {
//             $existingSlider->update([
//                 'title' => $news->title,
//                 'description' => $news->description,
//                 'img' => $news->img,
//                 'category_id' => $news->category_id
//             ]);
//         }
//     }
// }



//   public function destroy(string $id)
//   {
//       return $this->destroyModel(Slider::class, SliderResource::class, $id);
//   }

//   public function showDeleted()
//   {
//       return $this->showDeletedModels(Slider::class, SliderResource::class);
//   }

//   public function restore(string $id)
//   {
//       return $this->restoreModel(Slider::class, $id);
//   }

//   public function forceDelete(string $id)
//   {
//       return $this->forceDeleteModel(Slider::class, $id);
//   }

}
