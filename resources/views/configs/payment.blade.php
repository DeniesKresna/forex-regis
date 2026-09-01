@extends('layouts.app', ['title' => 'Payment Configuration']) @section('content')
    <form method="POST" action="{{ route('config.payment.update') }}" class="bg-white border rounded-xl p-6 max-w-xl">@csrf
        @method('PUT')<label class="font-medium">payment JSON</label><textarea name="config" rows="12"
            class="w-full border rounded-lg p-3 mt-2 font-mono text-sm">{{ old('config', json_encode($c->value, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)) }}</textarea>
        <p class="text-sm text-slate-500 mt-2">Example: { "10000": 3, "50000": 30 }</p><button
            class="mt-4 bg-slate-900 text-white px-4 py-2 rounded-lg">Save Configuration</button>
</form>@endsection