<?php



use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\UserAuthController;


    Route::controller(UserAuthController::class)->prefix('/user')
    ->middleware('api')->group(
        function () {
    Route::post('/login', 'login');
    Route::post('/register',  'register');
    Route::post('/logout',  'logout');
    Route::post('/refresh', 'refresh');
    Route::get('/user-profile', 'userProfile');

});
