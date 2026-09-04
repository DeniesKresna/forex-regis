@extends('layouts.public', ['title' => 'Lot Calculator'])

@section('content')
@php
    $setup = $lotCalculatorSetup ?? [];
    $selectedSymbol = $setup['symbol'] ?? 'XAU/USD';
    $lotCalculatorPairs = [
        'EUR/USD',
        'GBP/USD',
        'AUD/USD',
        'NZD/USD',
        'USD/CAD',
        'USD/CHF',
        'USD/JPY',
        'EUR/GBP',
        'EUR/AUD',
        'EUR/NZD',
        'EUR/CAD',
        'GBP/CAD',
        'AUD/CAD',
        'NZD/CAD',
        'EUR/CHF',
        'GBP/CHF',
        'AUD/CHF',
        'NZD/CHF',
        'EUR/JPY',
        'GBP/JPY',
        'AUD/JPY',
        'NZD/JPY',
        'CAD/CHF',
        'CAD/JPY',
        'CHF/JPY',
        'GBP/AUD',
        'GBP/NZD',
        'AUD/NZD',
    ];
@endphp
<div class="grid gap-4 xl:grid-cols-[1.05fr_0.95fr]">
    <section data-side-panel
        class="rounded-3xl border border-emerald-200 bg-white/95 p-4 text-slate-900 shadow-xl shadow-black/10 backdrop-blur lg:p-5">
        <div class="flex flex-wrap items-start justify-between gap-3">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.22em] text-amber-600">Trading Tools</p>
                <h1 class="mt-1 text-2xl font-semibold">Lot Calculator</h1>
                <p class="mt-1 max-w-xl text-sm leading-6 text-slate-600">
                    Calculate volume, price, stop loss, and take profit in one screen.
                </p>
            </div>
            <button type="button" data-tab="forex"
                class="tab-button rounded-full border border-amber-500 bg-amber-500 px-4 py-2 text-xs font-semibold text-white shadow-sm transition">
                Forex
            </button>
        </div>

        <div class="mt-4 flex items-center justify-between gap-3">
            <a href="/"
                class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                Back to Home
            </a>

            <div
                class="inline-flex items-center gap-2 rounded-full bg-emerald-50 px-3 py-2 shadow-sm ring-1 ring-emerald-200">
                <span class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Auto</span>
                <span id="sideBadge" data-side-badge
                    class="rounded-full bg-emerald-500 px-3 py-1 text-sm font-semibold text-white">
                    Buy
                </span>
            </div>
        </div>

        <div class="mt-4 rounded-2xl bg-amber-50 px-4 py-3 text-sm text-amber-900" data-instrument-hint>
            Point size changes by symbol. Cross pairs with non-USD quote need Quote to USD for exact lot sizing.
        </div>

        <form id="lotCalculatorForm" class="mt-4 grid gap-3">

            <label class="space-y-1.5">
                <span class="text-xs font-medium uppercase tracking-wide text-slate-500">
                    Pair
                </span>

                <select name="symbol"
                    class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-amber-500 focus:ring-2 focus:ring-amber-200">
                    <option value="XAU/USD" {{ in_array($selectedSymbol, ['XAU', 'XAU/USD'], true) ? 'selected' : '' }}>XAU/USD</option>
                    @foreach ($lotCalculatorPairs as $pair)
                        <option value="{{ $pair }}" {{ $selectedSymbol === $pair ? 'selected' : '' }}>{{ $pair }}</option>
                    @endforeach
                </select>
            </label>

            <!-- Line 1: Balance | Risk -->
            <div class="grid grid-cols-2 gap-3">
                <label class="space-y-1.5">
                    <span class="text-xs font-medium uppercase tracking-wide text-slate-500">
                        Balance (USD)
                    </span>
                    <input name="balance" type="text" inputmode="decimal" autocomplete="off" placeholder="1000,00"
                        value="{{ $setup['balance'] ?? '' }}"
                        class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-amber-500 focus:ring-2 focus:ring-amber-200">
                </label>

                <label class="space-y-1.5">
                    <span class="text-xs font-medium uppercase tracking-wide text-slate-500">
                        Risk (%)
                    </span>
                    <input name="risk" type="text" inputmode="decimal" autocomplete="off" placeholder="1,00"
                        value="{{ $setup['risk'] ?? '' }}"
                        class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-amber-500 focus:ring-2 focus:ring-amber-200">
                </label>
            </div>

            <label class="space-y-1.5 hidden" data-quote-rate-field>
                <span class="text-xs font-medium uppercase tracking-wide text-slate-500">
                    Quote to USD
                </span>

                <input name="quote_to_usd" type="text" inputmode="decimal" autocomplete="off" placeholder="1,0000"
                    value="{{ $setup['quote_to_usd'] ?? '' }}"
                    class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-amber-500 focus:ring-2 focus:ring-amber-200">

                <p class="text-[11px] leading-5 text-slate-500">
                    Required only for cross pairs like EUR/GBP, GBP/AUD, or AUD/NZD.
                </p>
            </label>


            <!-- Line 2: Entry | Stop -->
            <div class="grid grid-cols-2 gap-3">
                <label class="space-y-1.5">
                    <span class="text-xs font-medium uppercase tracking-wide text-slate-500">
                        Entry
                    </span>
                    <input name="entry" type="text" inputmode="decimal" autocomplete="off" placeholder="2500,00"
                        value="{{ $setup['entry'] ?? '' }}"
                        class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-amber-500 focus:ring-2 focus:ring-amber-200">
                </label>

                <label class="space-y-1.5">
                    <span class="text-xs font-medium uppercase tracking-wide text-slate-500">
                        Stop
                    </span>
                    <input name="stop" type="text" inputmode="decimal" autocomplete="off" placeholder="2495,00"
                        value="{{ $setup['stop'] ?? '' }}"
                        class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-amber-500 focus:ring-2 focus:ring-amber-200">
                </label>
            </div>


            <!-- Line 3: TP | With BEP -->
            <div class="grid grid-cols-2 gap-3">
                <label class="space-y-1.5">
                    <span class="flex items-center gap-2 text-xs font-medium uppercase tracking-wide text-slate-500">
                        <span>TP</span>
                        <span class="text-[10px] font-semibold uppercase tracking-[0.18em] text-slate-400">
                            RR
                        </span>
                    </span>

                    <input name="tp" type="text" inputmode="decimal" autocomplete="off" placeholder="2"
                        value="{{ $setup['tp'] ?? '' }}"
                        class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-amber-500 focus:ring-2 focus:ring-amber-200">
                </label>

                <div class="flex items-center justify-between gap-3 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3">
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wide text-slate-500">With BEP</p>
                        <p class="text-[11px] leading-5 text-slate-500">Show BEP value.</p>
                    </div>

                    <label class="relative inline-flex cursor-pointer items-center">
                        <input id="withBepToggle" name="with_bep" type="checkbox" class="peer sr-only" {{ !array_key_exists('with_bep', $setup) || !empty($setup['with_bep']) ? 'checked' : '' }}>
                        <div class="peer h-6 w-11 rounded-full bg-slate-300 transition peer-checked:bg-emerald-500"></div>
                        <div class="absolute left-1 top-1 h-4 w-4 rounded-full bg-white transition peer-checked:translate-x-5"></div>
                    </label>
                </div>
            </div>


            <!-- Line 4: Spread | Space -->
            <div class="grid grid-cols-2 gap-3">
                <label class="space-y-1.5">
                    <span class="text-xs font-medium uppercase tracking-wide text-slate-500">
                        Spread (point)
                    </span>

                    <input name="spread" type="text" inputmode="numeric" autocomplete="off" placeholder="20"
                        value="{{ $setup['spread'] ?? '' }}"
                        class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-amber-500 focus:ring-2 focus:ring-amber-200">
                </label>

                <label class="space-y-1.5">
                    <span class="text-xs font-medium uppercase tracking-wide text-slate-500">
                        Space (point)
                    </span>

                    <input name="space" type="text" inputmode="numeric" autocomplete="off" placeholder="100"
                        value="{{ $setup['space'] ?? '' }}"
                        class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-amber-500 focus:ring-2 focus:ring-amber-200">

                    <p class="text-[11px] leading-5 text-slate-500">
                        Tolerance in point.
                    </p>
                </label>
            </div>


            <!-- Buttons -->
            <div class="flex flex-wrap gap-3 pt-1">
                <button type="submit"
                    class="rounded-xl bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-slate-800">
                    Count
                </button>

                <button type="button" id="resetButton"
                    class="rounded-xl border border-slate-300 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                    Reset
                </button>
            </div>

        </form>

    </section>

    <section data-side-panel
        class="rounded-3xl border border-emerald-900/30 bg-slate-900/95 p-4 text-white shadow-xl shadow-black/20 backdrop-blur lg:p-5">
        <div class="flex items-center justify-between gap-3">
            <div>
                <h2 class="mt-1 text-xl font-semibold">Result</h2>
            </div>
            <span data-side-badge
                class="rounded-full bg-emerald-500 px-3 py-1 text-sm font-semibold text-white">Buy</span>
        </div>

        <div id="resultMessage"
            class="mt-4 rounded-2xl border border-dashed border-white/15 bg-white/5 px-4 py-3 text-sm text-slate-300">
            Press Count to see the result.
        </div>

        <div class="mt-4 grid gap-3">
            <div class="rounded-2xl border border-white/10 bg-white/5 px-4 py-3" data-key="volume">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <p class="text-xs uppercase tracking-wide text-slate-400">Volume</p>
                        <p class="mt-1 text-xl font-semibold text-white" data-value>—</p>
                    </div>
                    <button type="button" data-copy="volume"
                        class="copy-button rounded-full border border-white/10 bg-white/10 px-3 py-2 text-xs font-semibold text-white transition hover:bg-white/15 disabled:cursor-not-allowed disabled:opacity-40"
                        disabled>
                        Copy
                    </button>
                </div>
            </div>

            <div class="rounded-2xl border border-white/10 bg-white/5 px-4 py-3" data-key="price">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <p class="text-xs uppercase tracking-wide text-slate-400">Price</p>
                        <p class="mt-1 text-xl font-semibold text-white" data-value>—</p>
                    </div>
                    <button type="button" data-copy="price"
                        class="copy-button rounded-full border border-white/10 bg-white/10 px-3 py-2 text-xs font-semibold text-white transition hover:bg-white/15 disabled:cursor-not-allowed disabled:opacity-40"
                        disabled>
                        Copy
                    </button>
                </div>
            </div>

            <div class="rounded-2xl border border-white/10 bg-white/5 px-4 py-3" data-key="stop_loss">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <p class="text-xs uppercase tracking-wide text-slate-400">Stop Loss</p>
                        <p class="mt-1 text-xl font-semibold text-white" data-value>—</p>
                    </div>
                    <button type="button" data-copy="stop_loss"
                        class="copy-button rounded-full border border-white/10 bg-white/10 px-3 py-2 text-xs font-semibold text-white transition hover:bg-white/15 disabled:cursor-not-allowed disabled:opacity-40"
                        disabled>
                        Copy
                    </button>
                </div>
            </div>

            <div class="rounded-2xl border border-white/10 bg-white/5 px-4 py-3" data-key="take_profit">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <p class="text-xs uppercase tracking-wide text-slate-400">Take Profit</p>
                        <p class="mt-1 text-xl font-semibold text-white" data-value>—</p>
                    </div>
                    <button type="button" data-copy="take_profit"
                        class="copy-button rounded-full border border-white/10 bg-white/10 px-3 py-2 text-xs font-semibold text-white transition hover:bg-white/15 disabled:cursor-not-allowed disabled:opacity-40"
                        disabled>
                        Copy
                    </button>
                </div>
            </div>

            <div id="bepRow" class="hidden rounded-2xl border border-emerald-300/30 bg-emerald-500/10 px-4 py-3" data-key="bep">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <p class="text-xs uppercase tracking-wide text-emerald-200">BEP</p>
                        <p class="mt-1 text-xl font-semibold text-emerald-50" data-value>—</p>
                    </div>
                    <button type="button" data-copy="bep"
                        class="copy-button rounded-full border border-emerald-300/30 bg-white/10 px-3 py-2 text-xs font-semibold text-emerald-50 transition hover:bg-white/15 disabled:cursor-not-allowed disabled:opacity-40"
                        disabled>
                        Copy
                    </button>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    (function () {
        const form = document.getElementById('lotCalculatorForm');
        const symbolInput = form.symbol;
        const quoteRateField = document.querySelector('[data-quote-rate-field]');
        const quoteRateInput = form.quote_to_usd;
        const instrumentHint = document.querySelector('[data-instrument-hint]');
        const resultMessage = document.getElementById('resultMessage');
        const resetButton = document.getElementById('resetButton');
        const numberInputs = Array.from(form.querySelectorAll('input[name]'));
        const copyButtons = Array.from(document.querySelectorAll('[data-copy]'));
        const sideBadges = Array.from(document.querySelectorAll('[data-side-badge]'));
        const sidePanels = Array.from(document.querySelectorAll('[data-side-panel]'));
        const withBepToggle = document.getElementById('withBepToggle');
        const bepRow = document.getElementById('bepRow');
        const resultRows = {
            volume: document.querySelector('[data-key="volume"] [data-value]'),
            price: document.querySelector('[data-key="price"] [data-value]'),
            stop_loss: document.querySelector('[data-key="stop_loss"] [data-value]'),
            take_profit: document.querySelector('[data-key="take_profit"] [data-value]'),
            bep: document.querySelector('[data-key="bep"] [data-value]'),
        };
        const copyValues = {};
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
        const saveEndpoint = '/lotcalculator/save';
        const allowedSymbols = new Set([
            'XAU/USD',
            'XAU',
            'EUR/USD',
            'GBP/USD',
            'AUD/USD',
            'NZD/USD',
            'USD/CAD',
            'USD/CHF',
            'USD/JPY',
            'EUR/GBP',
            'EUR/AUD',
            'EUR/NZD',
            'EUR/CAD',
            'GBP/CAD',
            'AUD/CAD',
            'NZD/CAD',
            'EUR/CHF',
            'GBP/CHF',
            'AUD/CHF',
            'NZD/CHF',
            'EUR/JPY',
            'GBP/JPY',
            'AUD/JPY',
            'NZD/JPY',
            'CAD/CHF',
            'CAD/JPY',
            'CHF/JPY',
            'GBP/AUD',
            'GBP/NZD',
            'AUD/NZD',
        ]);
        let currentSide = 'buy';

        function sanitizeDecimalInput(value) {
            const text = String(value || '');
            let cleaned = '';
            let hasSeparator = false;

            for (const character of text) {
                if (character >= '0' && character <= '9') {
                    cleaned += character;
                    continue;
                }

                if ((character === ',' || character === '.') && !hasSeparator) {
                    cleaned += ',';
                    hasSeparator = true;
                }
            }

            return cleaned;
        }

        function sanitizeIntegerInput(value) {
            return String(value || '').replace(/[^0-9]/g, '');
        }

        function parseInput(value) {
            const text = String(value || '').trim();

            if (!text) {
                return NaN;
            }

            if (text.includes(',') && text.includes('.')) {
                if (text.lastIndexOf(',') > text.lastIndexOf('.')) {
                    return Number(text.replace(/\./g, '').replace(',', '.'));
                }

                return Number(text.replace(/,/g, ''));
            }

            return Number(text.replace(',', '.'));
        }

        function formatReadableNumber(value, digits) {
            if (!Number.isFinite(value)) {
                return '—';
            }

            const formatted = value.toFixed(digits);
            return formatted.replace(/\.0+$/, '').replace(/(\.\d*?)0+$/, '$1');
        }

        function getInstrumentConfig(symbol) {
            if (symbol === 'XAU' || symbol === 'XAU/USD') {
                return {
                    pointSize: 0.01,
                    contractSize: 100,
                    displayDigits: 2,
                    quoteMode: 'usd',
                    label: 'XAU/USD',
                };
            }

            const normalizedSymbol = allowedSymbols.has(symbol) ? symbol : 'XAU/USD';
            const [base, quote] = normalizedSymbol.split('/');
            const isJpyQuote = quote === 'JPY';

            return {
                pointSize: isJpyQuote ? 0.001 : 0.00001,
                contractSize: 100000,
                displayDigits: isJpyQuote ? 3 : 5,
                quoteMode: quote === 'USD' ? 'usd' : base === 'USD' ? 'inverse-entry' : 'manual',
                label: normalizedSymbol,
            };
        }

        function getSetupPayload() {
            return {
                symbol: symbolInput.value,
                balance: form.balance.value,
                risk: form.risk.value,
                entry: form.entry.value,
                stop: form.stop.value,
                tp: form.tp.value,
                space: form.space.value,
                spread: form.spread.value,
                quote_to_usd: form.quote_to_usd.value,
                with_bep: withBepToggle.checked ? '1' : '',
            };
        }

        function setSide(side) {
            currentSide = side;
            const isBuy = side === 'buy';
            const accentColor = isBuy ? '#22c55e' : '#ef4444';
            const softColor = isBuy ? 'rgba(34, 197, 94, 0.12)' : 'rgba(239, 68, 68, 0.12)';
            const borderColor = isBuy ? 'rgba(34, 197, 94, 0.28)' : 'rgba(239, 68, 68, 0.28)';

            sideBadges.forEach((badge) => {
                badge.textContent = isBuy ? 'Buy' : 'Sell';
                badge.style.backgroundColor = accentColor;
            });

            sidePanels.forEach((panel) => {
                panel.style.borderColor = borderColor;
            });

            resultMessage.style.backgroundColor = softColor;
            resultMessage.style.borderColor = borderColor;
            resultMessage.style.color = isBuy ? '#d1fae5' : '#fecaca';
        }

        function deriveSideFromInputs() {
            const entry = parseInput(form.entry.value);
            const stop = parseInput(form.stop.value);

            if (Number.isNaN(entry) || Number.isNaN(stop)) {
                return;
            }

            setSide(stop > entry ? 'sell' : 'buy');
        }

        function updateInstrumentHint() {
            const instrument = getInstrumentConfig(symbolInput.value);
            const pointText = formatReadableNumber(instrument.pointSize, instrument.displayDigits);
            const quoteModeLabel = instrument.quoteMode === 'usd'
                ? 'Quote to USD = 1'
                : instrument.quoteMode === 'inverse-entry'
                    ? 'Quote to USD is derived from entry'
                    : 'Quote to USD must be filled manually';

            instrumentHint.textContent = `${instrument.label} uses point size ${pointText}. ${quoteModeLabel}.`;

            quoteRateField.classList.toggle('hidden', instrument.quoteMode !== 'manual');
            if (instrument.quoteMode === 'usd') {
                quoteRateInput.value = '1';
            }
        }

        function handleNumericInput(event) {
            const field = event.target;
            const isIntegerField = field.name === 'space' || field.name === 'spread';
            const cursorPosition = field.selectionStart;
            const beforeLength = field.value.length;
            const cleaned = isIntegerField ? sanitizeIntegerInput(field.value) : sanitizeDecimalInput(field.value);

            if (field.value !== cleaned) {
                field.value = cleaned;
                const afterLength = cleaned.length;
                const offset = Math.max(0, afterLength - beforeLength);
                if (cursorPosition !== null) {
                    field.setSelectionRange(cursorPosition + offset, cursorPosition + offset);
                }
            }

            if (field.name === 'entry' || field.name === 'stop') {
                deriveSideFromInputs();
            }
        }

        function clearResults(message) {
            resultMessage.textContent = message;

            Object.values(resultRows).forEach((node) => {
                node.textContent = '—';
            });

            bepRow.classList.add('hidden');

            copyButtons.forEach((button) => {
                button.disabled = true;
                button.textContent = 'Copy';
            });

            Object.keys(copyValues).forEach((key) => {
                delete copyValues[key];
            });
        }

        function updateResults(values) {
            resultMessage.textContent = 'Calculation ready.';

            copyValues.volume = formatReadableNumber(values.volume, 4);
            copyValues.price = formatReadableNumber(values.price, values.displayDigits);
            copyValues.stop_loss = formatReadableNumber(values.stopLoss, values.displayDigits);
            copyValues.take_profit = formatReadableNumber(values.takeProfit, values.displayDigits);
            copyValues.bep = formatReadableNumber(values.bep, values.displayDigits);

            resultRows.volume.textContent = copyValues.volume;
            resultRows.price.textContent = copyValues.price;
            resultRows.stop_loss.textContent = copyValues.stop_loss;
            resultRows.take_profit.textContent = copyValues.take_profit;

            if (values.showBep) {
                resultRows.bep.textContent = copyValues.bep;
                bepRow.classList.remove('hidden');
            } else {
                bepRow.classList.add('hidden');
            }

            copyButtons.forEach((button) => {
                button.disabled = false;
                button.textContent = 'Copy';
            });
        }

        function calculate() {
            const instrument = getInstrumentConfig(symbolInput.value);
            const balance = parseInput(form.balance.value);
            const risk = parseInput(form.risk.value);
            const entry = parseInput(form.entry.value);
            const stop = parseInput(form.stop.value);
            const tp = parseInput(form.tp.value);
            const space = parseInput(form.space.value);
            const spread = parseInput(form.spread.value);
            const withBep = withBepToggle.checked;
            let quoteToUsd;

            if ([balance, risk, entry, stop, tp, space, spread].some((value) => Number.isNaN(value))) {
                clearResults('Silakan isi semua field dengan angka yang valid.');
                return;
            }

            if (instrument.quoteMode === 'manual') {
                quoteToUsd = parseInput(form.quote_to_usd.value);

                if (Number.isNaN(quoteToUsd) || quoteToUsd <= 0) {
                    clearResults('Isi Quote to USD agar lot bisa dihitung untuk cross pair ini.');
                    return;
                }
            } else if (instrument.quoteMode === 'inverse-entry') {
                if (entry <= 0) {
                    clearResults('Entry harus lebih besar dari 0 untuk menghitung konversi quote ke USD.');
                    return;
                }

                quoteToUsd = 1 / entry;
            } else {
                quoteToUsd = 1;
            }

            const riskAmount = balance * (risk / 100);
            let price;
            let stopLoss;

            if (currentSide === 'buy') {
                price = entry + ((space + spread) * instrument.pointSize);
                stopLoss = stop - (space * instrument.pointSize);
            } else {
                price = entry - (space * instrument.pointSize);
                stopLoss = stop + ((space + spread) * instrument.pointSize);
            }

            const gap = Math.abs(price - stopLoss);

            if (gap === 0) {
                clearResults('Gap tidak boleh 0 karena volume tidak bisa dihitung.');
                return;
            }

            const takeProfit = currentSide === 'buy'
                ? price + (tp * gap)
                : price - (tp * gap);

            const volume = Math.max(0.01, riskAmount / (gap * instrument.contractSize * quoteToUsd));
            const bep = currentSide === 'buy'
                ? price + gap
                : price - gap;

            updateResults({
                volume,
                price,
                stopLoss,
                takeProfit,
                bep,
                showBep: withBep,
                displayDigits: instrument.displayDigits,
            });
        }

        async function saveSetup() {
            try {
                await fetch(saveEndpoint, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify(getSetupPayload()),
                    keepalive: true,
                });
            } catch (error) {
                // Ignore persistence errors so the calculator still works offline.
            }
        }

        function copyToClipboard(key, button) {
            const value = copyValues[key];

            if (!value) {
                return;
            }

            navigator.clipboard.writeText(value).then(() => {
                button.textContent = 'Copied';
                window.setTimeout(() => {
                    button.textContent = 'Copy';
                }, 1200);
            });
        }

        numberInputs.forEach((input) => {
            input.addEventListener('input', handleNumericInput);
            input.addEventListener('paste', function () {
                window.setTimeout(() => {
                    handleNumericInput({ target: input });
                }, 0);
            });
        });

        symbolInput.addEventListener('change', function () {
            updateInstrumentHint();
        });

        form.addEventListener('submit', function (event) {
            event.preventDefault();
            saveSetup().finally(() => {
                calculate();
            });
        });

        resetButton.addEventListener('click', function () {
            form.reset();
            setSide('buy');
            updateInstrumentHint();
            bepRow.classList.add('hidden');
            clearResults('Press Count to see the result.');
        });

        copyButtons.forEach((button) => {
            button.addEventListener('click', function () {
                copyToClipboard(button.dataset.copy, button);
            });
        });

        updateInstrumentHint();
        deriveSideFromInputs();
        bepRow.classList.add('hidden');
        clearResults('Press Count to see the result.');
    })();
</script>
@endsection