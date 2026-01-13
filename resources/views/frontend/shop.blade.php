@extends('frontend.layouts.app')

@section('title', 'Shop - Emina Beauty')

@section('content')

{{-- Breadcrumb --}}
<div class="bg-gray-50 border-b">
    <div class="container mx-auto px-4 py-3">
        <nav class="flex items-center text-sm" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="text-gray-500 hover:text-primary transition">
                <i class="fas fa-home mr-1"></i>Home
            </a>
            <i class="fas fa-chevron-right mx-2 text-gray-400 text-xs"></i>
            <span class="text-gray-800 font-medium">Shop</span>
        </nav>
    </div>
</div>

{{-- Shop Section --}}
<section class="py-4 md:py-6 bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4">
        
        <div class="flex gap-4">
            
            {{-- Sidebar Filter (Desktop) --}}
            <div class="hidden lg:block w-64 flex-shrink-0">
                <div class="bg-white rounded-lg shadow-sm sticky top-20">
                    {{-- Filter Header --}}
                    <div class="p-4 border-b">
                        <h3 class="font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-sliders-h mr-2 text-primary"></i>
                            Filter Pencarian
                        </h3>
                    </div>

                    <form action="{{ route('shop.index') }}" method="GET" id="filter-form" class="p-4 space-y-4">
                        
                        {{-- Kategori --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Kategori</label>
                            <select name="kategori" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-1 focus:ring-primary focus:border-primary">
                                <option value="">Semua Kategori</option>
                                @foreach($kategori as $kat)
                                    <option value="{{ $kat->id }}" {{ request('kategori') == $kat->id ? 'selected' : '' }}>
                                        {{ $kat->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Harga --}}
                        <div class="border-t pt-4">
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Rentang Harga</label>
                            <div class="space-y-2">
                                <input type="number" name="harga_min" value="{{ request('harga_min') }}" 
                                       placeholder="Harga Min" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-1 focus:ring-primary focus:border-primary">
                                <input type="number" name="harga_max" value="{{ request('harga_max') }}" 
                                       placeholder="Harga Max" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-1 focus:ring-primary focus:border-primary">
                            </div>
                        </div>

                        {{-- Buttons --}}
                        <div class="space-y-2 border-t pt-4">
                            <button type="submit" class="w-full bg-primary hover:bg-accent text-white py-2 rounded-md font-medium text-sm transition">
                                Terapkan
                            </button>
                            <a href="{{ route('shop.index') }}" class="block w-full text-center border border-gray-300 text-gray-700 py-2 rounded-md font-medium text-sm hover:bg-gray-50 transition">
                                Atur Ulang
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Main Content --}}
            <div class="flex-1 min-w-0">
                
                {{-- Sort & Filter Bar --}}
                <div class="bg-white rounded-lg shadow-sm p-4 mb-4">
                    <div class="flex items-center justify-between flex-wrap gap-3">
                        {{-- Sort Options --}}
                        <div class="flex items-center gap-2 overflow-x-auto">
                            <span class="text-sm text-gray-600 whitespace-nowrap">Urutkan:</span>
                            <div class="flex gap-2">
                                <a href="{{ route('shop.index', array_merge(request()->except('sort'), ['sort' => 'terbaru'])) }}" 
                                   class="px-3 py-1.5 text-sm rounded-md transition {{ request('sort') == 'terbaru' || !request('sort') ? 'bg-primary text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                                    Terbaru
                                </a>
                                <a href="{{ route('shop.index', array_merge(request()->except('sort'), ['sort' => 'termurah'])) }}" 
                                   class="px-3 py-1.5 text-sm rounded-md transition {{ request('sort') == 'termurah' ? 'bg-primary text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                                    Termurah
                                </a>
                                <a href="{{ route('shop.index', array_merge(request()->except('sort'), ['sort' => 'termahal'])) }}" 
                                   class="px-3 py-1.5 text-sm rounded-md transition {{ request('sort') == 'termahal' ? 'bg-primary text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                                    Termahal
                                </a>
                            </div>
                        </div>

                        {{-- Results Count & Mobile Filter --}}
                        <div class="flex items-center gap-3">
                            <span class="text-sm text-gray-600 whitespace-nowrap">
                                <strong class="text-gray-800">{{ $produk->total() }}</strong> Produk
                            </span>
                            <button onclick="toggleMobileFilter()" class="lg:hidden bg-primary text-white px-4 py-2 rounded-md text-sm font-medium">
                                <i class="fas fa-filter mr-1"></i> Filter
                            </button>
                        </div>
                    </div>

                    {{-- Active Filters --}}
                    @if(request()->hasAny(['search', 'kategori', 'harga_min', 'harga_max']))
                        <div class="flex items-center gap-2 mt-3 pt-3 border-t flex-wrap">
                            <span class="text-xs text-gray-600">Filter aktif:</span>
                            
                            @if(request('search'))
                                <span class="inline-flex items-center gap-1 bg-primary/10 text-primary px-2 py-1 rounded-full text-xs">
                                    "{{ request('search') }}"
                                    <a href="{{ route('shop.index', request()->except('search')) }}" class="hover:text-accent">
                                        <i class="fas fa-times"></i>
                                    </a>
                                </span>
                            @endif
                            
                            @if(request('kategori'))
                                <span class="inline-flex items-center gap-1 bg-primary/10 text-primary px-2 py-1 rounded-full text-xs">
                                    {{ $kategori->firstWhere('id', request('kategori'))->nama_kategori ?? 'Kategori' }}
                                    <a href="{{ route('shop.index', request()->except('kategori')) }}" class="hover:text-accent">
                                        <i class="fas fa-times"></i>
                                    </a>
                                </span>
                            @endif
                            
                            @if(request('harga_min') || request('harga_max'))
                                <span class="inline-flex items-center gap-1 bg-primary/10 text-primary px-2 py-1 rounded-full text-xs">
                                    Rp {{ number_format(request('harga_min', 0)) }} - Rp {{ number_format(request('harga_max', 999999)) }}
                                    <a href="{{ route('shop.index', request()->except(['harga_min', 'harga_max'])) }}" class="hover:text-accent">
                                        <i class="fas fa-times"></i>
                                    </a>
                                </span>
                            @endif
                            
                            <a href="{{ route('shop.index') }}" class="text-xs text-accent hover:underline ml-2">
                                Hapus Semua
                            </a>
                        </div>
                    @endif
                </div>

                {{-- Products Grid --}}
                @if($produk->count() > 0)
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-3 md:gap-4">
                        @foreach($produk as $item)
                            <div class="bg-white rounded-lg shadow-sm overflow-hidden group hover:shadow-md transition card-shadow">
                                <a href="{{ route('shop.show', $item->id) }}" class="block">
                                    <div class="relative aspect-square overflow-hidden bg-gray-100">
                                        @if($item->foto)
                                            <img src="{{ asset('storage/img-produk/thumb_md_' . $item->foto) }}" 
                                                 alt="{{ $item->nama_produk }}" 
                                                 class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                        @else
                                            <div class="w-full h-full bg-gradient-to-br from-primary to-accent flex items-center justify-center">
                                                <i class="fas fa-image text-white text-3xl"></i>
                                            </div>
                                        @endif
                                        
                                        {{-- Stock Badge --}}
                                        @if($item->stok == 0)
                                            <div class="absolute inset-0 bg-black/50 flex items-center justify-center">
                                                <span class="bg-red-500 text-white text-xs px-3 py-1 rounded-full font-semibold">
                                                    Habis
                                                </span>
                                            </div>
                                        @elseif($item->stok < 10)
                                            <span class="absolute top-2 left-2 bg-orange-500 text-white text-xs px-2 py-1 rounded-md font-semibold">
                                                Sisa {{ $item->stok }}
                                            </span>
                                        @endif
                                    </div>
                                </a>
                                
                                <div class="p-3">
                                    <a href="{{ route('shop.show', $item->id) }}">
                                        <h3 class="text-sm text-gray-800 mb-1 line-clamp-2 group-hover:text-primary transition min-h-[2.5rem]">
                                            {{ $item->nama_produk }}
                                        </h3>
                                    </a>
                                    
                                    <div class="flex items-baseline justify-between mt-2">
                                        <span class="text-primary font-bold text-base">
                                            Rp {{ number_format($item->harga, 0, ',', '.') }}
                                        </span>
                                    </div>

                                    <div class="flex items-center text-xs text-gray-500 mt-1">
                                        <i class="fas fa-map-marker-alt mr-1"></i>
                                        <span>Jakarta</span>
                                        <span class="mx-2">•</span>
                                        <span>{{ $item->stok > 0 ? 'Stok: ' . $item->stok : 'Habis' }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-6">
                        {{ $produk->links() }}
                    </div>
                @else
                    {{-- Empty State --}}
                    <div class="bg-white rounded-lg shadow-sm p-12 text-center">
                        <div class="max-w-md mx-auto">
                            <i class="fas fa-search text-gray-300 text-6xl mb-4"></i>
                            <h3 class="text-xl font-bold text-gray-700 mb-2">Produk Tidak Ditemukan</h3>
                            <p class="text-gray-500 mb-6">Maaf, produk yang Anda cari tidak tersedia. Coba ubah filter atau kata kunci pencarian.</p>
                            <a href="{{ route('shop.index') }}" class="inline-block bg-primary hover:bg-accent text-white px-6 py-2.5 rounded-md font-medium transition">
                                <i class="fas fa-redo mr-2"></i> Lihat Semua Produk
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

{{-- Mobile Filter Modal --}}
<div id="mobile-filter-modal" class="fixed inset-0 bg-black/50 z-50 hidden">
    <div class="fixed inset-x-0 bottom-0 bg-white rounded-t-2xl max-h-[80vh] overflow-y-auto">
        <div class="sticky top-0 bg-white border-b p-4 flex items-center justify-between">
            <h3 class="font-semibold text-gray-800">Filter Produk</h3>
            <button onclick="toggleMobileFilter()" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <form action="{{ route('shop.index') }}" method="GET" class="p-4 space-y-4">
            {{-- Kategori --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Kategori</label>
                <select name="kategori" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm">
                    <option value="">Semua Kategori</option>
                    @foreach($kategori as $kat)
                        <option value="{{ $kat->id }}" {{ request('kategori') == $kat->id ? 'selected' : '' }}>
                            {{ $kat->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Harga --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Rentang Harga</label>
                <div class="space-y-2">
                    <input type="number" name="harga_min" value="{{ request('harga_min') }}" 
                           placeholder="Harga Minimum" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm">
                    <input type="number" name="harga_max" value="{{ request('harga_max') }}" 
                           placeholder="Harga Maksimum" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm">
                </div>
            </div>

            {{-- Buttons --}}
            <div class="sticky bottom-0 bg-white pt-4 space-y-2 border-t">
                <button type="submit" class="w-full bg-primary hover:bg-accent text-white py-3 rounded-md font-medium transition">
                    Terapkan Filter
                </button>
                <a href="{{ route('shop.index') }}" class="block w-full text-center border border-gray-300 text-gray-700 py-3 rounded-md font-medium hover:bg-gray-50 transition">
                    Atur Ulang
                </a>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
// Success/Error Messages
@if(session('success'))
    showNotification('success', '{{ session('success') }}');
@endif

@if(session('error'))
    showNotification('error', '{{ session('error') }}');
@endif

// Mobile Filter Toggle
function toggleMobileFilter() {
    const modal = document.getElementById('mobile-filter-modal');
    modal.classList.toggle('hidden');
}

// Close modal when clicking backdrop
document.getElementById('mobile-filter-modal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        toggleMobileFilter();
    }
});

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

<style>
@keyframes slide-in {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

.animate-slide-in {
    animation: slide-in 0.3s ease-out;
}
</style>
@endpush