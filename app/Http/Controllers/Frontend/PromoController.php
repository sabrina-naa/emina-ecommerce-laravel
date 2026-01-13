<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Http\Request;

class PromoController extends Controller
{
    public function index(Request $request)
    {
        // Query produk dengan status publish
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
        $sort = $request->get('sort', 'termurah');
        
        switch ($sort) {
            case 'termurah':
                $query->orderBy('harga', 'asc');
                break;
            case 'termahal':
                $query->orderBy('harga', 'desc');
                break;
            case 'terbaru':
                $query->orderBy('created_at', 'desc');
                break;
            default:
                $query->orderBy('harga', 'asc');
                break;
        }

        // Pagination
        $produk = $query->paginate(20)->withQueryString();
        
        // Ambil semua kategori
        $kategori = Kategori::orderBy('nama_kategori', 'asc')->get();

        return view('frontend.promo', compact('produk', 'kategori'));
    }
}