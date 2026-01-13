@extends('frontend.layouts.app')

@section('title', 'Pesanan Berhasil - Emina Beauty')

@section('content')

<section class="py-8 md:py-12 bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto">
            
            {{-- Success Card --}}
            <div class="bg-white rounded-lg shadow-lg p-6 md:p-8 text-center mb-6">
                {{-- Success Icon --}}
                <div class="inline-flex items-center justify-center w-20 h-20 bg-green-100 rounded-full mb-4">
                    <i class="fas fa-check-circle text-green-500 text-5xl"></i>
                </div>

                <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2">
                    Pesanan Berhasil Dibuat! 🎉
                </h1>
                <p class="text-gray-600 mb-6">
                    Terima kasih telah berbelanja di Emina Beauty
                </p>

                {{-- Order Code --}}
                <div class="bg-primary/10 border-2 border-primary rounded-lg p-4 mb-4">
                    <p class="text-sm text-gray-600 mb-1">Kode Pesanan</p>
                    <p class="text-2xl font-bold text-primary">{{ $transaksi->kode_transaksi }}</p>
                </div>

                {{-- BARCODE --}}
                <div class="bg-white border-2 border-gray-200 rounded-lg p-4 mb-6">
                    <p class="text-sm text-gray-600 mb-3">Scan Barcode untuk Cek Status</p>
                    <div class="flex justify-center">
                        <svg id="barcode-{{ $transaksi->kode_transaksi }}"></svg>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">Simpan barcode ini untuk tracking pesanan</p>
                </div>

                {{-- Order Status --}}
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-xs text-gray-500 mb-1">Status Pembayaran</p>
                        <span class="inline-block px-3 py-1 text-sm font-semibold rounded-full
                            {{ $transaksi->status_pembayaran == 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700' }}">
                            {{ $transaksi->status_pembayaran == 'pending' ? 'Menunggu Pembayaran' : 'Lunas' }}
                        </span>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-xs text-gray-500 mb-1">Status Pengiriman</p>
                        <span class="inline-block px-3 py-1 text-sm font-semibold rounded-full bg-blue-100 text-blue-700">
                            {{ $transaksi->status_pengiriman == 'pending' ? 'Diproses' : ucfirst($transaksi->status_pengiriman) }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Order Details --}}
            <div class="bg-white rounded-lg shadow-lg p-6 md:p-8 mb-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-info-circle text-primary mr-2"></i>
                    Detail Pesanan
                </h2>

                {{-- Customer Info --}}
                <div class="mb-6 pb-6 border-b">
                    <h3 class="font-semibold text-gray-800 mb-3">Informasi Pembeli</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Nama:</span>
                            <span class="font-medium text-gray-800">{{ $transaksi->nama_customer }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Email:</span>
                            <span class="font-medium text-gray-800">{{ $transaksi->email_customer }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">No. Telepon:</span>
                            <span class="font-medium text-gray-800">{{ $transaksi->no_hp }}</span>
                        </div>
                    </div>
                </div>

                {{-- Shipping Info --}}
                <div class="mb-6 pb-6 border-b">
                    <h3 class="font-semibold text-gray-800 mb-3">Informasi Pengiriman</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Kurir:</span>
                            <span class="font-medium text-gray-800">{{ strtoupper($transaksi->metode_pengiriman ?? '-') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Alamat:</span>
                            <span class="font-medium text-gray-800 text-right">{{ $transaksi->alamat_lengkap }}</span>
                        </div>
                    </div>
                </div>

                {{-- Products --}}
                <div class="mb-6 pb-6 border-b">
                    <h3 class="font-semibold text-gray-800 mb-4">Produk yang Dipesan</h3>
                    <div class="space-y-3">
                        @foreach($transaksi->details as $detail)
                            <div class="flex items-center gap-3 text-sm">
                                <div class="w-12 h-12 bg-gray-100 rounded flex-shrink-0">
                                    @if($detail->produk && $detail->produk->foto)
                                        <img src="{{ asset('storage/img-produk/thumb_sm_' . $detail->produk->foto) }}" 
                                             alt="{{ $detail->produk->nama_produk }}"
                                             class="w-full h-full object-cover rounded">
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <p class="font-medium text-gray-800">{{ $detail->produk->nama_produk ?? 'Produk' }}</p>
                                    <p class="text-gray-600 text-xs">{{ $detail->qty }} x Rp{{ number_format($detail->produk->harga ?? 0, 0, ',', '.') }}</p>
                                </div>
                                <p class="font-semibold text-gray-800">
                                    Rp{{ number_format($detail->subtotal, 0, ',', '.') }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Payment Summary --}}
                <div class="space-y-2 text-sm mb-6">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Subtotal</span>
                        <span class="font-medium">Rp{{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Ongkos Kirim</span>
                        <span class="font-medium text-green-600">GRATIS</span>
                    </div>
                    <div class="flex justify-between text-lg font-bold text-gray-800 pt-2 border-t">
                        <span>Total</span>
                        <span class="text-primary">Rp{{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
                    </div>
                </div>

                {{-- Payment Method --}}
                <div class="pt-6 border-t">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Metode Pembayaran:</span>
                        <span class="font-semibold text-gray-800">
                            {{ $transaksi->getMetodePembayaranLengkap() }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Payment Instructions (if pending) --}}
            @if($transaksi->status_pembayaran == 'pending' && $transaksi->metode_pembayaran == 'transfer_bank')
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 mb-6">
                    <h3 class="font-semibold text-gray-800 mb-3 flex items-center">
                        <i class="fas fa-exclamation-triangle text-yellow-600 mr-2"></i>
                        Instruksi Pembayaran
                    </h3>
                    <div class="space-y-2 text-sm text-gray-700">
                        <p>Silakan transfer ke rekening berikut:</p>
                        <div class="bg-white rounded p-3">
                            @if($transaksi->bank_terpilih == 'bca')
                                <div class="font-medium">BCA: <span class="font-mono">1234567890</span></div>
                            @elseif($transaksi->bank_terpilih == 'bri')
                                <div class="font-medium">BRI: <span class="font-mono">0987654321</span></div>
                            @elseif($transaksi->bank_terpilih == 'bni')
                                <div class="font-medium">BNI: <span class="font-mono">5555666677</span></div>
                            @elseif($transaksi->bank_terpilih == 'mandiri')
                                <div class="font-medium">Mandiri: <span class="font-mono">1122334455</span></div>
                            @endif
                            <div class="text-gray-600 mt-1">a.n. Emina Beauty</div>
                        </div>
                        <p class="text-xs text-gray-600 mt-2">
                            <i class="fas fa-info-circle"></i> Total: <strong>Rp{{ number_format($transaksi->total_harga, 0, ',', '.') }}</strong>
                        </p>
                    </div>
                </div>
            @endif

            {{-- Action Buttons --}}
            <div class="flex flex-col sm:flex-row gap-3">
                @auth('customer')
                    <a href="{{ route('customer.orders') }}" 
                       class="flex-1 bg-primary hover:bg-accent text-white text-center py-3 rounded-md font-semibold transition">
                        <i class="fas fa-receipt mr-2"></i> Lihat Pesanan Saya
                    </a>
                @endauth
                <a href="{{ route('shop.index') }}" 
                   class="flex-1 border border-primary text-primary hover:bg-primary hover:text-white text-center py-3 rounded-md font-semibold transition">
                    <i class="fas fa-shopping-bag mr-2"></i> Belanja Lagi
                </a>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
{{-- JsBarcode Library --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jsbarcode/3.11.5/JsBarcode.all.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Generate Barcode
    JsBarcode("#barcode-{{ $transaksi->kode_transaksi }}", "{{ $transaksi->kode_transaksi }}", {
        format: "CODE128",
        width: 2,
        height: 80,
        displayValue: true,
        fontSize: 14,
        margin: 10
    });
});
</script>
@endpush