<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\WalletController;
use App\Http\Controllers\User\TransactionController;

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
        Route::post("/change-password", [UserController::class, "changePassword"]);
        
        Route::get('/shippings', [ShippingController::class, 'getShippings']);
        Route::get('/transactions', [TransactionController::class, 'getTransactions']);

        //users endpoint
        Route::group([
            'prefix' => 'user'
        ], function () {
            Route::get('/', [UserController::class, 'getUser']);
            Route::post('/', [UserController::class, 'updateProfile']);
            Route::get('/{userId}/transactions', [TransactionController::class, 'getUserTransactions']);
            Route::get('/{userId}/shippings', [ShippingController::class, 'getUserShippings']);
            Route::get('/{userId}/wallet', [WalletController::class, 'getWallet']);

            //Route::post('/{userId}/send-push-notifications', [UserController::class, 'sendPushNotifications']);
            //Route::post('/{userId}/send-ios-notifications', [UserController::class, 'sendIosPushNotifications']);
            Route::get('/notifications', [UserController::class, 'fetchNotifications']);
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
    Route::post("/card-subscription/webhook", [WalletController::class, "subscriptionWebhook"]);
});