
<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\ShowAllController;

Route::group([

    'prefix' => 'user'
], function () {
Route::get('showAll/category',[ShowAllController::class,'showAllCategory']);
Route::get('showAll/newCategory',[ShowAllController::class,'showAllNewCategory']);
Route::get('showAll/TNews',[ShowAllController::class,'showAllTNews']);
Route::get('showAll/trendingNews',[ShowAllController::class,'showAllTrendingNews']);
Route::get('showAll/advertisement',[ShowAllController::class,'showAllAdvertisement']);
Route::get('showAll/slider',[ShowAllController::class,'showAllSlider']);
Route::get('showAll/news',[ShowAllController::class,'showAllNews']);
Route::get('showAll/comments',[ShowAllController::class,'showAllComments']);
Route::get('showAll/ads',[ShowAllController::class,'showAllAds']);
Route::get('showAll/mostReadNews', [ShowAllController::class, 'mostReadNews']);
});
