<?php
namespace App\Http\Controllers;

use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Support\Facades\Route;
class CustomAuthenticatedSessionController extends AuthenticatedSessionController
{
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        // Fetch the user to check their status before attempting login
        $user = User::where('email', $credentials['email'])->first();

        if ($user && $user->status == 1) {
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();

                // Update user login tracking fields
                $user->update([
                    'last_login_ip' => $request->ip(),
                    'last_login_country' => $this->getUserCountry($request->ip()),
                    'last_login_at' => now(),
                    'login_count' => $user->login_count + 1,
                ]);

                if ($request->has('redirect')) {
                    return redirect('/' . $request->post('redirect'));
                } elseif ($request->has('redirectto')) {
                    return redirect()->to($request->post('redirectto'));
                } else {
                    return redirect(RouteServiceProvider::HOME);
                }
            }
        }

        return back()->withErrors([
            //'email' => 'The provided credentials do not match our records or your account is inactive.',
            'email' => '',
        ]);
    }
    private function getUserCountry($ip)
    {
        if ($ip == '127.0.0.1' || $ip == '::1' || !filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
            return 'Local';
        }

        try {
            // Using ipinfo.io (free tier available)
            // Use @ to suppress warnings and check result
            $response = @file_get_contents("http://ipinfo.io/{$ip}/country");
            return $response !== false ? trim($response) : 'Unknown';

        } catch (\Throwable $e) {
            return 'Unknown';
        }
    }
}
?>
