<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdvertisementController;

Route::controller(AdvertisementController::class)->prefix('/admin')->middleware('admin')->group(
    function () {

   Route::get('/showAll/advertisement','showAll');
   Route::post('/create/advertisement', 'create');
   Route::get('/edit/advertisement/{id}','edit');
   Route::post('/update/advertisement/{id}', 'update');
   Route::delete('/delete/advertisement/{id}', 'destroy');
   Route::get('/showDeleted/advertisement', 'showDeleted');
Route::get('/restore/advertisement/{id}','restore');
Route::delete('/forceDelete/advertisement/{id}','forceDelete');
   });
