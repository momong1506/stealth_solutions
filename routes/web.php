<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\ProductManagementController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('login', [LoginController::class, 'index'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');


Route::get('register', [RegisterController::class, 'index'])->name('register');
Route::post('register', [RegisterController::class, 'register']);


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [HomePageController::class, 'index'])->name('dashboard');
    Route::get('/users', [UserManagementController::class, 'index'])->name('users')->middleware("role:admin");
    Route::get('/permissions', [UserManagementController::class, 'permissions'])->name('permissions')->middleware("role:admin");
    Route::get('/user_roles', [UserManagementController::class, 'userRoles'])->name('user_roles')->middleware("role:admin");
    Route::get('/categories', [ProductManagementController::class, 'categories'])->name('categories')->middleware("role:users,admin");
    Route::get('/products', [ProductManagementController::class, 'products'])->name('products')->middleware("role:users,admin");

    Route::post('/change_password', [UserManagementController::class, 'changePassword'])->name('change_password');
    Route::post('/update_user', [UserManagementController::class, 'updateUser'])->name('update_user')->middleware("role:user,admin");

    Route::post('/create_permissions', [UserManagementController::class, 'createPermission'])->name('create_permissions')->middleware("role:admin");
    Route::post('/update_permissions', [UserManagementController::class, 'updatePermission'])->name('update_permissions')->middleware("role:admin");
    Route::post('/delete_permissions', [UserManagementController::class, 'deletePermission'])->name('delete_permissions')->middleware("role:admin");

    Route::post('/create_user_roles', [UserManagementController::class, 'createRole'])->name('create_user_roles')->middleware("role:admin");
    Route::post('/update_user_roles', [UserManagementController::class, 'updateRole'])->name('update_user_roles')->middleware("role:admin");
    Route::post('/delete_user_roles', [UserManagementController::class, 'deleteRole'])->name('delete_user_roles')->middleware("role:admin");

    Route::post('/create_categories', [ProductManagementController::class, 'createCategory'])->name('create_categories')->middleware("role:users,admin");
    Route::post('/update_categories', [ProductManagementController::class, 'updateCategory'])->name('update_categories')->middleware("role:users,admin");
    Route::post('/delete_categories', [ProductManagementController::class, 'deleteCategory'])->name('delete_categories')->middleware("role:users,admin");

    Route::post('/create_products', [ProductManagementController::class, 'createProduct'])->name('create_products')->middleware("role:users,admin");
    Route::post('/update_products', [ProductManagementController::class, 'updateProduct'])->name('update_products')->middleware("role:users,admin");
    Route::post('/delete_products', [ProductManagementController::class, 'deleteProduct'])->name('delete_products')->middleware("role:users,admin");
});