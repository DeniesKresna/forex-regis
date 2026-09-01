<?php
namespace App\Http\Controllers;
use App\Models\MetaTraderConfig;
use Illuminate\Http\Request;
class ConfigController extends Controller
{
    public function editPayment()
    {
        $c = MetaTraderConfig::firstOrCreate(['name' => 'payment'], ['value' => ['10000' => 3, '50000' => 30]]);
        return view('configs.payment', compact('c'));
    }
    public function updatePayment(Request $r)
    {
        $d = $r->validate(['config' => 'required|string']);
        $json = json_decode($d['config'], true);
        if (!is_array($json))
            return back()->withErrors(['config' => 'Value must be a valid JSON object.']);
        foreach ($json as $amount => $days) {
            if (!is_numeric($amount) || !is_numeric($days) || $amount <= 0 || $days <= 0)
                return back()->withErrors(['config' => 'Each amount and duration must be positive numbers.']);
        }
        $c = MetaTraderConfig::firstOrCreate(['name' => 'payment']);
        $c->update(['value' => $json]);
        return back()->with('success', 'Payment configuration updated.');
    }
}
