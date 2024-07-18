<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\CreateController;


Route::group([

'prefix' => 'user',
'middleware' => 'auth'
], function () {
Route::post('create/contactUs',[CreateController::class,'createContactUs']);
Route::post('create/advertiseHere',[CreateController::class,'createAdvertiseHere']);

});
