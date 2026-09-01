<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>{{ $title ?? 'Forex Community Van Den Prise' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-50 text-slate-900">
    <div class="min-h-screen flex">
        <aside class="w-64 bg-slate-900 text-white p-5 hidden md:block">
            <div class="text-xl font-bold mb-8">FC Van Den Prise</div>
            <nav class="space-y-1 text-sm"><a class="block rounded px-3 py-2 hover:bg-slate-800"
                    href="{{ route('dashboard') }}">Dashboard</a><a class="block rounded px-3 py-2 hover:bg-slate-800"
                    href="{{ route('users.index') }}">Users</a><a class="block rounded px-3 py-2 hover:bg-slate-800"
                    href="{{ route('metatrader-accounts.index') }}">MetaTrader Accounts</a><a
                    class="block rounded px-3 py-2 hover:bg-slate-800"
                    href="{{ route('payments.index') }}">Payments</a><a
                    class="block rounded px-3 py-2 hover:bg-slate-800" href="{{ route('config.payment.edit') }}">Payment
                    Config</a></nav>
            <form method="POST" action="{{ route('logout') }}" class="mt-10">@csrf<button
                    class="w-full text-left px-3 py-2 rounded hover:bg-slate-800">Logout</button></form>
        </aside>
        <main class="flex-1">
            <header class="bg-white border-b px-5 py-4"><x-breadcrumb :title="$title ?? 'Dashboard'" /></header>
            <div class="p-5 max-w-7xl mx-auto">@if(session('success'))
                <div class="mb-4 rounded bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3">
            {{ session('success') }}</div>@endif @if($errors->any())
                        <div class="mb-4 rounded bg-red-50 border border-red-200 text-red-800 px-4 py-3">
                            <ul class="list-disc ml-5">@foreach($errors->all() as $e)
                            <li>{{ $e }}</li>@endforeach
                            </ul>
                    </div>@endif @yield('content')
            </div>
        </main>
    </div>
</body>

</html>