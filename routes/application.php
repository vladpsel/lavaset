<?php

use App\Http\Controllers\Application\AppCartController;
use App\Http\Controllers\Application\AppCategoryController;
use App\Http\Controllers\Application\AppController;
use App\Http\Controllers\Application\AppPageController;
use App\Http\Controllers\Application\AppPostController;
use App\Http\Controllers\Application\AppProductController;
use Illuminate\Support\Facades\Route;

//$locales = config('app.available_locales');
$locales = implode('|', config('app.available_locales'));

$routes = function () {
    Route::get('/', [AppController::class, 'home']);
    Route::get('category/{id}', [AppCategoryController::class, 'index'])->where('id', '([a-z0-9\-]+)?');
    Route::get('product/{id}', [AppProductController::class, 'index'])->where('id', '([a-z0-9\-]+)?')->name('public.product');
    Route::match(['get', 'post'], 'cart', [AppCartController::class, 'checkout'])->name('public.cart');
    Route::match(['get', 'post'], 'cart/success', [AppCartController::class, 'success'])->name('public.cart.success');
    Route::get('news', [AppPostController::class, 'posts'])->name('public.posts');
    Route::get('news/{id}', [AppPostController::class, 'single'])->where('id', '([a-z0-9\-]+)?');
    //
    Route::get('delivery', [AppPageController::class, 'delivery']);
    Route::get('sales', [AppPageController::class, 'sales']);
    Route::get('for-clients', [AppPageController::class, 'oferta']);
};

//API
Route::prefix('api/v1')->group(function(){
    Route::post('cart/add', [AppCartController::class, 'add']);
    Route::post('cart/set', [AppCartController::class, 'set']);
});

// Functions for correct work routes with/without prefix
$routes();
Route::group(
//    ['prefix' => '{locale}', 'where' => ['locale' => '([a-z]{2})?']],
    ['prefix' => '{locale}', 'where' => ['locale' => '(' . $locales .')?']],
    $routes
);
