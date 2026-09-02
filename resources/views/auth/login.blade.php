<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-slate-100 flex items-center justify-center p-5">
    <form method="POST" action="{{ route('login.store', [], false) }}" class="w-full max-w-md bg-white p-8 rounded-2xl shadow">
        <h1 class="text-2xl font-bold mb-2">Forex Community Van Den Prise</h1>
        <p class="text-slate-500 mb-6">Admin login</p>
        @csrf
        <label class="block text-sm font-medium">Email</label>
        <input name="email" type="email" value="{{ old('email') }}" class="w-full border rounded-lg px-3 py-2 mt-1 mb-4">
        <label class="block text-sm font-medium">Password</label>
        <input name="password" type="password" class="w-full border rounded-lg px-3 py-2 mt-1 mb-5">
        <button class="w-full bg-slate-900 text-white rounded-lg py-2.5">Login</button>
    </form>
</body>
</html>