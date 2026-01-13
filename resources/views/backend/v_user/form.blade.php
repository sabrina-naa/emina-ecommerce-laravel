@extends('backend.v_layouts.app')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form class="form-horizontal" action="{{ route('backend.laporan.cetakuser') }}" method="post"
                    target="_blank">
                    @csrf
                    <div class="card-body">
                        <h4 class="card-title">{{ $judul }}</h4>
                        <p class="text-muted">Filter laporan berdasarkan tanggal, role, dan status</p>
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
                            <!-- Filter Role -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Filter Role</label>
                                    <select name="role" class="form-control">
                                        <option value="">-- Semua Role --</option>
                                        <option value="1">Super Admin</option>
                                        <option value="0">Admin</option>
                                    </select>
                                    <small class="form-text text-muted">Kosongkan untuk menampilkan semua role</small>
                                </div>
                            </div>

                            <!-- Filter Status -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Filter Status</label>
                                    <select name="status" class="form-control">
                                        <option value="">-- Semua Status --</option>
                                        <option value="1">Aktif</option>
                                        <option value="0">Non Aktif</option>
                                    </select>
                                    <small class="form-text text-muted">Kosongkan untuk menampilkan semua status</small>
                                </div>
                            </div>
                        </div>

                        <hr>
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