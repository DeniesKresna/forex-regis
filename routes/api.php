<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\MetaTraderAccount;
Route::get('/metatrader/check', function (Request $request) {
    $data = $request->validate([
        'server_name' => ['required','string','max:255'],
        'account_number' => ['required','string','max:100'],
    ]);
    $account = MetaTraderAccount::where('server_name', $data['server_name'])
        ->where('account_number', $data['account_number'])->first();
    if (!$account) return response()->json(['success'=>false,'active'=>false,'message'=>'MetaTrader account not found'],404);
    $active = $account->expired_date && $account->expired_date->endOfDay()->isFuture();
    return response()->json(['success'=>true,'active'=>$active,'expired_date'=>$account->expired_date?->toDateString()]);
});
