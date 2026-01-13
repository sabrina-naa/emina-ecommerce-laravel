@extends('frontend.layouts.app')

@section('title', 'Detail Pesanan - Emina Beauty')

@section('content')

<!-- Breadcrumb -->
<div class="bg-gray-100 py-4">
    <div class="container mx-auto px-4">
        <nav class="flex text-sm" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="text-gray-500 hover:text-primary">Home</a>
            <span class="mx-2 text-gray-400">/</span>
            <a href="{{ route('customer.orders') }}" class="text-gray-500 hover:text-primary">Pesanan Saya</a>
            <span class="mx-2 text-gray-400">/</span>
            <span class="text-gray-700 font-semibold">{{ $order->kode_transaksi }}</span>
        </nav>
    </div>
</div>

<!-- Order Detail Section -->
<section class="py-12 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            
            <!-- Header -->
            <div class="bg-gradient-to-r from-primary to-accent text-white rounded-3xl p-8 mb-8 shadow-2xl">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <p class="text-sm opacity-90 mb-1">Nomor Pesanan</p>
                        <h1 class="text-3xl font-bold">{{ $order->kode_transaksi }}</h1>
                    </div>
                    <div class="text-right">
                        <p class="text-sm opacity-90 mb-1">Tanggal Pesanan</p>
                        <p class="text-xl font-semibold">{{ $order->created_at->format('d F Y, H:i') }}</p>
                    </div>
                </div>

                <div class="flex items-center space-x-3">
                    @if($order->nomor_resi)
                        <div class="mt-4 text-sm text-white opacity-90">
                            <i class="fas fa-truck mr-1"></i>
                            Nomor Resi: <strong>{{ $order->nomor_resi }}</strong>
                        </div>
                    @endif
                    @if($order->status_pembayaran == 'pending')
                        <span class="px-4 py-2 bg-yellow-500 bg-opacity-30 rounded-full font-semibold">
                            <i class="fas fa-clock mr-1"></i> Menunggu Pembayaran
                        </span>
                    @elseif($order->status_pembayaran == 'paid')
                        <span class="px-4 py-2 bg-green-500 bg-opacity-30 rounded-full font-semibold">
                            <i class="fas fa-check-circle mr-1"></i> Dibayar
                        </span>
                    @else
                        <span class="px-4 py-2 bg-gray-500 bg-opacity-30 rounded-full font-semibold">
                            <i class="fas fa-times-circle mr-1"></i> Gagal
                        </span>
                    @endif

                    @if($order->status_pengiriman == 'pending')
                        <span class="px-4 py-2 bg-blue-500 bg-opacity-30 rounded-full font-semibold">
                            <i class="fas fa-box mr-1"></i> Pending
                        </span>
                    @elseif($order->status_pengiriman == 'diproses')
                        <span class="px-4 py-2 bg-purple-500 bg-opacity-30 rounded-full font-semibold">
                            <i class="fas fa-spinner mr-1"></i> Diproses
                        </span>
                    @elseif($order->status_pengiriman == 'dikirim')
                        <span class="px-4 py-2 bg-orange-500 bg-opacity-30 rounded-full font-semibold">
                            <i class="fas fa-shipping-fast mr-1"></i> Dikirim
                        </span>
                    @elseif($order->status_pengiriman == 'selesai')
                        <span class="px-4 py-2 bg-green-500 bg-opacity-30 rounded-full font-semibold">
                            <i class="fas fa-check-double mr-1"></i> Selesai
                        </span>
                    @endif
                </div>
            </div>
            <!-- Lacak Pesanan -->
            <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
                <h3 class="font-bold text-gray-800 mb-6 flex items-center">
                    <i class="fas fa-route text-primary mr-2"></i> Lacak Pesanan
                </h3>

                <div class="flex items-center justify-between text-center">

                    {{-- Step 1 --}}
                    <div class="flex-1">
                        <div class="w-10 h-10 mx-auto rounded-full flex items-center justify-center
                            {{ in_array($order->status_pengiriman, ['pending','diproses','dikirim','selesai']) ? 'bg-primary text-white' : 'bg-gray-300 text-gray-500' }}">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <p class="mt-2 text-sm font-semibold">Pesanan Dibuat</p>
                    </div>

                    <div class="flex-1 h-1 bg-gray-300 mx-2"></div>

                    {{-- Step 2 --}}
                    <div class="flex-1">
                        <div class="w-10 h-10 mx-auto rounded-full flex items-center justify-center
                            {{ in_array($order->status_pengiriman, ['diproses','dikirim','selesai']) ? 'bg-primary text-white' : 'bg-gray-300 text-gray-500' }}">
                            <i class="fas fa-cogs"></i>
                        </div>
                        <p class="mt-2 text-sm font-semibold">Diproses</p>
                    </div>

                    <div class="flex-1 h-1 bg-gray-300 mx-2"></div>

                    {{-- Step 3 --}}
                    <div class="flex-1">
                        <div class="w-10 h-10 mx-auto rounded-full flex items-center justify-center
                            {{ in_array($order->status_pengiriman, ['dikirim','selesai']) ? 'bg-primary text-white' : 'bg-gray-300 text-gray-500' }}">
                            <i class="fas fa-truck"></i>
                        </div>
                        <p class="mt-2 text-sm font-semibold">Dikirim</p>
                    </div>

                    <div class="flex-1 h-1 bg-gray-300 mx-2"></div>

                    {{-- Step 4 --}}
                    <div class="flex-1">
                        <div class="w-10 h-10 mx-auto rounded-full flex items-center justify-center
                            {{ strtolower($order->status_pengiriman) == 'selesai'
                                ? 'bg-green-500 text-white'
                                : 'bg-gray-300 text-gray-500' }}">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <p class="mt-2 text-sm font-semibold">Selesai</p>
                    </div>
                </div>
            </div>

            <!-- Form Review Section - FIXED -->
            @if($order->status_pengiriman == 'selesai')
            <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
                <h3 class="font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-star text-yellow-400 mr-2"></i> Beri Rating Pesanan
                </h3>

                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4">
                        <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4">
                        <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
                    </div>
                @endif

                <!-- Loop untuk setiap produk -->
                @foreach($order->details as $detail)
                    @php
                        $existingReview = \App\Models\Review::where('transaksi_id', $order->id)
                            ->where('produk_id', $detail->produk_id)
                            ->where('customer_id', Auth::guard('customer')->id())
                            ->first();
                    @endphp

                    <div class="border border-gray-200 rounded-lg p-4 mb-4">
                        <div class="flex items-start space-x-4 mb-4">
                            <div class="flex-shrink-0">
                                @if($detail->produk && $detail->produk->foto)
                                    <img src="{{ asset('storage/img-produk/thumb_sm_' . $detail->produk->foto) }}" 
                                         alt="{{ $detail->nama_produk }}" 
                                         class="w-20 h-20 object-cover rounded-lg">
                                @else
                                    <div class="w-20 h-20 bg-gradient-to-br from-primary to-accent rounded-lg flex items-center justify-center">
                                        <i class="fas fa-image text-white text-2xl"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1">
                                <h4 class="font-semibold text-gray-800">{{ $detail->produk->nama_produk ?? 'Produk Tidak Ditemukan' }}</h4>
                                <p class="text-sm text-gray-500">{{ $detail->qty }} x Rp {{ number_format($detail->harga, 0, ',', '.') }}</p>
                            </div>
                        </div>

                        @if($existingReview)
                            <!-- Review sudah ada -->
                            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                <div class="flex items-center mb-2">
                                    <i class="fas fa-check-circle text-green-600 mr-2"></i>
                                    <span class="text-green-700 font-semibold">Review sudah diberikan</span>
                                </div>
                                <div class="mb-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= $existingReview->rating ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                                    @endfor
                                    <span class="ml-2 text-sm text-gray-600">{{ $existingReview->rating }}/5</span>
                                </div>
                                <p class="text-gray-700 text-sm">{{ $existingReview->review }}</p>
                                
                                @if($existingReview->admin_reply)
                                    <div class="mt-3 bg-blue-50 border border-blue-200 rounded-lg p-3">
                                        <p class="text-xs text-blue-600 font-semibold mb-1">
                                            <i class="fas fa-reply mr-1"></i> Balasan Admin:
                                        </p>
                                        <p class="text-sm text-blue-900">{{ $existingReview->admin_reply }}</p>
                                    </div>
                                @endif
                            </div>
                        @else
                            <!-- Form Review -->
                            <form action="{{ route('customer.review.store') }}" method="POST" class="review-form">
                                @csrf
                                <input type="hidden" name="transaksi_id" value="{{ $order->id }}">
                                <input type="hidden" name="produk_id" value="{{ $detail->produk_id }}">

                                <div class="mb-3">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Rating:</label>
                                    <div class="flex items-center space-x-1">
                                        @for($i = 5; $i >= 1; $i--)
                                            <input type="radio" 
                                                   id="star_{{ $detail->produk_id }}_{{ $i }}" 
                                                   name="rating" 
                                                   value="{{ $i }}" 
                                                   class="hidden peer/star{{ $i }}"
                                                   required>
                                            <label for="star_{{ $detail->produk_id }}_{{ $i }}" 
                                                   class="cursor-pointer text-3xl text-gray-300 hover:text-yellow-400 transition peer-checked/star{{ $i }}:text-yellow-400">
                                                ★
                                            </label>
                                        @endfor
                                    </div>
                                    @error('rating')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Ulasan:</label>
                                    <textarea name="review" 
                                              rows="3"
                                              class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-primary focus:border-primary"
                                              placeholder="Ceritakan pengalaman Anda dengan produk ini (minimal 10 karakter)..."
                                              required
                                              minlength="10"></textarea>
                                    @error('review')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <button type="submit" 
                                        class="bg-gradient-to-r from-primary to-accent text-white px-6 py-2 rounded-full font-semibold hover:shadow-lg transition">
                                    <i class="fas fa-paper-plane mr-2"></i> Kirim Review
                                </button>
                            </form>
                        @endif
                    </div>
                @endforeach
            </div>
            @endif


            <!-- Customer & Shipping Info -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-user text-primary mr-2"></i> Data Pembeli
                    </h3>
                    <div class="space-y-2 text-sm">
                        <p class="text-gray-600"><strong>Nama:</strong> {{ $order->nama_customer }}</p>
                        <p class="text-gray-600"><strong>Email:</strong> {{ $order->email_customer }}</p>
                        <p class="text-gray-600"><strong>HP:</strong> {{ $order->no_hp }}</p>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-map-marker-alt text-primary mr-2"></i> Alamat Pengiriman
                    </h3>
                    <p class="text-sm text-gray-600">{{ $order->alamat_lengkap }}</p>
                </div>
            </div>

            <!-- Products -->
            <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
                <h3 class="font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-shopping-bag text-primary mr-2"></i> Produk yang Dibeli
                </h3>
                
                <div class="space-y-4">
                    @foreach($order->details as $detail)
                        <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-xl">
                            <div class="flex-shrink-0">
                                @if($detail->produk && $detail->produk->foto)
                                    <img src="{{ asset('storage/img-produk/thumb_sm_' . $detail->produk->foto) }}" 
                                         alt="{{ $detail->nama_produk }}" 
                                         class="w-20 h-20 object-cover rounded-lg">
                                @else
                                    <div class="w-20 h-20 bg-gradient-to-br from-primary to-accent rounded-lg flex items-center justify-center">
                                        <i class="fas fa-image text-white text-2xl"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1">
                                <h4 class="font-semibold text-gray-800 mb-1">{{ $detail->nama_produk }}</h4>
                                <p class="text-sm text-gray-500">{{ $detail->qty }} x Rp {{ number_format($detail->harga, 0, ',', '.') }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-lg font-bold text-primary">
                                    Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Payment Summary -->
            <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
                <h3 class="font-bold text-gray-800 mb-4">Rincian Pembayaran</h3>
                
                <div class="space-y-3">
                    <div class="flex justify-between text-gray-600">
                        <span>Metode Pembayaran</span>
                        <span class="font-semibold">
                            @if($order->metode_pembayaran == 'transfer_bank')
                                Transfer Bank
                            @elseif($order->metode_pembayaran == 'cod')
                                COD
                            @else
                                E-Wallet
                            @endif
                        </span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Subtotal</span>
                        <span class="font-semibold">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Ongkos Kirim</span>
                        <span class="font-semibold text-green-600">GRATIS</span>
                    </div>
                    <hr>
                    <div class="flex justify-between text-xl font-bold text-gray-800">
                        <span>Total</span>
                        <span class="text-3xl text-primary">
                            Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Catatan -->
            @if($order->catatan)
                <div class="bg-yellow-50 border-2 border-yellow-200 rounded-2xl p-6 mb-6">
                    <h3 class="font-bold text-gray-800 mb-2 flex items-center">
                        <i class="fas fa-sticky-note text-yellow-600 mr-2"></i> Catatan
                    </h3>
                    <p class="text-gray-700">{{ $order->catatan }}</p>
                </div>
            @endif

            <!-- Actions -->
            <div class="flex space-x-4">
                <a href="{{ route('customer.orders') }}" 
                   class="flex-1 bg-gray-200 text-gray-700 text-center py-4 rounded-full font-bold hover:bg-gray-300 transition">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
                @if($order->status_pembayaran == 'pending')
                    <button class="flex-1 bg-gradient-to-r from-primary to-accent text-white py-4 rounded-full font-bold hover:shadow-xl transition">
                        <i class="fas fa-credit-card mr-2"></i> Bayar Sekarang
                    </button>
                @endif
                <button onclick="window.print()" 
                        class="flex-1 bg-white border-2 border-primary text-primary py-4 rounded-full font-bold hover:bg-primary hover:text-white transition">
                    <i class="fas fa-print mr-2"></i> Cetak
                </button>
            </div>
        </div>
    </div>
</section>

<style>
/* Star Rating CSS - Fix untuk multi produk */
input[id*="_5"]:checked ~ label[for*="_5"],
input[id*="_5"]:checked ~ label[for*="_5"] ~ label,
input[id*="_4"]:checked ~ label[for*="_4"],
input[id*="_4"]:checked ~ label[for*="_4"] ~ label,
input[id*="_3"]:checked ~ label[for*="_3"],
input[id*="_3"]:checked ~ label[for*="_3"] ~ label,
input[id*="_2"]:checked ~ label[for*="_2"],
input[id*="_2"]:checked ~ label[for*="_2"] ~ label,
input[id*="_1"]:checked ~ label[for*="_1"],
input[id*="_1"]:checked ~ label[for*="_1"] ~ label {
    color: #facc15 !important;
}

.review-form label[for^="star_"]:hover,
.review-form label[for^="star_"]:hover ~ label[for^="star_"] {
    color: #facc15 !important;
}
</style>

@endsection