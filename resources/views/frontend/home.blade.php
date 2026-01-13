@extends('frontend.layouts.app')

@section('title', 'Emina Beauty - Stay Cute, Stay Confident')

@section('content')

{{-- Hero Section --}}
<section 
    class="relative bg-cover bg-center bg-no-repeat text-white"
    style="background-image: url('{{ asset('image/home1.png') }}');"
>
    <div class="absolute inset-0 bg-black/25"></div>

    <div class="relative z-10 container mx-auto px-4 py-16 md:py-28">
        <div class="max-w-3xl space-y-4 md:space-y-6">
            <h1 class="text-3xl md:text-6xl font-bold leading-tight">
                Stay Cute,<br>
                Stay Confident! 💕
            </h1>

            <p class="text-lg md:text-xl text-white/90">
                Temukan produk kecantikan terbaik yang bikin kamu makin percaya diri setiap hari!
            </p>

            <div class="flex flex-col sm:flex-row gap-3 sm:space-x-4">
                <a href="{{ route('shop.index') }}" class="bg-white text-primary px-6 md:px-8 py-3 rounded-full font-semibold hover:shadow-2xl transition text-center">
                    <i class="fas fa-shopping-bag mr-2"></i> Belanja Sekarang
                </a>
                <a href="#produk-unggulan" class="border-2 border-white px-6 md:px-8 py-3 rounded-full font-semibold hover:bg-white hover:text-primary transition text-center">
                    Lihat Koleksi
                </a>
            </div>

            <div class="grid grid-cols-3 gap-4 md:gap-6 pt-6 md:pt-10">
                <div>
                    <div class="text-2xl md:text-3xl font-bold">500+</div>
                    <div class="text-white/80 text-xs md:text-sm">Produk</div>
                </div>
                <div>
                    <div class="text-2xl md:text-3xl font-bold">10K+</div>
                    <div class="text-white/80 text-xs md:text-sm">Pelanggan</div>
                </div>
                <div>
                    <div class="text-2xl md:text-3xl font-bold">4.9</div>
                    <div class="text-white/80 text-xs md:text-sm">Rating</div>
                </div>
            </div>
        </div>
    </div>
</section>


{{-- Kategori Section --}}
<section class="py-8 md:py-16 bg-white">
    <div class="container mx-auto px-4">
        <h2 class="text-xl md:text-3xl font-bold text-center mb-6 md:mb-12 text-gray-800">
            <span class="bg-gradient-to-r from-primary to-accent bg-clip-text text-transparent">
                Belanja Berdasarkan Kategori
            </span>
        </h2>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-6">
        {{-- Makeup --}}
        <a href="{{ route('makeup') }}" class="group">
            <div class="bg-gradient-to-br from-bg-light to-white p-4 md:p-8 rounded-xl md:rounded-2xl text-center hover:shadow-xl transition transform hover:scale-105 border-2 border-transparent hover:border-primary">
                <div class="w-14 h-14 md:w-20 md:h-20 bg-gradient-to-r from-pink-400 to-pink-600 rounded-full flex items-center justify-center mx-auto mb-2 md:mb-4 group-hover:scale-110 transition">
                    <i class="fas fa-palette text-white text-xl md:text-3xl"></i>
                </div>
                <h3 class="text-sm md:text-base font-semibold text-gray-800 group-hover:text-primary transition">
                    Makeup
                </h3>
            </div>
        </a>

        {{-- Skincare --}}
        <a href="{{ route('skincare') }}" class="group">
            <div class="bg-gradient-to-br from-bg-light to-white p-4 md:p-8 rounded-xl md:rounded-2xl text-center hover:shadow-xl transition transform hover:scale-105 border-2 border-transparent hover:border-primary">
                <div class="w-14 h-14 md:w-20 md:h-20 bg-gradient-to-r from-blue-400 to-cyan-400 rounded-full flex items-center justify-center mx-auto mb-2 md:mb-4 group-hover:scale-110 transition">
                    <i class="fas fa-spa text-white text-xl md:text-3xl"></i>
                </div>
                <h3 class="text-sm md:text-base font-semibold text-gray-800 group-hover:text-primary transition">
                    Skincare
                </h3>
            </div>
        </a>

        {{-- Lip Products --}}
        <a href="{{ route('lip-products') }}" class="group">
            <div class="bg-gradient-to-br from-bg-light to-white p-4 md:p-8 rounded-xl md:rounded-2xl text-center hover:shadow-xl transition transform hover:scale-105 border-2 border-transparent hover:border-primary">
                <div class="w-14 h-14 md:w-20 md:h-20 bg-gradient-to-r from-pink-500 to-red-500 rounded-full flex items-center justify-center mx-auto mb-2 md:mb-4 group-hover:scale-110 transition">
                    <i class="fas fa-kiss-wink-heart text-white text-xl md:text-3xl"></i>
                </div>
                <h3 class="text-sm md:text-base font-semibold text-gray-800 group-hover:text-primary transition">
                    Lip Products
                </h3>
            </div>
        </a>

        {{-- Sun Protection --}}
        <a href="{{ route('sun-protection') }}" class="group">
            <div class="bg-gradient-to-br from-bg-light to-white p-4 md:p-8 rounded-xl md:rounded-2xl text-center hover:shadow-xl transition transform hover:scale-105 border-2 border-transparent hover:border-primary">
                <div class="w-14 h-14 md:w-20 md:h-20 bg-gradient-to-r from-yellow-400 to-orange-500 rounded-full flex items-center justify-center mx-auto mb-2 md:mb-4 group-hover:scale-110 transition">
                    <i class="fas fa-sun text-white text-xl md:text-3xl"></i>
                </div>
                <h3 class="text-sm md:text-base font-semibold text-gray-800 group-hover:text-primary transition">
                    Sun Protection
                </h3>
            </div>
        </a>
    </div>
    </div>
