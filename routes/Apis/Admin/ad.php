<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdController;

Route::controller(AdController::class)->prefix('/admin')->middleware('admin')->group(
    function () {

   Route::get('/showAll/ad','showAll');
   Route::post('/create/ad', 'create');
   Route::get('/edit/ad/{id}','edit');
   Route::post('/update/ad/{id}', 'update');
   Route::delete('/delete/ad/{id}', 'destroy');
   Route::get('/showDeleted/ad', 'showDeleted');
Route::get('/restore/ad/{id}','restore');
Route::delete('/forceDelete/ad/{id}','forceDelete');
   });
