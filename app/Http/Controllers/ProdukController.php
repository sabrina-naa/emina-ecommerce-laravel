<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use App\Models\FotoProduk;
use App\Helpers\ImageHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $produk = Produk::orderBy('updated_at', 'desc')->get();
        return view('backend.v_produk.index', [
            'judul' => 'Data Produk',
            'index' => $produk
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategori = Kategori::orderBy('nama_kategori', 'asc')->get();
        return view('backend.v_produk.create', [
            'judul' => 'Tambah Produk',
            'kategori' => $kategori
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'kategori_id' => 'required',
            'nama_produk' => 'required|max:255|unique:produk',
            'detail' => 'required',
            'harga' => 'required',
            'berat' => 'required',
            'stok' => 'required',
            'foto' => 'required|image|mimes:jpeg,jpg,png,gif|file|max:1024',
        ], $messages = [
            'foto.image' => 'Format gambar gunakan file dengan ekstensi jpeg, jpg, png, atau gif.',
            'foto.max' => 'Ukuran file gambar Maksimal adalah 1024 KB.'
        ]);

        $validatedData['status'] = 0;
        if ($request->file('foto')) {
            $file = $request->file('foto');
            $extension = $file->getClientOriginalExtension();
            $originalFileName = date('YmdHis') . '_' . uniqid() . '.' . $extension;
            $directory = 'storage/img-produk/';
            // Simpan gambar asli
            $fileName = ImageHelper::uploadAndResize($file, $directory, $originalFileName);
            $validatedData['foto'] = $fileName;
            // create thumbnail 1 (lg)
            $thumbnailLg = 'thumb_lg_' . $originalFileName;
            ImageHelper::uploadAndResize($file, $directory, $thumbnailLg, 800, null);
            // create thumbnail 2 (md)
            $thumbnailMd = 'thumb_md_' . $originalFileName;
            ImageHelper::uploadAndResize($file, $directory, $thumbnailMd, 500, 519);
            // create thumbnail 3 (sm)
            $thumbnailSm = 'thumb_sm_' . $originalFileName;
            ImageHelper::uploadAndResize($file, $directory, $thumbnailSm, 100, 110);
            // Simpan nama file asli di database
            $validatedData['foto'] = $originalFileName;
            $validatedData['user_id'] = Auth::user()->id;
        }
        Produk::create($validatedData, $messages);
        return redirect()->route('backend.produk.index')->with('success', 'Data berhasil tersimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $produk = Produk::with('fotoProduk')->findOrFail($id);
        $kategori = Kategori::orderBy('nama_kategori', 'asc')->get();
        return view('backend.v_produk.show', [
            'judul' => 'Detail Produk',
            'show' => $produk,
            'kategori' => $kategori
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $produk = Produk::with('varian')->findOrFail($id);
        $kategori = Kategori::orderBy('nama_kategori', 'asc')->get();
        return view('backend.v_produk.edit', [
            'judul' => 'Ubah Produk',
            'edit' => $produk,
            'kategori' => $kategori
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //ddd($request);
        $produk = Produk::findOrFail($id);
        $rules = [
            'nama_produk' => 'required|max:255|unique:produk,nama_produk,' . $id,
            'kategori_id' => 'required',
            'status' => 'required',
            'detail' => 'required',
            'harga' => 'required',
            'berat' => 'required',
            'stok' => 'required',
            'foto' => 'image|mimes:jpeg,jpg,png,gif|file|max:1024',
        ];
        $messages = [
            'foto.image' => 'Format gambar gunakan file dengan ekstensi jpeg, jpg, png, atau gif.',
            'foto.max' => 'Ukuran file gambar Maksimal adalah 1024 KB.'
        ];
        $validatedData['user_id'] = auth()->id();
        $validatedData = $request->validate($rules, $messages);
        if ($request->file('foto')) {
            //hapus gambar lama
            if ($produk->foto) {
                $oldImagePath = public_path('storage/img-produk/') . $produk->foto;
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
                $oldThumbnailLg = public_path('storage/img-produk/') . 'thumb_lg_' .
                    $produk->foto;
                if (file_exists($oldThumbnailLg)) {
                    unlink($oldThumbnailLg);
                }
                $oldThumbnailMd = public_path('storage/img-produk/') . 'thumb_md_' .
                    $produk->foto;
                if (file_exists($oldThumbnailMd)) {
                    unlink($oldThumbnailMd);
                }
                $oldThumbnailSm = public_path('storage/img-produk/') . 'thumb_sm_' .
                    $produk->foto;
                if (file_exists($oldThumbnailSm)) {
                    unlink($oldThumbnailSm);
                }
            }
            $file = $request->file('foto');
            $extension = $file->getClientOriginalExtension();
            $originalFileName = date('YmdHis') . '_' . uniqid() . '.' . $extension;
            $directory = 'storage/img-produk/';
            // Simpan gambar asli
            $fileName = ImageHelper::uploadAndResize($file, $directory, $originalFileName);
            $validatedData['foto'] = $fileName;
            // create thumbnail 1 (lg)
            $thumbnailLg = 'thumb_lg_' . $originalFileName;
            ImageHelper::uploadAndResize($file, $directory, $thumbnailLg, 800, null);
            // create thumbnail 2 (md)
            $thumbnailMd = 'thumb_md_' . $originalFileName;
            ImageHelper::uploadAndResize($file, $directory, $thumbnailMd, 500, 519);
            // create thumbnail 3 (sm)
            $thumbnailSm = 'thumb_sm_' . $originalFileName;
            ImageHelper::uploadAndResize($file, $directory, $thumbnailSm, 100, 110);
            // Simpan nama file asli di database
            $validatedData['foto'] = $originalFileName;
        }
        $produk->update($validatedData);
        return redirect()->route('backend.produk.index')->with('success', 'Data berhasil diperbaharui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $produk = Produk::findOrFail($id);
        $directory = public_path('storage/img-produk/');
        if ($produk->foto) {
            // Hapus gambar asli
            $oldImagePath = $directory . $produk->foto;
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
            // Hapus thumbnail lg
            $thumbnailLg = $directory . 'thumb_lg_' . $produk->foto;
            if (file_exists($thumbnailLg)) {
                unlink($thumbnailLg);
            }
            // Hapus thumbnail md
            $thumbnailMd = $directory . 'thumb_md_' . $produk->foto;
            if (file_exists($thumbnailMd)) {
                unlink($thumbnailMd);
            }
            // Hapus thumbnail sm
            $thumbnailSm = $directory . 'thumb_sm_' . $produk->foto;
            if (file_exists($thumbnailSm)) {
                unlink($thumbnailSm);
            }
        }

        // Hapus foto produk lainnya di tabel foto_produk
        $fotoProduks = FotoProduk::where('produk_id', $id)->get();
        foreach ($fotoProduks as $fotoProduk) {
            $fotoPath = $directory . $fotoProduk->foto;
            if (file_exists($fotoPath)) {
                unlink($fotoPath);
            }
            $fotoProduk->delete();
        }
        $produk->delete();
        return redirect()->route('backend.produk.index')->with('success', 'Data berhasil dihapus');
    }

    // Method untuk menyimpan foto tambahan
    public function storeFoto(Request $request)
    {
    $request->validate([
        'produk_id' => 'required|exists:produk,id',
        'foto_produk' => 'required|image|mimes:jpeg,jpg,png,gif|max:2048',
    ]);

    if ($request->hasFile('foto_produk')) {
        $file = $request->file('foto_produk');
        $extension = $file->getClientOriginalExtension();
        $originalFileName = 'produk_' . $request->produk_id . '_' . time() . '_' . uniqid() . '.' . $extension;
        $directory = 'storage/img-produk/';
        
        // Upload dengan ImageHelper (sama seperti foto utama)
        $fileName = ImageHelper::uploadAndResize($file, $directory, $originalFileName);
        
        // Create thumbnails
        $thumbnailLg = 'thumb_lg_' . $originalFileName;
        ImageHelper::uploadAndResize($file, $directory, $thumbnailLg, 800, null);
        
        $thumbnailMd = 'thumb_md_' . $originalFileName;
        ImageHelper::uploadAndResize($file, $directory, $thumbnailMd, 500, 519);
        
        $thumbnailSm = 'thumb_sm_' . $originalFileName;
        ImageHelper::uploadAndResize($file, $directory, $thumbnailSm, 100, 110);
        
        // Simpan ke database
        FotoProduk::create([
            'produk_id' => $request->produk_id,
            'foto' => $originalFileName,
        ]);
        
        return redirect()->route('backend.produk.show', $request->produk_id)
            ->with('success', 'Foto berhasil ditambahkan!');
    }
    
    return redirect()->back()->with('error', 'File tidak valid.');
    }

    // Method untuk menghapus foto
    public function destroyFoto($id)
    {
        $foto = FotoProduk::findOrFail($id);
        $produkId = $foto->produk_id;
        // Hapus file gambar dari storage
        $imagePath = public_path('storage/img-produk/') . $foto->foto;
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
        // Hapus record dari database
        $foto->delete();
        return redirect()->route('backend.produk.show', $produkId)
            ->with('success', 'Foto berhasil dihapus.');
    }

    // Method untuk Form Laporan Produk
    public function formProduk()
    {
        return view('backend.v_produk.form', [
            'judul' => 'Laporan Data Produk',
        ]);
    }

    // Method untuk Cetak Laporan Produk
    public function cetakProduk(Request $request)
    {
    // Validasi input
    $request->validate([
        'tanggal_awal' => 'required|date',
        'tanggal_akhir' => 'required|date|after_or_equal:tanggal_awal',
    ], [
        'tanggal_awal.required' => 'Tanggal Awal harus diisi.',
        'tanggal_akhir.required' => 'Tanggal Akhir harus diisi.',
        'tanggal_akhir.after_or_equal' => 'Tanggal Akhir harus lebih besar atau sama dengan Tanggal Awal.',
    ]);

    $tanggalAwal = $request->input('tanggal_awal');
    $tanggalAkhir = $request->input('tanggal_akhir');
    $filterKategori = $request->input('kategori_id');

    // Query dasar dengan relasi kategori
    $query = Produk::with('kategori')
        ->whereBetween('updated_at', [$tanggalAwal, $tanggalAkhir]);

    // Filter berdasarkan kategori jika dipilih
    if ($filterKategori) {
        $query->where('kategori_id', $filterKategori);
    }

    $produk = $query->orderBy('id', 'desc')->get();

    // === STATISTIK STOK ===
    $totalProduk = $produk->count();
    $stokTersedia = $produk->where('stok', '>', 0)->count();
    $stokHabis = $produk->where('stok', '=', 0)->count();
    $stokMenipis = $produk->where('stok', '>', 0)->where('stok', '<', 10)->count();

    // Total nilai stok (harga × stok)
    $totalNilaiStok = $produk->sum(function ($item) {
        return $item->harga * $item->stok;
    });

    // === DATA STOK HABIS ===
    $produkStokHabis = $produk->where('stok', '=', 0);

    // === DATA STOK MENIPIS ===
    $produkStokMenipis = $produk->where('stok', '>', 0)->where('stok', '<', 10);

    // === STATISTIK PER KATEGORI ===
    $kategoriStats = $produk->groupBy('kategori_id')->map(function ($items) {
        $totalStok = $items->sum('stok');
        $totalNilai = $items->sum(function ($item) {
            return $item->harga * $item->stok;
        });
        
        return [
            'nama_kategori' => $items->first()->kategori->nama_kategori ?? 'Tanpa Kategori',
            'jumlah_produk' => $items->count(),
            'total_stok' => $totalStok,
            'total_nilai' => $totalNilai,
        ];
    });

    // === PRODUK TERLARIS (dari transaksi) ===
    $produkTerlaris = \DB::table('detail_transaksi')
        ->join('produk', 'detail_transaksi.produk_id', '=', 'produk.id')
        ->join('transaksi', 'detail_transaksi.transaksi_id', '=', 'transaksi.id')
        ->whereBetween('transaksi.created_at', [$tanggalAwal, $tanggalAkhir])
        ->select(
            'produk.nama_produk',
            \DB::raw('SUM(detail_transaksi.qty) as total_terjual'),
            \DB::raw('SUM(detail_transaksi.subtotal) as total_pendapatan')
        )
        ->groupBy('produk.id', 'produk.nama_produk')
        ->orderBy('total_terjual', 'desc')
        ->limit(10)
        ->get();

    // Ambil semua kategori untuk filter
    $kategori = \App\Models\Kategori::orderBy('nama_kategori', 'asc')->get();

    return view('backend.v_produk.cetak', [
        'judul' => 'Laporan Produk',
        'tanggalAwal' => $tanggalAwal,
        'tanggalAkhir' => $tanggalAkhir,
        'cetak' => $produk,
        'totalProduk' => $totalProduk,
        'stokTersedia' => $stokTersedia,
        'stokHabis' => $stokHabis,
        'stokMenipis' => $stokMenipis,
        'totalNilaiStok' => $totalNilaiStok,
        'produkStokHabis' => $produkStokHabis,
        'produkStokMenipis' => $produkStokMenipis,
        'kategoriStats' => $kategoriStats,
        'produkTerlaris' => $produkTerlaris,
        'filterKategori' => $filterKategori,
        'kategori' => $kategori,
    ]);
}
}
