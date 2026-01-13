@extends('frontend.layouts.app')

@section('title', $produk->nama_produk . ' - Emina Beauty')

@section('content')

{{-- Breadcrumb --}}
<div class="bg-gray-50 border-b">
    <div class="container mx-auto px-4 py-3">
        <nav class="flex items-center text-sm overflow-x-auto" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="text-gray-500 hover:text-primary transition whitespace-nowrap">
                <i class="fas fa-home mr-1"></i>Home
            </a>
            <i class="fas fa-chevron-right mx-2 text-gray-400 text-xs"></i>
            <a href="{{ route('shop.index') }}" class="text-gray-500 hover:text-primary transition whitespace-nowrap">Shop</a>
            <i class="fas fa-chevron-right mx-2 text-gray-400 text-xs"></i>
            <span class="text-gray-800 font-medium truncate">{{ Str::limit($produk->nama_produk, 50) }}</span>
        </nav>
    </div>
</div>

{{-- Product Detail --}}
<section class="py-4 md:py-6 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-0">
                
                {{-- Product Images --}}
                <div class="p-4 md:p-6 bg-white relative">
                    {{-- Wishlist Button (Floating) --}}
                    <button class="absolute top-6 right-6 z-10 w-10 h-10 bg-white rounded-full shadow-md flex items-center justify-center hover:bg-red-50 transition group">
                        <i class="far fa-heart text-gray-400 group-hover:text-red-500 text-xl"></i>
                    </button>

                    {{-- Main Image --}}
                    <div class="bg-gray-50 rounded-lg overflow-hidden mb-3 aspect-square">
                        @if($produk->foto)
                            <img id="main-image" 
                                 src="{{ asset('storage/img-produk/thumb_lg_' . $produk->foto) }}" 
                                 alt="{{ $produk->nama_produk }}" 
                                 class="w-full h-full object-contain">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-primary to-accent flex items-center justify-center">
                                <i class="fas fa-image text-white text-6xl"></i>
                            </div>
                        @endif
                    </div>

                    {{-- Thumbnail Images --}}
                    @if($produk->fotoProduk->count() > 0 || $produk->foto)
                        <div class="flex gap-2 overflow-x-auto pb-2">
                            {{-- Main Photo Thumbnail --}}
                            @if($produk->foto)
                                <div class="flex-shrink-0 w-16 h-16 cursor-pointer rounded-md overflow-hidden border-2 border-primary">
                                    <img src="{{ asset('storage/img-produk/thumb_sm_' . $produk->foto) }}" 
                                         alt="{{ $produk->nama_produk }}"
                                         class="w-full h-full object-cover hover:opacity-75 transition"
                                         onclick="changeImage('{{ asset('storage/img-produk/thumb_lg_' . $produk->foto) }}')">
                                </div>
                            @endif

                            {{-- Additional Photos --}}
                            @foreach($produk->fotoProduk as $foto)
                                <div class="flex-shrink-0 w-16 h-16 cursor-pointer rounded-md overflow-hidden border-2 border-gray-200 hover:border-primary transition">
                                    <img src="{{ asset('storage/img-produk/' . $foto->foto) }}" 
                                         alt="{{ $produk->nama_produk }}"
                                         class="w-full h-full object-cover hover:opacity-75 transition"
                                         onclick="changeImage('{{ asset('storage/img-produk/' . $foto->foto) }}')">
                                </div>
                            @endforeach
                        </div>
                    @endif

                    {{-- Share Buttons (Desktop) --}}
                    <div class="hidden md:flex items-center gap-3 mt-4 pt-4 border-t">
                        <span class="text-sm text-gray-600">Bagikan:</span>
                        <button class="flex items-center gap-2 text-gray-600 hover:text-green-600 transition text-sm">
                            <i class="fab fa-whatsapp text-lg"></i>
                        </button>
                        <button class="flex items-center gap-2 text-gray-600 hover:text-blue-600 transition text-sm">
                            <i class="fab fa-facebook text-lg"></i>
                        </button>
                        <button class="flex items-center gap-2 text-gray-600 hover:text-primary transition text-sm">
                            <i class="fab fa-instagram text-lg"></i>
                        </button>
                    </div>
                </div>

                {{-- Product Info --}}
                <div class="p-4 md:p-6 bg-white lg:border-l">
                    {{-- Product Name --}}
                    <h1 class="text-xl md:text-2xl font-bold text-gray-800 mb-3">
                        {{ $produk->nama_produk }}
                    </h1>

                    {{-- Rating & Sales (Dummy) --}}
                    <div class="flex items-center gap-4 text-sm mb-4 pb-4 border-b">
                        <div class="flex items-center gap-1">
                            <span class="text-primary font-semibold">5.0</span>
                            <div class="flex text-primary">
                                @for($i = 0; $i < 5; $i++)
                                    <i class="fas fa-star text-xs"></i>
                                @endfor
                            </div>
                        </div>
                        <div class="h-4 w-px bg-gray-300"></div>
                        <div class="text-gray-600">
                            <span class="font-semibold text-gray-800">127</span> Penilaian
                        </div>
                        <div class="h-4 w-px bg-gray-300"></div>
                        <div class="text-gray-600">
                            <span class="font-semibold text-gray-800">345</span> Terjual
                        </div>
                    </div>

                    {{-- Price --}}
                    <div class="bg-gray-50 rounded-lg p-4 mb-4">
                        <div class="flex items-baseline gap-2">
                            <span class="text-3xl font-bold text-primary" id="display-price">
                                Rp{{ number_format($produk->harga, 0, ',', '.') }}
                            </span>
                            <input type="hidden" id="base-price" value="{{ $produk->harga }}">
                        </div>
                    </div>

                    {{-- Variant/Shade (UPDATED - Dynamic dari Database) --}}
                    @if($produk->varian && $produk->varian->count() > 0)
                        <div class="mb-4 pb-4 border-b">
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Pilih Varian</label>
                            <div class="flex flex-wrap gap-2">
                                @foreach($produk->varian as $index => $varian)
                                    <label class="relative cursor-pointer">
                                        <input type="radio" 
                                               name="varian_id" 
                                               value="{{ $varian->id }}" 
                                               class="peer hidden varian-radio"
                                               data-harga="{{ $varian->harga_tambahan }}"
                                               data-stok="{{ $varian->stok }}"
                                               data-nama="{{ $varian->nama_varian }}"
                                               {{ $index === 0 ? 'checked' : '' }}
                                               onchange="updateVarianInfo(this)">
                                        
                                        <div class="flex items-center gap-2 px-4 py-2.5 border-2 border-gray-300 
                                                    peer-checked:border-primary peer-checked:bg-primary/5 
                                                    hover:border-primary/50 transition rounded-md">
                                            
                                            {{-- Color Preview --}}
                                            @if($varian->kode_warna)
                                                <div class="w-5 h-5 rounded-full border-2 border-white shadow-sm" 
                                                     style="background: {{ $varian->kode_warna }};"></div>
                                            @endif
                                            
                                            <div class="text-sm">
                                                <div class="font-medium text-gray-800">{{ $varian->nama_varian }}</div>
                                                <div class="text-xs text-gray-500">
                                                    @if($varian->stok > 0)
                                                        Stok: {{ $varian->stok }}
                                                    @else
                                                        <span class="text-red-500">Habis</span>
                                                    @endif
                                                    @if($varian->harga_tambahan > 0)
                                                        <span class="text-primary">
                                                            +Rp{{ number_format($varian->harga_tambahan, 0, ',', '.') }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                            
                            {{-- Varian Info Display --}}
                            <div id="varian-info" class="mt-3 text-sm text-gray-600 hidden">
                                <i class="fas fa-info-circle text-primary mr-1"></i>
                                <span id="varian-message"></span>
                            </div>
                        </div>
                    @endif

                    {{-- Stock Info (Dynamic berdasarkan varian atau produk) --}}
                    <div class="flex items-center gap-4 text-sm mb-6">
                        <div class="flex items-center gap-2">
                            <span class="text-gray-600">Stok:</span>
                            <span id="stock-display">
                                @if($produk->varian && $produk->varian->count() > 0)
                                    @php
                                        $firstVarian = $produk->varian->first();
                                    @endphp
                                    @if($firstVarian->stok > 0)
                                        @if($firstVarian->stok < 10)
                                            <span class="text-orange-600 font-semibold">Sisa {{ $firstVarian->stok }} item</span>
                                        @else
                                            <span class="text-green-600 font-semibold">{{ $firstVarian->stok }} item</span>
                                        @endif
                                    @else
                                        <span class="text-red-600 font-semibold">Habis</span>
                                    @endif
                                @else
                                    @if($produk->stok > 0)
                                        @if($produk->stok < 10)
                                            <span class="text-orange-600 font-semibold">Sisa {{ $produk->stok }} item</span>
                                        @else
                                            <span class="text-green-600 font-semibold">{{ $produk->stok }} item</span>
                                        @endif
                                    @else
                                        <span class="text-red-600 font-semibold">Habis</span>
                                    @endif
                                @endif
                            </span>
                        </div>
                        <div class="h-4 w-px bg-gray-300"></div>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-box-open text-gray-400"></i>
                            <span class="text-gray-600">Berat: {{ $produk->berat }}g</span>
                        </div>
                    </div>

                    {{-- Quantity & Actions --}}
                    @php
                        $hasStock = $produk->varian && $produk->varian->count() > 0 
                            ? $produk->varian->first()->stok > 0 
                            : $produk->stok > 0;
                        $maxStock = $produk->varian && $produk->varian->count() > 0 
                            ? $produk->varian->first()->stok 
                            : $produk->stok;
                    @endphp

                    @if($hasStock)
                        <form id="add-to-cart-form" action="{{ route('cart.add', $produk->id) }}" method="POST" class="mb-6">
                            @csrf
                            
                            {{-- Hidden varian_id input --}}
                            @if($produk->varian && $produk->varian->count() > 0)
                                <input type="hidden" name="varian_id" id="selected-varian-id" value="{{ $produk->varian->first()->id }}">
                            @endif
                            
                            {{-- Quantity Selector --}}
                            <div class="flex items-center gap-4 mb-4">
                                <span class="text-gray-700 text-sm font-medium">Kuantitas:</span>
                                <div class="flex items-center border border-gray-300 rounded-md">
                                    <button type="button" onclick="decreaseQty()" 
                                            class="px-3 py-2 text-gray-600 hover:bg-gray-100 transition">
                                        <i class="fas fa-minus text-sm"></i>
                                    </button>
                                    <input type="number" name="qty" id="qty" value="1" min="1" max="{{ $maxStock }}" 
                                           class="w-16 text-center border-x border-gray-300 py-2 focus:outline-none text-sm font-medium">
                                    <button type="button" onclick="increaseQty()" 
                                            class="px-3 py-2 text-gray-600 hover:bg-gray-100 transition">
                                        <i class="fas fa-plus text-sm"></i>
                                    </button>
                                </div>
                            </div>

                            {{-- Action Buttons --}}
                            <div class="flex gap-3">
                                <button type="submit" id="btn-add-cart"
                                        class="flex-1 border-2 border-primary text-primary hover:bg-primary hover:text-white py-3 rounded-md font-semibold transition flex items-center justify-center gap-2">
                                    <i class="fas fa-cart-plus"></i>
                                    <span>Keranjang</span>
                                </button>
                                <button type="button" onclick="beliSekarang()" id="btn-buy-now"
                                        class="flex-1 bg-primary hover:bg-accent text-white py-3 rounded-md font-semibold transition flex items-center justify-center gap-2">
                                    <i class="fas fa-bolt"></i>
                                    <span>Beli Sekarang</span>
                                </button>
                            </div>
                        </form>
                    @else
                        <div class="bg-red-50 border border-red-200 rounded-md p-4 text-center mb-6">
                            <i class="fas fa-times-circle text-red-500 text-2xl mb-2"></i>
                            <p class="text-red-700 font-semibold mb-1">Produk Habis</p>
                            <p class="text-red-600 text-sm">Silakan pilih produk lainnya</p>
                        </div>
                    @endif

                    {{-- Product Info Grid --}}
                    <div class="grid grid-cols-2 gap-3 mb-6 text-sm">
                        <div class="bg-gray-50 p-3 rounded-md">
                            <div class="text-gray-500 mb-1">Kategori</div>
                            <div class="font-semibold text-gray-800">{{ $produk->kategori->nama_kategori ?? '-' }}</div>
                        </div>
                        <div class="bg-gray-50 p-3 rounded-md">
                            <div class="text-gray-500 mb-1">Dikirim Dari</div>
                            <div class="font-semibold text-gray-800">Jakarta</div>
                        </div>
                    </div>

                    {{-- Mobile Share Buttons --}}
                    <div class="flex md:hidden gap-3 pt-4 border-t">
                        <button class="flex-1 flex items-center justify-center gap-2 border border-gray-300 text-gray-700 py-2 rounded-md hover:bg-gray-50 transition text-sm">
                            <i class="far fa-heart"></i>
                            <span>Favorit</span>
                        </button>
                        <button class="flex-1 flex items-center justify-center gap-2 border border-gray-300 text-gray-700 py-2 rounded-md hover:bg-gray-50 transition text-sm">
                            <i class="fas fa-share-alt"></i>
                            <span>Bagikan</span>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Product Description --}}
            <div class="p-4 md:p-6 border-t">
                <h2 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-info-circle text-primary mr-2"></i>
                    Detail Produk
                </h2>
                <div class="prose prose-sm max-w-none text-gray-600 leading-relaxed">
                    {!! nl2br(e($produk->detail)) !!}
                </div>
            </div>
        </div>

        {{-- Related Products --}}
        @if($produkTerkait->count() > 0)
            <div class="mt-6">
                <div class="bg-white rounded-lg shadow-sm p-4 md:p-6">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">Produk Terkait</h2>

                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3 md:gap-4">
                        @foreach($produkTerkait as $item)
                            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden group hover:shadow-md transition">
                                <a href="{{ route('shop.show', $item->id) }}" class="block">
                                    <div class="relative aspect-square overflow-hidden bg-gray-50">
                                        @if($item->foto)
                                            <img src="{{ asset('storage/img-produk/thumb_md_' . $item->foto) }}" 
                                                 alt="{{ $item->nama_produk }}" 
                                                 class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                        @else
                                            <div class="w-full h-full bg-gradient-to-br from-primary to-accent flex items-center justify-center">
                                                <i class="fas fa-image text-white text-3xl"></i>
                                            </div>
                                        @endif
                                    </div>
                                </a>
                                
                                <div class="p-2">
                                    <a href="{{ route('shop.show', $item->id) }}">
                                        <h3 class="text-sm text-gray-800 mb-1 line-clamp-2 group-hover:text-primary transition min-h-[2.5rem]">
                                            {{ $item->nama_produk }}
                                        </h3>
                                    </a>
                                    <div class="text-primary font-bold text-sm">
                                        Rp{{ number_format($item->harga, 0, ',', '.') }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>

{{-- Floating Mobile Action Bar --}}
<div class="fixed bottom-0 left-0 right-0 bg-white border-t shadow-lg md:hidden z-40 safe-area-bottom">
    <div class="container mx-auto px-4 py-3">
        <div class="flex gap-2">
            <button class="flex flex-col items-center justify-center px-3 text-gray-600">
                <i class="far fa-comments text-xl mb-1"></i>
                <span class="text-xs">Chat</span>
            </button>
            <button class="flex flex-col items-center justify-center px-3 text-gray-600">
                <i class="far fa-heart text-xl mb-1"></i>
                <span class="text-xs">Favorit</span>
            </button>
            @if($hasStock)
                <button type="button" onclick="document.getElementById('add-to-cart-form').submit()" 
                        class="flex-1 border-2 border-primary text-primary py-2.5 rounded-md font-semibold">
                    + Keranjang
                </button>
                <button type="button" onclick="beliSekarang()" 
                        class="flex-1 bg-primary text-white py-2.5 rounded-md font-semibold">
                    Beli Sekarang
                </button>
            @else
                <button disabled class="flex-1 bg-gray-300 text-gray-500 py-2.5 rounded-md font-semibold">
                    Stok Habis
                </button>
            @endif
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
.safe-area-bottom {
    padding-bottom: env(safe-area-inset-bottom);
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
// Change main image
function changeImage(src) {
    document.getElementById('main-image').src = src;
}

// Update varian info (harga, stok, dll)
function updateVarianInfo(radio) {
    const hargaTambahan = parseInt(radio.dataset.harga) || 0;
    const stok = parseInt(radio.dataset.stok);
    const namaVarian = radio.dataset.nama;
    const basePrice = parseInt(document.getElementById('base-price').value);
    const totalPrice = basePrice + hargaTambahan;
    
    // Update harga display
    document.getElementById('display-price').textContent = 
        'Rp' + totalPrice.toLocaleString('id-ID');
    
    // Update stock display
    const stockDisplay = document.getElementById('stock-display');
    if (stok > 0) {
        if (stok < 10) {
            stockDisplay.innerHTML = `<span class="text-orange-600 font-semibold">Sisa ${stok} item</span>`;
        } else {
            stockDisplay.innerHTML = `<span class="text-green-600 font-semibold">${stok} item</span>`;
        }
    } else {
        stockDisplay.innerHTML = '<span class="text-red-600 font-semibold">Habis</span>';
    }
    
    // Update max qty
    const qtyInput = document.getElementById('qty');
    qtyInput.max = stok;
    if (parseInt(qtyInput.value) > stok) {
        qtyInput.value = stok;
    }
    
    // Update hidden varian_id input
    const varianIdInput = document.getElementById('selected-varian-id');
    if (varianIdInput) {
        varianIdInput.value = radio.value;
    }
    
    // Disable/enable buttons based on stock
    const btnAddCart = document.getElementById('btn-add-cart');
    const btnBuyNow = document.getElementById('btn-buy-now');
    
    if (stok === 0) {
        if (btnAddCart) btnAddCart.disabled = true;
        if (btnBuyNow) btnBuyNow.disabled = true;
        btnAddCart?.classList.add('opacity-50', 'cursor-not-allowed');
        btnBuyNow?.classList.add('opacity-50', 'cursor-not-allowed');
    } else {
        if (btnAddCart) btnAddCart.disabled = false;
        if (btnBuyNow) btnBuyNow.disabled = false;
        btnAddCart?.classList.remove('opacity-50', 'cursor-not-allowed');
        btnBuyNow?.classList.remove('opacity-50', 'cursor-not-allowed');
    }
    
    // Show varian message
    const varianInfo = document.getElementById('varian-info');
    const varianMessage = document.getElementById('varian-message');
    
    if (hargaTambahan > 0) {
        varianMessage.textContent = `Varian "${namaVarian}" +Rp${hargaTambahan.toLocaleString('id-ID')}`;
        varianInfo.classList.remove('hidden');
    } else {
        varianInfo.classList.add('hidden');
    }
}

// Quantity controls
function increaseQty() {
    const input = document.getElementById('qty');
    const max = parseInt(input.max);
    const current = parseInt(input.value);
    if (current < max) {
        input.value = current + 1;
    }
}

function decreaseQty() {
    const input = document.getElementById('qty');
    const min = parseInt(input.min);
    const current = parseInt(input.value);
    if (current > min) {
        input.value = current - 1;
    }
}

// Beli Sekarang - Add to cart then redirect to checkout
function beliSekarang() {
    const form = document.getElementById('add-to-cart-form');
    const formData = new FormData(form);
    
    fetch(form.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.href = '{{ route("checkout.index") }}';
        } else {
            alert(data.message || 'Gagal menambahkan ke keranjang');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        // Fallback: submit form normally
        form.submit();
        setTimeout(() => {
            window.location.href = '{{ route("checkout.index") }}';
        }, 500);
    });
}

// Success/Error Messages
@if(session('success'))
    showNotification('success', '{{ session('success') }}');
@endif

@if(session('error'))
    showNotification('error', '{{ session('error') }}');
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