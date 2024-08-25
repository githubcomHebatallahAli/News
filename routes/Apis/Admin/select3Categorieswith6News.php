<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Selected3CategoriesController;



Route::controller(Selected3CategoriesController::class)->prefix('/admin')->middleware('admin')->group(
    function () {


   Route::post('/select/3/categories/with/6/news', 'updateSelectedCategories');
});
