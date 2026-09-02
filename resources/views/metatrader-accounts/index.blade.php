@extends('layouts.app', ['title' => 'MetaTrader Accounts']) @section('content')
    <div class="flex justify-between mb-4">
        <h2 class="text-lg font-semibold">MetaTrader Accounts</h2><a href="{{ route('metatrader-accounts.create') }}"
            class="bg-slate-900 text-white px-4 py-2 rounded-lg text-sm">Add Account</a>
    </div>
    <div class="bg-white border rounded-xl overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-slate-50">
                <tr>
                    <th class="p-3 text-left">User</th>
                    <th class="p-3 text-left">Server</th>
                    <th class="p-3 text-left">Account</th>
                    <th class="p-3 text-left">Balance</th>
                    <th class="p-3 text-left">Expired</th>
                    <th class="p-3 text-right">Action</th>
                </tr>
            </thead>
            <tbody>@foreach($accounts as $a)
                <tr class="border-t">
                    <td class="p-3">{{ $a->user->name }}</td>
                    <td class="p-3">{{ $a->server_name }}</td>
                    <td class="p-3 font-mono">{{ $a->account_number }}</td>
                    <td class="p-3">{{ number_format($a->balance, 2) }}</td>
                    <td class="p-3">{{ $a->expired_date?->format('Y-m-d') ?? '—' }} @if($a->is_active)<span
                    class="text-emerald-600">●</span>@else<span class="text-red-600">●</span>@endif</td>
                    <td class="p-3 text-right"><a class="text-blue-600"
                            href="{{ route('metatrader-accounts.edit', $a) }}">Edit</a>
                        <form class="inline" method="POST" action="{{ route('metatrader-accounts.destroy', $a, false) }}">@csrf
                            @method('DELETE')<button class="text-red-600 ml-3"
                                onclick="return confirm('Delete account?')">Delete</button></form>
                    </td>
            </tr>@endforeach
            </tbody>
        </table>
    </div>
<div class="mt-4">{{ $accounts->links() }}</div>@endsection