@extends('backend.v_layouts.app')
@section('content')
    <style>
        /* Pink Theme Styling */
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
        
        .content-header i {
            color: white;
            margin-right: 10px;
        }
        
        .card {
            border-radius: 15px;
            border: none;
            box-shadow: 0 2px 15px rgba(245, 139, 149, 0.1);
            overflow: hidden;
        }
        
        .card-body {
            padding: 25px;
        }
        
        .table thead th {
            background: linear-gradient(135deg, #f58b95 0%, #ff6b9d 100%);
            color: white;
            border: none;
            font-weight: 600;
            padding: 15px;
            text-align: center;
            vertical-align: middle;
            font-size: 14px;
        }
        
        .table tbody td {
            padding: 20px 15px;
            vertical-align: middle;
            border-bottom: 1px solid #ffe8ec;
        }
        
        .table tbody tr:hover {
            background: #fffafc;
        }
        
        /* Kode Transaksi */
        .kode-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 20px;
            color: white;
            font-weight: 700;
            font-size: 12px;
        }
        
        /* Customer Info */
        .customer-info {
            display: flex;
            flex-direction: column;
            gap: 3px;
        }
        
        .customer-name {
            font-weight: 700;
            color: #d94865;
            font-size: 14px;
        }
        
        .customer-contact {
            font-size: 12px;
            color: #999;
        }
        
        /* Total Harga */
        .total-badge {
            display: inline-flex;
            padding: 8px 16px;
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            border-radius: 10px;
            color: white;
            font-weight: 700;
            font-size: 14px;
        }
        
        /* Status Badges */
        .badge-pending {
            background: linear-gradient(135deg, #ffd89b 0%, #f093fb 100%);
            color: white;
            padding: 6px 14px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 11px;
        }
        
        .badge-lunas {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            color: white;
            padding: 6px 14px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 11px;
        }
        
        .badge-gagal {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);
            color: white;
            padding: 6px 14px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 11px;
        }
        
        .badge-diproses {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
            padding: 6px 14px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 11px;
        }
        
        .badge-dikirim {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 6px 14px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 11px;
        }
        
        .badge-selesai {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            color: white;
            padding: 6px 14px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 11px;
        }
        
        .badge-dibatalkan {
            background: linear-gradient(135deg, #a8a8a8 0%, #7d7d7d 100%);
            color: white;
            padding: 6px 14px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 11px;
        }
        
        /* Action Buttons */
        .btn-detail {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            padding: 8px 15px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 13px;
            margin: 2px;
        }
        
        .btn-detail:hover {
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
            color: white;
        }
        
        .btn-ubah {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            border: none;
            color: white;
            padding: 8px 15px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 13px;
            margin: 2px;
        }
        
        .btn-ubah:hover {
            background: linear-gradient(135deg, #00f2fe 0%, #4facfe 100%);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(79, 172, 254, 0.4);
            color: white;
        }
        
        .btn-hapus {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);
            border: none;
            color: white;
            padding: 8px 15px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 13px;
            margin: 2px;
        }
        
        .btn-hapus:hover {
            background: linear-gradient(135deg, #ee5a6f 0%, #ff6b6b 100%);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(238, 90, 111, 0.4);
            color: white;
        }
        
        .no-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, #f58b95 0%, #ff6b9d 100%);
            color: white;
            border-radius: 10px;
            font-weight: 700;
            font-size: 15px;
        }
        
        /* DataTable */
        .dataTables_wrapper .dataTables_length select,
        .dataTables_wrapper .dataTables_filter input {
            border: 2px solid #f58b95;
            border-radius: 8px;
            padding: 5px 10px;
        }
        
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: linear-gradient(135deg, #f58b95 0%, #ff6b9d 100%) !important;
            border: none !important;
            color: white !important;
            border-radius: 8px;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-state i {
            font-size: 80px;
            color: #f58b95;
            margin-bottom: 20px;
        }

        .empty-state h3 {
            color: #d94865;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .empty-state p {
            color: #999;
            font-size: 15px;
        }
    </style>

    <div class="row">
        <div class="col-12">
            <div class="content-header">
                <h5><i class="mdi mdi-cart"></i>{{ $judul }}</h5>
            </div>
            
            <div class="card">
                <div class="card-body">
                    @if($index->count() > 0)
                        <div class="table-responsive">
                            <table id="zero_config" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 60px;">No</th>
                                        <th style="width: 150px;">Kode Transaksi</th>
                                        <th>Customer</th>
                                        <th style="width: 150px;">Total</th>
                                        <th style="width: 120px;">Pembayaran</th>
                                        <th style="width: 120px;">Pengiriman</th>
                                        <th style="width: 250px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($index as $row)
                                        <tr>
                                            <td class="text-center">
                                                <span class="no-badge">{{ $loop->iteration }}</span>
                                            </td>
                                            <td class="text-center">
                                                <span class="kode-badge">
                                                    <i class="mdi mdi-barcode"></i>
                                                    {{ $row->kode_transaksi }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="customer-info">
                                                    <span class="customer-name">{{ $row->nama_customer }}</span>
                                                    <span class="customer-contact">📧 {{ $row->email_customer }}</span>
                                                    <span class="customer-contact">📱 {{ $row->no_hp }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="total-badge">
                                                    Rp {{ number_format($row->total_harga, 0, ',', '.') }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                @if ($row->status_pembayaran == 'pending')
                                                    <span class="badge-pending">
                                                        <i class="mdi mdi-clock-outline"></i> Pending
                                                    </span>
                                                @elseif($row->status_pembayaran == 'lunas')
                                                    <span class="badge-lunas">
                                                        <i class="mdi mdi-check-circle"></i> Lunas
                                                    </span>
                                                @else
                                                    <span class="badge-gagal">
                                                        <i class="mdi mdi-close-circle"></i> Gagal
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if ($row->status_pengiriman == 'diproses')
                                                    <span class="badge-diproses">
                                                        <i class="mdi mdi-package"></i> Diproses
                                                    </span>
                                                @elseif($row->status_pengiriman == 'dikirim')
                                                    <span class="badge-dikirim">
                                                        <i class="mdi mdi-truck"></i> Dikirim
                                                    </span>
                                                @elseif($row->status_pengiriman == 'selesai')
                                                    <span class="badge-selesai">
                                                        <i class="mdi mdi-check-all"></i> Selesai
                                                    </span>
                                                @else
                                                    <span class="badge-dibatalkan">
                                                        <i class="mdi mdi-cancel"></i> Dibatalkan
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('backend.transaksi.show', $row->id) }}" title="Detail">
                                                    <button type="button" class="btn btn-detail">
                                                        <i class="fas fa-eye"></i> Detail
                                                    </button>
                                                </a>
                                                <a href="{{ route('backend.transaksi.edit', $row->id) }}" title="Ubah Status">
                                                    <button type="button" class="btn btn-ubah">
                                                        <i class="far fa-edit"></i> Ubah
                                                    </button>
                                                </a>
                                                <form method="POST" action="{{ route('backend.transaksi.destroy', $row->id) }}"
                                                    style="display: inline-block;">
                                                    @method('delete')
                                                    @csrf
                                                    <button type="submit" class="btn btn-hapus show_confirm"
                                                        data-konf-delete="{{ $row->kode_transaksi }}" title='Hapus'>
                                                        <i class="fas fa-trash-alt"></i> Hapus
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="mdi mdi-cart-off"></i>
                            <h3>Belum Ada Transaksi</h3>
                            <p>Data transaksi akan muncul di sini ketika ada pesanan dari customer</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection