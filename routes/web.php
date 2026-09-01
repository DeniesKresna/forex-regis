<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MetaTraderAccountController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ConfigController;
Route::middleware('guest')->group(function () {
  Route::get('/login', [AuthController::class,'showLogin'])->name('login');
  Route::post('/login', [AuthController::class,'login'])->name('login.store');
  Route::get('/login/otp', [AuthController::class,'showOtp'])->name('login.otp');
  Route::post('/login/otp', [AuthController::class,'verifyOtp'])->name('login.otp.verify');
});
Route::post('/logout', [AuthController::class,'logout'])->name('logout');
Route::middleware('auth')->group(function () {
  Route::get('/', fn()=>redirect()->route('dashboard'));
  Route::prefix('dashboard')->group(function () {
    Route::get('/', [DashboardController::class,'index'])->name('dashboard');
    Route::resource('users',UserController::class)->except(['show']);
    Route::resource('metatrader-accounts',MetaTraderAccountController::class)->except(['show']);
    Route::resource('payments',PaymentController::class)->only(['index','create','store']);
    Route::get('/config/payment',[ConfigController::class,'editPayment'])->name('config.payment.edit');
    Route::put('/config/payment',[ConfigController::class,'updatePayment'])->name('config.payment.update');
  });
});
