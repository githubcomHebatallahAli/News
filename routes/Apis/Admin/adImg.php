<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdImgController;

Route::controller(AdImgController::class)->prefix('/admin')->middleware('admin')->group(
    function () {

   Route::get('/showAll/adImg','showAll');
   Route::post('/create/adImg', 'create');
   Route::get('/edit/adImg/{id}','edit');
   Route::post('/update/adImg/{id}', 'update');
   Route::delete('/delete/adImg/{id}', 'destroy');
   Route::get('/showDeleted/adImg', 'showDeleted');
Route::get('/restore/adImg/{id}','restore');
Route::delete('/forceDelete/adImg/{id}','forceDelete');
   });
