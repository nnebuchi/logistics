<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\ShippingController;
use App\Http\Controllers\User\WalletController;
use App\Http\Controllers\User\TransactionController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ImpersonateController;


Route::get('/', function(){
    return redirect()->route('dashboard');
})->name('home');

Route::group(['middleware' => ['guest']], function () {
    Route::get('/reset-password/{email}/{token}', [AuthController::class, 'showPasswordResetForm'])->name('password.reset');
    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::get('/forgot-password-success', [AuthController::class, 'forgotPasswordResponse'])->name('password.request.success');
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name("login");
    Route::get('/register', [AuthController::class, 'showSignupForm'])->name("signup");

    Route::post('/login', [AuthController::class, 'login'])->name('user-signin');
    Route::post('/register', [AuthController::class, 'register'])->name('user-signup');
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot-password');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});


Route::get('/email-verification-success', function() {
    return view('customer.auth.email-verification-success');
});

Route::get('/password-change-success', function() {
    return view('customer.auth.password-change-success');
});

Route::get('/test', [AuthController::class, 'test']);

Route::group([
    'middleware' => ['auth']
], function () {
    Route::get('/email/verify', function () {
        return view('customer.auth.verify-email');
    })->name('verification.notice');
    
    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
     
        return redirect('/email-verification-success');
    })->middleware(['signed'])->name('verification.verify');
    
    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', 'Verification link sent!');
    })->middleware(['throttle:6,1'])->name('verification.send');

    Route::group([
        'middleware' => ['verified']
    ], function () {
        Route::get('/dashboard', [UserController::class, 'index'])->name('dashboard');
        Route::group([
            'prefix'=>'shipping', 'middleware'=>'kyc'
        ], function () {
            
            Route::get('/track', [ShippingController::class, 'showTrackingForm'])->name('track-shipments');
            Route::get('/create', [ShippingController::class, 'newShipment'])->name('create-shipment');
            Route::post('/create', [ShippingController::class, 'createShipment'])->name('add-shipment');
            Route::get('/{id}/details', [ShippingController::class, 'getShipment'])->name('get-shipment');
            Route::post('/save-parcel', [ShippingController::class, 'saveParcel'])->name('shipment.save-parcel');
            Route::get('/delete-parcel', [ShippingController::class, 'deleteParcel'])->name('shipment.delete-parcel');
            Route::post('/save-address', [ShippingController::class, 'saveAddress'])->name('shipment.save-address');
            Route::get('/{id}/carriers', [ShippingController::class, 'getCarriers'])->name('shipment.create');
            Route::post('/add-item', [ShippingController::class, 'saveItem'])->name('item.create');
            Route::get('/delete-item', [ShippingController::class, 'deleteItem'])->name('item.delete');
            Route::get('/delete-attachment', [ShippingController::class, 'deleteAttachment'])->name('attachment.delete');
            Route::get('/{slug}/delete', [ShippingController::class, 'deleteShipment'])->name('shipment.delete');
            
            Route::get('/{shipmentId}/track', [ShippingController::class, 'trackShipment']);
            Route::post('/make-payment', [ShippingController::class, 'makePayment'])->name('shipment.pay');
            // Route::get('/{shipmentId}', [ShippingController::class, 'editShipping'])->name('edit-shipping');
            Route::get('/list', [ShippingController::class, 'showShippings'])->name('shippings');
            Route::post('/upload-docs', [ShippingController::class, 'uploadParcelDocument'])->name('upload-parcel-docs');
            
            Route::get('/{slug}', [ShippingController::class, 'showShippingForm'])->name('edit-shipment');
        });
        
        Route::post('/address', [ShippingController::class, 'createAddress']);
    
        Route::get('/wallet', [WalletController::class, 'index']);
        Route::get('/profile', [UserController::class, 'showProfile'])->name('profile');
        Route::get('/logout', [AuthController::class, 'logOut']);
    
        Route::get('/cities/{stateId}', [ShippingController::class, 'getCities']);
        Route::get('/states/{countryId}', [ShippingController::class, 'getStates']);
    
        Route::get('/categories', [ShippingController::class, 'getCategories']);
        Route::get('/hs_codes', [ShippingController::class, 'getHsCodes']);
    
        Route::post("/change-password", [UserController::class, "changePassword"]);
        //users endpoint
        Route::group([
            'prefix' => 'user'
        ], function () {
            Route::get('/', [UserController::class, 'getUser']);
            Route::post('/', [UserController::class, 'updateProfile']);
            Route::get('/{userId}/wallet', [WalletController::class, 'getWallet']);
            Route::get('/{userId}/shipments', [ShippingController::class, 'getUserShipments']);
            Route::get('/{userId}/transactions', [TransactionController::class, 'getUserTransactions']);
            Route::post('/{userId}/transaction', [WalletController::class, 'createTransaction']);
            Route::get('/{userId}/notifications', [UserController::class, 'fetchNotifications']);
             //Route::post('/{userId}/send-push-notifications', [UserController::class, 'sendPushNotifications']);
        });
    
        Route::get('impersonate/leave', [ImpersonateController::class, 'leave'])->name('impersonate.leave');
    });

});

