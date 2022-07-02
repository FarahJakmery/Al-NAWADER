<?php

use App\Http\Controllers\Api\AdvertisementController;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CommissionController;
use App\Http\Controllers\Api\PageController;
use App\Http\Controllers\Api\ReplyController;
use App\Http\Controllers\Api\SectionController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
    Route::put('/user-update-profile', [AuthController::class, 'update']);
});

// Sections Routes
Route::get('all_sections', [SectionController::class, 'allSections']);
Route::get('show_section/{id}', [SectionController::class, 'showSection']);

// Categories Routes
Route::get('all_categories', [CategoryController::class, 'allCategories']);
Route::get('show_category/{id}', [CategoryController::class, 'showCategory']);

// Advertisements Routes
Route::get('advertisements', [AdvertisementController::class, 'allAdvertisements']);
Route::get('show_advertisement/{id}', [AdvertisementController::class, 'showAdvertisement']);

//Pages Routes
Route::get('privacy_policy_page', [PageController::class, 'privacyPolicyPage']);
Route::get('share_application_page', [PageController::class, 'shareApplicationPage']);
Route::get('social_media', [PageController::class, 'contactUsPage']);
Route::post('sent_message_to_email', [PageController::class, 'sent_message_to_email']);

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

    // Commission Routes
    Route::post('send_commission_request', [CommissionController::class, 'commissionRequest']);
    Route::get('all_commission_request/{id}', [CommissionController::class, 'allCommissionRequest']);
});
