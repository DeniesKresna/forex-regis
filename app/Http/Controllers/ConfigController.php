<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
class ConfigController extends Controller
{
    private function normalizePaymentConfig(?array $config): array
    {
        if (!$config) {
            return [];
        }

        if (isset($config['payment']) && is_array($config['payment'])) {
            return $config['payment'];
        }

        return $config;
    }

    private function normalizeForexQuoteToUsdConfig(?array $config): array
    {
        $defaults = [
            'EUR' => 1.0,
            'GBP' => 1.0,
            'AUD' => 1.0,
            'NZD' => 1.0,
            'CAD' => 1.0,
            'CHF' => 1.0,
            'JPY' => 1.0,
        ];

        if (! $config) {
            return $defaults;
        }

        if (isset($config['quote_to_usd']) && is_array($config['quote_to_usd'])) {
            $config = $config['quote_to_usd'];
        }

        foreach ($defaults as $currency => $defaultRate) {
            $value = $config[$currency] ?? $defaultRate;
            $defaults[$currency] = is_numeric($value) ? (float) $value : $defaultRate;
        }

        return $defaults;
    }

    public function editPayment()
    {
        $paymentRow = DB::table('metatrader_configs')->where('name', 'payment')->first();
        $brokerRow = DB::table('metatrader_configs')->where('name', 'referal_broker_url')->first()
            ?? DB::table('metatrader_configs')->where('name', 'broker_referal_url')->first();
        $indicatorDownloadRow = DB::table('metatrader_configs')->where('name', 'indicator_download_url')->first();
        $quoteToUsdRow = DB::table('metatrader_configs')->where('name', 'forex_quote_to_usd')->first();

        if (!$paymentRow) {
            DB::table('metatrader_configs')->insert([
                'name' => 'payment',
                'value' => json_encode(['10000' => 3, '50000' => 30]),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

            $paymentValue = ['10000' => 3, '50000' => 30];
        } else {
            $paymentValue = $this->normalizePaymentConfig(json_decode($paymentRow->value, true));
        }

        $brokerReferalUrl = $brokerRow ? (json_decode($brokerRow->value, true) ?: '') : '';
        $indicatorDownloadUrl = $indicatorDownloadRow ? (json_decode($indicatorDownloadRow->value, true) ?: '') : route('indicators.download');
        $quoteToUsdValue = $quoteToUsdRow ? $this->normalizeForexQuoteToUsdConfig(json_decode($quoteToUsdRow->value, true)) : $this->normalizeForexQuoteToUsdConfig(null);

        return view('configs.payment', [
            'paymentJson' => json_encode($paymentValue, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),
            'brokerReferalUrl' => $brokerReferalUrl,
            'indicatorDownloadUrl' => $indicatorDownloadUrl,
            'quoteToUsdJson' => json_encode($quoteToUsdValue, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),
        ]);
    }
    public function updatePayment(Request $r)
    {
        $d = $r->validate([
            'config' => 'required|string',
        ]);
        $json = json_decode($d['config'], true);
        if (!is_array($json))
            return back()->withErrors(['config' => 'Value must be a valid JSON object.']);

        $json = $this->normalizePaymentConfig($json);

        foreach ($json as $amount => $days) {
            if (!is_numeric($amount) || !is_numeric($days) || $amount <= 0 || $days <= 0)
                return back()->withErrors(['config' => 'Each amount and duration must be positive numbers.']);
        }
        $now = date('Y-m-d H:i:s');

        DB::table('metatrader_configs')->updateOrInsert(
            ['name' => 'payment'],
            ['value' => json_encode($json), 'updated_at' => $now, 'created_at' => $now]
        );
        return back()->with('success', 'Payment configuration updated.');
    }

    public function updateBrokerReferalUrl(Request $r)
    {
        $d = $r->validate([
            'broker_referal_url' => 'nullable|url',
        ]);

        $now = date('Y-m-d H:i:s');

        DB::table('metatrader_configs')->updateOrInsert(
            ['name' => 'referal_broker_url'],
            ['value' => json_encode($d['broker_referal_url'] ?? ''), 'updated_at' => $now, 'created_at' => $now]
        );

        return back()->with('success', 'Broker referral URL updated.');
    }

    public function updateIndicatorDownloadUrl(Request $r)
    {
        $d = $r->validate([
            'indicator_download_url' => 'nullable|url',
        ]);

        $now = date('Y-m-d H:i:s');

        DB::table('metatrader_configs')->updateOrInsert(
            ['name' => 'indicator_download_url'],
            ['value' => json_encode($d['indicator_download_url'] ?? ''), 'updated_at' => $now, 'created_at' => $now]
        );

        return back()->with('success', 'Indicator download URL updated.');
    }

    public function updateForexQuoteToUsd(Request $r)
    {
        $d = $r->validate([
            'config' => 'required|string',
        ]);

        $json = json_decode($d['config'], true);

        if (! is_array($json)) {
            return back()->withErrors(['config' => 'Value must be a valid JSON object.']);
        }

        $normalized = $this->normalizeForexQuoteToUsdConfig($json);

        foreach ($normalized as $currency => $rate) {
            if (! is_string($currency) || ! preg_match('/^[A-Z]{3}$/', $currency)) {
                return back()->withErrors(['config' => 'Use 3-letter currency codes only.']);
            }

            if (! is_numeric($rate) || (float) $rate <= 0) {
                return back()->withErrors(['config' => 'Each rate must be a positive number.']);
            }
        }

        $now = date('Y-m-d H:i:s');

        DB::table('metatrader_configs')->updateOrInsert(
            ['name' => 'forex_quote_to_usd'],
            ['value' => json_encode($normalized), 'updated_at' => $now, 'created_at' => $now]
        );

        return back()->with('success', 'Forex quote to USD configuration updated.');
    }
}
