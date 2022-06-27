<?php

use App\Http\Controllers\Api\AdvertisementController;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
    Route::put('/user-update-profile', [AuthController::class, 'update']);
});

// All Advertisements Route
Route::get('advertisements', [AdvertisementController::class, 'allAdvertisements']);
// Show a Specific Advertisement by Id Route
Route::get('show_advertisement/{id}', [AdvertisementController::class, 'showAdvertisement']);
// Add  Advertisement Route
Route::post('add_advertisement', [AdvertisementController::class, 'storeAdvertisement']);
// Update Advertisement Route
Route::put('update_advertisement/{id}', [AdvertisementController::class, 'updateAdvertisement']);
// Delete Advertisement Route
Route::delete('remove_advertisement/{id}', [AdvertisementController::class, 'removeAdvertisements']);
// My Advertisement Route
Route::get('my_advertisements', [AdvertisementController::class, 'myAdvertisement']);

Route::middleware(['jwt.verify'])->group(function () {
});
