<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PasswordResetOtp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class ForgotPasswordController extends Controller
{
    /**
     * Display the forgot password form (Step 1)
     * Route: GET /forgot-password
     */
    public function showEmailForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Display the OTP verification form (Step 2)
     * Route: GET /forgot-password/verify
     */
    public function showOtpForm(Request $request)
    {
        // Check if email is provided in the query string
        if (!$request->has('email')) {
            return redirect()->route('password.request')
                ->with('error', 'Email is required');
        }

        return view('auth.verify-otp', ['email' => $request->email]);
    }

    /**
     * Send OTP to user's email (Step 1 - Process)
     * Route: POST /forgot-password/send-otp
     */
    public function sendOtp(Request $request)
    {
        // Validate email
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $email = $request->email;

        // Check if user is active
        $user = User::where('email', $email)->first();

        if ($user->status != '1') {
            return back()
                ->with('error', 'Account is inactive. Please contact support.')
                ->withInput();
        }

        // Delete any existing OTPs for this email
        PasswordResetOtp::where('email', $email)->delete();

        // Generate new 6-digit OTP
        $otp = PasswordResetOtp::generateOtp();

        // Store OTP in database (expires in 10 minutes)
        PasswordResetOtp::create([
            'email' => $email,
            'otp' => $otp,
            'expires_at' => Carbon::now()->addMinutes(10)
        ]);

        try {
            $this->sendZohoMail($user->name, $email, 'Password Reset OTP - Your Account', view('emails.otp', ['otp' => $otp, 'name' => $user->name])->render());

            return redirect()->route('password.otp.form', ['email' => $email])
                ->with('success', 'OTP sent successfully to your email. It will expire in 10 minutes. Please check your inbox or spam folder.');

        } catch (\Exception $e) {
            return back()
                ->with('error', 'Failed to send OTP. Error: ' . $e->getMessage())
                ->withInput();
        }
    }
	private function sendZohoMail($name, $toEmail, $subject, $htmlContent)
    {
        // === Step 1: Exchange Refresh Token for Access Token ===
        $client_id = env('ZOHO_CLIENT_ID');
        $client_secret = env('ZOHO_CLIENT_SECRET');
        $refresh_token = env('ZOHO_REFRESH_TOKEN');
        $token_url = "https://accounts.zoho.com/oauth/v2/token";

        $tokenData = [
            "refresh_token" => $refresh_token,
            "client_id" => $client_id,
            "client_secret" => $client_secret,
            "grant_type" => "refresh_token"
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $token_url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($tokenData));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        $tokenResponse = json_decode($response, true);
        if (!isset($tokenResponse['access_token'])) {
            throw new \Exception("Unable to get Zoho access token: " . $response);
        }

        $access_token = $tokenResponse['access_token'];

        // === Step 2: Send Email via Zoho Mail API ===
        $account_id = env('ZOHO_ACCOUNT_ID'); // Replace with your Zoho Mail Account ID
        $api_url = "https://mail.zoho.com/api/accounts/{$account_id}/messages";

        $mailData = [
            "fromAddress" => "support@catchakiwi.co.nz",
            "toAddress"   => trim(strtolower($toEmail)),
            "subject"     => $subject,
            "content"     => $htmlContent,
            //"contentType" => "html"
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Zoho-oauthtoken {$access_token}",
            "Content-Type: application/json"
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($mailData));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $sendResponse = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($sendResponse, true);

        if (isset($result['errorCode'])) {
            throw new \Exception("Zoho Mail API Error: " . $result['message']);
        }

        return true;
    }


    /**
     * Verify OTP and reset password (Step 2 - Process)
     * Route: POST /forgot-password/reset
     */
    public function resetPassword(Request $request)
    {
        // Validate input
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'otp' => 'required|digits:6',
            'password' => 'required|min:8|confirmed'
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput($request->except('password', 'password_confirmation'));
        }

        // Find the OTP record
        $otpRecord = PasswordResetOtp::where('email', $request->email)
            ->where('otp', $request->otp)
            ->first();

        // Check if OTP exists
        if (!$otpRecord) {
            return back()
                ->with('error', 'Invalid OTP. Please check and try again.')
                ->withInput($request->except('password', 'password_confirmation'));
        }

        // Check if OTP is expired
        if ($otpRecord->isExpired()) {
            $otpRecord->delete();
            return back()
                ->with('error', 'OTP has expired. Please request a new one.')
                ->withInput($request->except('password', 'password_confirmation'));
        }

        // Find user and update password
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()
                ->with('error', 'User not found')
                ->withInput($request->except('password', 'password_confirmation'));
        }

        // Update password
        $user->password = Hash::make($request->password);
        $user->save();

        // Delete the used OTP
        $otpRecord->delete();

        // Send password changed confirmation email via Zoho Mail API
        try {
            $this->sendZohoMail(
                $user->name,
                $user->email,
                'Password Changed Successfully',
                view('emails.password-changed', ['name' => $user->name])->render()
            );
        } catch (\Exception $e) {
            // Continue even if confirmation email fails
        }

        // Redirect to login page with success message
        return redirect()->route('login')
            ->with('success', 'Password reset successfully! You can now login with your new password.');
    }


    /**
     * Resend OTP to user's email
     * Route: POST /forgot-password/resend-otp
     */
    public function resendOtp(Request $request)
    {
        // Validate email
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email'
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $email = $request->email;
        $user = User::where('email', $email)->first();

        // Delete existing OTPs
        PasswordResetOtp::where('email', $email)->delete();

        // Generate new OTP
        $otp = PasswordResetOtp::generateOtp();

        // Store new OTP
        PasswordResetOtp::create([
            'email' => $email,
            'otp' => $otp,
            'expires_at' => Carbon::now()->addMinutes(10)
        ]);

        // Send new OTP using Zoho Mail API helper
        try {
            $this->sendZohoMail(
                $user->name,
                $email,
                'Password Reset OTP - Your Account',
                view('emails.otp', ['otp' => $otp, 'name' => $user->name])->render()
            );

            return back()
                ->with('success', 'New OTP sent successfully to your email. Please check your inbox or spam folder.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Failed to send OTP. Error: ' . $e->getMessage())
                ->withInput();
        }
    }

}