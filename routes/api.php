<?php

use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\ProductionController;
use App\Http\Controllers\PerformanceController;
use App\Http\Controllers\BasketController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AuthController;




/*
|--------------------------------------------------------------------------
| Public (no auth)
|--------------------------------------------------------------------------
*/

Route::get('/productions', [ProductionController::class, 'index']);
Route::get('/productions/{slug}', [ProductionController::class, 'show']);
Route::get('/productions/{id}/performances', [PerformanceController::class, 'index']);

/*
|--------------------------------------------------------------------------
| Auth (per production)
|--------------------------------------------------------------------------
*/

Route::prefix('auth')->group(function () {

    Route::post('/register', [RegisterController::class, 'register']);

    Route::post('/login', [LoginController::class, 'login'])
        ->middleware('throttle:5,1');

    Route::middleware('auth:sanctum')
        ->post('/logout', [LogoutController::class, 'logout']);
});

/*
|--------------------------------------------------------------------------
| Authenticated user actions
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {

    // User
    Route::get('/user/profile', [ProfileController::class, 'show']);
    Route::put('/user/profile', [ProfileController::class, 'update']);

    // Basket
    Route::post('/basket', [BasketController::class, 'store']);
    Route::get('/basket', [BasketController::class, 'index']);
    Route::put('/basket/{id}', [BasketController::class, 'update']);

    // Bookings
    Route::post('/bookings', [BookingController::class, 'store']);
    Route::get('/bookings', [BookingController::class, 'index']);
    Route::post('/bookings/{booking}/upload-proof', [BookingController::class, 'uploadProof']);
    
});

/*
|--------------------------------------------------------------------------
| Production Admin (auth + production-level)
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Admin\ProductionBookingController;
use App\Http\Controllers\Admin\PerformanceAdminController;
use App\Http\Controllers\Admin\VehicleController;

Route::middleware(['auth:sanctum', 'production.admin'])->group(function () {

    // Calendar
    Route::get(
        '/productions/{production}/calendar',
        [ProductionController::class, 'calendar']
    );

    // Production bookings (admin)
    Route::get(
        '/productions/{production}/bookings',
        [ProductionBookingController::class, 'index']
    );

    // Booking admin actions
    Route::put(
        '/bookings/{booking}/confirm',
        [ProductionBookingController::class, 'confirm']
    );

    Route::put(
        '/bookings/{booking}/edit',
        [ProductionBookingController::class, 'update']
    );

    // Performances
    Route::post(
        '/productions/{production}/performances',
        [PerformanceAdminController::class, 'store']
    );

    Route::put('/performances/{performance}', [PerformanceAdminController::class, 'update']);
    Route::delete('/performances/{performance}', [PerformanceAdminController::class, 'destroy']);

    // Vehicles
    Route::post(
        '/productions/{production}/vehicles',
        [VehicleController::class, 'store']
    );

    Route::post(
        '/productions/{production}/vehicles/{vehicle}/location',
        [VehicleController::class, 'location']
    );
});

Route::middleware(['auth:sanctum'])
    ->post('/subscriptions/{production}/upload-proof',
        [SubscriptionController::class, 'uploadProof']);


/*
|--------------------------------------------------------------------------
| Super Admin (server admin)
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Admin\AdminProductionController;
use App\Http\Controllers\Admin\AdminBookingController;

Route::middleware(['auth:sanctum', 'super.admin'])
    ->prefix('admin')
    ->group(function () {

        // Productions
        Route::get('/productions', [AdminProductionController::class, 'index']);
        Route::post('/productions', [AdminProductionController::class, 'store']);

        // ✅ Suspend production
        Route::patch(
            '/productions/{production}/suspend',
            [AdminProductionController::class, 'suspend']
        );

        // Bookings
        Route::get('/bookings', [AdminBookingController::class, 'index']);
    });

/*
|--------------------------------------------------------------------------
| Subscriptions
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->post(
    '/subscriptions/{subscription}/approve',
    [SubscriptionController::class, 'approve']
);


Route::post('/payments/mpesa-callback', [PaymentController::class, 'callback'])
    ->middleware('throttle:10,1');
