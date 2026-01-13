<!DOCTYPE html>
<html dir="ltr" lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Halaman Login Emina Beauty">
    <meta name="author" content="Emina Beauty">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('backend/image/logo_emina.png') }}">
    <title>Masuk - Emina Beauty</title>
    <link href="{{ asset('backend/dist/css/style.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            overflow: hidden;
        }
        
        /* Split Screen Layout */
        .login-container {
            display: flex;
            min-height: 100vh;
        }
        
        /* Left Side - Decorative */
        .left-side {
            flex: 1;
            background: linear-gradient(135deg, #f58b95 0%, #ff6b9d 50%, #f093fb 100%);
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }
        
        /* Animated Shapes */
        .shape {
            position: absolute;
            opacity: 0.3;
        }
        
        .shape-1 {
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            top: -100px;
            left: -100px;
            animation: float1 20s infinite ease-in-out;
        }
        
        .shape-2 {
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
            bottom: 50px;
            right: 50px;
            animation: float2 15s infinite ease-in-out;
        }
        
        .shape-3 {
            width: 150px;
            height: 150px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            top: 50%;
            left: 20%;
            animation: float3 18s infinite ease-in-out;
        }
        
        @keyframes float1 {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            50% { transform: translate(50px, 50px) rotate(180deg); }
        }
        
        @keyframes float2 {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            50% { transform: translate(-30px, -30px) rotate(-180deg); }
        }
        
        @keyframes float3 {
            0%, 100% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(20px, -20px) scale(1.2); }
        }
        
        /* Left Content */
        .left-content {
            text-align: center;
            z-index: 10;
            color: white;
            padding: 40px;
        }
        
        .brand-logo {
            width: 180px;
            height: 180px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(20px);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
            animation: logoFloat 3s infinite ease-in-out;
        }
        
        @keyframes logoFloat {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        .brand-logo img {
            width: 120px;
            height: 120px;
            object-fit: contain;
        }
        
        .brand-title {
            font-size: 48px;
            font-weight: 800;
            margin-bottom: 15px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }
        
        .brand-subtitle {
            font-size: 18px;
            font-weight: 300;
            opacity: 0.9;
            line-height: 1.6;
        }
        
        /* Right Side - Form */
        .right-side {
            flex: 1;
            background: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            position: relative;
        }
        
        /* Decorative Corner */
        .corner-decoration {
            position: absolute;
            top: 0;
            right: 0;
            width: 200px;
            height: 200px;
            background: linear-gradient(135deg, rgba(245, 139, 149, 0.1) 0%, transparent 100%);
            border-bottom-left-radius: 100%;
        }
        
        /* Form Container */
        .form-container {
            width: 100%;
            max-width: 450px;
            position: relative;
            z-index: 10;
        }
        
        .form-header {
            margin-bottom: 40px;
        }
        
        .form-header h2 {
            font-size: 36px;
            font-weight: 800;
            color: #333;
            margin-bottom: 10px;
        }
        
        .form-header p {
            color: #999;
            font-size: 15px;
        }
        
        /* Alert */
        .alert-custom {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);
            color: white;
            border: none;
            border-radius: 15px;
            padding: 16px 20px;
            margin-bottom: 25px;
            font-weight: 600;
            box-shadow: 0 8px 20px rgba(255, 107, 107, 0.3);
            display: flex;
            align-items: center;
            gap: 12px;
            animation: slideInDown 0.5s ease;
        }
        
        @keyframes slideInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Input Groups */
        .input-group-custom {
            margin-bottom: 25px;
            position: relative;
        }
        
        .input-group-custom label {
            display: block;
            margin-bottom: 10px;
            color: #333;
            font-weight: 600;
            font-size: 14px;
        }
        
        .input-wrapper {
            position: relative;
        }
        
        .input-icon {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: #f58b95;
            font-size: 20px;
            z-index: 1;
            transition: all 0.3s ease;
        }
        
        .input-custom {
            width: 100%;
            padding: 18px 20px 18px 55px;
            border: 2px solid #f0f0f0;
            border-radius: 15px;
            font-size: 15px;
            transition: all 0.3s ease;
            background: #fafafa;
            color: #333;
            font-weight: 500;
        }
        
        .input-custom::placeholder {
            color: #aaa;
        }
        
        .input-custom:focus {
            outline: none;
            border-color: #f58b95;
            background: white;
            box-shadow: 0 0 0 4px rgba(245, 139, 149, 0.1);
        }
        
        .input-custom:focus ~ .input-icon {
            color: #ff6b9d;
            transform: translateY(-50%) scale(1.1);
        }
        
        .input-custom.is-invalid {
            border-color: #ff6b6b;
            background: #fff5f5;
        }
        
        .invalid-feedback-custom {
            color: #ff6b6b;
            font-size: 13px;
            margin-top: 8px;
            display: flex;
            align-items: center;
            gap: 5px;
            font-weight: 500;
        }
        
        /* Remember & Forgot */
        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }
        
        .remember-check {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #666;
            font-size: 14px;
            cursor: pointer;
        }
        
        .remember-check input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: #f58b95;
        }
        
        .forgot-link {
            color: #f58b95;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .forgot-link:hover {
            color: #ff6b9d;
            text-decoration: underline;
        }
        
        /* Buttons */
        .btn-login {
            width: 100%;
            padding: 18px;
            background: linear-gradient(135deg, #f58b95 0%, #ff6b9d 100%);
            color: white;
            border: none;
            border-radius: 15px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 8px 25px rgba(245, 139, 149, 0.4);
            position: relative;
            overflow: hidden;
        }
        
        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s ease;
        }
        
        .btn-login:hover::before {
            left: 100%;
        }
        
        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(245, 139, 149, 0.6);
        }
        
        .btn-login:active {
            transform: translateY(-1px);
        }
        
        /* Recover Form */
        .recover-form {
            display: none;
        }
        
        .recover-form.active {
            display: block;
            animation: fadeIn 0.5s ease;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        .btn-back {
            width: 100%;
            padding: 15px;
            background: white;
            color: #f58b95;
            border: 2px solid #f58b95;
            border-radius: 15px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 15px;
        }
        
        .btn-back:hover {
            background: #f58b95;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(245, 139, 149, 0.3);
        }
        
        /* Loading */
        .preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #f58b95 0%, #ff6b9d 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            transition: opacity 0.5s ease;
        }
        
        .spinner {
            width: 60px;
            height: 60px;
            border: 5px solid rgba(255, 255, 255, 0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        /* Responsive */
        @media (max-width: 992px) {
            .login-container {
                flex-direction: column;
            }
            
            .left-side {
                min-height: 300px;
            }
            
            .brand-logo {
                width: 120px;
                height: 120px;
            }
            
            .brand-logo img {
                width: 80px;
                height: 80px;
            }
            
            .brand-title {
                font-size: 32px;
            }
            
            .right-side {
                padding: 40px 20px;
            }
        }
        
        @media (max-width: 576px) {
            .form-header h2 {
                font-size: 28px;
            }
        }
    </style>
</head>

<body>
    <!-- Preloader -->
    <div class="preloader">
        <div class="spinner"></div>
    </div>

    <!-- Login Container -->
    <div class="login-container">
        <!-- Left Side -->
        <div class="left-side">
            <!-- Animated Shapes -->
            <div class="shape shape-1"></div>
            <div class="shape shape-2"></div>
            <div class="shape shape-3"></div>
            
            <!-- Brand Content -->
            <div class="left-content">
                <div class="brand-logo">
                    <img src="{{ asset('backend/image/logo_emina.png') }}" alt="Emina Beauty" />
                </div>
                <h1 class="brand-title">Emina Beauty</h1>
                <p class="brand-subtitle">Mitra kecantikan terpercaya Anda<br>untuk kulit yang sehat dan bercahaya</p>
            </div>
        </div>

        <!-- Right Side -->
        <div class="right-side">
            <div class="corner-decoration"></div>
            
            <div class="form-container">
                <!-- Login Form -->
                <div id="loginform">
                    <div class="form-header">
                        <h2>Selamat Datang Kembali! 👋</h2>
                        <p>Silakan masuk untuk mengakses dashboard</p>
                    </div>

                    <!-- Error Alert -->
                    @if (session()->has('error'))
                        <div class="alert-custom">
                            <i class="fas fa-exclamation-circle"></i>
                            <span>{{ session('error') }}</span>
                        </div>
                    @endif

                    <form action="{{ route('backend.login') }}" method="post">
                        @csrf
                        
                        <!-- Email -->
                        <div class="input-group-custom">
                            <label>Alamat Email</label>
                            <div class="input-wrapper">
                                <input type="text" 
                                       name="email" 
                                       value="{{ old('email') }}"
                                       class="input-custom @error('email') is-invalid @enderror"
                                       placeholder="Masukkan email Anda">
                                <i class="ti-email input-icon"></i>
                            </div>
                            @error('email')
                                <span class="invalid-feedback-custom">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="input-group-custom">
                            <label>Kata Sandi</label>
                            <div class="input-wrapper">
                                <input type="password" 
                                       name="password"
                                       class="input-custom @error('password') is-invalid @enderror"
                                       placeholder="Masukkan kata sandi">
                                <i class="ti-lock input-icon"></i>
                            </div>
                            @error('password')
                                <span class="invalid-feedback-custom">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <!-- Options -->
                        <div class="form-options">
                            <label class="remember-check">
                                <input type="checkbox" name="remember">
                                <span>Ingat Saya</span>
                            </label>
                            <a href="javascript:void(0)" class="forgot-link" id="to-recover">Lupa Kata Sandi?</a>
                        </div>

                        <!-- Submit -->
                        <button type="submit" class="btn-login">
                            <i class="fas fa-sign-in-alt"></i> Masuk ke Dashboard
                        </button>
                    </form>
                </div>

                <!-- Recover Form -->
                <div id="recoverform" class="recover-form">
                    <div class="form-header">
                        <h2>Reset Kata Sandi 🔐</h2>
                        <p>Masukkan email Anda untuk menerima instruksi reset</p>
                    </div>

                    <form>
                        <div class="input-group-custom">
                            <label>Alamat Email</label>
                            <div class="input-wrapper">
                                <input type="text" 
                                       class="input-custom"
                                       placeholder="Masukkan email Anda">
                                <i class="ti-email input-icon"></i>
                            </div>
                        </div>

                        <button type="button" class="btn-login">
                            <i class="fas fa-paper-plane"></i> Kirim Tautan Reset
                        </button>

                        <button type="button" class="btn-back" id="to-login">
                            <i class="fas fa-arrow-left"></i> Kembali ke Masuk
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('backend/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('backend/libs/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    
    <script>
        $(document).ready(function() {
            // Hide preloader
            setTimeout(function() {
                $(".preloader").fadeOut(500);
            }, 800);

            // Switch forms
            $('#to-recover').click(function() {
                $("#loginform").fadeOut(300, function() {
                    $("#recoverform").addClass('active').fadeIn(300);
                });
            });

            $('#to-login').click(function() {
                $("#recoverform").fadeOut(300, function() {
                    $("#recoverform").removeClass('active');
                    $("#loginform").fadeIn(300);
                });
            });
        });
    </script>
</body>

</html>