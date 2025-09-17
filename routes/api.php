<?php

use App\Http\Controllers\ArtistController;
use App\Http\Controllers\SongController;
use App\Http\Controllers\UploadController;
use Illuminate\Support\Facades\Route;

Route::apiResources([
    'artists' => ArtistController::class,
    'songs' => SongController::class
]);
Route::apiResource('upload', UploadController::class)
    ->only('store');