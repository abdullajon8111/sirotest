<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\TestController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\TestTakingController;

Route::redirect('/', '/login');

// Authentication Routes
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);

// Admin Routes
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    // Categories
    Route::resource('categories', CategoryController::class, ['as' => 'admin']);
    Route::post('categories/{category}/import', [CategoryController::class, 'import'])->name('admin.categories.import');

    // Questions
    Route::resource('questions', QuestionController::class, ['as' => 'admin']);

    // Tests
    Route::resource('tests', TestController::class, ['as' => 'admin']);

    // Users
    Route::resource('users', UserController::class, ['as' => 'admin']);
});

// User Routes
Route::prefix('user')->middleware(['auth', 'user'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('user.dashboard');

    // Test Taking
    Route::get('test/{test}', [TestTakingController::class, 'show'])->name('user.test.show');
    Route::post('test/{test}/start', [TestTakingController::class, 'start'])->name('user.test.start');
    Route::get('test-result/{testResult}/take', [TestTakingController::class, 'take'])->name('user.test.take');
    Route::post('test-result/{testResult}/answer', [TestTakingController::class, 'saveAnswer'])->name('user.test.answer');
    Route::post('test-result/{testResult}/finish', [TestTakingController::class, 'finish'])->name('user.test.finish');
    Route::get('test-result/{testResult}', [TestTakingController::class, 'result'])->name('user.test.result');
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
});
