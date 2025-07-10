<?php

use App\Http\Controllers\AdminVerificationController;
use App\Http\Controllers\CardGenerationController;
use App\Http\Controllers\MemberActivationController;
use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Auth::routes();

// Registration Routes
Route::group(['prefix' => 'registration', 'as' => 'registration.'], function () {
    Route::get('/step-1', [RegistrationController::class, 'showStep1'])->name('step1');
    Route::post('/step-1', [RegistrationController::class, 'processStep1']);
    
    Route::middleware(['auth'])->group(function () {
        Route::get('/step-2', [RegistrationController::class, 'showStep2'])->name('step2');
        Route::post('/step-2', [RegistrationController::class, 'processStep2']);
        
        Route::get('/step-3', [RegistrationController::class, 'showStep3'])->name('step3');
        Route::post('/step-3', [RegistrationController::class, 'processStep3']);
        
        Route::get('/complete', [RegistrationController::class, 'complete'])->name('complete');
    });
});

// Member Routes
Route::middleware(['auth'])->prefix('member')->name('member.')->group(function () {
    // Member Dashboard (New landing page)
    Route::get('/dashboard', [App\Http\Controllers\MemberDashboardController::class, 'index'])->name('dashboard');
    
    // Member Profile (Moved to sidebar)
    Route::get('/profile', [App\Http\Controllers\MemberProfileController::class, 'index'])->name('profile');
    Route::post('/profile/update-photo', [App\Http\Controllers\MemberProfileController::class, 'updatePhoto'])->name('profile.update-photo');
    Route::post('/profile/update-ktp', [App\Http\Controllers\MemberProfileController::class, 'updateKtp'])->name('profile.update-ktp');
    
    // Member Card
    Route::get('/card', [App\Http\Controllers\MemberProfileController::class, 'showCard'])->name('card');
    Route::get('/card/generate', [App\Http\Controllers\MemberProfileController::class, 'generateCard'])->name('card.generate');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Admin Dashboard
    Route::get('/dashboard', [App\Http\Controllers\AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Members Management Routes
    Route::resource('members', App\Http\Controllers\AdminMemberController::class);
    Route::get('members/export', [App\Http\Controllers\AdminMemberController::class, 'export'])->name('members.export');
    Route::post('members/{id}/activate', [MemberActivationController::class, 'directActivate'])->name('members.activate');
    
    // Divisions Management Routes
    Route::resource('divisions', App\Http\Controllers\AdminDivisionController::class);
    
    // Positions Management Routes
    Route::resource('positions', App\Http\Controllers\AdminPositionController::class);
    
    // Users Management Routes
    Route::resource('users', App\Http\Controllers\AdminUserController::class);
    
    // Activity Categories Management Routes
    Route::resource('activity-categories', App\Http\Controllers\ActivityCategoryController::class);
    
    // Admin Settings
    Route::get('settings', [App\Http\Controllers\AdminSettingsController::class, 'index'])->name('settings');
    Route::post('settings', [App\Http\Controllers\AdminSettingsController::class, 'update'])->name('settings.update');
    
    // Verification Routes
    Route::group(['prefix' => 'verifications', 'as' => 'verifications.'], function () {
        Route::get('/', [AdminVerificationController::class, 'index'])->name('index');
        Route::get('/verified', [AdminVerificationController::class, 'verified'])->name('verified');
        Route::get('/rejected', [AdminVerificationController::class, 'rejected'])->name('rejected');
        Route::get('/{id}', [AdminVerificationController::class, 'show'])->name('show');
        Route::post('/{id}/verify', [AdminVerificationController::class, 'verify'])->name('verify');
        Route::post('/{id}/reject', [AdminVerificationController::class, 'reject'])->name('reject');
    });
    
    // Activation Routes
    Route::group(['prefix' => 'activations', 'as' => 'activations.'], function () {
        Route::get('/', [MemberActivationController::class, 'index'])->name('index');
        Route::get('/active', [MemberActivationController::class, 'active'])->name('active');
        Route::get('/{id}', [MemberActivationController::class, 'show'])->name('show');
        Route::post('/{id}/activate', [MemberActivationController::class, 'activate'])->name('activate');
    });
    
    // Card Generation Routes
    Route::group(['prefix' => 'cards', 'as' => 'cards.'], function () {
        Route::get('/', [CardGenerationController::class, 'index'])->name('index');
        Route::get('/{id}/generate', [CardGenerationController::class, 'generate'])->name('generate');
        Route::post('/{id}/save', [CardGenerationController::class, 'save'])->name('save');
        Route::get('/{id}/download', [CardGenerationController::class, 'download'])->name('download');
        Route::get('/{id}/pdf', [CardGenerationController::class, 'download'])->name('pdf');
    });
});

// Activity Routes (accessible to all authenticated users)
Route::middleware(['auth'])->group(function () {
    // Admin Activity resource routes (only admin can create/edit/delete)
    Route::resource('activities', App\Http\Controllers\ActivityController::class);
    
    // Member Activity routes (readonly access for members)
    Route::prefix('member')->name('member.')->group(function () {
        Route::get('/activities', [App\Http\Controllers\Member\MemberActivityController::class, 'index'])->name('activities.index');
        Route::get('/activities/{activity}', [App\Http\Controllers\Member\MemberActivityController::class, 'show'])->name('activities.show');
    });
    
    // Activity like routes
    Route::post('/activities/{activity}/like', [App\Http\Controllers\LikeController::class, 'toggleLike'])->name('activities.like');
    
    // Comment routes
    Route::post('/activities/{activity}/comments', [App\Http\Controllers\CommentController::class, 'store'])->name('comments.store');
    Route::put('/comments/{comment}', [App\Http\Controllers\CommentController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{comment}', [App\Http\Controllers\CommentController::class, 'destroy'])->name('comments.destroy');
    Route::post('/comments/{comment}/like', [App\Http\Controllers\CommentController::class, 'like'])->name('comments.like');
    Route::post('/comments/{comment}/toggle-visibility', [App\Http\Controllers\CommentController::class, 'toggleVisibility'])->name('comments.toggle-visibility');
    
    // Comment reply routes
    Route::post('/comments/{comment}/replies', [App\Http\Controllers\CommentReplyController::class, 'store'])->name('replies.store');
    Route::put('/replies/{reply}', [App\Http\Controllers\CommentReplyController::class, 'update'])->name('replies.update');
    Route::delete('/replies/{reply}', [App\Http\Controllers\CommentReplyController::class, 'destroy'])->name('replies.destroy');
    Route::post('/replies/{reply}/like', [App\Http\Controllers\CommentReplyController::class, 'like'])->name('replies.like');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
