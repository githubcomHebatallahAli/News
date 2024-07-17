<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\TNewsController;

Route::controller(TNewsController::class)->prefix('/admin')->middleware('admin')->group(
    function () {

   Route::get('/showAll/TNews','showAll');
   Route::post('/create/TNews', 'create');
   Route::get('/edit/TNews/{id}','edit');
   Route::post('/update/TNews/{id}', 'update');
   Route::delete('/delete/TNews/{id}', 'destroy');
   Route::get('/showDeleted/TNews', 'showDeleted');
Route::get('/restore/TNews/{id}','restore');
Route::delete('/forceDelete/TNews/{id}','forceDelete');
   });
