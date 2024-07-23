<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminProfileController;

Route::controller(AdminProfileController::class)->prefix('/admin')->middleware('admin')->group(
    function () {

   Route::get('/showAll/adminProfile','showAll');
   Route::post('/create/adminProfile', 'create');
   Route::get('/edit/adminProfile/{id}','edit');
   Route::post('/update/adminProfile/{id}', 'update');
   Route::delete('/delete/adminProfile/{id}', 'destroy');
   Route::get('/showDeleted/adminProfile', 'showDeleted');
Route::get('/restore/adminProfile/{id}','restore');
Route::delete('/forceDelete/adminProfile/{id}','forceDelete');
   });
