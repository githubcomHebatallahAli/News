<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdvertismentController;

Route::controller(AdvertismentController::class)->prefix('/admin')->middleware('admin')->group(
    function () {

   Route::get('/showAll/advertisment','showAll');
   Route::post('/create/advertisment', 'create');
   Route::get('/edit/advertisment/{id}','edit');
   Route::post('/update/advertisment/{id}', 'update');
   Route::delete('/delete/advertisment/{id}', 'destroy');
   Route::get('/showDeleted/advertisment', 'showDeleted');
Route::get('/restore/advertisment/{id}','restore');
Route::delete('/forceDelete/advertisment/{id}','forceDelete');
   });
