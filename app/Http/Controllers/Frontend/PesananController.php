<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaksi;

class PesananController extends Controller
{
    // LIST PESANAN SAYA
    public function index()
    {
        $customer = Auth::guard('customer')->user();

        $pesanan = Transaksi::where('email_customer', $customer->email)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('frontend.pesanan.index', compact('pesanan'));
    }

    // DETAIL + LACAK PESANAN
    public function show($kode)
    {
        $customer = Auth::guard('customer')->user();

        $transaksi = Transaksi::with('details.produk')
            ->where('kode_transaksi', $kode)
            ->where('email_customer', $customer->email)
            ->firstOrFail();

        return view('frontend.pesanan.show', compact('transaksi'));
    }
}
