<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\TrendingNewsController;

Route::controller(TrendingNewsController::class)->prefix('/admin')->middleware('admin')->group(
    function () {

   Route::get('/showAll/trendingNews','showAll');
   Route::post('/create/trendingNews', 'create');
   Route::get('/edit/trendingNews/{id}','edit');
   Route::post('/update/trendingNews/{id}', 'update');
   Route::delete('/delete/trendingNews/{id}', 'destroy');
   Route::get('/showDeleted/trendingNews', 'showDeleted');
Route::get('/restore/trendingNews/{id}','restore');
Route::delete('/forceDelete/trendingNews/{id}','forceDelete');
   });
