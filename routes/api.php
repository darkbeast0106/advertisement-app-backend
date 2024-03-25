<?php

use App\Http\Controllers\API\AdvertisementController;
use App\Http\Controllers\API\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::post('/logout-everywhere', [AuthController::class, 'logoutEverywhere'])->middleware('auth:sanctum');

Route::get("/advertisement/all", [AdvertisementController::class, 'all']);
Route::get("/advertisement/all/{id}", [AdvertisementController::class, 'showWithUser']);
Route::patch("/advertisement/remove-image/{id}", [AdvertisementController::class, "removeImage"])
    ->middleware("auth:sanctum");
Route::apiResource("/advertisement", AdvertisementController::class)->middleware("auth:sanctum");
