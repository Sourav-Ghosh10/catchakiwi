<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;

class IpLocate
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Session::has('CountryCode')){
            
        } else {
            $userIP = $_SERVER['REMOTE_ADDR'];

            if ($userIP == '127.0.0.1' || $userIP == '::1' || !filter_var($userIP, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
                session(['CountryCode' => 'NZ', 'Country' => 'New Zealand', 'location' => 'NZ-New Zealand']);
                return $next($request);
            }

            $url = "http://ip-api.com/json/$userIP";
            // Initialize cURL
            $curl = curl_init($url);
            
            // Set cURL options
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            
            // Execute the cURL request
            $response = curl_exec($curl);
            
            // Check for errors
            if ($response === false) {
                echo "Error: " . curl_error($curl);
                exit;
            }
            
            // Close cURL
            curl_close($curl);
            
            // Decode the JSON response
            $data = json_decode($response, true);
            
            $countryCode = $data['countryCode'] ?? 'NZ';
            $country = $data['country'] ?? 'New Zealand';

            session(['ipData' => $data]);
            session(['location' => $countryCode."-".$country]);
            session(['CountryCode' => $countryCode]);
            session(['Country' => $country]);
        }
        return $next($request);
    }
}

