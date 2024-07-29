<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\ShowByIdController;


Route::group([

    'prefix' => 'user'
], function () {
Route::get('show/category/{id}',[ShowByIdController::class,'showCategory']);
Route::get('show/news/{id}',[ShowByIdController::class,'showNews']);
Route::get('show/ad/{id}',[ShowByIdController::class,'showAd']);


});



