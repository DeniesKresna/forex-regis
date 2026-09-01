<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
class AuthController extends Controller
{
    private const OTP_SESSION_KEY = 'admin_login_otp_user_id';
    private const OTP_CACHE_PREFIX = 'admin_login_otp:';

    public function showLogin()
    {
        return view('auth.login');
    }

    public function showOtp()
    {
        if (!session()->has(self::OTP_SESSION_KEY)) {
            return redirect()->route('login');
        }

        return view('auth.otp');
    }

    public function login(Request $r)
    {
        $data = $r->validate(['email' => 'required|email', 'password' => 'required']);
        if (Auth::attempt($data, $r->boolean('remember'))) {
            $r->session()->regenerate();
            $user = Auth::user();
            if (! $user || ! $user->isAdmin()) {
                Auth::logout();
                return back()->withErrors(['email' => 'Admin access required.']);
            }

            $otp = (string) random_int(100000, 999999);
            $cacheKey = self::OTP_CACHE_PREFIX . $user->id;
            Cache::store('redis')->put($cacheKey, $otp, now()->addMinute());

            $response = Http::timeout(5)->post(config('services.discord.login_otp_webhook'), [
                'content' => "OTP login untuk {$user->email}: {$otp}",
            ]);

            if (! $response->successful()) {
                Cache::store('redis')->forget($cacheKey);
                Auth::logout();
                return back()->withErrors(['email' => 'Failed to send OTP. Please try again.']);
            }

            $r->session()->put(self::OTP_SESSION_KEY, $user->id);
            Auth::logout();

            return redirect()->route('login.otp')->with('success', 'OTP has been sent to Discord.');
        }
        return back()->withErrors(['email' => 'Invalid credentials.'])->onlyInput('email');
    }

    public function verifyOtp(Request $r)
    {
        $data = $r->validate(['otp' => 'required|digits:6']);
        $userId = $r->session()->get(self::OTP_SESSION_KEY);

        if (! $userId) {
            return redirect()->route('login')->withErrors(['otp' => 'OTP session expired. Please login again.']);
        }

        $cacheKey = self::OTP_CACHE_PREFIX . $userId;
        $storedOtp = Cache::store('redis')->get($cacheKey);

        if (! $storedOtp || ! hash_equals((string) $storedOtp, (string) $data['otp'])) {
            return back()->withErrors(['otp' => 'Invalid or expired OTP.'])->onlyInput('otp');
        }

        Cache::store('redis')->forget($cacheKey);
        $r->session()->forget(self::OTP_SESSION_KEY);

        $user = \App\Models\User::findOrFail($userId);
        Auth::login($user, $r->boolean('remember'));
        $r->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }

    public function logout(Request $r)
    {
        if ($userId = $r->session()->get(self::OTP_SESSION_KEY)) {
            Cache::store('redis')->forget(self::OTP_CACHE_PREFIX . $userId);
            $r->session()->forget(self::OTP_SESSION_KEY);
        }

        Auth::logout();
        $r->session()->invalidate();
        $r->session()->regenerateToken();
        return redirect()->route('login');
    }
}
