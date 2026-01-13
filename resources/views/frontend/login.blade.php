@extends('frontend.layouts.app')

@section('title', 'Login - Emina Beauty')

@section('content')

<section class="py-20 bg-gradient-to-br from-bg-light to-white min-h-screen flex items-center">
    <div class="container mx-auto px-4">
        <div class="max-w-md mx-auto">
            
            <!-- Logo/Header -->
            <div class="text-center mb-8">
                <div class="inline-block bg-gradient-to-r from-primary to-accent rounded-full p-6 mb-4">
                    <i class="fas fa-heart text-white text-4xl"></i>
                </div>
                <h1 class="text-3xl font-bold text-gray-800 mb-2">
                    Selamat Datang Kembali! 💕
                </h1>
                <p class="text-gray-600">Login untuk melanjutkan belanja</p>
            </div>

            <!-- Login Form -->
            <div class="bg-white rounded-3xl shadow-2xl p-8">
                <form action="{{ route('customer.login') }}" method="POST">
                    @csrf

                    <!-- Email -->
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-envelope text-primary mr-1"></i> Email
                        </label>
                        <input type="email" name="email" value="{{ old('email') }}" 
                               class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent transition @error('email') border-red-500 @enderror"
                               placeholder="email@example.com" required autofocus>
                        @error('email')
                            <p class="text-red-500 text-xs mt-2">
                                <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-lock text-primary mr-1"></i> Password
                        </label>
                        <div class="relative">
                            <input type="password" name="password" id="password"
                                   class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent transition @error('password') border-red-500 @enderror"
                                   placeholder="Masukkan password" required>
                            <button type="button" onclick="togglePassword()" 
                                    class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 hover:text-primary">
                                <i class="fas fa-eye" id="toggleIcon"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-red-500 text-xs mt-2">
                                <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between mb-6">
                        <label class="flex items-center">
                            <input type="checkbox" name="remember" class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary">
                            <span class="ml-2 text-sm text-gray-600">Ingat saya</span>
                        </label>
                        <a href="#" class="text-sm text-primary hover:text-accent font-semibold">
                            Lupa Password?
                        </a>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" 
                            class="w-full bg-gradient-to-r from-primary to-accent text-white py-4 rounded-xl font-bold text-lg hover:shadow-xl transition transform hover:scale-105 mb-4">
                        <i class="fas fa-sign-in-alt mr-2"></i> Login
                    </button>

                    <!-- Divider -->
                    <div class="relative my-6">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-4 bg-white text-gray-500">atau</span>
                        </div>
                    </div>

                    <!-- Register Link -->
                    <div class="text-center">
                        <p class="text-gray-600 mb-3">Belum punya akun?</p>
                        <a href="{{ route('customer.register') }}" 
                           class="block w-full bg-white border-2 border-primary text-primary py-3 rounded-xl font-bold hover:bg-primary hover:text-white transition">
                            <i class="fas fa-user-plus mr-2"></i> Daftar Sekarang
                        </a>
                    </div>
                </form>
            </div>

            <!-- Back to Home -->
            <div class="text-center mt-6">
                <a href="{{ route('home') }}" class="text-gray-600 hover:text-primary font-semibold">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
    // Toggle Password Visibility
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.getElementById('toggleIcon');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleIcon.classList.remove('fa-eye');
            toggleIcon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            toggleIcon.classList.remove('fa-eye-slash');
            toggleIcon.classList.add('fa-eye');
        }
    }

    // Show messages
    @if(session('success'))
        alert('{{ session('success') }}');
    @endif

    @if(session('error'))
        alert('{{ session('error') }}');
    @endif
</script>
@endpush