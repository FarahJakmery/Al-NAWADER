<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SectionController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('Admin.Auth.login');
});


// ============================ Admin Routes ============================
Route::prefix('admin')->name('admin.')->group(function () {

    Route::middleware(['guest:admin', 'PreventBackHistory'])->group(function () {
        Route::view('/login', 'Admin.Auth.login')->name('login');
        Route::post('/check', [AdminController::class, 'check'])->name('check');
    });

    Route::middleware(['auth:admin', 'PreventBackHistory'])->group(function () {
        // Authentication Routes
        Route::view('/home', 'Admin.Auth.dashboard')->name('home');
        Route::post('/logout', [AdminController::class, 'logout'])->name('logout');
        // Section Route
        Route::resource('sections', SectionController::class);
        // Category Route
        Route::resource('categories', CategoryController::class);
    });
});
