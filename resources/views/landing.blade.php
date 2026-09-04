<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Vandenprise App</title>
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-slate-950 text-white">
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-32 -right-32 h-96 w-96 rounded-full bg-emerald-500/20 blur-3xl"></div>
        <div class="absolute top-40 -left-24 h-80 w-80 rounded-full bg-cyan-500/20 blur-3xl"></div>
    </div>

    <main class="relative mx-auto flex min-h-screen max-w-6xl items-center px-6 py-14 lg:px-10">
        <section class="grid gap-12 lg:grid-cols-[1.15fr_0.85fr] lg:items-center">
            <div>
                <h1 class="mt-6 max-w-2xl text-4xl font-semibold tracking-tight sm:text-5xl lg:text-6xl">
                    Van Den Prise Forex Community
                </h1>
                <p class="mt-6 max-w-2xl text-lg leading-8 text-slate-300">
                    Web ini membagikan indikator yang sering tim kami gunakan untuk melakukan analisa trading.
                </p>

                <div class="mt-8 flex flex-col gap-4 sm:flex-row">
                    <a href="{{ $indicatorDownloadUrl ?: route('indicators.download') }}" class="inline-flex items-center justify-center rounded-xl bg-emerald-400 px-6 py-3 text-base font-semibold text-slate-950 shadow-lg shadow-emerald-500/25 transition hover:bg-emerald-300">
                        Download indicators
                    </a>
                    <a href="/lotcalculator" class="inline-flex items-center justify-center gap-2 rounded-xl border border-white/15 bg-white/5 px-6 py-3 text-base font-semibold text-white transition hover:bg-white/10">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-5 w-5" aria-hidden="true">
                            <rect x="5" y="3" width="14" height="18" rx="2" ry="2"></rect>
                            <path d="M8 7h8"></path>
                            <path d="M8 11h2"></path>
                            <path d="M12 11h2"></path>
                            <path d="M16 11h0"></path>
                            <path d="M8 15h2"></path>
                            <path d="M12 15h2"></path>
                            <path d="M16 15h0"></path>
                            <path d="M8 19h2"></path>
                            <path d="M12 19h2"></path>
                            <path d="M16 19h0"></path>
                        </svg>
                        Lot Calculator
                    </a>
                    <a href="https://wa.me/6281357006008" target="_blank" rel="noreferrer" class="inline-flex items-center justify-center rounded-xl border border-white/15 bg-white/5 px-6 py-3 text-base font-semibold text-white transition hover:bg-white/10">
                        Order via WhatsApp
                    </a>
                </div>

                <div class="mt-10 grid gap-4 sm:grid-cols-3">
                        <a href="{{ $brokerReferalUrl ?: '#' }}" target="_blank" rel="noreferrer" class="rounded-2xl border border-emerald-400/20 bg-emerald-400/10 p-5 transition hover:bg-emerald-400/15 {{ $brokerReferalUrl ?: 'pointer-events-none opacity-60' }}">
                            <div class="text-sm text-emerald-200">Broker Mini Spread</div>
                            <div class="mt-2 font-medium text-white">Open broker referral link</div>
                            <div class="mt-2 text-sm text-slate-300">Open the broker referral page for mini spread access.</div>
                        </a>
                    <div class="rounded-2xl border border-white/10 bg-white/5 p-5">
                        <div class="text-sm text-slate-400">TG Multitimeframe EMA</div>
                        <div class="mt-2 font-medium">Order block validation 2</div>
                    </div>
                    <div class="rounded-2xl border border-white/10 bg-white/5 p-5">
                        <div class="text-sm text-slate-400">DK UFO</div>
                        <div class="mt-2 font-medium"><br />Order block finder</div>
                    </div>
                </div>

                <div class="mt-10">
                    <img src="{{ asset('images/chart001.png') }}" alt="Chart 001">
                </div>
            </div>

            <aside class="rounded-3xl border border-white/10 bg-white/5 p-6 shadow-2xl shadow-black/30 backdrop-blur">
                <div class="rounded-2xl bg-slate-900/80 p-6">
                    <div class="text-sm uppercase tracking-[0.2em] text-emerald-300">Subscription</div>
                    <h2 class="mt-3 text-2xl font-semibold">DK UFO access</h2>
                    <p class="mt-4 text-sm leading-7 text-slate-300">
                        Khusus DK UFO, diperlukan subscription:
                    </p>
                    <ul class="mt-4 space-y-3 text-sm text-slate-200">
                        <li class="rounded-xl border border-white/10 bg-white/5 px-4 py-3">Rp 10.000 untuk 3 hari</li>
                        <li class="rounded-xl border border-white/10 bg-white/5 px-4 py-3">Rp 50.000 untuk 1 bulan</li>
                    </ul>
                    <div class="mt-6 rounded-xl border border-emerald-400/20 bg-emerald-400/10 px-4 py-3 text-sm text-emerald-100">
                        Untuk memesan, silakan klik tombol WhatsApp.
                    </div>
                </div>

                <div class="mt-6 rounded-2xl border border-dashed border-white/15 p-5 text-sm leading-7 text-slate-300">
                    <p class="font-semibold text-white">Cara pasang:</p>
                    <ol class="mt-3 space-y-2 list-decimal pl-5">
                        <li>Download file indikator dari tombol download di section kiri.</li>
                        <li>Copy <span class="font-medium text-white">Iunima_mtf</span> dan <span class="font-medium text-white">TG Multitimeframe EMA</span> ke folder <span class="font-medium text-white">Indicators</span> di MT5.</li>
                        <li>Copy <span class="font-medium text-white">DK UFO</span> ke folder <span class="font-medium text-white">Scripts</span> di MT5.</li>
                        <li>Jika ingin memakai DK UFO, lakukan subscription terlebih dahulu.</li>
                    </ol>
                </div>
            </aside>
        </section>
    </main>

    <x-site-footer />
</body>
</html>