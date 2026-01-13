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
        }
        
        .form-label {
            font-weight: 600;
            color: #d94865;
            margin-bottom: 10px;
        }
        
        .form-select {
            border: 2px solid #ffe8ec;
            border-radius: 10px;
            padding: 12px;
            font-size: 15px;
        }
        
        .form-select:focus {
            border-color: #f58b95;
            box-shadow: 0 0 0 3px rgba(245, 139, 149, 0.1);
        }
        
        .btn-simpan {
            background: linear-gradient(135deg, #f58b95 0%, #ff6b9d 100%);
            color: white;
            padding: 12px 30px;
            border-radius: 10px;
            font-weight: 600;
            border: none;
        }
        
        .btn-simpan:hover {
            background: linear-gradient(135deg, #ff6b9d 0%, #d94865 100%);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(245, 139, 149, 0.4);
            color: white;
        }
        
        .btn-kembali {
            background: white;
            color: #f58b95;
            border: 2px solid #f58b95;
            padding: 12px 30px;
            border-radius: 10px;
            font-weight: 600;
        }
        
        .btn-kembali:hover {
            background: #f58b95;
            color: white;
        }
    </style>

    <div class="row">
        <div class="col-12">
            <div class="content-header">
                <h5><i class="mdi mdi-pencil"></i> {{ $judul }}</h5>
            </div>
            
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('backend.transaksi.update', $edit->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <label class="form-label">Kode Transaksi</label>
                            <input type="text" class="form-control" value="{{ $edit->kode_transaksi }}" readonly style="background: #f5f5f5; border: 2px solid #ffe8ec; border-radius: 10px; padding: 12px;">
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label">Nama Customer</label>
                            <input type="text" class="form-control" value="{{ $edit->nama_customer }}" readonly style="background: #f5f5f5; border: 2px solid #ffe8ec; border-radius: 10px; padding: 12px;">
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label">Status Pembayaran</label>
                            <select name="status_pembayaran" class="form-select" required>
                                <option value="pending" {{ $edit->status_pembayaran == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="lunas" {{ $edit->status_pembayaran == 'lunas' ? 'selected' : '' }}>Lunas</option>
                                <option value="gagal" {{ $edit->status_pembayaran == 'gagal' ? 'selected' : '' }}>Gagal</option>
                            </select>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label">Status Pengiriman</label>
                            <select name="status_pengiriman" class="form-select" required>
                                <option value="diproses" {{ $edit->status_pengiriman == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                <option value="dikirim" {{ $edit->status_pengiriman == 'dikirim' ? 'selected' : '' }}>Dikirim</option>
                                <option value="selesai" {{ $edit->status_pengiriman == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="dibatalkan" {{ $edit->status_pengiriman == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                            </select>
                        </div>
                        
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-simpan">
                                <i class="fas fa-save"></i> Simpan Perubahan
                            </button>
                            <a href="{{ route('backend.transaksi.index') }}" class="btn btn-kembali">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection