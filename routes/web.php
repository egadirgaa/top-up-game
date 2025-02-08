<?php

use App\Http\Middleware\IsAdmin;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TopUpController;
use App\Http\Controllers\MidtransController;
use App\Http\Controllers\API\PaymentController;
use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\Customer\CustomerTopUpController;

// Route::get('/', function () {
//     return view('welcome', ['title' => 'Welcome']);
// })->name('welcome');



// Middleware 'guest' untuk mencegah user yang sudah login mengakses halaman login & register
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('showRegister');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::get('/login', [AuthController::class, 'showLogin'])->name('showLogin');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});

// Middleware 'auth' untuk memastikan hanya user yang sudah login bisa logout
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Admin
Route::prefix('admin')->middleware(IsAdmin::class)->name('admin.')->group(function () {
    Route::get('dashboard', [DashboardAdminController::class, 'index'])->name('dashboard');
});


// ROUTE CHECKOUT MIDTRANS
Route::get('/', [MidtransController::class, 'checkout'])->name('checkout');

// API untuk mendapatkan token baru dari Midtrans
Route::post('/midtrans/token', [MidtransController::class, 'getToken'])->name('midtrans.token');

// API untuk mengambil token lama jika transaksi belum selesai
Route::get('/midtrans/token/{transaction_id}', [MidtransController::class, 'getExistingToken'])
    ->where('transaction_id', '[A-Za-z0-9\-]+') // Mencegah input aneh
    ->name('midtrans.token.existing');

    Route::get('/topup', [TopUpController::class, 'index'])->name('topup.index');
    Route::post('/topup/checkout', [TopUpController::class, 'checkout'])->name('topup.checkout');