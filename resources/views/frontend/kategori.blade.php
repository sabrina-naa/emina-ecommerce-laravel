@extends('frontend.layouts.app')

@section('title', $pageTitle . ' - Emina Beauty')

@section('content')

{{-- Breadcrumb --}}
<div class="bg-gray-50 border-b">
    <div class="container mx-auto px-4 py-3">
        <nav class="flex items-center text-sm" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="text-gray-500 hover:text-primary transition">
                <i class="fas fa-home mr-1"></i>Home
            </a>
            <i class="fas fa-chevron-right mx-2 text-gray-400 text-xs"></i>
            <span class="text-gray-800 font-medium">{{ $pageTitle }}</span>
        </nav>
    </div>
</div>

{{-- Category Banner --}}
@php
    $bannerImage = match ($pageSlug) {
        'makeup' => 'makeup.png',
        'skincare' => 'skincare.png',
        'lip-products' => 'lipproduct.png',
        'sun-protection' => 'sunprotection.png',
        default => 'home1.png',
    };
@endphp

<section
    class="relative h-[420px] flex items-center justify-center text-white category-banner"
    style="
        background-image: url('{{ asset('image/' . $bannerImage) }}');
        background-size: cover;
        background-position: center;
    "
>
    {{-- Overlay --}}
    <div class="absolute inset-0 bg-black/40"></div>

    {{-- Content --}}
    <div class="relative z-10 text-center px-4 max-w-3xl">
        <h1 class="text-3xl md:text-5xl font-bold mb-4">
            {{ $pageTitle }}
        </h1>

        <p class="text-lg md:text-xl text-white/90">
            @if ($pageSlug === 'makeup')
                Tampil cantik dan percaya diri dengan koleksi makeup terbaik dari Emina!
            @elseif ($pageSlug === 'skincare')
                Rawat kulitmu dengan produk skincare yang aman dan berkualitas!
            @elseif ($pageSlug === 'lip-products')
                Bibir cantik dan sehat dengan pilihan lip products favoritmu!
            @elseif ($pageSlug === 'sun-protection')
                Lindungi kulitmu dari sinar matahari dengan sun protection terbaik setiap hari!
            @endif
        </p>

        <div class="mt-8 inline-flex items-center gap-4 bg-white/20 backdrop-blur-md rounded-full px-6 py-3">
            <div>
                <div class="text-2xl font-bold">{{ $produk->total() }}</div>
                <div class="text-sm text-white/80">Produk Tersedia</div>
            </div>
        </div>
    </div>
</section>


