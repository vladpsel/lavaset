<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminPageController;
use App\Http\Controllers\Admin\AdminSecurityController;
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

Route::match(['get', 'post'], '/login', [AdminSecurityController::class, 'login'])
    ->name('admin.login');


Route::get('dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

Route::prefix('pages')->group(function() {
    Route::match(['get', 'post'], '/', [AdminPageController::class, 'index'])->name('admin.pages');
    Route::match(['get', 'post'], '/{id}', [AdminPageController::class, 'update'])
        ->where('id', '[0-9]+')
        ->name('admin.pages.single');
    Route::match(['get', 'post'], '/{id}/delete', [AdminPageController::class, 'delete'])
        ->where('id', '[0-9]+')
        ->name('admin.pages.single.delete');
});
