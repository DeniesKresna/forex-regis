<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>{{ $title ?? 'Forex Community Van Den Prise' }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-slate-950 text-white">
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-32 -right-32 h-96 w-96 rounded-full bg-emerald-500/20 blur-3xl"></div>
        <div class="absolute top-40 -left-24 h-80 w-80 rounded-full bg-cyan-500/20 blur-3xl"></div>
    </div>

    <main class="relative mx-auto flex min-h-screen max-w-6xl flex-col px-6 py-8 lg:px-10">
        <div class="flex-1">
            @yield('content')
        </div>
        <x-site-footer />
    </main>
</body>

</html>