{{-- Products Section --}}
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

                    <form action="{{ route($pageSlug) }}" method="GET" id="filter-form" class="p-4 space-y-4">

                        {{-- Harga --}}
                        <div>
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
                            <a href="{{ route($pageSlug) }}" class="block w-full text-center border border-gray-300 text-gray-700 py-2 rounded-md font-medium text-sm hover:bg-gray-50 transition">
                                Atur Ulang
                            </a>
                        </div>
                    </form>

                    {{-- Quick Links --}}
                    <div class="p-4 border-t">
                        <h4 class="text-sm font-semibold text-gray-700 mb-3">Kategori Lainnya</h4>
                        <div class="space-y-2">
                            @if($pageSlug != 'makeup')
                                <a href="{{ route('makeup') }}" class="block text-sm text-gray-600 hover:text-primary transition">
                                    <i class="fas fa-palette mr-2"></i> Makeup
                                </a>
                            @endif
                            @if($pageSlug != 'skincare')
                                <a href="{{ route('skincare') }}" class="block text-sm text-gray-600 hover:text-primary transition">
                                    <i class="fas fa-spa mr-2"></i> Skincare
                                </a>
                            @endif
                            @if($pageSlug != 'lip-products')
                                <a href="{{ route('lip-products') }}" class="block text-sm text-gray-600 hover:text-primary transition">
                                    <i class="fas fa-kiss-wink-heart mr-2"></i> Lip Products
                                </a>
                            @endif
                            @if($pageSlug != 'sun-protection')
                                <a href="{{ route('sun-protection') }}" class="block text-sm text-gray-600 hover:text-primary transition">
                                    <i class="fas fa-sun mr-2"></i> Sun Protection
                                </a>
                            @endif
                            <a href="{{ route('shop.index') }}" class="block text-sm text-gray-600 hover:text-primary transition">
                                <i class="fas fa-th-large mr-2"></i> Semua Produk
                            </a>
                        </div>
                    </div>
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
                                <a href="{{ route($pageSlug, array_merge(request()->except('sort'), ['sort' => 'terbaru'])) }}" 
                                   class="px-3 py-1.5 text-sm rounded-md transition {{ request('sort') == 'terbaru' || !request('sort') ? 'bg-primary text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                                    Terbaru
                                </a>
                                <a href="{{ route($pageSlug, array_merge(request()->except('sort'), ['sort' => 'termurah'])) }}" 
                                   class="px-3 py-1.5 text-sm rounded-md transition {{ request('sort') == 'termurah' ? 'bg-primary text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                                    Termurah
                                </a>
                                <a href="{{ route($pageSlug, array_merge(request()->except('sort'), ['sort' => 'termahal'])) }}" 
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
                    @if(request()->hasAny(['search', 'harga_min', 'harga_max']))
                        <div class="flex items-center gap-2 mt-3 pt-3 border-t flex-wrap">
                            <span class="text-xs text-gray-600">Filter aktif:</span>
                            
                            @if(request('search'))
                                <span class="inline-flex items-center gap-1 bg-primary/10 text-primary px-2 py-1 rounded-full text-xs">
                                    "{{ request('search') }}"
                                    <a href="{{ route($pageSlug, request()->except('search')) }}" class="hover:text-accent">
                                        <i class="fas fa-times"></i>
                                    </a>
                                </span>
                            @endif
                            
                            @if(request('harga_min') || request('harga_max'))
                                <span class="inline-flex items-center gap-1 bg-primary/10 text-primary px-2 py-1 rounded-full text-xs">
                                    Rp {{ number_format(request('harga_min', 0)) }} - Rp {{ number_format(request('harga_max', 999999)) }}
                                    <a href="{{ route($pageSlug, request()->except(['harga_min', 'harga_max'])) }}" class="hover:text-accent">
                                        <i class="fas fa-times"></i>
                                    </a>
                                </span>
                            @endif
                            
                            <a href="{{ route($pageSlug) }}" class="text-xs text-accent hover:underline ml-2">
                                Hapus Semua
                            </a>
                        </div>
                    @endif
                </div>

                {{-- Products Grid --}}
                @if($produk->count() > 0)
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-3 md:gap-4">
                        @foreach($produk as $item)
                            <div class="bg-white rounded-lg shadow-sm overflow-hidden group hover:shadow-md transition">
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
                                            <span class="absolute top-2 right-2 bg-orange-500 text-white text-xs px-2 py-1 rounded-md font-semibold">
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
                            <i class="fas fa-box-open text-gray-300 text-6xl mb-4"></i>
                            <h3 class="text-xl font-bold text-gray-700 mb-2">Produk Tidak Ditemukan</h3>
                            <p class="text-gray-500 mb-6">Maaf, belum ada produk {{ $pageTitle }} yang tersedia saat ini.</p>
                            <a href="{{ route('shop.index') }}" class="inline-block bg-primary hover:bg-accent text-white px-6 py-2.5 rounded-md font-medium transition">
                                <i class="fas fa-shopping-bag mr-2"></i> Lihat Semua Produk
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

        <form action="{{ route($pageSlug) }}" method="GET" class="p-4 space-y-4">
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
                <a href="{{ route($pageSlug) }}" class="block w-full text-center border border-gray-300 text-gray-700 py-3 rounded-md font-medium hover:bg-gray-50 transition">
                    Atur Ulang
                </a>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
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
</script>
@endpush