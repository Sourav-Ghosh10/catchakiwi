<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Verify OTP & Reset Password</title>
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
            background: #f4ffe4;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .verify-container {
            width: 100%;
            max-width: 520px;
        }

        .verify-card {
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

        .email-badge {
            background: linear-gradient(135deg, #f0f4ff 0%, #e8ecff 100%);
            padding: 15px 20px;
            border-radius: 12px;
            text-align: center;
            margin-bottom: 30px;
            border: 2px solid #d0d9ff;
        }

        .email-badge i {
            color: #8ac23a;
            margin-right: 8px;
        }

        .email-badge span {
            color: #000;
            font-weight: 600;
            font-size: 15px;
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
            border-color: #8ac23a;
            background: white;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }

        .form-control.is-invalid {
            border-color: #dc3545;
            background: #fff5f5;
        }

        .otp-input {
            text-align: center;
            font-size: 32px;
            font-weight: 700;
            letter-spacing: 15px;
            color: #667eea;
        }

        .password-field {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #999;
            font-size: 18px;
            transition: color 0.3s;
        }

        .password-toggle:hover {
            color: #667eea;
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
            background:#f78e07;
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
            margin-bottom: 15px;
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

        .btn-secondary {
            width: 100%;
            padding: 15px;
            background: white;
            border: 2px solid #e1e8ed;
            border-radius: 12px;
            color: #555;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-secondary:hover {
            border-color: #667eea;
            color: #667eea;
            background: #f0f4ff;
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

        .resend-section {
            text-align: center;
            margin-top: 25px;
            padding-top: 25px;
            border-top: 1px solid #e1e8ed;
        }

        .resend-section p {
            color: #666;
            font-size: 14px;
            margin-bottom: 10px;
        }

        .resend-section button {
            background: none;
            border: none;
            color: #8ac23a;
            font-weight: 600;
            cursor: pointer;
            text-decoration: underline;
            font-size: 15px;
            transition: color 0.3s;
        }

        .resend-section button:hover {
            color: #764ba2;
        }

        .timer {
            display: inline-block;
            color: #667eea;
            font-weight: 600;
            margin-left: 5px;
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

        .password-strength {
            height: 4px;
            background: #e1e8ed;
            border-radius: 2px;
            margin-top: 10px;
            overflow: hidden;
        }

        .password-strength-bar {
            height: 100%;
            width: 0%;
            transition: all 0.3s ease;
            border-radius: 2px;
        }

        .strength-weak { background: #dc3545; width: 33%; }
        .strength-medium { background: #ffc107; width: 66%; }
        .strength-strong { background: #28a745; width: 100%; }

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

            .otp-input {
                font-size: 24px;
                letter-spacing: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="verify-container">
  <div class="container"><div class="logo"><h1><a href="https://catchakiwi.com/"><img src="{{ asset('assets/images/logo-inner.png') }}" alt="" style="max-width: 330px; margin: 0 auto;
 display: block;" /></a></h1></div></div>
        <div class="verify-card">
            <div class="card-header">
                <div class="icon-container">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h2>Verify OTP</h2>
                <p>Enter the OTP sent to your email</p>
            </div>

            <div class="card-body">
                <div class="email-badge">
                    <i class="fas fa-envelope"></i>
                    <span>{{ $email }}</span>
                </div>

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

                <form action="{{ route('password.reset') }}" method="POST" id="verifyForm">
                    @csrf
                    <input type="hidden" name="email" value="{{ $email }}">

                    <div class="form-group">
                        <label for="otp" class="form-label">
                            <i class="fas fa-key"></i>Enter 6-Digit OTP
                        </label>
                        <input 
                            type="text" 
                            class="form-control otp-input @error('otp') is-invalid @enderror" 
                            id="otp" 
                            name="otp" 
                            maxlength="6"
                            placeholder="000000"
                            value="{{ old('otp') }}"
                            required
                            autofocus
                            autocomplete="off"
                        >
                        @error('otp')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                        <small style="color: #999; font-size: 12px; display: block; margin-top: 8px;">
                            <i class="far fa-clock"></i> OTP will expire in <span class="timer" id="timer">10:00</span>
                        </small>
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">
                            <i class="fas fa-lock"></i>New Password
                        </label>
                        <div class="password-field">
                            <input 
                                type="password" 
                                class="form-control @error('password') is-invalid @enderror" 
                                id="password" 
                                name="password" 
                                placeholder="Enter new password (min 8 characters)"
                                required
                            >
                            <i class="fas fa-eye password-toggle" id="togglePassword"></i>
                        </div>
                        <div class="password-strength">
                            <div class="password-strength-bar" id="strengthBar"></div>
                        </div>
                        @error('password')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">
                            <i class="fas fa-lock"></i>Confirm New Password
                        </label>
                        <div class="password-field">
                            <input 
                                type="password" 
                                class="form-control" 
                                id="password_confirmation" 
                                name="password_confirmation" 
                                placeholder="Re-enter new password"
                                required
                            >
                            <i class="fas fa-eye password-toggle" id="togglePasswordConfirm"></i>
                        </div>
                    </div>

                    <button type="submit" class="btn-primary" id="submitBtn">
                        <i class="fas fa-check-circle"></i>
                        <span id="btnText">Reset Password</span>
                        <div class="spinner" id="spinner" style="display: none;"></div>
                    </button>

                    <a href="{{ route('password.request') }}" class="btn-secondary">
                        <i class="fas fa-arrow-left"></i>
                        <span>Back</span>
                    </a>
                </form>

                <div class="resend-section">
                    <p>Didn't receive the OTP?</p>
                    <form action="{{ route('password.resend.otp') }}" method="POST" id="resendForm" style="display: inline;">
                        @csrf
                        <input type="hidden" name="email" value="{{ $email }}">
                        <button type="submit" id="resendBtn">
                            <i class="fas fa-redo"></i> Resend OTP
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // OTP input - only allow numbers
        const otpInput = document.getElementById('otp');
        otpInput.addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });

        // Auto-submit when OTP is 6 digits (optional)
        otpInput.addEventListener('input', function() {
            if (this.value.length === 6) {
                // Optional: auto-focus to password field
                // document.getElementById('password').focus();
            }
        });

        // Password visibility toggle
        document.getElementById('togglePassword').addEventListener('click', function() {
            const password = document.getElementById('password');
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });

        document.getElementById('togglePasswordConfirm').addEventListener('click', function() {
            const password = document.getElementById('password_confirmation');
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });

        // Password strength indicator
        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            const strengthBar = document.getElementById('strengthBar');
            
            strengthBar.className = 'password-strength-bar';
            
            if (password.length === 0) {
                strengthBar.style.width = '0%';
            } else if (password.length < 6) {
                strengthBar.classList.add('strength-weak');
            } else if (password.length < 10) {
                strengthBar.classList.add('strength-medium');
            } else {
                strengthBar.classList.add('strength-strong');
            }
        });

        // Countdown timer (10 minutes)
        let timeLeft = 600; // 10 minutes in seconds
        const timerElement = document.getElementById('timer');
        
        const countdown = setInterval(function() {
            timeLeft--;
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            timerElement.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
            
            if (timeLeft <= 0) {
                clearInterval(countdown);
                timerElement.textContent = 'EXPIRED';
                timerElement.style.color = '#dc3545';
            } else if (timeLeft <= 60) {
                timerElement.style.color = '#dc3545';
            }
        }, 1000);

        // Form submission with loading state
        document.getElementById('verifyForm').addEventListener('submit', function() {
            const btn = document.getElementById('submitBtn');
            const btnText = document.getElementById('btnText');
            const spinner = document.getElementById('spinner');
            
            btn.disabled = true;
            btnText.textContent = 'Resetting...';
            spinner.style.display = 'block';
        });

        // Resend OTP with loading state
        document.getElementById('resendForm').addEventListener('submit', function(e) {
            const btn = document.getElementById('resendBtn');
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';
            
            // Reset timer
            timeLeft = 600;
            timerElement.style.color = '#667eea';
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

        // Password match validation
        document.getElementById('password_confirmation').addEventListener('input', function() {
            const password = document.getElementById('password').value;
            const confirmPassword = this.value;
            
            if (confirmPassword && password !== confirmPassword) {
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-invalid');
            }
        });
    </script>
</body>
</html>