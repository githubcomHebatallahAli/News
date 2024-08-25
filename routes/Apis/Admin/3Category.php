<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Category3Controller;

Route::controller(Category3Controller::class)->prefix('/admin')->middleware('admin')->group(
    function () {

   Route::get('/showAll/3Category','showAll');
   Route::post('/create/3Category', 'create');
   Route::get('/edit/3Category/{id}','edit');
   Route::post('/update/3Category/{id}', 'update');
   Route::delete('/delete/3Category/{id}', 'destroy');
   Route::get('/showDeleted/3Category', 'showDeleted');
Route::get('/restore/3Category/{id}','restore');
Route::delete('/forceDelete/3Category/{id}','forceDelete');
   });
