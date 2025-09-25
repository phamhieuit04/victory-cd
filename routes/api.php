<?php

use App\Http\Controllers\ArtistController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SongController;
use App\Http\Controllers\UploadController;
use Illuminate\Support\Facades\Route;

Route::apiResources([
    'artists' => ArtistController::class,
    'songs' => SongController::class
]);
Route::apiResource('bills', BillController::class)
    ->only(['index', 'update']);
Route::apiResource('upload', UploadController::class)
    ->only('store');
Route::apiResource('payment', PaymentController::class)
    ->only('store', 'show');