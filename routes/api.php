<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\WalletController;
use App\Http\Controllers\User\TransactionController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;

Route::get('/', function () {
    return [
        'app' => 'Ziga Afrika API',
        'version' => '1.0.0'
    ];
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['prefix' => 'v1'], function () {
    Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
        
        Route::get('/shippings', [ShippingController::class, 'getShippings']);
        Route::get('/users', [AdminDashboardController::class, 'getUsers']);
        Route::get('/user/{userId}', [AdminDashboardController::class, 'getUserData']);
        Route::get('/transactions', [AdminDashboardController::class, 'getTransactions']);
        Route::get('/statistics', [AdminDashboardController::class, 'fetchStatistics']);

        //users endpoint
        Route::group([
            'prefix' => 'user'
        ], function () {
            Route::get('/{userId}/shippings', [ShippingController::class, 'getUserShippings']);
        });
    });
});

//paystack checkout callbacks
Route::get(
    '/wallet-funding/callback', 
    [WalletController::class, 'fundWallet']
);
//paystack subscription webhook
Route::group([
    //'prefix' => 'payout',
    'middleware' => ['paystack.verify']
], function () {
    Route::post("/payment/webhook", [WalletController::class, "paymentWebhook"]);
});