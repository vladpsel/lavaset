<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    dump(app()->getLocale());
    echo 'qw';
});

Route::prefix('{locale}')->group(function (){

    Route::get('/', function () {
        dump(app()->getLocale());
        echo 'qw';
    });

    Route::get('{slug}', function () {
        dump(app()->getLocale());
        echo 'qw';
    })->where('slug', '[a-z/]+');
});
