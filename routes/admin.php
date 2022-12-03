<?php

use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminComponentsController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminCustomFieldsController;
use App\Http\Controllers\Admin\AdminModulesController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminPageController;
use App\Http\Controllers\Admin\AdminPostController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminSecurityController;
use App\Http\Controllers\Admin\AdminUserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" and "user:admin" middleware group. Now create something great!
|
*/

Route::match(['get', 'post'], '/login', [AdminSecurityController::class, 'login'])->name('admin.login');
Route::get('dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::get('clear-asset/{path}/{file?}', [AdminController::class, 'removePicture'])->name('admin.remove.asset');

Route::match(['get', 'post'],'settings', [AdminController::class, 'settings'])->name('admin.settings');

Route::prefix('modules')->group(function() {
//    Route::get('/', [AdminOrderController::class, 'index'])->name('admin.modules');
});

Route::prefix('pages')->group(function() {
    Route::match(['get', 'post'], '/', [AdminPageController::class, 'index'])->name('admin.pages');
    Route::match(['get', 'post'], '/{id}', [AdminPageController::class, 'update'])
        ->where('id', '[0-9]+')
        ->name('admin.pages.single');
    Route::match(['get', 'post'], '/{id}/delete', [AdminPageController::class, 'delete'])
        ->where('id', '[0-9]+')
        ->name('admin.pages.single.delete');
});

Route::prefix('categories')->group(function () {
    Route::match(['get', 'post'], '/', [AdminCategoryController::class, 'index'])->name('admin.categories');
    Route::match(['get', 'post'], '/{id}', [AdminCategoryController::class, 'update'])
        ->where('id', '[0-9]+')
        ->name('admin.categories.single');
    Route::match(['get', 'post'], '/{id}/delete', [AdminCategoryController::class, 'delete'])
        ->where('id', '[0-9]+')
        ->name('admin.categories.single.delete');
});

Route::prefix('components')->group(function () {
    Route::match(['get', 'post'], '/', [AdminComponentsController::class, 'index'])->name('admin.components');
    Route::match(['get', 'post'], '/{id}', [AdminComponentsController::class, 'update'])
        ->where('id', '[0-9]+')
        ->name('admin.components.single');
    Route::match(['get', 'post'], '/{id}/delete', [AdminComponentsController::class, 'delete'])
        ->where('id', '[0-9]+')
        ->name('admin.components.single.delete');
});

Route::prefix('products')->group(function (){
    Route::match(['get', 'post'], '/', [AdminProductController::class, 'index'])->name('admin.products');
    Route::match(['get', 'post'], '/{id}', [AdminProductController::class, 'update'])
        ->where('id', '[0-9]+')
        ->name('admin.products.single');
    Route::match(['get', 'post'], '/{id}/delete', [AdminProductController::class, 'delete'])
        ->where('id', '[0-9]+')
        ->name('admin.products.single.delete');
});

Route::prefix('orders')->group(function (){
    Route::match(['get', 'post'], '/', [AdminOrderController::class, 'index'])->name('admin.orders');
    Route::match(['get', 'post'], '/{id}', [AdminOrderController::class, 'update'])
        ->where('id', '[0-9]+')
        ->name('admin.orders.single');
    Route::match(['get', 'post'], '/{id}/delete', [AdminOrderController::class, 'delete'])
        ->where('id', '[0-9]+')
        ->name('admin.orders.single.delete');
});

Route::prefix('counterparties')->group(function () {
    Route::match(['get', 'post'], '/', [AdminUserController::class, 'index'])->name('admin.users');
    Route::match(['get', 'post'], '/{id}', [AdminUserController::class, 'update'])
        ->where('id', '[0-9]+')
        ->name('admin.users.single');
    Route::match(['get', 'post'], '/{id}/delete', [AdminUserController::class, 'delete'])
        ->where('id', '[0-9]+')
        ->name('admin.users.single.delete');
});

Route::prefix('modules')->group(function(){
    // banners
    Route::get('/', [AdminModulesController::class, 'index'])->name('admin.modules');
    Route::match(['get', 'post'], '/banners', [AdminModulesController::class, 'banners'])->name('admin.modules.banners');
    Route::match(['get', 'post'], '/banners/{id}/update', [AdminModulesController::class, 'bannersUpdate'])
        ->where('id', '[0-9]+')
        ->name('admin.modules.banners.update');
    Route::match(['get', 'post'], '/banners/{id}/delete', [AdminModulesController::class, 'bannersDelete'])
        ->where('id', '[0-9]+')
        ->name('admin.modules.banners.delete');
    // custom fields
    Route::match(['get', 'post'],'custom-fields', [AdminCustomFieldsController::class, 'index'])->name('admin.modules.fields');
    Route::match(['get', 'post'], '/custom-fields/{id}/update', [AdminCustomFieldsController::class, 'update'])
        ->where('id', '[0-9]+')
        ->name('admin.modules.fields.update');
    Route::match(['get', 'post'], '/custom-fields/{id}/delete', [AdminCustomFieldsController::class, 'delete'])
        ->where('id', '[0-9]+')
        ->name('admin.modules.fields.delete');
});

Route::prefix('posts')->group(function(){
    Route::match(['get', 'post'],'/', [AdminPostController::class, 'index'])->name('admin.posts');
    Route::match(['get', 'post'], '/{id}', [AdminPostController::class, 'update'])
        ->where('id', '[0-9]+')
        ->name('admin.posts.single');
    Route::match(['get', 'post'], '/{id}/delete', [AdminPostController::class, 'delete'])
        ->where('id', '[0-9]+')
        ->name('admin.posts.single.delete');
});

