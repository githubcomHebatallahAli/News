<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RoleController;

// Route::post('/create', [RoleController::class, 'create']) ;



require __DIR__ . '/Apis/Auth/user.php';
require __DIR__ . '/Apis/Auth/admin.php';
require __DIR__ . '/Apis/Auth/resetPassword.php';
require __DIR__ . '/Apis/Admin/role.php';
require __DIR__ . '/Apis/Admin/category.php';
