@extends('backend.v_layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ $judul }}</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Kategori</label>
                                    <select name="kategori_id"
                                        class="form-control @error('kategori_id') is-invalid @enderror" disabled>
                                        <option value="" selected> - Pilih Kategori - </option>
                                        @foreach ($kategori as $row)
                                            <option value="{{ $row->id }}"
                                                {{ old('kategori_id', $show->kategori_id) == $row->id ? 'selected' : '' }}>
                                                {{ $row->nama_kategori }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Nama Produk</label>
                                    <input type="text" name="nama_produk"
                                        value="{{ old('nama_produk', $show->nama_produk) }}"
                                        class="form-control"
                                        placeholder="Masukkan Nama Produk" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Detail</label>
                                    <textarea name="detail" class="form-control" id="ckeditor" disabled>{{ old('detail', $show->detail) }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>Foto Utama</label> <br>
                                    <img src="{{ asset('storage/img-produk/' . $show->foto) }}" class="foto-preview"
                                        width="100%">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>Foto Tambahan</label>
                                <div id="foto-container">
                                    <div class="row">
                                        @foreach ($show->fotoProduk as $gambar)
                                            <div class="col-md-12 mb-3">
                                                <div class="card">
                                                    <img src="{{ asset('storage/img-produk/' . $gambar->foto) }}"
                                                        class="card-img-top">
                                                    <div class="card-body text-center">
                                                        <form action="{{ route('backend.foto_produk.destroy', $gambar->id) }}"
                                                            method="post" style="display: inline;">
                                                            @csrf
                                                            @method('delete')
                                                            <button type="submit" class="btn btn-danger btn-sm"
                                                                onclick="return confirm('Hapus foto ini?')">
                                                                <i class="fas fa-trash"></i> Hapus
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <button type="button" class="btn btn-primary add-foto mt-2" id="btnTambahFoto">
                                    <i class="fas fa-plus"></i> Tambah Foto
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="border-top">
                        <div class="card-body">
                            <a href="{{ route('backend.produk.index') }}">
                                <button type="button" class="btn btn-secondary">Kembali</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('Script Tambah Foto loaded!');
    
    // Cek apakah jQuery tersedia
    if (typeof jQuery === 'undefined') {
        console.error('jQuery tidak tersedia!');
        alert('Error: jQuery tidak ditemukan. Harap pastikan jQuery sudah ter-load.');
        return;
    }
    
    console.log('jQuery tersedia, versi:', jQuery.fn.jquery);
    
    // Event dengan jQuery
    $('#btnTambahFoto').on('click', function() {
        console.log('Button Tambah Foto diklik!');
        
        var fotoRow = $('<div>', {
            class: 'mt-3 border p-3 rounded bg-light foto-row'
        });
        
        var formHtml = `
            <form action="{{ route('backend.foto_produk.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="produk_id" value="{{ $show->id }}">
                <div class="row align-items-center">
                    <div class="col-md-7">
                        <input type="file" name="foto_produk" class="form-control" required accept="image/*">
                    </div>
                    <div class="col-md-5">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                        <button type="button" class="btn btn-secondary remove-foto">
                            <i class="fas fa-times"></i> Batal
                        </button>
                    </div>
                </div>
            </form>
        `;
        
        fotoRow.html(formHtml);
        $('#foto-container').append(fotoRow);
        
        console.log('Form berhasil ditambahkan!');
    });
    
    // Event delegation untuk button hapus
    $(document).on('click', '.remove-foto', function() {
        console.log('Button Batal diklik!');
        $(this).closest('.foto-row').remove();
    });
    
    // Fallback dengan vanilla JavaScript jika jQuery gagal
    var btnFoto = document.getElementById('btnTambahFoto');
    if (btnFoto && typeof jQuery === 'undefined') {
        console.log('Menggunakan vanilla JavaScript sebagai fallback');
        
        btnFoto.addEventListener('click', function() {
            console.log('Button diklik (vanilla JS)!');
            
            var fotoContainer = document.getElementById('foto-container');
            var fotoRow = document.createElement('div');
            fotoRow.classList.add('mt-3', 'border', 'p-3', 'rounded', 'bg-light', 'foto-row');
            
            fotoRow.innerHTML = `
                <form action="{{ route('backend.foto_produk.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="produk_id" value="{{ $show->id }}">
                    <div class="row align-items-center">
                        <div class="col-md-7">
                            <input type="file" name="foto_produk" class="form-control" required accept="image/*">
                        </div>
                        <div class="col-md-5">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                            <button type="button" class="btn btn-secondary remove-foto">
                                <i class="fas fa-times"></i> Batal
                            </button>
                        </div>
                    </div>
                </form>
            `;
            
            fotoContainer.appendChild(fotoRow);
            
            // Event untuk button hapus
            fotoRow.querySelector('.remove-foto').addEventListener('click', function() {
                fotoRow.remove();
            });
        });
    }
});
</script>
@endpush