<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;

Route::controller(AdminController::class)->prefix('/admin')->middleware('admin')->group(
    function () {

   Route::get('/showAll/admin','showAll');
   Route::get('/edit/admin/{id}','edit');
   Route::delete('/delete/admin/{id}', 'destroy');
   Route::get('/showDeleted/admin', 'showDeleted');
Route::get('/restore/admin/{id}','restore');
Route::delete('/forceDelete/admin/{id}','forceDelete');
   });
