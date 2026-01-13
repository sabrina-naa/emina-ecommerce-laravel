<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        // Query builder
        $query = Produk::with('kategori')->where('status', 1);

        // Filter berdasarkan kategori
        if ($request->has('kategori') && $request->kategori != '') {
            $query->where('kategori_id', $request->kategori);
        }

        // Filter berdasarkan search
        if ($request->has('search') && $request->search != '') {
            $query->where('nama_produk', 'like', '%' . $request->search . '%');
        }

        // Filter berdasarkan harga
        if ($request->has('harga_min') && $request->harga_min != '') {
            $query->where('harga', '>=', $request->harga_min);
        }
        
        if ($request->has('harga_max') && $request->harga_max != '') {
            $query->where('harga', '<=', $request->harga_max);
        }

        // Sorting
        $sort = $request->get('sort', 'terbaru');
        
        switch ($sort) {
            case 'termurah':
                $query->orderBy('harga', 'asc');
                break;
            case 'termahal':
                $query->orderBy('harga', 'desc');
                break;
            case 'terbaru':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        // Pagination
        $produk = $query->paginate(20)->withQueryString();
        
        // Ambil semua kategori untuk filter
        $kategori = Kategori::orderBy('nama_kategori', 'asc')->get();

        return view('frontend.shop', compact('produk', 'kategori'));
    }

    /**
     * Halaman kategori khusus (Makeup, Skincare, Lip Products)
     */
    public function kategori(Request $request, $slug)
    {
        // Mapping slug ke kategori
        $kategoriMap = [
            'makeup' => 'Makeup',
            'skincare' => 'Skincare',
            'lip-products' => 'Lip Products',
            'sun-protection' => 'Sun Protection',
        ];

        // Cek apakah slug valid
        if (!isset($kategoriMap[$slug])) {
            abort(404);
        }

        // Cari kategori berdasarkan nama
        $kategoriData = Kategori::where('nama_kategori', $kategoriMap[$slug])->first();
        
        if (!$kategoriData) {
            abort(404);
        }

        // Query produk berdasarkan kategori
        $query = Produk::with('kategori')
            ->where('status', 1)
            ->where('kategori_id', $kategoriData->id);

        // Filter berdasarkan search
        if ($request->has('search') && $request->search != '') {
            $query->where('nama_produk', 'like', '%' . $request->search . '%');
        }

        // Filter berdasarkan harga
        if ($request->has('harga_min') && $request->harga_min != '') {
            $query->where('harga', '>=', $request->harga_min);
        }
        
        if ($request->has('harga_max') && $request->harga_max != '') {
            $query->where('harga', '<=', $request->harga_max);
        }

        // Sorting
        $sort = $request->get('sort', 'terbaru');
        
        switch ($sort) {
            case 'termurah':
                $query->orderBy('harga', 'asc');
                break;
            case 'termahal':
                $query->orderBy('harga', 'desc');
                break;
            case 'terbaru':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        // Pagination
        $produk = $query->paginate(20)->withQueryString();
        
        // Ambil semua kategori untuk filter
        $kategori = Kategori::orderBy('nama_kategori', 'asc')->get();

        // Data untuk view
        $pageTitle = $kategoriMap[$slug];
        $pageSlug = $slug;

        return view('frontend.kategori', compact('produk', 'kategori', 'kategoriData', 'pageTitle', 'pageSlug'));
    }

    public function show($id)
    {
        $produk = Produk::with(['kategori', 'varian', 'fotoProduk'])->findOrFail($id);

        // Ambil produk terkait (kategori sama, selain produk ini)
        $produkTerkait = Produk::where('kategori_id', $produk->kategori_id)
            ->where('id', '!=', $produk->id)
            ->where('status', 1)
            ->limit(8)
            ->get();

        return view('frontend.produk-detail', compact('produk', 'produkTerkait'));
    }
}