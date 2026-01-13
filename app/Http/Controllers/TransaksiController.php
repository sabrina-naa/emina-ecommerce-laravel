<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Produk;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksi = Transaksi::orderBy('created_at', 'desc')->get();
        return view('backend.v_transaksi.index', [
            'judul' => 'Data Transaksi',
            'index' => $transaksi
        ]);
    }

    public function show(string $id)
    {
        $transaksi = Transaksi::with('details')->findOrFail($id);
        return view('backend.v_transaksi.show', [
            'judul' => 'Detail Transaksi',
            'transaksi' => $transaksi
        ]);
    }

    public function edit(string $id)
    {
        $transaksi = Transaksi::findOrFail($id);
        return view('backend.v_transaksi.edit', [
            'judul' => 'Ubah Status Transaksi',
            'edit' => $transaksi
        ]);
    }

    public function update(Request $request, string $id)
    {
        $transaksi = Transaksi::findOrFail($id);
        
        $validatedData = $request->validate([
            'status_pembayaran' => 'required',
            'status_pengiriman' => 'required',
        ]);

        $transaksi->update($validatedData);

        return redirect()->route('backend.transaksi.index')->with('success', 'Status transaksi berhasil diupdate');
    }

    public function destroy(string $id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->delete();
        return redirect()->route('backend.transaksi.index')->with('success', 'Transaksi berhasil dihapus');
    }
}