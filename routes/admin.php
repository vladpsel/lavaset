<?php

use App\Http\Controllers\Admin\AdminController;
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
