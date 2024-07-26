<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminProfileController;

Route::controller(AdminProfileController::class)->prefix('/admin')->middleware('admin')->group(
    function () {

   Route::get('/showAll/adminProfile','showAll');

   Route::get('/edit/adminProfile/{id}','edit');
   Route::patch('notActive/admin/{id}', 'notActive');

   Route::delete('/delete/adminProfile/{id}', 'destroy');
   Route::get('/showDeleted/adminProfile', 'showDeleted');
Route::get('/restore/adminProfile/{id}','restore');
Route::delete('/forceDelete/adminProfile/{id}','forceDelete');
   });
