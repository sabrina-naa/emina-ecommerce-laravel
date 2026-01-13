@extends('frontend.layouts.app')

@section('title', 'Register - Emina Beauty')

@section('content')

<section class="py-20 bg-gradient-to-br from-bg-light to-white min-h-screen flex items-center">
    <div class="container mx-auto px-4">
        <div class="max-w-md mx-auto">
            
            <!-- Logo/Header -->
            <div class="text-center mb-8">
                <div class="inline-block bg-gradient-to-r from-primary to-accent rounded-full p-6 mb-4">
                    <i class="fas fa-user-plus text-white text-4xl"></i>
                </div>
                <h1 class="text-3xl font-bold text-gray-800 mb-2">
                    Daftar Sekarang! ✨
                </h1>
                <p class="text-gray-600">Bergabung dan dapatkan promo spesial</p>
            </div>

            <!-- Register Form -->
            <div class="bg-white rounded-3xl shadow-2xl p-8">
                <form action="{{ route('customer.register') }}" method="POST">
                    @csrf

                    <!-- Nama -->
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-user text-primary mr-1"></i> Nama Lengkap
                        </label>
                        <input type="text" name="nama" value="{{ old('nama') }}" 
                               class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent transition @error('nama') border-red-500 @enderror"
                               placeholder="Nama lengkap kamu" required>
                        @error('nama')
                            <p class="text-red-500 text-xs mt-1">
                                <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-envelope text-primary mr-1"></i> Email
                        </label>
                        <input type="email" name="email" value="{{ old('email') }}" 
                               class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent transition @error('email') border-red-500 @enderror"
                               placeholder="email@example.com" required>
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">
                                <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- No HP -->
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-phone text-primary mr-1"></i> No. HP/WhatsApp
                        </label>
                        <input type="text" name="no_hp" value="{{ old('no_hp') }}" 
                               class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent transition @error('no_hp') border-red-500 @enderror"
                               placeholder="08123456789" required>
                        @error('no_hp')
                            <p class="text-red-500 text-xs mt-1">
                                <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-lock text-primary mr-1"></i> Password
                        </label>
                        <div class="relative">
                            <input type="password" name="password" id="password"
                                   class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent transition @error('password') border-red-500 @enderror"
                                   placeholder="Minimal 4 karakter" required>
                            <button type="button" onclick="togglePassword('password', 'toggleIcon1')" 
                                    class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 hover:text-primary">
                                <i class="fas fa-eye" id="toggleIcon1"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-red-500 text-xs mt-1">
                                <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-lock text-primary mr-1"></i> Konfirmasi Password
                        </label>
                        <div class="relative">
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                   class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent transition"
                                   placeholder="Ketik ulang password" required>
                            <button type="button" onclick="togglePassword('password_confirmation', 'toggleIcon2')" 
                                    class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 hover:text-primary">
                                <i class="fas fa-eye" id="toggleIcon2"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Terms & Conditions -->
                    <div class="mb-6">
                        <label class="flex items-start">
                            <input type="checkbox" required class="w-5 h-5 text-primary border-gray-300 rounded focus:ring-primary mt-0.5">
                            <span class="ml-3 text-sm text-gray-600">
                                Saya setuju dengan <a href="#" class="text-primary hover:text-accent font-semibold">Syarat & Ketentuan</a> 
                                dan <a href="#" class="text-primary hover:text-accent font-semibold">Kebijakan Privasi</a>
                            </span>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" 
                            class="w-full bg-gradient-to-r from-primary to-accent text-white py-4 rounded-xl font-bold text-lg hover:shadow-xl transition transform hover:scale-105 mb-4">
                        <i class="fas fa-user-plus mr-2"></i> Daftar Sekarang
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

                    <!-- Login Link -->
                    <div class="text-center">
                        <p class="text-gray-600 mb-3">Sudah punya akun?</p>
                        <a href="{{ route('customer.login') }}" 
                           class="block w-full bg-white border-2 border-primary text-primary py-3 rounded-xl font-bold hover:bg-primary hover:text-white transition">
                            <i class="fas fa-sign-in-alt mr-2"></i> Login
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

            <!-- Benefits -->
            <div class="mt-8 grid grid-cols-3 gap-4 text-center">
                <div class="bg-white p-4 rounded-xl shadow-md">
                    <i class="fas fa-gift text-primary text-2xl mb-2"></i>
                    <p class="text-xs text-gray-600 font-semibold">Promo Eksklusif</p>
                </div>
                <div class="bg-white p-4 rounded-xl shadow-md">
                    <i class="fas fa-shipping-fast text-primary text-2xl mb-2"></i>
                    <p class="text-xs text-gray-600 font-semibold">Gratis Ongkir</p>
                </div>
                <div class="bg-white p-4 rounded-xl shadow-md">
                    <i class="fas fa-star text-primary text-2xl mb-2"></i>
                    <p class="text-xs text-gray-600 font-semibold">Rewards</p>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
    // Toggle Password Visibility
    function togglePassword(inputId, iconId) {
        const passwordInput = document.getElementById(inputId);
        const toggleIcon = document.getElementById(iconId);
        
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

    @if(session('success'))
        alert('{{ session('success') }}');
    @endif

    @if(session('error'))
        alert('{{ session('error') }}');
    @endif
</script>
@endpush