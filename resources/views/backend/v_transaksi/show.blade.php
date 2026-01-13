@extends('backend.v_layouts.app')
@section('content')
    <style>
        .content-header {
            background: linear-gradient(135deg, #f58b95 0%, #ff6b9d 100%);
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 25px;
            box-shadow: 0 5px 20px rgba(245, 139, 149, 0.3);
        }
        
        .content-header h5 {
            color: white;
            font-weight: 700;
            margin: 0;
            font-size: 24px;
        }
        
        .card {
            border-radius: 15px;
            border: none;
            box-shadow: 0 2px 15px rgba(245, 139, 149, 0.1);
            margin-bottom: 20px;
        }
        
        .info-row {
            display: flex;
            padding: 15px 0;
            border-bottom: 1px solid #ffe8ec;
        }
        
        .info-label {
            flex: 0 0 200px;
            font-weight: 600;
            color: #d94865;
        }
        
        .info-value {
            flex: 1;
            color: #333;
        }
        
        .table thead th {
            background: linear-gradient(135deg, #f58b95 0%, #ff6b9d 100%);
            color: white;
            border: none;
            font-weight: 600;
            padding: 15px;
        }
        
        .btn-kembali {
            background: linear-gradient(135deg, #f58b95 0%, #ff6b9d 100%);
            color: white;
            padding: 12px 30px;
            border-radius: 10px;
            font-weight: 600;
            border: none;
        }
        
        .btn-kembali:hover {
            background: linear-gradient(135deg, #ff6b9d 0%, #d94865 100%);
            color: white;
        }

        .badge-status {
            padding: 8px 15px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 13px;
        }

        .badge-pending {
            background: #fff3cd;
            color: #856404;
        }

        .badge-paid {
            background: #d4edda;
            color: #155724;
        }

        .badge-dikirim {
            background: #cce5ff;
            color: #004085;
        }

        .badge-selesai {
            background: #d1e7dd;
            color: #0f5132;
        }
    </style>

    <div class="row">
        <div class="col-12">
            <div class="content-header">
                <h5><i class="mdi mdi-eye"></i> {{ $judul }}</h5>
            </div>
            
            <!-- Info Transaksi -->
            <div class="card">
                <div class="card-body">
                    <h5 style="color: #d94865; font-weight: 700; margin-bottom: 20px;">Informasi Transaksi</h5>
                    
                    <div class="info-row">
                        <div class="info-label">Kode Transaksi:</div>
                        <div class="info-value"><strong>{{ $transaksi->kode_transaksi }}</strong></div>
                    </div>
                    
                    <div class="info-row">
                        <div class="info-label">Tanggal:</div>
                        <div class="info-value">{{ $transaksi->created_at->format('d F Y, H:i') }}</div>
                    </div>
                    
                    <div class="info-row">
                        <div class="info-label">Nama Customer:</div>
                        <div class="info-value">{{ $transaksi->nama_customer }}</div>
                    </div>
                    
                    <div class="info-row">
                        <div class="info-label">Email:</div>
                        <div class="info-value">{{ $transaksi->email_customer }}</div>
                    </div>
                    
                    <div class="info-row">
                        <div class="info-label">No. HP:</div>
                        <div class="info-value">{{ $transaksi->no_hp }}</div>
                    </div>
                    
                    <div class="info-row">
                        <div class="info-label">Alamat:</div>
                        <div class="info-value">{{ $transaksi->alamat_lengkap }}</div>
                    </div>
                    
                    <div class="info-row">
                        <div class="info-label">Metode Pembayaran:</div>
                        <div class="info-value">
                            {{-- 🔥 FIX: Gunakan method getMetodePembayaranLengkap() --}}
                            {{ $transaksi->getMetodePembayaranLengkap() }}
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-label">Metode Pengiriman:</div>
                        <div class="info-value">{{ strtoupper($transaksi->metode_pengiriman ?? '-') }}</div>
                    </div>
                    
                    <div class="info-row">
                        <div class="info-label">Status Pembayaran:</div>
                        <div class="info-value">
                            @if($transaksi->status_pembayaran == 'pending')
                                <span class="badge-status badge-pending">MENUNGGU PEMBAYARAN</span>
                            @elseif($transaksi->status_pembayaran == 'paid')
                                <span class="badge-status badge-paid">LUNAS</span>
                            @else
                                <span class="badge-status badge-pending">{{ strtoupper($transaksi->status_pembayaran) }}</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="info-row">
                        <div class="info-label">Status Pengiriman:</div>
                        <div class="info-value">
                            @if($transaksi->status_pengiriman == 'pending')
                                <span class="badge-status badge-pending">PENDING</span>
                            @elseif($transaksi->status_pengiriman == 'diproses')
                                <span class="badge-status badge-dikirim">DIPROSES</span>
                            @elseif($transaksi->status_pengiriman == 'dikirim')
                                <span class="badge-status badge-dikirim">DIKIRIM</span>
                            @elseif($transaksi->status_pengiriman == 'selesai')
                                <span class="badge-status badge-selesai">SELESAI</span>
                            @else
                                <span class="badge-status badge-pending">{{ strtoupper($transaksi->status_pengiriman) }}</span>
                            @endif
                        </div>
                    </div>
                    
                    @if($transaksi->catatan)
                    <div class="info-row">
                        <div class="info-label">Catatan:</div>
                        <div class="info-value">{{ $transaksi->catatan }}</div>
                    </div>
                    @endif
                </div>
            </div>
            
            <!-- Detail Produk -->
            <div class="card">
                <div class="card-body">
                    <h5 style="color: #d94865; font-weight: 700; margin-bottom: 20px;">Detail Produk</h5>
                    
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="40%">Nama Produk</th>
                                    <th width="20%">Harga</th>
                                    <th width="10%">Qty</th>
                                    <th width="25%">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transaksi->details as $detail)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>
                                        {{-- 🔥 FIX: Gunakan relasi produk --}}
                                        @if($detail->produk)
                                            {{ $detail->produk->nama_produk }}
                                        @else
                                            <span class="text-muted">Produk tidak ditemukan</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{-- 🔥 FIX: Ambil harga dari relasi produk --}}
                                        @if($detail->produk)
                                            Rp {{ number_format($detail->produk->harga, 0, ',', '.') }}
                                        @else
                                            Rp 0
                                        @endif
                                    </td>
                                    <td class="text-center">{{ $detail->qty }}</td>
                                    <td>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                                <tr style="background: #fff0f2;">
                                    <td colspan="4" class="text-right"><strong>TOTAL:</strong></td>
                                    <td><strong>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="d-flex gap-2">
                <a href="{{ route('backend.transaksi.index') }}" class="btn btn-kembali">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <a href="{{ route('backend.transaksi.edit', $transaksi->id) }}" class="btn btn-kembali" style="background: linear-gradient(135deg, #6c63ff 0%, #5a52d5 100%);">
                    <i class="fas fa-edit"></i> Ubah Status
                </a>
            </div>
        </div>
    </div>
@endsection