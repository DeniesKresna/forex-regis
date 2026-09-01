@extends('layouts.app', ['title' => 'Payments']) @section('content')
    <div class="flex justify-between mb-4">
        <h2 class="text-lg font-semibold">Payment History</h2><a href="{{ route('payments.create') }}"
            class="bg-slate-900 text-white px-4 py-2 rounded-lg text-sm">Add Payment</a>
    </div>
    <div class="bg-white border rounded-xl overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-slate-50">
                <tr>
                    <th class="p-3 text-left">Date</th>
                    <th class="p-3 text-left">User</th>
                    <th class="p-3 text-left">MT Account</th>
                    <th class="p-3 text-left">Amount</th>
                    <th class="p-3 text-left">Days</th>
                    <th class="p-3 text-left">Update Expiry</th>
                    <th class="p-3 text-left">Expired After</th>
                </tr>
            </thead>
            <tbody>@foreach($payments as $p)
                <tr class="border-t">
                    <td class="p-3">{{ $p->created_at->format('Y-m-d H:i') }}</td>
                    <td class="p-3">{{ $p->metatraderAccount->user->name }}</td>
                    <td class="p-3 font-mono">{{ $p->metatraderAccount->account_number }}</td>
                    <td class="p-3">Rp {{ number_format($p->amount, 0, ',', '.') }}</td>
                    <td class="p-3">{{ $p->duration_days }}</td>
                    <td class="p-3">{{ $p->update_trading_account_expired ? 'Yes' : 'No' }}</td>
                    <td class="p-3">{{ $p->expired_after->format('Y-m-d') }}</td>
            </tr>@endforeach
            </tbody>
        </table>
    </div>
<div class="mt-4">{{ $payments->links() }}</div>@endsection