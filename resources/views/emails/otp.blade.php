<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Password Reset OTP</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #333333;
            background-color: #f4f4f4;
            padding: 20px;
        }

        .email-wrapper {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .email-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 40px 30px;
            text-align: center;
            color: #ffffff;
        }

        .email-header h1 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .email-header p {
            font-size: 16px;
            opacity: 0.9;
            margin: 0;
        }

        .lock-icon {
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            font-size: 28px;
        }

        .email-body {
            padding: 40px 30px;
        }

        .greeting {
            font-size: 18px;
            font-weight: 600;
            color: #333333;
            margin-bottom: 20px;
        }

        .email-text {
            font-size: 15px;
            color: #555555;
            line-height: 1.8;
            margin-bottom: 30px;
        }

        .otp-container {
            background: linear-gradient(135deg, #f0f4ff 0%, #e8ecff 100%);
            border: 3px dashed #667eea;
            border-radius: 12px;
            padding: 30px;
            text-align: center;
            margin: 30px 0;
        }

        .otp-label {
            font-size: 14px;
            color: #666666;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .otp-code {
            font-size: 48px;
            font-weight: 700;
            color: #667eea;
            letter-spacing: 12px;
            margin: 15px 0;
            font-family: 'Courier New', monospace;
            text-align: center;
        }

        .otp-expiry {
            font-size: 14px;
            color: #dc3545;
            margin-top: 15px;
            font-weight: 600;
        }

        .otp-expiry::before {
            content: "⏰ ";
        }

        .security-notice {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 20px;
            border-radius: 8px;
            margin: 30px 0;
        }

        .security-notice h3 {
            font-size: 16px;
            color: #856404;
            margin-bottom: 12px;
            font-weight: 600;
        }

        .security-notice ul {
            margin: 0;
            padding-left: 20px;
        }

        .security-notice li {
            font-size: 14px;
            color: #856404;
            margin-bottom: 8px;
            line-height: 1.6;
        }

        .info-box {
            background-color: #e7f3ff;
            border-left: 4px solid #2196F3;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }

        .info-box p {
            font-size: 14px;
            color: #0c5460;
            margin: 0;
            line-height: 1.6;
        }

        .email-footer {
            background-color: #f8f9fa;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #e9ecef;
        }

        .email-footer p {
            font-size: 13px;
            color: #6c757d;
            margin: 5px 0;
            line-height: 1.6;
        }

        .email-footer .company-name {
            font-weight: 600;
            color: #667eea;
        }

        .divider {
            height: 1px;
            background: linear-gradient(to right, transparent, #e9ecef, transparent);
            margin: 30px 0;
        }

        @media only screen and (max-width: 600px) {
            body {
                padding: 10px;
            }

            .email-header {
                padding: 30px 20px;
            }

            .email-header h1 {
                font-size: 24px;
            }

            .email-body {
                padding: 30px 20px;
            }

            .otp-code {
                font-size: 36px;
                letter-spacing: 8px;
            }

            .otp-container {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <!-- Header -->
        <div class="email-header">
            <div class="lock-icon">🔒</div>
            <h1>Password Reset Request</h1>
            <p>Secure OTP Verification</p>
        </div>

        <!-- Body -->
        <div class="email-body">
            <div class="greeting">
                Hello {{ $name ?? 'User' }},
            </div>

            <div class="email-text">
                We received a request to reset your password. To proceed with the password reset, please use the One-Time Password (OTP) provided below.
            </div>

            <!-- OTP Box -->
            <div class="otp-container">
                <div class="otp-label">Your One-Time Password</div>
                <div class="otp-code">{{ $otp }}</div>
                <div class="otp-expiry">This OTP will expire in 10 minutes</div>
            </div>

            <div class="email-text">
                Enter this OTP on the password reset page to continue. Please do not share this code with anyone.
            </div>

            <div class="divider"></div>

            <!-- Security Notice -->
            <div class="security-notice">
                <h3>🛡️ Security Information</h3>
                <ul>
                    <li><strong>Never share this OTP</strong> with anyone, including our support team</li>
                    <li>This OTP is <strong>valid for 10 minutes only</strong></li>
                    <li>If you didn't request this, please <strong>ignore this email</strong></li>
                    <li>Consider changing your password if you suspect unauthorized access</li>
                </ul>
            </div>

            <!-- Info Box -->
            <div class="info-box">
                <p>
                    <strong>ℹ️ Didn't request this?</strong><br>
                    If you did not request a password reset, no action is needed. Your account remains secure and this OTP will expire automatically.
                </p>
            </div>

            <div class="email-text" style="margin-top: 30px;">
                If you have any questions or concerns, please contact our support team immediately.
            </div>
        </div>

        <!-- Footer -->
        <div class="email-footer">
            <p><strong>This is an automated message, please do not reply to this email.</strong></p>
            <p style="margin-top: 15px;">
                © {{ date('Y') }} <span class="company-name">{{ config('app.name', 'Your Company') }}</span>. All rights reserved.
            </p>
            <p style="margin-top: 10px; color: #999; font-size: 12px;">
                You received this email because a password reset was requested for your account.
            </p>
        </div>
    </div>
</body>
</html>