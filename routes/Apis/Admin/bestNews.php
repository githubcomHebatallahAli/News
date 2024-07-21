<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\BestNewsController;

Route::controller(BestNewsController::class)->prefix('/admin')->middleware('admin')->group(
    function () {

   Route::get('/showAll/bestNews','showAll');
   Route::post('/create/bestNews', 'create');
   Route::get('/edit/bestNews/{id}','edit');
   Route::post('/update/bestNews/{id}', 'update');
   Route::delete('/delete/bestNews/{id}', 'destroy');
   Route::get('/showDeleted/bestNews', 'showDeleted');
Route::get('/restore/bestNews/{id}','restore');
Route::delete('/forceDelete/bestNews/{id}','forceDelete');
   });
