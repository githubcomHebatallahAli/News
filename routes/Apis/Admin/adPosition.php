<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdPositionController;



Route::controller(AdPositionController::class)->prefix('/admin')->middleware('admin')->group(
    function () {

   Route::get('/showAll/adPosition','showAll');
   Route::post('/create/adPosition', 'create');
   Route::get('/edit/adPosition/{id}','edit');
   Route::post('/update/adPosition/{id}', 'update');
   Route::delete('/delete/adPosition/{id}', 'destroy');
   Route::get('/showDeleted/adPosition', 'showDeleted');
Route::get('/restore/adPosition/{id}','restore');
Route::delete('/forceDelete/adPosition/{id}','forceDelete');
   });
