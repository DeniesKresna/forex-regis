<?php

namespace App\Services;

use App\Models\MetaTraderAccount;
use App\Models\MetaTraderConfig;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PaymentService
{
    public function create(
        MetaTraderAccount $account,
        float $amount,
        bool $updateTradingAccountExpired = true,
        string $type = 'metatrader',
    ): Payment {
        return DB::transaction(function () use ($account, $amount, $updateTradingAccountExpired, $type) {
            $config = MetaTraderConfig::where('name', 'payment')->firstOrFail();
            $map = $config->value ?? [];
            if (isset($map['payment']) && is_array($map['payment'])) {
                $map = $map['payment'];
            }
            $key = (string) (int) $amount;

            if (! array_key_exists($key, $map)) {
                throw ValidationException::withMessages([
                    'amount' => 'Payment amount Rp' . number_format($amount, 0, ',', '.') . ' is not configured.',
                ]);
            }

            $days = (int) $map[$key];
            $before = $account->expired_date?->copy();
            $base = $before && $before->isFuture() ? $before->copy() : now();
            $after = $base->copy()->addDays($days)->startOfDay();

            $payment = Payment::create([
                'metatrader_account_id' => $account->id,
                'type' => $type,
                'amount' => $amount,
                'update_trading_account_expired' => $updateTradingAccountExpired,
                'duration_days' => $days,
                'expired_before' => $before,
                'expired_after' => $after,
            ]);

            if ($updateTradingAccountExpired) {
                $account->update(['expired_date' => $after]);
            }

            return $payment;
        });
    }
}
