<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder; use App\Models\Role; use App\Models\User; use App\Models\MetaTraderConfig;
class DatabaseSeeder extends Seeder {public function run():void{$admin=Role::firstOrCreate(['name'=>'admin']);Role::firstOrCreate(['name'=>'common_trader']);$user=User::firstOrCreate(['email'=>'admin@example.com'],['name'=>'Administrator','password'=>'admin12345','is_verified'=>true]);$user->roles()->syncWithoutDetaching([$admin->id]);MetaTraderConfig::firstOrCreate(['name'=>'payment'],['value'=>['10000'=>3,'50000'=>30]]);}}