Route::group([
    //'middleware' => ['ziga.admin.guest'],
    'middleware' => 'guest:admin'
], function () {
    Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name("admin.login");
    Route::get('/admin/reset-password/{email}/{token}', [AdminAuthController::class, 'showPasswordResetForm']);
    Route::get('/admin/forgot-password', [AdminAuthController::class, 'showForgotPasswordForm']);
});
Route::post('/admin/login', [AdminAuthController::class, 'login']);
Route::post('/admin/forgot-password', [AdminAuthController::class, 'forgotPassword']);
Route::post('/admin/reset-password', [AdminAuthController::class, 'resetPassword']);

Route::group([
    'middleware' => [
        'ziga.admin.auth:admin', 
        'verified'
    ]
], function () {
    Route::get('/admin/logout', [AdminAuthController::class, 'logOut']);

    Route::get('/admin', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    Route::get('/admin/users', [AdminDashboardController::class, 'showUsers'])->name('admin.users');
    Route::get('/admin/users/{uuid}', [AdminDashboardController::class, 'showUser'])->name('admin.user');
    Route::get('/admin/users/{uuid}/verify-kyc', [AdminController::class, 'verifyCustomerAccount']);

    Route::get('/admin/shippings', [AdminDashboardController::class, 'showShippings'])->name('admin.shippings');
    Route::get('/admin/transactions', [AdminDashboardController::class, 'showTransactions'])->name('admin.transactions');
    Route::get('admin/get-all-transactions', [AdminDashboardController::class, 'getTransactions']);

    Route::get('/admin/accounts', [AdminDashboardController::class, 'showAccounts']);
    Route::get('/admin/get-all-shippings', [AdminDashboardController::class, 'getAllShipment']);

    Route::get('/admin/get-all-customers', [AdminDashboardController::class, 'getAllCustomers']);
    Route::get('/admin/customer/{userId}', [AdminDashboardController::class, 'getUserData']);
    Route::delete('/admin/customer/{userId}', [AdminDashboardController::class, 'deleteCustomer']);

    Route::post('/account', [AdminDashboardController::class, 'createAccount'])->name("account.create");
    Route::post('/account/{accountId}', [AdminDashboardController::class, 'updateAccount']);

    Route::get('/admin/admins', [AdminDashboardController::class, 'showAdmins']);
    Route::get('/admin/{userId}', [AdminDashboardController::class, 'getAdminData']);
    Route::post('/admin', [AdminController::class, 'createAdmin'])->name("subadmin.create");
    Route::post('/admin/{adminId}', [AdminController::class, 'updateAdmin']);

    Route::get('/get-chart-data', [AdminDashboardController::class, 'getChartData']);

    Route::get('impersonate/{user_id}', [ImpersonateController::class, 'impersonate'])->name('impersonate');

    Route::get('/admin/shipping/{shipmentId}/track', [ShippingController::class, 'trackShipment']);

    Route::post('/admin/customer/vitual-account/{userId}', [AdminController::class, 'updateUserVirtualAccount'])->name("virtual-account.save");

    Route::post('/admin/customer/send-notification', [AdminController::class, 'broadcastToCustomer'])->name("broadcast.send");
});