</section>

{{-- Produk Unggulan --}}
<section id="produk-unggulan" class="py-4 md:py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-4 md:mb-12">
            <h2 class="text-xl md:text-4xl font-bold text-gray-800 mb-2 md:mb-4">
                Produk <span class="bg-gradient-to-r from-primary to-accent bg-clip-text text-transparent">Unggulan</span> ✨
            </h2>
            <p class="text-sm md:text-base text-gray-600">Pilihan terbaik yang paling banyak dicari!</p>
        </div>

        {{-- Mobile: 2 Columns, Desktop: 4 Columns (Shopee Style) --}}
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2 md:gap-4">
            @foreach($produkUnggulan as $produk)
                <div class="bg-white rounded-lg md:rounded-xl shadow-sm overflow-hidden group hover:shadow-md transition">
                    <a href="{{ route('shop.show', $produk->id) }}" class="block">
                        <div class="relative overflow-hidden bg-gray-50" style="aspect-ratio: 1/1;">
                            @if($produk->foto)
                                <img src="{{ asset('storage/img-produk/thumb_md_' . $produk->foto) }}" 
                                     alt="{{ $produk->nama_produk }}" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-primary to-accent flex items-center justify-center">
                                    <i class="fas fa-image text-white text-3xl md:text-5xl"></i>
                                </div>
                            @endif
                            
                            {{-- Badge Stok --}}
                            @if($produk->stok == 0)
                                <div class="absolute inset-0 bg-black/50 flex items-center justify-center">
                                    <span class="bg-red-500 text-white text-xs px-2 py-1 rounded-md font-semibold">
                                        Habis
                                    </span>
                                </div>
                            @elseif($produk->stok < 10)
                                <span class="absolute top-1 md:top-2 right-1 md:right-2 bg-orange-500 text-white text-xs px-2 py-1 rounded-md font-semibold">
                                    Sisa {{ $produk->stok }}
                                </span>
                            @endif
                        </div>
                    </a>
                    
                    <div class="p-2 md:p-3">
                        <a href="{{ route('shop.show', $produk->id) }}">
                            <h3 class="text-xs md:text-sm text-gray-800 mb-1 md:mb-2 line-clamp-2 group-hover:text-primary transition" style="min-height: 2.5rem;">
                                {{ $produk->nama_produk }}
                            </h3>
                        </a>
                        
                        <div class="flex items-baseline justify-between">
                            <span class="text-primary font-bold text-sm md:text-lg">
                                Rp{{ number_format($produk->harga, 0, ',', '.') }}
                            </span>
                        </div>

                        {{-- Info Tambahan --}}
                        <div class="flex items-center text-xs text-gray-500 mt-1">
                            <i class="fas fa-map-marker-alt mr-1"></i>
                            <span>Jakarta</span>
                        </div>

                        {{-- Button Tambah (Desktop Only) --}}
                        <form action="{{ route('cart.add', $produk->id) }}" method="POST" class="hidden md:block mt-2">
                            @csrf
                            <input type="hidden" name="qty" value="1">
                            @if($produk->stok > 0)
                                <button type="submit" class="w-full bg-primary hover:bg-accent text-white py-2 rounded-md font-medium text-sm transition">
                                    <i class="fas fa-cart-plus mr-1"></i> Keranjang
                                </button>
                            @else
                                <button disabled class="w-full bg-gray-300 text-gray-500 py-2 rounded-md font-medium text-sm cursor-not-allowed">
                                    Habis
                                </button>
                            @endif
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="text-center mt-6 md:mt-12">
            <a href="{{ route('shop.index') }}" class="inline-block bg-gradient-to-r from-primary to-accent text-white px-6 md:px-10 py-2.5 md:py-3 rounded-full font-semibold hover:shadow-xl transition transform hover:scale-105 text-sm md:text-base">
                Lihat Semua Produk <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
    </div>
