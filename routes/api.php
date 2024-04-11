<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\WalletController;
use App\Http\Controllers\User\TransactionController;

Route::get('/', function () {
    return [
        'app' => 'Ziga-Afrika API',
        'version' => '1.0.0'
    ];
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['prefix' => 'v1'], function () {
    Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
        Route::get('/user/wallet', [WalletController::class, 'getWallet']);
        Route::get('/user/dashboard-data', [UserController::class, 'getDashboardData']);
        Route::get('/transactions', [TransactionController::class, 'filter']);
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
    Route::post("/card-subscription/webhook", [WalletController::class, "subscriptionWebhook"]);
});