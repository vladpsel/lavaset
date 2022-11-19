<?php

use App\Http\Controllers\Application\AppCategoryController;
use App\Http\Controllers\Application\AppController;
use App\Http\Controllers\Application\AppProductController;
use Illuminate\Support\Facades\Route;

//Route::get('{locale}', [AppController::class, 'home'])->where('locale', '([a-z]{2})?');
//Route::get('category/{id}', [AppCategoryController::class, 'index'])->where('id', '([a-z0-9\-]+)?');
//
//
//Route::get('{locale}/category/{id}', [AppCategoryController::class, 'index'])->where([
//    'id' => '([a-z0-9\-]+)?',
//    'locale' => '([a-z]{2})?',
//]);

$routes = function () {
    Route::get('/', [AppController::class, 'home']);
    Route::get('category/{id}', [AppCategoryController::class, 'index'])->where('id', '([a-z0-9\-]+)?');
    Route::get('product/{id}', [AppProductController::class, 'index'])->where('id', '([a-z0-9\-]+)?')->name('public.product');
};


// Functions for correct work routes with/without prefix
$routes();
Route::group(
    ['prefix' => '{locale}', 'where' => ['locale' => '([a-z]{2})?']],
    $routes
);


//Route::get('sales', [AppController::class, 'home']);
//
//Route::prefix('{locale}')->group(function (){
//    Route::get('/', [AppController::class, 'home']);
//    Route::get('sales', [AppController::class, 'home']);
//});
