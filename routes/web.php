<?php

use Illuminate\Support\Facades\Route;

Route::get('/', fn() => redirect('/dashboard'));

Route::get('/{route}', function () {
    return view('app');
})->where('route', '.*');
