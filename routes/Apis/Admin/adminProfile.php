<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminProfileController;

Route::controller(AdminProfileController::class)->prefix('/admin')->middleware('admin')->group(
    function () {

   Route::get('/showAll/adminProfile','showAll');

   Route::get('/edit/adminProfile/{id}','edit');
   Route::patch('notActive/admin/{id}', 'notActive');
   Route::patch('active/admin/{id}', 'active');

   Route::delete('/delete/adminProfile/{id}', 'destroy');
   Route::get('/showDeleted/adminProfile', 'showDeleted');
Route::get('/restore/adminProfile/{id}','restore');
Route::delete('/forceDelete/adminProfile/{id}','forceDelete');


Route::get('/edit/adminProfile/with/publised/news/{id}','editAdminProfileWithpublishedNews');
Route::get('/edit/adminProfile/with/pending/news/{id}','editAdminProfileWithPendingNews');
Route::get('/edit/adminProfile/with/reviewed/news/{id}','editAdminProfileWithReviewedNews');
Route::get('/edit/adminProfile/with/rejected/news/{id}','editAdminProfileWithRejectedNews');
   });
