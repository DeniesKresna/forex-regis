<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Vandenprise App</title>
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-slate-100 flex items-center justify-center p-5">
    <form method="POST" action="{{ route('login.otp.verify', [], false) }}" class="w-full max-w-md bg-white p-8 rounded-2xl shadow">
        <h1 class="text-2xl font-bold mb-2">Verify OTP</h1>
        <p class="text-slate-500 mb-6">Masukkan OTP yang dikirim ke Discord. Berlaku 1 menit.</p>

        @if(session('success'))
            <div class="mb-4 rounded-lg bg-emerald-50 border border-emerald-200 px-4 py-3 text-emerald-800 text-sm">
                {{ session('success') }}
            </div>
        @endif

        @csrf
        <label class="block text-sm font-medium">OTP</label>
        <input name="otp" type="text" inputmode="numeric" autocomplete="one-time-code" maxlength="6" class="w-full border rounded-lg px-3 py-2 mt-1 mb-5 tracking-[0.4em] text-center text-lg">
        <button class="w-full bg-slate-900 text-white rounded-lg py-2.5">Verify</button>
    </form>
</body>
</html>