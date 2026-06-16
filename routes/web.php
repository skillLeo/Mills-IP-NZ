<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ApplicationController;
use App\Http\Controllers\Public\ApplicationFormController;
use App\Http\Controllers\Public\SearchController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [SearchController::class, 'index'])->name('search');
Route::get('/search', [SearchController::class, 'results'])->name('search.results');
Route::get('/search/more', [SearchController::class, 'loadMore'])->name('search.more');

// Application form
Route::prefix('apply')->name('apply.')->group(function () {
    Route::get('/step/1', [ApplicationFormController::class, 'step1'])->name('step1');
    Route::post('/step/1', [ApplicationFormController::class, 'processStep1'])->name('step1.post');
    Route::get('/step/2', [ApplicationFormController::class, 'step2'])->name('step2');
    Route::post('/step/2', [ApplicationFormController::class, 'processStep2'])->name('step2.post');
    Route::get('/step/3', [ApplicationFormController::class, 'step3'])->name('step3');
    Route::post('/step/3', [ApplicationFormController::class, 'processStep3'])->name('step3.post');
    Route::get('/step/4', [ApplicationFormController::class, 'step4'])->name('step4');
    Route::post('/step/4', [ApplicationFormController::class, 'processStep4'])->name('step4.post');
    Route::get('/step/5', [ApplicationFormController::class, 'step5'])->name('step5');
    Route::post('/submit', [ApplicationFormController::class, 'submit'])->name('submit');
    Route::get('/confirm', [ApplicationFormController::class, 'confirm'])->name('confirm');
});

// Admin routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Public admin routes (login/logout)
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Protected admin routes
    Route::middleware(['auth:admin'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/applications', [ApplicationController::class, 'index'])->name('application.index');
        Route::get('/applications/{id}', [ApplicationController::class, 'show'])->name('application.show');
        Route::get('/applications/{id}/logo', [ApplicationController::class, 'serveLogo'])->name('application.logo');
        Route::post('/applications/{id}/status', [ApplicationController::class, 'updateStatus'])->name('application.status');
        Route::post('/applications/{id}/notes', [ApplicationController::class, 'addNote'])->name('application.note');
        Route::delete('/applications/{id}', [ApplicationController::class, 'destroy'])->name('application.destroy');
    });
});
