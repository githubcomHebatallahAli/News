<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SliderController;

Route::controller(SliderController::class)->prefix('/admin')->middleware('admin')->group(
    function () {

   Route::get('/showAll/slider','showAll');
   Route::post('/create/slider', 'create');
   Route::get('/edit/slider/{id}','edit');
   Route::post('/update/slider/{id}', 'update');
   Route::delete('/delete/slider/{id}', 'destroy');
   Route::get('/showDeleted/slider', 'showDeleted');
Route::get('/restore/slider/{id}','restore');
Route::delete('/forceDelete/slider/{id}','forceDelete');
   });
