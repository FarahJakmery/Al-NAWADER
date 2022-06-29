<?php

use App\Http\Controllers\Api\AdvertisementController;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ReplyController;
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

Route::middleware(['jwt.verify'])->group(function () {
    // Advertisements Routes
    Route::post('add_advertisement', [AdvertisementController::class, 'storeAdvertisement']);
    Route::post('update_advertisement/{id}', [AdvertisementController::class, 'updateAdvertisement']);
    Route::delete('remove_advertisement/{id}', [AdvertisementController::class, 'removeAdvertisements']);
    Route::get('my_advertisements', [AdvertisementController::class, 'myAdvertisement']);

    // Replies Routes
    Route::post('add_reply', [ReplyController::class, 'addReply']);
    Route::post('update_reply/{id}', [ReplyController::class, 'updateReply']);
    Route::delete('remove_reply/{id}', [ReplyController::class, 'removeReply']);
});
