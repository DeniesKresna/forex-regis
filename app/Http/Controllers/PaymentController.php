<?php

namespace App\Http\Controllers;

use App\Models\MetaTraderAccount;
use App\Models\Payment;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        return view('payments.index', [
            'payments' => Payment::with('metatraderAccount.user')->latest()->paginate(20),
        ]);
    }

    public function create()
    {
        return view('payments.create', [
            'accounts' => MetaTraderAccount::with('user')->orderBy('account_number')->get(),
        ]);
    }

    public function store(Request $request, PaymentService $service)
    {
        $data = $request->validate([
            'metatrader_account_id' => 'required|exists:metatrader_accounts,id',
            'amount' => 'required|numeric|min:1',
            'update_trading_account_expired' => 'nullable|boolean',
        ]);

        $updateExpired = $request->boolean('update_trading_account_expired', true);

        $service->create(
            MetaTraderAccount::findOrFail($data['metatrader_account_id']),
            $data['amount'],
            $updateExpired,
        );

        return redirect()->route('payments.index')->with(
            'success',
            $updateExpired ? 'Payment recorded and expiry extended.' : 'Payment recorded without extending expiry.',
        );
    }
}
