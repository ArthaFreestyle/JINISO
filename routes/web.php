<?php

use App\Http\Controllers\FrontController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Models\Category;
use App\Models\Products;

Route::get('/', [FrontController::class, 'index'])->name('front.index');

Route::get('/browse/{category:slug}', [FrontController::class, 'category'])->name('front.category');

Route::get('/details/{product:slug}', [FrontController::class, 'details'])->name('front.details');

Route::get('/search', [FrontController::class, 'search'])->name('front.search');

Route::group(['middleware' => 'auth'], function () {
    Route::get('profile', [AuthController::class, 'showProfile'])->name('profile')->middleware('auth');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/check-booking', [OrderController::class, 'checkBooking'])->name('front.check_booking');
    Route::get('/check-booking/{orderDetails:order_detail_id}', [OrderController::class, 'checkBookingDetails'])->name('front.check_booking_details');

    Route::post('/order/begin/{product:slug}', [OrderController::class, 'saveOrder'])->name('front.save_order');

    Route::get('/order/bookings', [OrderController::class, 'booking'])->name('front.booking');

    Route::get('/order/booking/customer-data', [OrderController::class, 'customerData'])->name('front.customer_data');
    Route::post('/order/booking/customer-data/save', [OrderController::class, 'saveCustomerData'])->name('front.save_customer_data');

    Route::get('/order/payment', [OrderController::class, 'payment'])->name('front.payment');
    Route::get('/order/payment/confirm', [OrderController::class, 'paymentConfirm'])->name('front.payment_confirm');

    Route::get('/order/finished/{orders:order_id}', [OrderController::class, 'orderFinished'])->name('front.order_finished');
});



Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('register', [AuthController::class, 'register']);


