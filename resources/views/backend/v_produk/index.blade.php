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
        
        .btn-tambah {
            background: linear-gradient(135deg, #f58b95 0%, #ff6b9d 100%);
            border: none;
            color: white;
            padding: 12px 25px;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(245, 139, 149, 0.3);
        }
        
        .btn-tambah:hover {
            background: linear-gradient(135deg, #ff6b9d 0%, #d94865 100%);
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(245, 139, 149, 0.5);
            color: white;
        }
        
        .card {
            border-radius: 15px;
            border: none;
            box-shadow: 0 2px 15px rgba(245, 139, 149, 0.1);
            overflow: hidden;
        }
        
        .table thead th {
            background: linear-gradient(135deg, #f58b95 0%, #ff6b9d 100%);
            color: white;
            border: none;
            font-weight: 600;
            padding: 12px 8px;
            text-align: center;
            vertical-align: middle;
            font-size: 13px;
        }
        
        .table tbody td {
            padding: 12px 8px;
            vertical-align: middle;
            border-bottom: 1px solid #fff0f2;
            font-size: 13px;
        }
        
        .table tbody tr:hover {
            background: #fff0f2;
        }
        
        /* Kategori Badge - FIXED SIZE */
        .kategori-badge {
            display: inline-block;
            padding: 4px 10px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 12px;
            color: white;
            font-weight: 600;
            font-size: 11px;
            white-space: nowrap;
        }
        
        /* Status Badges - FIXED SIZE */
        .badge-publish,
        .badge-blok {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 11px;
            white-space: nowrap;
        }
        
        .badge-publish {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            color: white;
        }
        
        .badge-blok {
            background: linear-gradient(135deg, #a8a8a8 0%, #7d7d7d 100%);
            color: white;
        }
        
        /* Product Name */
        .product-name {
            font-weight: 600;
            color: #d94865;
            font-size: 13px;
        }
        
        /* Price Badge */
        .price-badge {
            display: inline-block;
            padding: 4px 10px;
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            border-radius: 8px;
            color: white;
            font-weight: 700;
            font-size: 12px;
            white-space: nowrap;
        }
        
        /* Stock Badge */
        .stock-badge {
            display: inline-block;
            padding: 4px 12px;
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            border-radius: 8px;
            color: white;
            font-weight: 700;
            font-size: 12px;
        }
        
        .stock-low {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);
        }
        
        /* Action Buttons */
        .btn-action {
            border: none;
            color: white;
            padding: 6px 12px;
            border-radius: 6px;
            font-weight: 600;
            transition: all 0.3s ease;
            font-size: 11px;
            margin: 2px;
            display: inline-block;
        }
        
        .btn-ubah {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }
        
        .btn-ubah:hover {
            background: linear-gradient(135deg, #00f2fe 0%, #4facfe 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(79, 172, 254, 0.4);
            color: white;
        }
        
        .btn-gambar {
            background: linear-gradient(135deg, #ffd89b 0%, #f093fb 100%);
        }
        
        .btn-gambar:hover {
            background: linear-gradient(135deg, #f093fb 0%, #ffd89b 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(240, 147, 251, 0.4);
            color: white;
        }
        
        .btn-hapus {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);
        }
        
        .btn-hapus:hover {
            background: linear-gradient(135deg, #ee5a6f 0%, #ff6b6b 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(238, 90, 111, 0.4);
            color: white;
        }
        
        .no-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            background: linear-gradient(135deg, #f58b95 0%, #ff6b9d 100%);
            color: white;
            border-radius: 50%;
            font-weight: 700;
            font-size: 13px;
        }
    </style>

    <div class="row">
        <div class="col-12">
            <div class="content-header">
                <h5><i class="mdi mdi-shopping"></i> {{ $judul }}</h5>
            </div>
            
            <a href="{{ route('backend.produk.create') }}">
                <button type="button" class="btn btn-tambah mb-3">
                    <i class="fas fa-plus-circle"></i> Tambah Produk
                </button>
            </a>
            
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="zero_config" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 50px;">No</th>
                                    <th style="width: 100px;">Kategori</th>
                                    <th style="width: 90px;">Status</th>
                                    <th>Nama Produk</th>
                                    <th style="width: 120px;">Harga</th>
                                    <th style="width: 70px;">Stok</th>
                                    <th style="width: 240px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($index as $row)
                                    <tr>
                                        <td class="text-center">
                                            <span class="no-badge">{{ $loop->iteration }}</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="kategori-badge">
                                                <i class="mdi mdi-tag"></i>
                                                {{ $row->kategori->nama_kategori }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            @if ($row->status == 1)
                                                <span class="badge-publish">
                                                    <i class="mdi mdi-check-circle"></i> Publish
                                                </span>
                                            @else
                                                <span class="badge-blok">
                                                    <i class="mdi mdi-block-helper"></i> Blok
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="product-name">
                                                {{ $row->nama_produk }}
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span class="price-badge">
                                                Rp {{ number_format($row->harga, 0, ',', '.') }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="stock-badge {{ $row->stok < 10 ? 'stock-low' : '' }}">
                                                {{ $row->stok }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('backend.produk.edit', $row->id) }}" title="Ubah Data">
                                                <button type="button" class="btn-action btn-ubah">
                                                    <i class="far fa-edit"></i> Ubah
                                                </button>
                                            </a>
                                            <a href="{{ route('backend.produk.show', $row->id) }}" title="Kelola Gambar">
                                                <button type="button" class="btn-action btn-gambar">
                                                    <i class="fas fa-images"></i> Gambar
                                                </button>
                                            </a>
                                            <form method="POST" action="{{ route('backend.produk.destroy', $row->id) }}"
                                                style="display: inline-block;">
                                                @method('delete')
                                                @csrf
                                                <button type="submit" class="btn-action btn-hapus show_confirm"
                                                    data-konf-delete="{{ $row->nama_produk }}" title='Hapus Data'>
                                                    <i class="fas fa-trash-alt"></i> Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection