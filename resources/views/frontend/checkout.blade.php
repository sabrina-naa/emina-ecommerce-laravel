@extends('frontend.layouts.app')

@section('title', 'Checkout - Emina Beauty')

@section('content')

{{-- Breadcrumb --}}
<div class="bg-gray-50 border-b">
    <div class="container mx-auto px-4 py-3">
        <nav class="flex items-center text-sm overflow-x-auto" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="text-gray-500 hover:text-primary transition whitespace-nowrap">
                <i class="fas fa-home mr-1"></i>Home
            </a>
            <i class="fas fa-chevron-right mx-2 text-gray-400 text-xs"></i>
            <a href="{{ route('cart.index') }}" class="text-gray-500 hover:text-primary transition whitespace-nowrap">Keranjang</a>
            <i class="fas fa-chevron-right mx-2 text-gray-400 text-xs"></i>
            <span class="text-gray-800 font-medium whitespace-nowrap">Checkout</span>
        </nav>
    </div>
</div>

{{-- Checkout Section --}}
<section class="py-4 md:py-6 bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4">

        <form action="{{ route('checkout.process') }}" method="POST" id="checkoutForm">
            @csrf
            
            <div class="flex flex-col lg:flex-row gap-4">
                
                {{-- Form Section --}}
                <div class="flex-1 space-y-4">
                    
                    {{-- Alamat Pengiriman --}}
                    <div class="bg-white rounded-lg shadow-sm p-4">
                        <div class="flex items-center gap-2 mb-4 pb-3 border-b">
                            <i class="fas fa-map-marker-alt text-primary"></i>
                            <h3 class="font-semibold text-gray-800">Alamat Pengiriman</h3>
                        </div>
                        
                        <div class="space-y-3">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Nama Lengkap <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="nama_customer" 
                                           value="{{ old('nama_customer', $customer->nama ?? '') }}" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-1 focus:ring-primary focus:border-primary @error('nama_customer') border-red-500 @enderror"
                                           placeholder="Masukkan nama lengkap" required>
                                    @error('nama_customer')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        No. Telepon <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="no_hp" 
                                           value="{{ old('no_hp', $customer->no_hp ?? '') }}" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-1 focus:ring-primary focus:border-primary @error('no_hp') border-red-500 @enderror"
                                           placeholder="08123456789" required>
                                    @error('no_hp')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <input type="email" name="email_customer" 
                                       value="{{ old('email_customer', $customer->email ?? '') }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-1 focus:ring-primary focus:border-primary @error('email_customer') border-red-500 @enderror"
                                       placeholder="email@example.com" required>
                                @error('email_customer')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Alamat Lengkap <span class="text-red-500">*</span>
                                </label>
                                <textarea name="alamat_lengkap" rows="3" 
                                          class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-1 focus:ring-primary focus:border-primary @error('alamat_lengkap') border-red-500 @enderror"
                                          placeholder="Nama jalan, gedung, no. rumah" required>{{ old('alamat_lengkap', $customer->alamat ?? '') }}</textarea>
                                @error('alamat_lengkap')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Catatan untuk Kurir (Opsional)
                                </label>
                                <input type="text" name="catatan" 
                                       value="{{ old('catatan') }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-1 focus:ring-primary focus:border-primary"
                                       placeholder="Contoh: Warna rumah, Patokan">
                            </div>
                        </div>
                    </div>

                    {{-- Metode Pengiriman --}}
                    <div class="bg-white rounded-lg shadow-sm p-4">
                        <div class="flex items-center gap-2 mb-4 pb-3 border-b">
                            <i class="fas fa-shipping-fast text-primary"></i>
                            <h3 class="font-semibold text-gray-800">Metode Pengiriman</h3>
                        </div>
                        
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                            <label class="flex items-center justify-center p-3 border-2 border-gray-200 rounded-md cursor-pointer hover:border-primary transition has-[:checked]:border-primary has-[:checked]:bg-primary/5">
                                <input type="radio" name="metode_pengiriman" value="jne" class="mr-2" required>
                                <span class="text-sm font-medium">JNE</span>
                            </label>
                            <label class="flex items-center justify-center p-3 border-2 border-gray-200 rounded-md cursor-pointer hover:border-primary transition has-[:checked]:border-primary has-[:checked]:bg-primary/5">
                                <input type="radio" name="metode_pengiriman" value="jnt" class="mr-2" required>
                                <span class="text-sm font-medium">J&T</span>
                            </label>
                            <label class="flex items-center justify-center p-3 border-2 border-gray-200 rounded-md cursor-pointer hover:border-primary transition has-[:checked]:border-primary has-[:checked]:bg-primary/5">
                                <input type="radio" name="metode_pengiriman" value="sicepat" class="mr-2" required>
                                <span class="text-sm font-medium">SiCepat</span>
                            </label>
                            <label class="flex items-center justify-center p-3 border-2 border-gray-200 rounded-md cursor-pointer hover:border-primary transition has-[:checked]:border-primary has-[:checked]:bg-primary/5">
                                <input type="radio" name="metode_pengiriman" value="anteraja" class="mr-2" required>
                                <span class="text-sm font-medium">AnterAja</span>
                            </label>
                            <label class="flex items-center justify-center p-3 border-2 border-gray-200 rounded-md cursor-pointer hover:border-primary transition has-[:checked]:border-primary has-[:checked]:bg-primary/5">
                                <input type="radio" name="metode_pengiriman" value="ninja" class="mr-2" required>
                                <span class="text-sm font-medium">Ninja Xpress</span>
                            </label>
                        </div>
                        @error('metode_pengiriman')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Produk Dipesan --}}
                    <div class="bg-white rounded-lg shadow-sm p-4">
                        <div class="flex items-center gap-2 mb-4 pb-3 border-b">
                            <i class="fas fa-box text-primary"></i>
                            <h3 class="font-semibold text-gray-800">Produk Dipesan</h3>
                        </div>

                        <div class="space-y-3">
                            @foreach($cart as $item)
                                <div class="flex gap-3 pb-3 border-b last:border-0 last:pb-0">
                                    <div class="flex-shrink-0">
                                        @if($item['foto'])
                                            <img src="{{ asset('storage/img-produk/thumb_sm_' . $item['foto']) }}" 
                                                 alt="{{ $item['nama'] }}" 
                                                 class="w-16 h-16 object-cover rounded-md border">
                                        @else
                                            <div class="w-16 h-16 bg-gradient-to-br from-primary to-accent rounded-md border"></div>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="text-sm font-medium text-gray-800 mb-1 line-clamp-2">
                                            {{ $item['nama'] }}
                                        </h4>
                                        <div class="flex items-center justify-between text-xs text-gray-600">
                                            <span>{{ $item['qty'] }} x Rp{{ number_format($item['harga'], 0, ',', '.') }}</span>
                                            <span class="font-semibold text-gray-800">
                                                Rp{{ number_format($item['harga'] * $item['qty'], 0, ',', '.') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Metode Pembayaran --}}
                    <div class="bg-white rounded-lg shadow-sm p-4">
                        <div class="flex items-center gap-2 mb-4 pb-3 border-b">
                            <i class="fas fa-credit-card text-primary"></i>
                            <h3 class="font-semibold text-gray-800">Metode Pembayaran</h3>
                        </div>
                        
                        <div class="space-y-3">
                            {{-- Transfer Bank --}}
                            <div class="border-2 border-gray-200 rounded-lg p-3">
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="metode_pembayaran" value="transfer_bank" 
                                           class="w-4 h-4 text-primary" onclick="showBankOptions()" required>
                                    <span class="ml-3 font-medium text-gray-800">Transfer Bank</span>
                                </label>
                                
                                <div id="bankOptions" class="hidden mt-3 pl-7 space-y-2">
                                    <label class="flex items-center p-2 border border-gray-200 rounded cursor-pointer hover:bg-gray-50">
                                        <input type="radio" name="bank_terpilih" value="bca" class="mr-2">
                                        <span class="text-sm">BCA - 1234567890</span>
                                    </label>
                                    <label class="flex items-center p-2 border border-gray-200 rounded cursor-pointer hover:bg-gray-50">
                                        <input type="radio" name="bank_terpilih" value="bri" class="mr-2">
                                        <span class="text-sm">BRI - 0987654321</span>
                                    </label>
                                    <label class="flex items-center p-2 border border-gray-200 rounded cursor-pointer hover:bg-gray-50">
                                        <input type="radio" name="bank_terpilih" value="bni" class="mr-2">
                                        <span class="text-sm">BNI - 5555666677</span>
                                    </label>
                                    <label class="flex items-center p-2 border border-gray-200 rounded cursor-pointer hover:bg-gray-50">
                                        <input type="radio" name="bank_terpilih" value="mandiri" class="mr-2">
                                        <span class="text-sm">Mandiri - 1122334455</span>
                                    </label>
                                </div>
                            </div>

                            {{-- E-Wallet --}}
                            <div class="border-2 border-gray-200 rounded-lg p-3">
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="metode_pembayaran" value="ewallet" 
                                           class="w-4 h-4 text-primary" onclick="showEwalletOptions()" required>
                                    <span class="ml-3 font-medium text-gray-800">E-Wallet</span>
                                </label>
                                
                                <div id="ewalletOptions" class="hidden mt-3 pl-7 space-y-2">
                                    <label class="flex items-center p-2 border border-gray-200 rounded cursor-pointer hover:bg-gray-50">
                                        <input type="radio" name="ewallet_terpilih" value="ovo" class="mr-2">
                                        <span class="text-sm">OVO</span>
                                    </label>
                                    <label class="flex items-center p-2 border border-gray-200 rounded cursor-pointer hover:bg-gray-50">
                                        <input type="radio" name="ewallet_terpilih" value="dana" class="mr-2">
                                        <span class="text-sm">DANA</span>
                                    </label>
                                    <label class="flex items-center p-2 border border-gray-200 rounded cursor-pointer hover:bg-gray-50">
                                        <input type="radio" name="ewallet_terpilih" value="gopay" class="mr-2">
                                        <span class="text-sm">GoPay</span>
                                    </label>
                                </div>
                            </div>

                            {{-- COD --}}
                            <label class="flex items-center p-3 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-primary transition has-[:checked]:border-primary has-[:checked]:bg-primary/5">
                                <input type="radio" name="metode_pembayaran" value="cod" 
                                       class="w-4 h-4 text-primary" onclick="hideBankEwalletOptions()" required>
                                <div class="ml-3 flex-1 flex items-center justify-between">
                                    <span class="font-medium text-gray-800">Bayar di Tempat (COD)</span>
                                    <i class="fas fa-money-bill-wave text-green-500"></i>
                                </div>
                            </label>
                        </div>
                        @error('metode_pembayaran')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Order Summary (Desktop) --}}
                <div class="hidden lg:block w-80 flex-shrink-0">
                    <div class="bg-white rounded-lg shadow-sm p-4 sticky top-20">
                        <h3 class="font-semibold text-gray-800 mb-4">Ringkasan Belanja</h3>
                        
                        <div class="space-y-2 mb-4 pb-4 border-b text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Subtotal Produk</span>
                                <span class="font-semibold">Rp{{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Ongkir</span>
                                <span class="font-semibold text-green-600">GRATIS</span>
                            </div>
                        </div>

                        <div class="flex justify-between items-center mb-4">
                            <span class="font-medium text-gray-700">Total Pembayaran</span>
                            <p class="text-2xl font-bold text-primary">
                                Rp{{ number_format($total, 0, ',', '.') }}
                            </p>
                        </div>

                        <button type="submit" 
                                class="w-full bg-primary hover:bg-accent text-white py-3 rounded-md font-semibold transition mb-3">
                            Buat Pesanan
                        </button>

                        <a href="{{ route('cart.index') }}" 
                           class="block w-full text-center text-gray-600 hover:text-primary py-2 text-sm transition">
                            <i class="fas fa-arrow-left mr-1"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>

            {{-- Mobile Bottom Bar --}}
            <div class="fixed bottom-0 left-0 right-0 bg-white border-t shadow-lg lg:hidden z-40">
                <div class="container mx-auto px-4 py-3">
                    <div class="flex items-center justify-between gap-3">
                        <div class="flex-1">
                            <p class="text-xs text-gray-600 mb-0.5">Total Pembayaran</p>
                            <p class="text-lg font-bold text-primary">
                                Rp{{ number_format($total, 0, ',', '.') }}
                            </p>
                        </div>
                        <button type="submit" 
                                class="flex-shrink-0 bg-primary hover:bg-accent text-white px-6 py-3 rounded-md font-semibold transition">
                            Buat Pesanan
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

@endsection

@push('styles')
<style>
@media (max-width: 1024px) {
    body {
        padding-bottom: 80px;
    }
}
</style>
@endpush

@push('scripts')
<script>
function showBankOptions() {
    document.getElementById('bankOptions').classList.remove('hidden');
    document.getElementById('ewalletOptions').classList.add('hidden');
}

function showEwalletOptions() {
    document.getElementById('ewalletOptions').classList.remove('hidden');
    document.getElementById('bankOptions').classList.add('hidden');
}

function hideBankEwalletOptions() {
    document.getElementById('bankOptions').classList.add('hidden');
    document.getElementById('ewalletOptions').classList.add('hidden');
}

// Validation sebelum submit
document.getElementById('checkoutForm').addEventListener('submit', function(e) {
    const metodePembayaran = document.querySelector('input[name="metode_pembayaran"]:checked');
    
    if (metodePembayaran && metodePembayaran.value === 'transfer_bank') {
        const bankTerpilih = document.querySelector('input[name="bank_terpilih"]:checked');
        if (!bankTerpilih) {
            e.preventDefault();
            alert('Pilih bank untuk transfer terlebih dahulu');
            return false;
        }
    }
    
    if (metodePembayaran && metodePembayaran.value === 'ewallet') {
        const ewalletTerpilih = document.querySelector('input[name="ewallet_terpilih"]:checked');
        if (!ewalletTerpilih) {
            e.preventDefault();
            alert('Pilih e-wallet terlebih dahulu');
            return false;
        }
    }
});
</script>
@endpush