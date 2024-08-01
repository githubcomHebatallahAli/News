<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SuggestedNewsController;

Route::controller(SuggestedNewsController::class)->prefix('/admin')->middleware('admin')->group(
    function () {

   Route::get('/showAll/suggestedNews','showAll');
   Route::post('/create/suggestedNews', 'create');
   Route::get('/edit/suggestedNews/{id}','edit');
   Route::post('/update/suggestedNews/{id}', 'update');
   Route::delete('/delete/suggestedNews/{id}', 'destroy');
   Route::get('/showDeleted/suggestedNews', 'showDeleted');
Route::get('/restore/suggestedNews/{id}','restore');
Route::delete('/forceDelete/suggestedNews/{id}','forceDelete');
   });
