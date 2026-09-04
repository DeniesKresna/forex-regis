<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MetaTraderAccountController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ConfigController;

Route::get('/', function () {
  $brokerConfig = DB::table('metatrader_configs')->where('name', 'referal_broker_url')->first()
    ?? DB::table('metatrader_configs')->where('name', 'broker_referal_url')->first();
  $brokerReferalUrl = $brokerConfig ? (json_decode($brokerConfig->value, true) ?: '') : '';
  $indicatorDownloadConfig = DB::table('metatrader_configs')->where('name', 'indicator_download_url')->first();
  $indicatorDownloadUrl = $indicatorDownloadConfig ? (json_decode($indicatorDownloadConfig->value, true) ?: '') : route('indicators.download');

  return view('landing', [
    'brokerReferalUrl' => $brokerReferalUrl,
    'indicatorDownloadUrl' => $indicatorDownloadUrl,
  ]);
});

Route::get('/indicators/download', function () {
  $path = public_path('indicators.zip');

  abort_unless(file_exists($path), 404);

  return Response::download($path, 'indicators.zip');
})->name('indicators.download');

Route::middleware('guest')->group(function () {
  Route::get('/login', [AuthController::class,'showLogin'])->name('login');
  Route::post('/login', [AuthController::class,'login'])->name('login.store');
  Route::get('/login/otp', [AuthController::class,'showOtp'])->name('login.otp');
  Route::post('/login/otp', [AuthController::class,'verifyOtp'])->name('login.otp.verify');
});
Route::get('/lotcalculator', function (Request $request) {
  $key = 'calcu_' . md5($request->ip() . '|' . ($request->userAgent() ?? ''));
  $storedSetup = json_decode(Redis::get($key) ?: 'null', true) ?: [];
  $quoteToUsdConfigRow = DB::table('metatrader_configs')->where('name', 'forex_quote_to_usd')->first();
  $quoteToUsdConfig = $quoteToUsdConfigRow ? (json_decode($quoteToUsdConfigRow->value, true) ?: []) : [];

  return view('lotcalculator', [
    'lotCalculatorSetup' => $storedSetup,
    'quoteToUsdConfig' => $quoteToUsdConfig,
  ]);
})->name('lotcalculator');

Route::post('/lotcalculator/save', function (Request $request) {
  $key = 'calcu_' . md5($request->ip() . '|' . ($request->userAgent() ?? ''));
  $payload = [
    'symbol' => strtoupper(str_replace('/', '', (string) $request->input('symbol', 'XAUUSD'))),
    'balance' => (string) $request->input('balance', ''),
    'risk' => (string) $request->input('risk', ''),
    'entry' => (string) $request->input('entry', ''),
    'stop' => (string) $request->input('stop', ''),
    'tp' => (string) $request->input('tp', ''),
    'space' => (string) $request->input('space', ''),
    'spread' => (string) $request->input('spread', ''),
    'quote_to_usd' => (string) $request->input('quote_to_usd', ''),
  ];

  Redis::setex($key, 3600, json_encode($payload));

  return response()->noContent();
})->name('lotcalculator.save');

Route::middleware(['auth', 'admin'])->group(function () {
  Route::put('/dashboard/config/forex-quote-to-usd', [ConfigController::class, 'updateForexQuoteToUsd'])->name('config.forex-quote-to-usd.update');
});

Route::post('/logout', [AuthController::class,'logout'])->name('logout');
Route::middleware(['auth', 'admin'])->group(function () {
  Route::prefix('dashboard')->group(function () {
    Route::get('/', [DashboardController::class,'index'])->name('dashboard');
    Route::resource('users',UserController::class)->except(['show']);
    Route::resource('metatrader-accounts',MetaTraderAccountController::class)->except(['show']);
    Route::resource('payments',PaymentController::class)->only(['index','create','store']);
    Route::get('/config',[ConfigController::class,'editPayment'])->name('config.payment.edit');
    Route::put('/config/payment',[ConfigController::class,'updatePayment'])->name('config.payment.update');
    Route::put('/config/broker',[ConfigController::class,'updateBrokerReferalUrl'])->name('config.broker.update');
    Route::put('/config/indicator',[ConfigController::class,'updateIndicatorDownloadUrl'])->name('config.indicator.update');
  });
});
