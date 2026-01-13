@extends('frontend.layouts.app')

@section('title', 'Pesanan Saya - Emina Beauty')

@section('content')

{{-- Breadcrumb --}}
<div class="bg-gray-50 border-b">
    <div class="container mx-auto px-4 py-3">
        <nav class="flex items-center text-sm" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="text-gray-500 hover:text-primary transition">
                <i class="fas fa-home mr-1"></i>Home
            </a>
            <i class="fas fa-chevron-right mx-2 text-gray-400 text-xs"></i>
            <span class="text-gray-800 font-medium">Pesanan Saya</span>
        </nav>
    </div>
</div>

{{-- Orders Section --}}
<section class="py-6 md:py-12 bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4">

        <div class="flex flex-col lg:flex-row gap-6">
            
            {{-- Sidebar --}}
            <div class="lg:w-64 flex-shrink-0">
                <div class="bg-white rounded-lg shadow-sm p-4 sticky top-20">
                    {{-- User Info --}}
                    <div class="text-center mb-4 pb-4 border-b">
                        <div class="w-16 h-16 bg-gradient-to-r from-primary to-accent rounded-full flex items-center justify-center mx-auto mb-2">
                            @if(Auth::guard('customer')->user()->foto)
                                <img src="{{ asset('storage/img-customer/' . Auth::guard('customer')->user()->foto) }}" 
                                     alt="{{ Auth::guard('customer')->user()->nama }}"
                                     class="w-full h-full object-cover rounded-full">
                            @else
                                <i class="fas fa-user text-white text-2xl"></i>
                            @endif
                        </div>
                        <h3 class="font-bold text-gray-800 text-sm">{{ Auth::guard('customer')->user()->nama }}</h3>
                        <p class="text-xs text-gray-500">{{ Auth::guard('customer')->user()->email }}</p>
                    </div>

                    {{-- Menu --}}
                    <nav class="space-y-1">
                        <a href="{{ route('customer.profile') }}" 
                           class="flex items-center px-3 py-2 text-gray-700 hover:bg-gray-50 rounded-md transition text-sm">
                            <i class="fas fa-user w-5 mr-2"></i> Profile
                        </a>
                        <a href="{{ route('customer.orders') }}" 
                           class="flex items-center px-3 py-2 bg-primary text-white rounded-md font-medium text-sm">
                            <i class="fas fa-receipt w-5 mr-2"></i> Pesanan Saya
                        </a>
                        <form action="{{ route('customer.logout') }}" method="POST">
                            @csrf
                            <button type="submit" 
                                    class="w-full flex items-center px-3 py-2 text-red-600 hover:bg-red-50 rounded-md transition text-sm">
                                <i class="fas fa-sign-out-alt w-5 mr-2"></i> Logout
                            </button>
                        </form>
                    </nav>
                </div>
            </div>

            {{-- Orders List --}}
            <div class="flex-1">
                <div class="mb-6">
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2">
                        Pesanan Saya
                    </h1>
                    <p class="text-sm text-gray-600">Kelola dan lacak pesanan Anda</p>
                </div>

                @if($orders->count() > 0)
                    <div class="space-y-4">
                        @foreach($orders as $order)
                            <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition">
                                {{-- Order Header --}}
                                <div class="bg-gradient-to-r from-primary to-accent text-white p-4">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-xs opacity-90 mb-1">Nomor Pesanan</p>
                                            <h3 class="text-lg font-bold">{{ $order->kode_transaksi }}</h3>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-xs opacity-90 mb-1">Tanggal</p>
                                            <p class="text-sm font-semibold">{{ $order->created_at->format('d M Y') }}</p>
                                        </div>
                                    </div>
                                    
                                    <div class="flex flex-wrap gap-2 mt-3">
                                        @if($order->nomor_resi)
                                            <span class="text-xs text-white opacity-90">
                                                <i class="fas fa-truck mr-1"></i>
                                                Resi: <strong>{{ $order->nomor_resi }}</strong>
                                            </span>
                                        @endif
                                        {{-- Status Pembayaran --}}
                                        @if($order->status_pembayaran == 'pending')
                                            <span class="px-2 py-1 bg-yellow-500 bg-opacity-30 text-white rounded-md text-xs font-semibold">
                                                <i class="fas fa-clock mr-1"></i> Menunggu Pembayaran
                                            </span>
                                        @elseif($order->status_pembayaran == 'paid')
                                            <span class="px-2 py-1 bg-green-500 bg-opacity-30 text-white rounded-md text-xs font-semibold">
                                                <i class="fas fa-check-circle mr-1"></i> Lunas
                                            </span>
                                        @elseif($order->status_pembayaran == 'failed')
                                            <span class="px-2 py-1 bg-gray-500 bg-opacity-30 text-white rounded-md text-xs font-semibold">
                                                <i class="fas fa-times-circle mr-1"></i> Gagal
                                            </span>
                                        @else
                                            <span class="px-2 py-1 bg-gray-500 bg-opacity-30 text-white rounded-md text-xs font-semibold">
                                                <i class="fas fa-question-circle mr-1"></i> {{ ucfirst($order->status_pembayaran) }}
                                            </span>
                                        @endif

                                        {{-- Status Pengiriman --}}
                                        @if($order->status_pengiriman == 'pending')
                                            <span class="px-2 py-1 bg-blue-500 bg-opacity-30 text-white rounded-md text-xs font-semibold">
                                                <i class="fas fa-box mr-1"></i> Belum Diproses
                                            </span>
                                        @elseif($order->status_pengiriman == 'processing')
                                            <span class="px-2 py-1 bg-purple-500 bg-opacity-30 text-white rounded-md text-xs font-semibold">
                                                <i class="fas fa-cog mr-1"></i> Sedang Diproses
                                            </span>
                                        @elseif($order->status_pengiriman == 'shipped')
                                            <span class="px-2 py-1 bg-orange-500 bg-opacity-30 text-white rounded-md text-xs font-semibold">
                                                <i class="fas fa-shipping-fast mr-1"></i> Sedang Dikirim
                                            </span>
                                        @elseif($order->status_pengiriman == 'delivered')
                                            <span class="px-2 py-1 bg-green-500 bg-opacity-30 text-white rounded-md text-xs font-semibold">
                                                <i class="fas fa-check-double mr-1"></i> Selesai
                                            </span>
                                        @else
                                            <span class="px-2 py-1 bg-gray-500 bg-opacity-30 text-white rounded-md text-xs font-semibold">
                                                <i class="fas fa-question-circle mr-1"></i> {{ ucfirst($order->status_pengiriman) }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                {{-- Order Body --}}
                                <div class="p-4">
                                    {{-- Products --}}
                                    <div class="space-y-2 mb-4">
                                        @foreach($order->details as $detail)
                                            <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
                                                <div class="flex-shrink-0">
                                                    @if($detail->produk && $detail->produk->foto)
                                                        <img src="{{ asset('storage/img-produk/thumb_sm_' . $detail->produk->foto) }}" 
                                                             alt="{{ $detail->produk->nama_produk ?? 'Produk' }}" 
                                                             class="w-12 h-12 object-cover rounded-md">
                                                    @else
                                                        <div class="w-12 h-12 bg-gradient-to-br from-primary to-accent rounded-md flex items-center justify-center">
                                                            <i class="fas fa-image text-white text-sm"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <h4 class="text-sm font-semibold text-gray-800 truncate">
                                                        {{ $detail->produk->nama_produk ?? 'Produk' }}
                                                    </h4>
                                                    <p class="text-xs text-gray-500">
                                                        {{ $detail->qty }} x Rp{{ number_format($detail->produk->harga ?? 0, 0, ',', '.') }}
                                                    </p>
                                                </div>
                                                <div class="text-right">
                                                    <p class="text-sm font-bold text-primary">
                                                        Rp{{ number_format($detail->subtotal, 0, ',', '.') }}
                                                    </p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    {{-- Total & Actions --}}
                                    <div class="flex items-center justify-between pt-4 border-t">
                                        <div>
                                            <p class="text-xs text-gray-500 mb-1">Total Pembayaran</p>
                                            <p class="text-xl font-bold text-primary">
                                                Rp{{ number_format($order->total_harga, 0, ',', '.') }}
                                            </p>
                                        </div>
                                        <div class="flex gap-2">
                                            <a href="{{ route('customer.orders.detail', $order->id) }}" 
                                               class="bg-gray-100 text-gray-700 px-4 py-2 rounded-md text-sm font-medium hover:bg-gray-200 transition">
                                                <i class="fas fa-eye mr-1"></i> Detail
                                            </a>
                                            @if($order->status_pembayaran == 'pending')
                                                <a href="{{ route('checkout.success', $order->id) }}" 
                                                   class="bg-primary hover:bg-accent text-white px-4 py-2 rounded-md text-sm font-semibold transition">
                                                    <i class="fas fa-credit-card mr-1"></i> Bayar
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-6">
                        {{ $orders->links() }}
                    </div>
                @else
                    {{-- Empty State --}}
                    <div class="bg-white rounded-lg shadow-sm p-12 text-center">
                        <div class="inline-block bg-gray-100 rounded-full p-8 mb-4">
                            <i class="fas fa-receipt text-gray-300 text-5xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-700 mb-2">Belum Ada Pesanan</h3>
                        <p class="text-gray-500 mb-6">Yuk, mulai belanja dan buat pesanan pertamamu!</p>
                        <a href="{{ route('shop.index') }}" 
                           class="inline-block bg-primary hover:bg-accent text-white px-8 py-3 rounded-md font-semibold transition">
                            <i class="fas fa-shopping-bag mr-2"></i> Mulai Belanja
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
@if(session('success'))
    showNotification('success', '{{ session('success') }}');
@endif

@if(session('error'))
    showNotification('error', '{{ session('error') }}');
@endif

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