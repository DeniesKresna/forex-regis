<?php
namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
class User extends Authenticatable { use SoftDeletes, Notifiable; protected $fillable=['name','phone','email','password','is_verified']; protected $hidden=['password','remember_token']; protected function casts(): array{return ['password'=>'hashed','is_verified'=>'boolean'];} public function roles(){return $this->belongsToMany(Role::class);} public function metatraderAccounts(){return $this->hasMany(MetaTraderAccount::class);} }
