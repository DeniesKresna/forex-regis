@props([
    'title' => 'Dashboard',
    'backUrl' => null,
    'backLabel' => 'Back',
])

@php
    $backUrl = $backUrl ?? url()->previous();
@endphp

<div class="flex items-center justify-between gap-4">
    <div class="min-w-0">
        <nav class="flex items-center gap-2 text-sm text-slate-500" aria-label="Breadcrumb">
            <a href="{{ route('dashboard') }}" class="font-medium text-slate-700 hover:text-slate-900">Dashboard</a>
            @if($title !== 'Dashboard')
                <span>/</span>
                <span class="truncate text-slate-500">{{ $title }}</span>
            @endif
        </nav>
        <h1 class="mt-1 text-lg font-semibold text-slate-900">{{ $title }}</h1>
    </div>

    <a href="{{ $backUrl }}" class="shrink-0 inline-flex items-center rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50 hover:text-slate-900">
        {{ $backLabel }}
    </a>
</div>