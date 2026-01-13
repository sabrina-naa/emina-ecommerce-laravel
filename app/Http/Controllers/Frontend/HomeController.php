<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil produk unggulan (status = 1, stok > 0)
        $produkUnggulan = Produk::with('kategori')
            ->where('status', 1)
            ->where('stok', '>', 0)
            ->orderBy('updated_at', 'desc')
            ->limit(8)
            ->get();

        // Ambil semua kategori
        $kategori = Kategori::orderBy('nama_kategori', 'asc')->get();

        // Produk terbaru
        $produkTerbaru = Produk::with('kategori')
            ->where('status', 1)
            ->where('stok', '>', 0)
            ->orderBy('created_at', 'desc')
            ->limit(4)
            ->get();

        return view('frontend.home', [
            'produkUnggulan' => $produkUnggulan,
            'produkTerbaru' => $produkTerbaru,
            'kategori' => $kategori,
        ]);
    }
}