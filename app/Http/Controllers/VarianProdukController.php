<?php

namespace App\Http\Controllers;

use App\Models\VarianProduk;
use Illuminate\Http\Request;

class VarianProdukController extends Controller
{
    // Store varian baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'produk_id' => 'required|exists:produk,id',
            'nama_varian' => 'required|string|max:255',
            'stok' => 'required|integer|min:0',
            'harga_tambahan' => 'nullable|numeric|min:0',
            'kode_warna' => 'nullable|string|max:7',
        ]);

        VarianProduk::create($validated);

        return redirect()->back()->with('success', 'Varian berhasil ditambahkan');
    }

    // Update varian
    public function update(Request $request, $id)
    {
        $varian = VarianProduk::findOrFail($id);

        $validated = $request->validate([
            'nama_varian' => 'required|string|max:255',
            'stok' => 'required|integer|min:0',
            'harga_tambahan' => 'nullable|numeric|min:0',
            'kode_warna' => 'nullable|string|max:7',
        ]);

        $varian->update($validated);

        return redirect()->back()->with('success', 'Varian berhasil diupdate');
    }

    // Delete varian
    public function destroy($id)
    {
        $varian = VarianProduk::findOrFail($id);
        $varian->delete();

        return redirect()->back()->with('success', 'Varian berhasil dihapus');
    }
}