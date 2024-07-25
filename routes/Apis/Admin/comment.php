<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CommentController;

Route::controller(CommentController::class)->prefix('/admin')->middleware('admin')->group(
    function () {

   Route::get('/showAll/comment','showAll');
   Route::get('/edit/comment/{id}','edit');
   Route::patch('approve/comment/{id}', 'approve');
   Route::patch('reject/comment/{id}', 'reject');
   Route::delete('/delete/comment/{id}', 'destroy');
   Route::get('/showDeleted/comment', 'showDeleted');
Route::get('/restore/comment/{id}','restore');
Route::delete('/forceDelete/comment/{id}','forceDelete');
   });
