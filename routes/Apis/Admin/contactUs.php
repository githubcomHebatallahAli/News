<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ContactUsController;

Route::controller(ContactUsController::class)->prefix('/admin')->middleware('admin')->group(
    function () {

   Route::get('/showAll/contactUs','showAll');
   Route::get('/edit/contactUs/{id}','edit');
   Route::delete('/delete/contactUs/{id}', 'destroy');
   Route::get('/showDeleted/contactUs', 'showDeleted');
Route::get('/restore/contactUs/{id}','restore');
Route::delete('/forceDelete/contactUs/{id}','forceDelete');
   });
