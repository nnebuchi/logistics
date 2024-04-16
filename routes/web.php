<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\WalletController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;

Route::group(['middleware' => ['guest']], function () {
    Route::get('/reset-password/{email}/{token}', [AuthController::class, 'showPasswordResetForm'])->name('password.reset');
    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name("login");
    Route::get('/register', [AuthController::class, 'showSignupForm'])->name("signup");
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.email');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

Route::get('/email/verify', function () {
    return view('customer.auth.verify-email');
})->middleware('auth')->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
 
    return redirect('/email-verification-success');
})->middleware(['auth', 'signed'])->name('verification.verify');
Route::get('/email-verification-success', function() {
    return view('customer.auth.email-verification-success');
});
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
 
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');
Route::get('/password-change-success', function() {
    return view('customer.auth.password-change-success');
});
Route::get('/test', [AuthController::class, 'test']);
Route::group([
    'middleware' => ['auth', 'verified']
], function () {
    Route::get('/logout', [AuthController::class, 'logOut']);

    Route::get('/', [UserController::class, 'index']);
    Route::get('/shipments', [UserController::class, 'showShipments']);
    Route::get('/wallet', [WalletController::class, 'index']);
    Route::get('/profile', [UserController::class, 'showProfile']);
    Route::post('/wallet/create-transaction', [WalletController::class, 'createTransaction']);
});

Route::group([
    'middleware' => ['ziga.admin.guest']
], function () {
    Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name("admin.login");
    Route::post('/admin/login', [AdminAuthController::class, 'login']);
});

Route::group([
    'middleware' => ['ziga.admin.auth', 'verified', 'ziga.admin']
], function () {
    //Route::get('/logout', [AdminAuthController::class, 'logOut']);

    Route::get('/admin', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
});

