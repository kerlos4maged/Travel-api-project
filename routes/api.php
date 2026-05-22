<?php

use App\Http\Controllers\Api\v1\admin\AdminToursController;
use App\Http\Controllers\api\v1\admin\AdminTravelController;
use \App\Http\Controllers\Api\v1\auth\LoginController;
use App\Http\Controllers\Api\v1\ToursController;
use App\Http\Controllers\Api\v1\TravelController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user()->load('Roles');
})->middleware('auth:sanctum');

Route::prefix('/v1')->group(function () {

    Route::prefix('/admin')->middleware(['auth:sanctum'])->group(function () {
        Route::middleware(['role:admin'])->group(function () {
            Route::post('/travels', [AdminTravelController::class, 'store']);
            Route::post('/travels/{travel:id}/tours', [AdminToursController::class, 'store']);
        });

    });

    Route::middleware(['auth:sanctum', 'role:editor'])->group(function () {
        Route::put('/travels/{travel:id}', [AdminToursController::class, 'update']);
    });

    Route::get('/travels', [TravelController::class, 'index']);
    Route::get('/travels/{travel}/tours', [ToursController::class, 'index']);

    Route::post('/login', LoginController::class);
});
