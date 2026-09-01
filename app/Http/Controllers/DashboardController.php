<?php
namespace App\Http\Controllers;
use App\Models\User;use App\Models\MetaTraderAccount;use App\Models\Payment;
class DashboardController extends Controller {public function index(){return view('dashboard.index',['users'=>User::count(),'accounts'=>MetaTraderAccount::count(),'active'=>MetaTraderAccount::whereDate('expired_date','>=',today())->count(),'payments'=>Payment::count()]);}}
