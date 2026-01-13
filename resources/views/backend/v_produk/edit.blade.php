@extends('backend.v_layouts.app')
@section('content')
    <style>
        .varian-card {
            border: 2px solid #f58b95;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            background: linear-gradient(135deg, #fff5f7 0%, #ffffff 100%);
        }
        
        .varian-item {
            background: white;
            border: 1px solid #ffc1c8;
            border-radius: 8px;
            padding: 12px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 15px;
            transition: all 0.3s ease;
        }
        
        .varian-item:hover {
            border-color: #f58b95;
            box-shadow: 0 3px 10px rgba(245, 139, 149, 0.2);
        }
        
        .color-preview {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 3px solid white;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }
        
        .varian-info {
            flex: 1;
        }
        
        .varian-name {
            font-weight: 700;
            color: #d94865;
            font-size: 14px;
            margin-bottom: 4px;
        }
        
        .varian-meta {
            font-size: 12px;
            color: #666;
        }
        
        .btn-varian {
            background: linear-gradient(135deg, #f58b95 0%, #ff6b9d 100%);
            border: none;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-varian:hover {
            background: linear-gradient(135deg, #ff6b9d 0%, #d94865 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(245, 139, 149, 0.4);
            color: white;
        }
        
        .btn-delete-varian {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);
            border: none;
            color: white;
            padding: 8px 15px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 12px;
        }
        
        .btn-delete-varian:hover {
            background: linear-gradient(135deg, #ee5a6f 0%, #ff6b6b 100%);
            color: white;
        }
    </style>

    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="content-header" style="background: linear-gradient(135deg, #f58b95 0%, #ff6b9d 100%); padding: 25px; border-radius: 15px; margin-bottom: 25px;">
                <h5 style="color: white; font-weight: 700; margin: 0;">
                    <i class="mdi mdi-pencil"></i> {{ $judul }}
                </h5>
            </div>

            <!-- Form Edit Produk -->
            <div class="card" style="border-radius: 15px; box-shadow: 0 2px 15px rgba(245, 139, 149, 0.1);">
                <div class="card-body">
                    <form action="{{ route('backend.produk.update', $edit->id) }}" method="post" enctype="multipart/form-data">
                        @method('put')
                        @csrf

                        <div class="row">
                            <!-- Kategori -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Kategori <span class="text-danger">*</span></label>
                                <select name="kategori_id" class="form-control @error('kategori_id') is-invalid @enderror" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach($kategori as $row)
                                        <option value="{{ $row->id }}" {{ old('kategori_id', $edit->kategori_id) == $row->id ? 'selected' : '' }}>
                                            {{ $row->nama_kategori }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('kategori_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                <select name="status" class="form-control @error('status') is-invalid @enderror" required>
                                    <option value="0" {{ old('status', $edit->status) == 0 ? 'selected' : '' }}>Blok</option>
                                    <option value="1" {{ old('status', $edit->status) == 1 ? 'selected' : '' }}>Publish</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Nama Produk -->
                            <div class="col-12 mb-3">
                                <label class="form-label">Nama Produk <span class="text-danger">*</span></label>
                                <input type="text" name="nama_produk" class="form-control @error('nama_produk') is-invalid @enderror" 
                                       value="{{ old('nama_produk', $edit->nama_produk) }}" required>
                                @error('nama_produk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Detail -->
                            <div class="col-12 mb-3">
                                <label class="form-label">Detail Produk <span class="text-danger">*</span></label>
                                <textarea name="detail" rows="5" class="form-control @error('detail') is-invalid @enderror" required>{{ old('detail', $edit->detail) }}</textarea>
                                @error('detail')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Harga -->
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Harga <span class="text-danger">*</span></label>
                                <input type="number" name="harga" class="form-control @error('harga') is-invalid @enderror" 
                                       value="{{ old('harga', $edit->harga) }}" required>
                                @error('harga')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Berat -->
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Berat (gram) <span class="text-danger">*</span></label>
                                <input type="number" name="berat" class="form-control @error('berat') is-invalid @enderror" 
                                       value="{{ old('berat', $edit->berat) }}" required>
                                @error('berat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Stok -->
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Stok <span class="text-danger">*</span></label>
                                <input type="number" name="stok" class="form-control @error('stok') is-invalid @enderror" 
                                       value="{{ old('stok', $edit->stok) }}" required>
                                @error('stok')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Foto -->
                            <div class="col-12 mb-3">
                                <label class="form-label">Foto Produk</label>
                                @if($edit->foto)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/img-produk/thumb_md_' . $edit->foto) }}" 
                                             class="img-thumbnail" style="max-width: 200px;">
                                    </div>
                                @endif
                                <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror" accept="image/*">
                                <small class="text-muted">Kosongkan jika tidak ingin mengubah foto</small>
                                @error('foto')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="text-right">
                            <a href="{{ route('backend.produk.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-varian">
                                <i class="fas fa-save"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Varian Produk Section -->
            <div class="varian-card mt-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0" style="color: #d94865; font-weight: 700;">
                        <i class="mdi mdi-palette"></i> Varian Produk (Shade/Warna)
                    </h5>
                    <button type="button" class="btn btn-varian btn-sm" id="btnTambahVarian">
                        <i class="fas fa-plus"></i> Tambah Varian
                    </button>
                </div>

                <!-- Daftar Varian -->
                @if($edit->varian->count() > 0)
                    @foreach($edit->varian as $varian)
                        <div class="varian-item">
                            <div class="color-preview" style="background: {{ $varian->kode_warna ?? '#f58b95' }};"></div>
                            <div class="varian-info">
                                <div class="varian-name">{{ $varian->nama_varian }}</div>
                                <div class="varian-meta">
                                    <span><i class="mdi mdi-package-variant"></i> Stok: <strong>{{ $varian->stok }}</strong></span>
                                    @if($varian->harga_tambahan > 0)
                                        <span class="ml-3">
                                            <i class="mdi mdi-cash-plus"></i> 
                                            +Rp{{ number_format($varian->harga_tambahan, 0, ',', '.') }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div>
                                <button type="button" class="btn btn-sm btn-warning mr-1 btn-edit-varian" 
                                        data-id="{{ $varian->id }}"
                                        data-nama="{{ $varian->nama_varian }}"
                                        data-stok="{{ $varian->stok }}"
                                        data-harga="{{ $varian->harga_tambahan }}"
                                        data-warna="{{ $varian->kode_warna }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('backend.varian.destroy', $varian->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-delete-varian" 
                                            onclick="return confirm('Hapus varian {{ $varian->nama_varian }}?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-4">
                        <i class="mdi mdi-palette-outline" style="font-size: 48px; color: #ddd;"></i>
                        <p class="text-muted mt-2">Belum ada varian. Tambahkan varian produk seperti shade atau warna.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal Tambah Varian -->
    <div class="modal fade" id="modalTambahVarian" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('backend.varian.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="produk_id" value="{{ $edit->id }}">
                    
                    <div class="modal-header" style="background: linear-gradient(135deg, #f58b95 0%, #ff6b9d 100%);">
                        <h5 class="modal-title" style="color: white;">
                            <i class="mdi mdi-palette"></i> Tambah Varian Baru
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" style="color: white;">&times;</span>
                        </button>
                    </div>
                    
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Varian <span class="text-danger">*</span></label>
                            <input type="text" name="nama_varian" class="form-control" 
                                   placeholder="Contoh: 01 Light Beige" required>
                            <small class="text-muted">Contoh: 01 Light Beige, 02 Natural Beige, Shade A, dll</small>
                        </div>

                        <div class="form-group">
                            <label>Stok <span class="text-danger">*</span></label>
                            <input type="number" name="stok" class="form-control" value="0" min="0" required>
                        </div>

                        <div class="form-group">
                            <label>Harga Tambahan</label>
                            <input type="number" name="harga_tambahan" class="form-control" value="0" min="0">
                            <small class="text-muted">Kosongkan atau isi 0 jika harga sama dengan produk utama</small>
                        </div>

                        <div class="form-group">
                            <label>Kode Warna (Hex)</label>
                            <div class="input-group">
                                <input type="text" name="kode_warna" id="kode_warna" class="form-control" 
                                       placeholder="#FFC1A8" value="#f58b95">
                                <div class="input-group-append">
                                    <input type="color" id="color_picker" class="form-control" 
                                           value="#f58b95" style="width: 60px; padding: 2px;">
                                </div>
                            </div>
                            <small class="text-muted">Preview warna untuk varian shade</small>
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-varian">
                            <i class="fas fa-save"></i> Simpan Varian
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Varian -->
    <div class="modal fade" id="modalEditVarian" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="formEditVarian" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="modal-header" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                        <h5 class="modal-title" style="color: white;">
                            <i class="mdi mdi-pencil"></i> Edit Varian
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" style="color: white;">&times;</span>
                        </button>
                    </div>
                    
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Varian <span class="text-danger">*</span></label>
                            <input type="text" name="nama_varian" id="edit_nama_varian" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Stok <span class="text-danger">*</span></label>
                            <input type="number" name="stok" id="edit_stok" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Harga Tambahan</label>
                            <input type="number" name="harga_tambahan" id="edit_harga_tambahan" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Kode Warna (Hex)</label>
                            <div class="input-group">
                                <input type="text" name="kode_warna" id="edit_kode_warna" class="form-control">
                                <div class="input-group-append">
                                    <input type="color" id="edit_color_picker" class="form-control" 
                                           style="width: 60px; padding: 2px;">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-varian" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                            <i class="fas fa-save"></i> Update Varian
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('Script loaded!');
    
    // Cek apakah jQuery tersedia
    if (typeof jQuery === 'undefined') {
        console.error('jQuery tidak tersedia!');
        alert('Error: jQuery tidak ditemukan. Harap pastikan jQuery sudah ter-load.');
        return;
    }
    
    console.log('jQuery tersedia, versi:', jQuery.fn.jquery);
    
    // Button Tambah Varian
    $('#btnTambahVarian').on('click', function() {
        console.log('Button Tambah Varian diklik!');
        $('#modalTambahVarian').modal('show');
    });
    
    // Color Picker - Tambah
    $('#color_picker').on('change', function() {
        $('#kode_warna').val(this.value);
    });
    
    $('#kode_warna').on('input', function() {
        if (this.value.match(/^#[0-9A-Fa-f]{6}$/)) {
            $('#color_picker').val(this.value);
        }
    });
    
    // Button Edit Varian
    $('.btn-edit-varian').on('click', function() {
        console.log('Button Edit Varian diklik!');
        
        var id = $(this).data('id');
        var nama = $(this).data('nama');
        var stok = $(this).data('stok');
        var harga = $(this).data('harga');
        var warna = $(this).data('warna') || '#f58b95';
        
        var url = "{{ url('backend/varian') }}/" + id;
        $('#formEditVarian').attr('action', url);
        
        $('#edit_nama_varian').val(nama);
        $('#edit_stok').val(stok);
        $('#edit_harga_tambahan').val(harga || 0);
        $('#edit_kode_warna').val(warna);
        $('#edit_color_picker').val(warna);
        
        $('#modalEditVarian').modal('show');
    });
    
    // Color Picker - Edit
    $('#edit_color_picker').on('change', function() {
        $('#edit_kode_warna').val(this.value);
    });
    
    $('#edit_kode_warna').on('input', function() {
        if (this.value.match(/^#[0-9A-Fa-f]{6}$/)) {
            $('#edit_color_picker').val(this.value);
        }
    });
});
</script>
@endpush