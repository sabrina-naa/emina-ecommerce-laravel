@extends('backend.v_layouts.app')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form class="form-horizontal" action="{{ route('backend.laporan.cetakproduk') }}" method="post"
                    target="_blank">
                    @csrf
                    <div class="card-body">
                        <h4 class="card-title">{{ $judul }}</h4>
                        <p class="text-muted">Filter laporan berdasarkan tanggal dan kategori produk</p>
                        <hr>

                        <div class="row">
                            <!-- Tanggal Awal -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tanggal Awal <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal_awal" value="{{ old('tanggal_awal') }}"
                                        class="form-control @error('tanggal_awal') is-invalid @enderror" required>
                                    @error('tanggal_awal')
                                        <span class="invalid-feedback alert-danger" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Tanggal Akhir -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tanggal Akhir <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal_akhir" value="{{ old('tanggal_akhir') }}"
                                        class="form-control @error('tanggal_akhir') is-invalid @enderror" required>
                                    @error('tanggal_akhir')
                                        <span class="invalid-feedback alert-danger" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Filter Kategori -->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Filter Kategori</label>
                                    <select name="kategori_id" class="form-control">
                                        <option value="">-- Semua Kategori --</option>
                                        @foreach(\App\Models\Kategori::orderBy('nama_kategori')->get() as $kat)
                                            <option value="{{ $kat->id }}">{{ $kat->nama_kategori }}</option>
                                        @endforeach
                                    </select>
                                    <small class="form-text text-muted">Kosongkan untuk menampilkan semua kategori</small>
                                </div>
                            </div>
                        </div>

                        <hr>
                        
                        <!-- Info Laporan -->
                        <div class="alert alert-info">
                            <h5><i class="fa fa-info-circle"></i> Informasi Laporan</h5>
                            <p class="mb-0">Laporan ini akan menampilkan:</p>
                            <ul class="mb-0">
                                <li>Statistik stok (Tersedia, Habis, Menipis)</li>
                                <li>Total nilai stok keseluruhan</li>
                                <li>Rincian stok per kategori</li>
                                <li>Daftar produk yang stok habis</li>
                                <li>Daftar produk yang stok menipis (&lt; 10)</li>
                                <li>Produk terlaris (dari transaksi)</li>
                            </ul>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-print"></i> Cetak Laporan
                            </button>
                            <a href="{{ route('backend.beranda') }}" class="btn btn-secondary">
                                <i class="fa fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection