@extends('layouts.app', ['title' => 'Add Payment']) @section('content')
    <form method="POST" action="{{ route('payments.store', [], false) }}" class="bg-white border rounded-xl p-6 max-w-xl">@csrf<div
            class="space-y-4">
            <div><label>MetaTrader Account</label><select name="metatrader_account_id"
                    class="w-full border rounded-lg px-3 py-2">@foreach($accounts as $a)
                        <option value="{{ $a->id }}">{{ $a->user->name }} — {{ $a->server_name }} / {{ $a->account_number }} —
                    expires {{ $a->expired_date?->format('Y-m-d') ?? 'never' }}</option>@endforeach
                </select></div>
            <div><label>Amount (IDR)</label><input name="amount" type="number" step="1" min="1"
                    class="w-full border rounded-lg px-3 py-2" placeholder="50000"></div><label
                class="flex items-start gap-3 rounded-lg border border-slate-200 bg-slate-50 p-3 text-sm text-slate-700"><input
                    name="update_trading_account_expired" type="checkbox" value="1" checked
                    class="mt-1 h-4 w-4 rounded border-slate-300 text-slate-900 focus:ring-slate-900"><span>Update trading
                    account expired?</span></label>
            <div class="bg-slate-50 rounded-lg p-3 text-sm text-slate-600">The configured payment duration is applied
                automatically. If the account is still active, days are added from its current expiry; otherwise days are
                added from today.</div><button class="bg-slate-900 text-white px-4 py-2 rounded-lg">Record Payment</button>
        </div>
</form>@endsection