</section>

{{-- Produk Terbaru --}}
<section class="py-4 md:py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-4 md:mb-12">
            <h2 class="text-xl md:text-4xl font-bold text-gray-800 mb-2 md:mb-4">
                Produk <span class="bg-gradient-to-r from-primary to-accent bg-clip-text text-transparent">Terbaru</span> 🆕
            </h2>
            <p class="text-sm md:text-base text-gray-600">Koleksi terbaru yang wajib kamu coba!</p>
        </div>

        {{-- Mobile: 2 Columns, Desktop: 4 Columns (Shopee Style) --}}
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2 md:gap-4">
            @foreach($produkTerbaru as $produk)
                <div class="bg-white rounded-lg md:rounded-xl shadow-sm overflow-hidden group hover:shadow-md transition">
                    <a href="{{ route('shop.show', $produk->id) }}" class="block">
                        <div class="relative overflow-hidden bg-gray-50" style="aspect-ratio: 1/1;">
                            @if($produk->foto)
                                <img src="{{ asset('storage/img-produk/thumb_md_' . $produk->foto) }}" 
                                     alt="{{ $produk->nama_produk }}" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-primary to-accent flex items-center justify-center">
                                    <i class="fas fa-image text-white text-3xl md:text-5xl"></i>
                                </div>
                            @endif
                            
                            {{-- Badge NEW --}}
                            <span class="absolute top-1 md:top-2 left-1 md:left-2 bg-green-500 text-white text-xs px-2 py-1 rounded-md font-semibold">
                                NEW
                            </span>
                        </div>
                    </a>
                    
                    <div class="p-2 md:p-3">
                        <a href="{{ route('shop.show', $produk->id) }}">
                            <h3 class="text-xs md:text-sm text-gray-800 mb-1 md:mb-2 line-clamp-2 group-hover:text-primary transition" style="min-height: 2.5rem;">
                                {{ $produk->nama_produk }}
                            </h3>
                        </a>
                        
                        <div class="flex items-baseline justify-between">
                            <span class="text-primary font-bold text-sm md:text-lg">
                                Rp{{ number_format($produk->harga, 0, ',', '.') }}
                            </span>
                        </div>

                        {{-- Info Tambahan --}}
                        <div class="flex items-center text-xs text-gray-500 mt-1">
                            <i class="fas fa-map-marker-alt mr-1"></i>
                            <span>Jakarta</span>
                            @if($produk->stok > 0)
                                <span class="mx-1">•</span>
                                <span>Stok: {{ $produk->stok }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA Section --}}
<section class="py-12 md:py-20 bg-gradient-to-r from-primary to-accent text-white">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-2xl md:text-5xl font-bold mb-4 md:mb-6">
            Siap Tampil Lebih Percaya Diri? 💖
        </h2>
        <p class="text-base md:text-xl mb-6 md:mb-8 text-white/90">
            Daftar sekarang dan dapatkan promo spesial untuk member baru!
        </p>
        <div class="flex flex-col sm:flex-row justify-center gap-3 sm:space-x-4">
            @guest('customer')
                <a href="{{ route('customer.register') }}" class="bg-white text-primary px-6 md:px-10 py-3 md:py-4 rounded-full font-bold text-base md:text-lg hover:shadow-2xl transition transform hover:scale-105">
                    Daftar Gratis
                </a>
                <a href="{{ route('shop.index') }}" class="border-2 border-white text-white px-6 md:px-10 py-3 md:py-4 rounded-full font-bold text-base md:text-lg hover:bg-white hover:text-primary transition">
                    Mulai Belanja
                </a>
            @else
                <a href="{{ route('shop.index') }}" class="bg-white text-primary px-6 md:px-10 py-3 md:py-4 rounded-full font-bold text-base md:text-lg hover:shadow-2xl transition transform hover:scale-105">
                    Mulai Belanja Sekarang
                </a>
            @endguest
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
// Success message with notification
@if(session('success'))
    showNotification('success', '{{ session('success') }}');
@endif

// Notification Helper
function showNotification(type, message) {
    const bgColor = type === 'success' ? 'bg-green-500' : 'bg-red-500';
    const notification = document.createElement('div');
    notification.className = `fixed top-20 right-4 ${bgColor} text-white px-6 py-3 rounded-lg shadow-lg z-50 animate-slide-in`;
    notification.innerHTML = `
        <div class="flex items-center gap-2">
            <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
            <span>${message}</span>
        </div>
    `;
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.remove();
    }, 3000);
}
</script>
@endpush