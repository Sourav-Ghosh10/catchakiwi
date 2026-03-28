<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Forgot Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background:#f4ffe4;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .forgot-password-container {
            width: 100%;
            max-width: 480px;
        }

        .forgot-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            animation: slideUp 0.5s ease;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card-header {
            background:#9bcd22;
            padding: 40px 30px;
            text-align: center;
            color: white;
        }

        .card-header h2 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .card-header p {
            font-size: 15px;
            opacity: 0.9;
            margin: 0;
        }

        .icon-container {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }

        .icon-container i {
            font-size: 36px;
            color: white;
        }

        .card-body {
            padding: 40px 30px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 10px;
            display: block;
            font-size: 14px;
        }

        .form-label i {
            margin-right: 8px;
            color: #8ac23a;
        }

        .form-control {
            width: 100%;
            padding: 15px 20px;
            border: 2px solid #e1e8ed;
            border-radius: 12px;
            font-size: 15px;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .form-control:focus {
            outline: none;
            border-color: #9bcd22;
            background: white;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }

        .form-control.is-invalid {
            border-color: #dc3545;
            background: #fff5f5;
        }

        .invalid-feedback {
            color: #dc3545;
            font-size: 13px;
            margin-top: 8px;
            display: block;
        }

        .btn-primary {
            width: 100%;
            padding: 15px;
            background: #f78e07;
            border: none;
            border-radius: 12px;
            color: white;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-primary:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .alert {
            padding: 15px 20px;
            border-radius: 12px;
            margin-bottom: 25px;
            border: none;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
        }

        .alert i {
            font-size: 18px;
        }

        .back-to-login {
            text-align: center;
            margin-top: 25px;
            padding-top: 25px;
            border-top: 1px solid #e1e8ed;
        }

        .back-to-login a {
            color: #8ac23a;
            text-decoration: none;
            font-weight: 600;
            font-size: 15px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .back-to-login a:hover {
            gap: 12px;
            color: #764ba2;
        }

        .info-box {
            background: #f0f4ff;
            padding: 20px;
            border-radius: 12px;
            border-left: 4px solid #9bcd22;
            margin-bottom: 25px;
        }

        .info-box p {
            margin: 0;
            color: #555;
            font-size: 14px;
            line-height: 1.6;
        }

        .spinner {
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        @media (max-width: 576px) {
            .card-header {
                padding: 30px 20px;
            }

            .card-header h2 {
                font-size: 24px;
            }

            .card-body {
                padding: 30px 20px;
            }

            .icon-container {
                width: 70px;
                height: 70px;
            }

            .icon-container i {
                font-size: 30px;
            }
        }
    </style>
</head>
<body>
    <div class="forgot-password-container">
      <div class="container"><div class="logo"><h1><a href="https://catchakiwi.com/"><img src="{{ asset('assets/images/logo-inner.png') }}" alt="" style="max-width: 330px; margin: 0 auto;
 display: block;" /></a></h1></div></div>
        <div class="forgot-card">
            <div class="card-header">
                <div class="icon-container">
                    <i class="fas fa-lock"></i>
                </div>
                <h2>Forgot Password?</h2>
                <p>Don't worry, we'll send you an OTP to reset it</p>
            </div>

            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                <div class="info-box">
                    <p><i class="fas fa-info-circle" style="color: #8ac23a;"></i> Enter your registered email address and we'll send you a 6-digit OTP to reset your password.</p>
                </div>

                <form action="{{ route('password.send.otp') }}" method="POST" id="forgotForm">
                    @csrf
                    
                    <div class="form-group">
                        <label for="email" class="form-label">
                            <i class="fas fa-envelope"></i>Email Address
                        </label>
                        <input 
                            type="email" 
                            class="form-control @error('email') is-invalid @enderror" 
                            id="email" 
                            name="email" 
                            value="{{ old('email') }}"
                            placeholder="Enter your registered email"
                            required
                            autofocus
                        >
                        @error('email')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="btn-primary" id="submitBtn">
                        <i class="fas fa-paper-plane"></i>
                        <span id="btnText">Send OTP</span>
                        <div class="spinner" id="spinner" style="display: none;"></div>
                    </button>
                </form>

                <div class="back-to-login">
                    <a href="{{ route('login') }}">
                        <i class="fas fa-arrow-left"></i>
                        <span>Back to Login</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Form submission with loading state
        document.getElementById('forgotForm').addEventListener('submit', function() {
            const btn = document.getElementById('submitBtn');
            const btnText = document.getElementById('btnText');
            const spinner = document.getElementById('spinner');
            
            btn.disabled = true;
            btnText.textContent = 'Sending...';
            spinner.style.display = 'block';
        });

        // Auto-dismiss alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                alert.style.animation = 'slideUp 0.3s ease reverse';
                setTimeout(function() {
                    alert.style.display = 'none';
                }, 300);
            });
        }, 5000);
    </script>
</body>
</html>