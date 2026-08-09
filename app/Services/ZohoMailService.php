<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class ZohoMailService
{
    protected string $fromAddress = 'support@catchakiwi.co.nz';

    protected ?string $accountId;

    protected ?string $clientId;

    protected ?string $clientSecret;

    protected ?string $refreshToken;

    public function __construct()
    {
        $this->accountId = config('services.zoho.account_id');
        $this->clientId = config('services.zoho.client_id');
        $this->clientSecret = config('services.zoho.client_secret');
        $this->refreshToken = config('services.zoho.refresh_token');
    }

    /**
     * Get a fresh Zoho OAuth access token using the refresh token.
     */
    private function getAccessToken(): ?string
    {
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => 'https://accounts.zoho.com/oauth/v2/token',
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query([
                'refresh_token' => $this->refreshToken,
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
                'grant_type' => 'refresh_token',
            ]),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_TIMEOUT => 30,
        ]);

        $response = curl_exec($ch);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($curlError) {
            Log::error('ZohoMailService: Token cURL Error: '.$curlError);

            return null;
        }

        $data = json_decode($response, true);

        if (empty($data['access_token'])) {
            Log::error('ZohoMailService: Access token missing from response', $data ?? []);

            return null;
        }

        return $data['access_token'];
    }

    /**
     * Send an email via Zoho Mail API.
     *
     * @param  string|array  $to  Single address or array of addresses
     * @param  string  $htmlContent  HTML body content
     * @param  array  $bcc  Optional BCC addresses
     * @param  string|null  $from  Override from address (default: support@catchakiwi.co.nz)
     */
    public function send(
        string|array $to,
        string $subject,
        string $htmlContent,
        array $bcc = [],
        ?string $from = null
    ): bool {
        $accessToken = $this->getAccessToken();

        if (! $accessToken) {
            return false;
        }

        $toAddress = is_array($to) ? implode(',', $to) : $to;
        $fromAddress = $from ?? $this->fromAddress;

        $payload = [
            'fromAddress' => $fromAddress,
            'toAddress' => $toAddress,
            'subject' => $subject,
            'content' => $htmlContent,
        ];

        if (! empty($bcc)) {
            $payload['bccAddress'] = implode(',', $bcc);
        }

        $apiUrl = "https://mail.zoho.com/api/accounts/{$this->accountId}/messages";

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $apiUrl,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => [
                "Authorization: Zoho-oauthtoken {$accessToken}",
                'Content-Type: application/json',
            ],
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_TIMEOUT => 30,
        ]);

        $response = curl_exec($ch);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($curlError) {
            Log::error('ZohoMailService: Send cURL Error: '.$curlError);

            return false;
        }

        $result = json_decode($response, true);

        if (isset($result['status']['code']) && $result['status']['code'] == 200) {
            return true;
        }

        Log::error('ZohoMailService: Send failed', $result ?? ['raw' => $response]);

        return false;
    }

    /**
     * Render a Blade view to HTML string for use as email body.
     */
    public static function renderView(string $view, array $data = []): string
    {
        return view($view, $data)->render();
    }
}
