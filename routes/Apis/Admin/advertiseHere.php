<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdvertiseHereController;

Route::controller(AdvertiseHereController::class)->prefix('/admin')->middleware('admin')->group(
    function () {

   Route::get('/showAll/advertiseHere','showAll');
   Route::get('/edit/advertiseHere/{id}','edit');
   Route::delete('/delete/advertiseHere/{id}', 'destroy');
   Route::get('/showDeleted/advertiseHere', 'showDeleted');
Route::get('/restore/advertiseHere/{id}','restore');
Route::delete('/forceDelete/advertiseHere/{id}','forceDelete');
   });
