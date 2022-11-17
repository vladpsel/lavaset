<?php

use App\Http\Controllers\Application\AppController;
use Illuminate\Support\Facades\Route;

Route::get('{locale}', [AppController::class, 'home'])->where('locale', '([a-z]{2})?');

//Route::get('sales', [AppController::class, 'home']);
//
//Route::prefix('{locale}')->group(function (){
//    Route::get('/', [AppController::class, 'home']);
//    Route::get('sales', [AppController::class, 'home']);
//});
