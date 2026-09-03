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