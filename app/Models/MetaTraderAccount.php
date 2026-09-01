<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class MetaTraderAccount extends Model {use SoftDeletes; protected $table='metatrader_accounts'; protected $fillable=['user_id','server_name','account_number','balance','expired_date']; protected function casts():array{return ['balance'=>'decimal:2','expired_date'=>'date'];} public function user(){return $this->belongsTo(User::class);} public function payments(){return $this->hasMany(Payment::class);} public function getIsActiveAttribute(){return $this->expired_date && $this->expired_date->endOfDay()->isFuture();}}
