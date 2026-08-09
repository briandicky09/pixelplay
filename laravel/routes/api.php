<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\GameController;
use App\Http\Controllers\Api\PlatformController;
use Illuminate\Support\Facades\Route;

Route::middleware('throttle:api')->group(function () {
    Route::get('/games', [GameController::class, 'index']);
    Route::get('/games/{game}', [GameController::class, 'show']);
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/platforms', [PlatformController::class, 'index']);
});
