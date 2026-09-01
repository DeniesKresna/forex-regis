<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Payment extends Model {protected $fillable=['metatrader_account_id','type','amount','duration_days','expired_before','expired_after']; protected function casts():array{return ['amount'=>'decimal:2','expired_before'=>'date','expired_after'=>'date'];} public function metatraderAccount(){return $this->belongsTo(MetaTraderAccount::class);} }
