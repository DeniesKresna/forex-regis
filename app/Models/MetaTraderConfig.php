<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class MetaTraderConfig extends Model {use SoftDeletes; protected $table='metatrader_configs'; protected $fillable=['name','value']; protected function casts():array{return ['value'=>'array'];}}
