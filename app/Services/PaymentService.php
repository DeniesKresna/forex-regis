<?php
namespace App\Services;
use App\Models\MetaTraderAccount;
use App\Models\MetaTraderConfig;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
class PaymentService { public function create(MetaTraderAccount $account,float $amount,string $type='metatrader'): Payment { return DB::transaction(function() use($account,$amount,$type){ $config=MetaTraderConfig::where('name','payment')->firstOrFail(); $map=$config->value??[]; $key=(string)(int)$amount; if(!array_key_exists($key,$map)) throw ValidationException::withMessages(['amount'=>"Payment amount Rp".number_format($amount,0,',','.')." is not configured."]); $days=(int)$map[$key]; $before=$account->expired_date?->copy(); $base=$before && $before->isFuture()? $before->copy():now(); $after=$base->copy()->addDays($days)->startOfDay(); $payment=Payment::create(['metatrader_account_id'=>$account->id,'type'=>$type,'amount'=>$amount,'duration_days'=>$days,'expired_before'=>$before,'expired_after'=>$after]); $account->update(['expired_date'=>$after]); return $payment; }); } }
