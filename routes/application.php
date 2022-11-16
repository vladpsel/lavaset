<?php

use Illuminate\Support\Facades\Route;

Route::prefix('{locale}')->group(function (){
    Route::get('/', function () {
        echo 'qw';
    });

    Route::get('{slug}', function () {
        dump(app()->getLocale());
        echo 'qw';
    })->where('slug', '[a-z/]+');
});
