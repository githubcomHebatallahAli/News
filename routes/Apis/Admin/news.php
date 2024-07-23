<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\NewsController;

   Route::controller(NewsController::class)->prefix('/admin')
->middleware('admin')->group(
    function () {

   Route::get('/showAll/news','showAll');
   Route::post('/create/news', 'create');
   Route::get('/edit/news/{id}','edit');
   Route::post('/update/news/{id}', 'update');
   Route::delete('/delete/news/{id}', 'destroy');
   Route::get('/showDeleted/news', 'showDeleted');
Route::get('/restore/news/{id}','restore');
Route::delete('/forceDelete/news/{id}','forceDelete');
Route::patch('review/news/{id}', 'review');
Route::patch('reject/news/{id}', 'reject');
Route::patch('publish/news/{id}', 'publish');

});



//    Route::controller(NewsController::class)->prefix('/admin')
// ->middleware(['admin','superAdmin','reviewer'])->group(
//     function () {
//         Route::patch('news/review/{id}', 'review');
//         Route::patch('news/reject/{id}', 'reject');
//     });

//    Route::controller(NewsController::class)->prefix('/admin')
// ->middleware(['admin','superAdmin'])->group(
//     function () {
//         Route::patch('news/publish/{id}', 'publish');

//     });
