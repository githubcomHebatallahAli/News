<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ContactUsController;
Route::group([

'prefix' => 'user'
], function () {
Route::get('create/contactUs',[ContactUsController::class,'create']);
Route::get('edit/contactUs',[ContactUsController::class,'edit']);
Route::get('update/contactUs',[ContactUsController::class,'update']);
Route::get('forceDelete/contactUs',[ContactUsController::class,'forceDelete']);
});
