@extends('frontend.layouts.app')

@section('title', 'Keranjang Belanja - Emina Beauty')

@section('content')

{{-- Breadcrumb --}}
<div class="bg-gray-50 border-b">
    <div class="container mx-auto px-4 py-3">
        <nav class="flex items-center text-sm">
            <a href="{{ route('home') }}" class="text-gray-500 hover:text-primary transition">
                <i class="fas fa-home mr-1"></i> Home
            </a>
            <i class="fas fa-chevron-right mx-2 text-gray-400 text-xs"></i>
            <span class="text-gray-800 font-medium">Keranjang</span>
        </nav>
    </div>
</div>

{{-- Cart Section --}}
<section class="py-6 bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4">

        @if(!empty($cart) && count($cart) > 0)

        <div class="flex flex-col lg:flex-row gap-6">

            {{-- CART ITEMS --}}
            <div class="flex-1 space-y-4">

                {{-- Header --}}
                <div class="hidden md:flex justify-between items-center bg-white p-4 rounded-lg shadow">
                    <h2 class="font-semibold text-gray-800">
                        <i class="fas fa-shopping-cart text-primary mr-2"></i>
                        Keranjang Belanja ({{ count($cart) }} Produk)
                    </h2>
                    <form action="{{ route('cart.clear') }}" method="POST"
                          onsubmit="return confirm('Yakin ingin mengosongkan keranjang?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-medium">
                            <i class="fas fa-trash mr-1"></i> Hapus Semua
                        </button>
                    </form>
                </div>

                {{-- LIST ITEMS --}}
                @foreach($cart as $itemId => $item)
                <div class="bg-white rounded-lg shadow p-4">
                    <div class="flex gap-3 md:gap-4">

                        {{-- Checkbox --}}
                        <div class="flex-shrink-0 pt-2">
                            <input type="checkbox"
                                   class="w-5 h-5 text-primary rounded focus:ring-primary cursor-pointer"
                                   {{ isset($item['is_selected']) && $item['is_selected'] ? 'checked' : '' }}
                                   onchange="toggleSelect({{ $itemId }})">
                        </div>

                        {{-- Image --}}
                        <a href="{{ route('shop.show', isset($item['produk_id']) ? $item['produk_id'] : $itemId) }}" 
                           class="flex-shrink-0">
                            @if(!empty($item['foto']))
                                <img src="{{ asset('storage/img-produk/thumb_sm_' . $item['foto']) }}"
                                     alt="{{ $item['nama'] }}"
                                     class="w-20 h-20 md:w-24 md:h-24 rounded-lg object-cover border">
                            @else
                                <div class="w-20 h-20 md:w-24 md:h-24 bg-gradient-to-br from-primary to-accent rounded-lg flex items-center justify-center border">
                                    <i class="fas fa-image text-white text-2xl"></i>
                                </div>
                            @endif
                        </a>

                        {{-- Product Info --}}
                        <div class="flex-1 min-w-0">
                            {{-- Header with Delete --}}
                            <div class="flex justify-between gap-2 mb-2">
                                <div class="flex-1">
                                    <h4 class="font-medium text-gray-800 text-sm md:text-base line-clamp-2">
                                        {{ $item['nama'] }}
                                    </h4>
                                    {{-- Varian Info (jika ada) --}}
                                    @if(!empty($item['varian_nama']))
                                        <p class="text-xs text-gray-500 mt-1">
                                            Varian: {{ $item['varian_nama'] }}
                                        </p>
                                    @endif
                                </div>
                                
                                {{-- Delete Button --}}
                                <form action="{{ route('cart.remove', $itemId) }}" method="POST"
                                      onsubmit="return confirm('Hapus produk ini dari keranjang?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-gray-400 hover:text-red-500 transition">
                                        <i class="fas fa-trash text-lg"></i>
                                    </button>
                                </form>
                            </div>

                            {{-- Price --}}
                            <p class="text-primary font-bold text-base md:text-lg mb-3">
                                Rp{{ number_format($item['harga'], 0, ',', '.') }}
                            </p>

                            {{-- Quantity & Subtotal --}}
                            <div class="flex justify-between items-center">
                                {{-- Quantity Controls --}}
                                <div class="flex items-center border border-gray-300 rounded-md">
                                    <button type="button"
                                            onclick="updateCart({{ $itemId }}, -1)" 
                                            class="px-2 md:px-3 py-1.5 text-gray-600 hover:bg-gray-100 transition">
                                        <i class="fas fa-minus text-xs"></i>
                                    </button>
                                    <input type="number"
                                           id="qty-{{ $itemId }}" 
                                           value="{{ $item['qty'] }}" 
                                           min="1"
                                           readonly
                                           class="w-10 md:w-12 text-center border-x border-gray-300 py-1.5 text-sm font-medium focus:outline-none">
                                    <button type="button"
                                            onclick="updateCart({{ $itemId }}, 1)" 
                                            class="px-2 md:px-3 py-1.5 text-gray-600 hover:bg-gray-100 transition">
                                        <i class="fas fa-plus text-xs"></i>
                                    </button>
                                </div>

                                {{-- Subtotal --}}
                                <div class="text-right">
                                    <p class="text-xs text-gray-500 mb-0.5">Subtotal</p>
                                    <p id="subtotal-{{ $itemId }}" class="text-sm md:text-base font-bold text-gray-800">
                                        Rp{{ number_format($item['harga'] * $item['qty'], 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

                {{-- Mobile Clear All --}}
                <div class="md:hidden mt-3">
                    <form action="{{ route('cart.clear') }}" method="POST"
                          onsubmit="return confirm('Yakin ingin mengosongkan keranjang?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full text-center text-red-500 hover:text-red-700 text-sm font-medium py-2">
                            <i class="fas fa-trash mr-1"></i> Hapus Semua Produk
                        </button>
                    </form>
                </div>

            </div>

            {{-- SUMMARY (Desktop) - FIXED --}}
            <div class="hidden lg:block w-80 flex-shrink-0">
                <div class="bg-white rounded-lg shadow p-4 sticky top-20">
                    <h3 class="font-semibold text-gray-800 mb-4">Ringkasan Belanja</h3>

                    {{-- Total Harga (List per item yang dicentang) --}}
                    <div class="space-y-2 mb-4 pb-4 border-b">
                        <p class="text-sm font-medium text-gray-700 mb-2">Total Harga</p>
                        <div id="list-harga-desktop" class="space-y-1 text-sm text-gray-600">
                            @foreach($cart as $item)
                                @if($item['is_selected'])
                                <div class="harga-item-{{ $item['id'] }}">
                                    Rp{{ number_format($item['harga'] * $item['qty'], 0, ',', '.') }}
                                </div>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    {{-- Total Harga Terpilih --}}
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-gray-700 font-medium">Total Harga</span>
                        <div class="text-right">
                            <p class="text-2xl font-bold text-primary" id="total-terpilih-desktop">
                                Rp{{ number_format($totalTerpilih, 0, ',', '.') }}
                            </p>
                            <p class="text-xs text-gray-500" id="jumlah-terpilih-desktop">
                                {{ $jumlahTerpilih }} item dipilih
                            </p>
                        </div>
                    </div>

                    <a href="{{ route('checkout.index') }}" 
                       class="block w-full bg-primary hover:bg-accent text-white text-center py-3 rounded-md font-semibold transition mb-2">
                        Checkout
                    </a>

                    <a href="{{ route('shop.index') }}" 
                       class="block w-full text-center text-gray-600 hover:text-primary py-2 text-sm transition">
                        <i class="fas fa-arrow-left mr-1"></i> Lanjut Belanja
                    </a>
                </div>
            </div>

        </div>

        {{-- MOBILE BOTTOM CHECKOUT BAR - FIXED --}}
        <div class="fixed bottom-0 left-0 right-0 bg-white border-t shadow-lg lg:hidden z-40">
            <div class="container mx-auto px-4 py-3">
                <div class="flex items-center justify-between gap-3">
                    <div class="flex-1">
                        <p class="text-xs text-gray-600 mb-0.5">
                            <span id="jumlah-terpilih-mobile">{{ $jumlahTerpilih }}</span> item dipilih
                        </p>
                        <p id="total-terpilih-mobile" class="text-lg font-bold text-primary">
                            Rp{{ number_format($totalTerpilih, 0, ',', '.') }}
                        </p>
                    </div>
                    <a href="{{ route('checkout.index') }}" 
                    class="flex-shrink-0 bg-primary hover:bg-accent text-white px-6 py-3 rounded-md font-semibold transition">
                        Checkout
                    </a>
                </div>
            </div>
        </div>

        @else
        {{-- EMPTY CART --}}
        <div class="bg-white rounded-lg shadow p-8 md:p-12 text-center">
            <div class="max-w-md mx-auto">
                <div class="inline-block bg-gray-100 rounded-full p-8 md:p-12 mb-6">
                    <i class="fas fa-shopping-cart text-gray-300 text-5xl md:text-7xl"></i>
                </div>
                <h3 class="text-xl md:text-3xl font-bold text-gray-700 mb-3">Wah, keranjang belanjamu kosong</h3>
                <p class="text-sm md:text-base text-gray-500 mb-6 md:mb-8">Yuk, isi dengan produk-produk favoritmu!</p>
                <a href="{{ route('shop.index') }}" 
                   class="inline-block bg-primary hover:bg-accent text-white px-6 md:px-10 py-3 md:py-4 rounded-md font-semibold transition">
                    <i class="fas fa-shopping-bag mr-2"></i> Mulai Belanja
                </a>
            </div>
        </div>
        @endif

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

.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endpush

@push('scripts')
<script>
/* ================================
   TOGGLE CHECKBOX (ITEM TERPILIH)
================================ */
function toggleSelect(itemId) {
    fetch(`/cart/toggle-select/${itemId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            updateTotalTerpilih(data.totalTerpilih, data.jumlahTerpilih);
            showNotification('success', 'Item berhasil diupdate');
            
            // Reload page untuk update list harga
            setTimeout(() => location.reload(), 500);
        } else {
            showNotification('error', data.message || 'Terjadi kesalahan');
        }
    })
    .catch(error => {
        console.error(error);
        showNotification('error', 'Terjadi kesalahan. Silakan refresh halaman.');
    });
}

/* ================================
   UPDATE TOTAL TERPILIH (PINK)
================================ */
function updateTotalTerpilih(totalTerpilih, jumlahTerpilih) {
    // Desktop
    const totalDesktop = document.getElementById('total-terpilih-desktop');
    const jumlahDesktop = document.getElementById('jumlah-terpilih-desktop');

    if (totalDesktop) totalDesktop.textContent = 'Rp' + totalTerpilih;
    if (jumlahDesktop) jumlahDesktop.textContent = jumlahTerpilih + ' item dipilih';

    // Mobile
    const totalMobile = document.getElementById('total-terpilih-mobile');
    const jumlahMobile = document.getElementById('jumlah-terpilih-mobile');

    if (totalMobile) totalMobile.textContent = 'Rp' + totalTerpilih;
    if (jumlahMobile) jumlahMobile.textContent = jumlahTerpilih;
}

/* ================================
   UPDATE JUMLAH ITEM (+ / -)
================================ */
function updateCart(itemId, change) {
    const qtyInput = document.getElementById('qty-' + itemId);
    let qty = parseInt(qtyInput.value) + change;

    if (qty < 1) {
        if (confirm('Hapus produk ini dari keranjang?')) {
            document.querySelector(`form[action*="/cart/remove/${itemId}"]`).submit();
        }
        return;
    }

    fetch(`/cart/update/${itemId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ qty })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            qtyInput.value = qty;
            document.getElementById('subtotal-' + itemId).textContent = 'Rp' + data.subtotal;
            
            updateTotalTerpilih(data.totalTerpilih, data.jumlahTerpilih);
            
            // Update list harga
            setTimeout(() => location.reload(), 500);
            
            showNotification('success', 'Jumlah berhasil diupdate');
        } else {
            showNotification('error', data.message || 'Terjadi kesalahan');
        }
    })
    .catch(() => {
        showNotification('error', 'Terjadi kesalahan. Silakan coba lagi.');
    });
}

/* ================================
   NOTIFICATION
================================ */
function showNotification(type, message) {
    const bg = type === 'success' ? 'bg-green-500' : 'bg-red-500';
    const notif = document.createElement('div');

    notif.className = `fixed top-20 right-4 ${bg} text-white px-6 py-3 rounded-lg shadow-lg z-50 animate-slide-in`;
    notif.innerHTML = `
        <div class="flex items-center gap-2">
            <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
            <span>${message}</span>
        </div>
    `;

    document.body.appendChild(notif);
    setTimeout(() => notif.remove(), 3000);
}
</script>

<style>
@keyframes slide-in {
    from { transform: translateX(100%); opacity: 0; }
    to { transform: translateX(0); opacity: 1; }
}
.animate-slide-in {
    animation: slide-in 0.3s ease-out;
}
</style>
@endpush