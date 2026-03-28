<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Password Changed Successfully</title>
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
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
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

        .success-icon {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            font-size: 40px;
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
            margin-bottom: 20px;
        }

        .success-box {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            border: 2px solid #28a745;
            border-radius: 12px;
            padding: 30px;
            text-align: center;
            margin: 30px 0;
        }

        .success-box-icon {
            font-size: 60px;
            margin-bottom: 15px;
        }

        .success-box h2 {
            font-size: 24px;
            color: #155724;
            margin-bottom: 10px;
            font-weight: 700;
        }

        .success-box p {
            font-size: 15px;
            color: #155724;
            margin: 0;
        }

        .timestamp-box {
            background-color: #f8f9fa;
            border-left: 4px solid #667eea;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }

        .timestamp-box p {
            font-size: 14px;
            color: #495057;
            margin: 5px 0;
            line-height: 1.6;
        }

        .timestamp-box strong {
            color: #333333;
        }

        .warning-box {
            background-color: #fff3cd;
            border: 2px solid #ffc107;
            border-radius: 12px;
            padding: 25px;
            margin: 30px 0;
        }

        .warning-box h3 {
            font-size: 18px;
            color: #856404;
            margin-bottom: 15px;
            font-weight: 700;
        }

        .warning-box h3::before {
            content: "⚠️ ";
            margin-right: 8px;
        }

        .warning-box p {
            font-size: 15px;
            color: #856404;
            margin-bottom: 15px;
            line-height: 1.6;
        }

        .warning-box .action-text {
            font-size: 14px;
            font-weight: 600;
            color: #721c24;
            background-color: #f8d7da;
            padding: 12px;
            border-radius: 8px;
            margin-top: 15px;
        }

        .tips-section {
            background-color: #e7f3ff;
            border-left: 4px solid #2196F3;
            padding: 25px;
            border-radius: 8px;
            margin: 30px 0;
        }

        .tips-section h3 {
            font-size: 16px;
            color: #0c5460;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .tips-section h3::before {
            content: "💡 ";
            margin-right: 8px;
        }

        .tips-section ul {
            margin: 0;
            padding-left: 20px;
        }

        .tips-section li {
            font-size: 14px;
            color: #0c5460;
            margin-bottom: 10px;
            line-height: 1.6;
        }

        .button-container {
            text-align: center;
            margin: 30px 0;
        }

        .button {
            display: inline-block;
            padding: 15px 40px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #ffffff;
            text-decoration: none;
            border-radius: 10px;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .divider {
            height: 1px;
            background: linear-gradient(to right, transparent, #e9ecef, transparent);
            margin: 30px 0;
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

        .contact-info {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #dee2e6;
        }

        .contact-info p {
            font-size: 12px;
            color: #999;
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

            .success-box {
                padding: 20px;
            }

            .success-box h2 {
                font-size: 20px;
            }

            .success-box-icon {
                font-size: 50px;
            }

            .success-icon {
                width: 70px;
                height: 70px;
                font-size: 34px;
            }

            .button {
                padding: 12px 30px;
                font-size: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <!-- Header -->
        <div class="email-header">
            <div class="success-icon">✓</div>
            <h1>Password Changed Successfully</h1>
            <p>Your account is now secure</p>
        </div>

        <!-- Body -->
        <div class="email-body">
            <div class="greeting">
                Hello {{ $name ?? 'User' }},
            </div>

            <div class="email-text">
                This email confirms that your password has been successfully changed. You can now use your new password to log in to your account.
            </div>

            <!-- Success Confirmation Box -->
            <div class="success-box">
                <div class="success-box-icon">🎉</div>
                <h2>Password Updated!</h2>
                <p>Your password has been securely updated and is now active.</p>
            </div>

            <!-- Timestamp Information -->
            <div class="timestamp-box">
                <p><strong>Change Details:</strong></p>
                <p>📅 Date: <strong>{{ date('F d, Y') }}</strong></p>
                <p>🕐 Time: <strong>{{ date('h:i A') }}</strong></p>
                <p>🌐 Timezone: <strong>{{ date('T') }}</strong></p>
            </div>

            <div class="divider"></div>

            <!-- Warning Box -->
            <div class="warning-box">
                <h3>Didn't make this change?</h3>
                <p>
                    If you did not request or authorize this password change, your account may have been compromised. 
                    Please take immediate action to secure your account.
                </p>
                <div class="action-text">
                    ⚡ Contact our support team immediately at: <strong>{{ config('mail.from.address', 'support@example.com') }}</strong>
                </div>
            </div>

            <!-- Security Tips -->
            <div class="tips-section">
                <h3>Security Best Practices</h3>
                <ul>
                    <li><strong>Use a strong password:</strong> Combine uppercase, lowercase, numbers, and special characters</li>
                    <li><strong>Never share your password:</strong> Keep it confidential, even from support staff</li>
                    <li><strong>Change passwords regularly:</strong> Update your password every 3-6 months</li>
                    <li><strong>Use unique passwords:</strong> Don't reuse passwords across different accounts</li>
                    <li><strong>Enable two-factor authentication:</strong> Add an extra layer of security if available</li>
                </ul>
            </div>

            <div class="email-text" style="margin-top: 30px;">
                If you have any questions or need assistance, please don't hesitate to contact our support team.
            </div>

            <!-- Login Button -->
            <div class="button-container">
                <a href="{{ config('app.url') }}/login" class="button">
                    Login to Your Account →
                </a>
            </div>
        </div>

        <!-- Footer -->
        <div class="email-footer">
            <p><strong>This is an automated message, please do not reply to this email.</strong></p>
            <p style="margin-top: 15px;">
                © {{ date('Y') }} <span class="company-name">{{ config('app.name', 'Your Company') }}</span>. All rights reserved.
            </p>
            
            <div class="contact-info">
                <p>
                    You received this email because your password was changed on your account.<br>
                    If you have concerns about your account security, please contact us immediately.
                </p>
            </div>
        </div>
    </div>
</body>
</html>