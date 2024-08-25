<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Selected6CategoriesController;


Route::controller(Selected6CategoriesController::class)->prefix('/admin')->middleware('admin')->group(
    function () {


   Route::post('/select/6/categories/with/4/news', 'updateSelectedCategories');
});
