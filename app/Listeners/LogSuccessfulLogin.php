<?php
namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;

class LogSuccessfulLogin
{
    public function handle(Login $event)
    {
        if (Auth::guard('admin')->check()) {
            return; 
        }
        $user = $event->user;
        $ip = Request::ip();
        $user->last_login_ip = $ip;
        //$location = Location::get($ip);
        if ($ip == '127.0.0.1' || $ip == '::1') {
            $user->last_login_country = 'Local';
        } else {
            $response = @file_get_contents("http://ip-api.com/json/{$ip}");
            $locationData = $response ? json_decode($response, true) : null;
            $user->last_login_country = $locationData['country'] ?? 'Unknown';
        }
        $user->last_login_at = now();
        $user->login_count = ($user->login_count ?? 0) + 1;
        $user->save();
    }
}
