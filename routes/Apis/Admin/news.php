<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\NewsController;

   Route::controller(NewsController::class)->prefix('/admin')
->middleware('admin')->group(
    function () {

   Route::get('/showAll/news','showAll');
   Route::post('/create/news', 'create');
   Route::post('/add/suggested/to/news', 'addNewsToSuggested');

   Route::post('/add/news/{newsId}/to/suggestedNews/{suggestedNewsId}', 'addSingleSuggestedNews');
   Route::post('/upload-subImg',  'uploadImage');
   Route::get('/edit/news/{id}','edit');
   Route::post('/update/news/{id}', 'update');
   Route::delete('/delete/news/{id}', 'destroy');
Route::get('/showDeleted/news', 'showDeleted');
Route::get('/restore/news/{id}','restore');
Route::delete('/forceDelete/news/{id}','forceDelete');
   Route::patch('review/news/{id}', 'review');
Route::patch('reject/news/{id}', 'reject');
Route::patch('publish/news/{id}', 'publish');
Route::patch('updateAdminId/news/{id}', 'updateAdminId');
Route::get('showAll/mostReadNews',  'mostReadNews');

});








