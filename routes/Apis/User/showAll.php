
<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\ShowAllController;

Route::group([

    'prefix' => 'user'
], function () {
Route::get('showAll/category',[ShowAllController::class,'showAllCategory']);
Route::get('showAll/newCategory',[ShowAllController::class,'showAllNewCategory']);
Route::get('showAll/TNews',[ShowAllController::class,'showAllTNews']);
Route::get('showAll/newTNews',[ShowAllController::class,'showAllNewTNews']);
Route::get('showAll/trendingNews',[ShowAllController::class,'showAllTrendingNews']);
Route::get('showAll/advertisement',[ShowAllController::class,'showAllAdvertisement']);
Route::get('showAll/newSlider',[ShowAllController::class,'showAllNewSlider']);
Route::get('showAll/slider',[ShowAllController::class,'showAllSlider']);
Route::get('showAll/news',[ShowAllController::class,'showAllNews']);
Route::get('showAll/comments',[ShowAllController::class,'showAllComments']);
Route::get('showAll/ads',[ShowAllController::class,'showAllAds']);
Route::get('showAll/mostReadNews', [ShowAllController::class, 'mostReadNews']);
Route::get('showAll/6Categories/with/latest4News', [ShowAllController::class, 'showAllLatest4NewsFrom6Selected']);
Route::get('showAll/3Categories/with/latest6News', [ShowAllController::class, 'showAllLatest6NewsFrom3Selected']);
});

