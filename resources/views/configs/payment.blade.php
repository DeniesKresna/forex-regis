@extends('layouts.app', ['title' => 'Config'])

@section('content')
    <div class="space-y-4 max-w-2xl">
        <form method="POST" action="{{ route('config.payment.update', [], false) }}" class="bg-white border rounded-xl p-6">
            @csrf
            @method('PUT')

            <div class="flex flex-col gap-4 md:flex-row md:items-end">
                <div class="flex-1">
                    <label class="font-medium block">payment</label>
                    <textarea name="config" rows="6" class="w-full border rounded-lg p-3 mt-2 font-mono text-sm">{{ old('config', $paymentJson) }}</textarea>
                    <p class="text-sm text-slate-500 mt-2">Default: { "10000": 3, "50000": 30 }</p>
                </div>

                <button class="h-12 rounded-lg bg-slate-900 px-4 text-white">Save</button>
            </div>
        </form>

        <form method="POST" action="{{ route('config.forex-quote-to-usd.update', [], false) }}" class="bg-white border rounded-xl p-6">
            @csrf
            @method('PUT')

            <div class="flex flex-col gap-4 md:flex-row md:items-end">
                <div class="flex-1">
                    <label class="font-medium block">forex quote to usd</label>
                    <textarea name="config" rows="8" class="w-full border rounded-lg p-3 mt-2 font-mono text-sm">{{ old('config', $quoteToUsdJson) }}</textarea>
                    <p class="text-sm text-slate-500 mt-2">Example: { "EUR": 1.162388, "GBP": 1.300000, "AUD": 0.655000, "NZD": 0.602000, "CAD": 0.730000, "CHF": 1.118000, "JPY": 0.006800 }</p>
                    <p class="text-sm text-slate-500 mt-1">Isi conversion rate quote currency ke USD. Contoh JPY bukan 3 digit harga pair, tapi nilai kecil seperti 0.006800.</p>
                </div>

                <button class="h-12 rounded-lg bg-slate-900 px-4 text-white">Save</button>
            </div>
        </form>

        <form method="POST" action="{{ route('config.broker.update', [], false) }}" class="bg-white border rounded-xl p-6">
            @csrf
            @method('PUT')

            <div class="flex flex-col gap-4 md:flex-row md:items-end">
                <div class="flex-1">
                    <label class="font-medium block">referal broker url</label>
                    <input type="url" name="broker_referal_url" value="{{ old('broker_referal_url', $brokerReferalUrl) }}" class="w-full border rounded-lg p-3 mt-2 text-sm" placeholder="https://...">
                </div>

                <button class="h-12 rounded-lg bg-slate-900 px-4 text-white">Save</button>
            </div>
        </form>

        <form method="POST" action="{{ route('config.indicator.update', [], false) }}" class="bg-white border rounded-xl p-6">
            @csrf
            @method('PUT')

            <div class="flex flex-col gap-4 md:flex-row md:items-end">
                <div class="flex-1">
                    <label class="font-medium block">indicator download url</label>
                    <input type="url" name="indicator_download_url" value="{{ old('indicator_download_url', $indicatorDownloadUrl) }}" class="w-full border rounded-lg p-3 mt-2 text-sm" placeholder="https://...">
                </div>

                <button class="h-12 rounded-lg bg-slate-900 px-4 text-white">Save</button>
            </div>
        </form>
    </div>
@endsection