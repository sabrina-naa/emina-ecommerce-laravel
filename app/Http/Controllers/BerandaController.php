<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Kategori;
use App\Models\Produk;

class BerandaController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function berandaBackend()
    {
        $totalUser = User::count();
        $totalKategori = Kategori::count();
        $totalProduk = Produk::count();

        return view('backend.v_beranda.index', [
            'judul' => 'Dashboard Emina Beauty',
            'totalUser' => $totalUser,
            'totalKategori' => $totalKategori,
            'totalProduk' => $totalProduk,
        ]);
    }
}
