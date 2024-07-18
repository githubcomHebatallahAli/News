<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\CreateController;


Route::group([

'prefix' => 'user'
], function () {
Route::post('create/contactUs',[CreateController::class,'createContactUs']);

});
