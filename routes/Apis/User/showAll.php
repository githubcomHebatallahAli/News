
<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\ShowAllController;

Route::group([

    'prefix' => 'user'
], function () {
Route::get('showAll/category',[ShowAllController::class,'showAllCategory']);
Route::get('showAll/TNews',[ShowAllController::class,'showAllTNews']);
Route::get('showAll/trendingNews',[ShowAllController::class,'showAllTrendingNews']);
});
