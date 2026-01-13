<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Keranjang;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Tampilkan keranjang
    public function index()
    {
    if (!Auth::guard('customer')->check()) {
        return redirect()->route('customer.login')
            ->with('error', 'Silakan login terlebih dahulu');
    }

    $customer = Auth::guard('customer')->user();
    
    // Ambil keranjang dari database
    $cartItems = Keranjang::with(['produk', 'varian'])
        ->where('customer_id', $customer->id)
        ->get();

    // Format ke array
    $cart = [];
    $totalSemua = 0;      // Total SEMUA barang (untuk "Total Harga")
    $totalTerpilih = 0;   // Total barang yang DICENTANG (untuk "Total" pink)
    $jumlahTerpilih = 0;  // Jumlah barang yang dicentang
    
    foreach ($cartItems as $item) {
        if (!$item->produk) continue;
        
        $harga = $item->produk->harga;
        if ($item->varian) {
            $harga += $item->varian->harga_tambahan;
        }
        
        $subtotal = $harga * $item->qty;
        
        $cart[$item->id] = [
            'id' => $item->id,
            'produk_id' => $item->produk_id,
            'nama' => $item->produk->nama_produk,
            'harga' => $harga,
            'qty' => $item->qty,
            'foto' => $item->produk->foto,
            'is_selected' => $item->is_selected,
            'varian_nama' => $item->varian ? $item->varian->nama_varian : null,
        ];
        
        // Hitung total SEMUA barang (tidak peduli centang atau tidak)
        $totalSemua += $subtotal;
        
        // Hitung total HANYA yang dicentang
        if ($item->is_selected == 1) {
            $totalTerpilih += $subtotal;
            $jumlahTerpilih++;
        }
    }

    return view('frontend.cart', compact('cart', 'totalSemua', 'totalTerpilih', 'jumlahTerpilih'));
    }

    // Tambah ke keranjang
    public function add(Request $request, $id)
    {
    if (!Auth::guard('customer')->check()) {
        return redirect()->route('customer.login')
            ->with('error', 'Silakan login terlebih dahulu');
    }

    $produk = Produk::findOrFail($id);
    $customer = Auth::guard('customer')->user();
    
    $varianId = $request->input('varian_id');
    $qty = $request->input('qty', 1);

    // Cek apakah produk (+ varian) sudah ada di keranjang
    $existingCart = Keranjang::where('customer_id', $customer->id)
        ->where('produk_id', $id)
        ->where('varian_id', $varianId)
        ->first();

    if ($existingCart) {
        // Update quantity
        $existingCart->update([
            'qty' => $existingCart->qty + $qty,
            'is_selected' => 1,
        ]);
    } else {
        // Tambah item baru
        Keranjang::create([
            'customer_id' => $customer->id,
            'produk_id' => $id,
            'varian_id' => $varianId,
            'qty' => $qty,
            'is_selected' => 1,
        ]);
    }

    // Hitung total item di keranjang
    $cartCount = Keranjang::where('customer_id', $customer->id)->count();

    return back()->with([
        'success' => 'Produk berhasil ditambahkan ke keranjang',
        'cart_count' => $cartCount // Kirim count untuk update badge
    ]);
    }

    // Update quantity
    public function update(Request $request, $id)
    {
    if (!Auth::guard('customer')->check()) {
        return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
    }

    $customer = Auth::guard('customer')->user();
    
    $cartItem = Keranjang::where('id', $id)
        ->where('customer_id', $customer->id)
        ->firstOrFail();

    $cartItem->update([
        'qty' => $request->qty
    ]);

    // Hitung ulang subtotal item ini
    $harga = $cartItem->produk->harga;
    if ($cartItem->varian) {
        $harga += $cartItem->varian->harga_tambahan;
    }
    $subtotal = $harga * $request->qty;

    // Hitung ulang TOTAL TERPILIH (yang is_selected = 1)
    $cartItems = Keranjang::with(['produk', 'varian'])
        ->where('customer_id', $customer->id)
        ->where('is_selected', 1)
        ->get();

    $totalTerpilih = 0;
    $jumlahTerpilih = 0;
    
    foreach ($cartItems as $item) {
        $hargaItem = $item->produk->harga;
        if ($item->varian) {
            $hargaItem += $item->varian->harga_tambahan;
        }
        $totalTerpilih += $hargaItem * $item->qty;
        $jumlahTerpilih++;
    }

    return response()->json([
        'success' => true,
        'subtotal' => number_format($subtotal, 0, ',', '.'),
        'totalTerpilih' => number_format($totalTerpilih, 0, ',', '.'),
        'jumlahTerpilih' => $jumlahTerpilih,
    ]);
    }
    // Toggle checkbox (pilih/tidak pilih item)
    public function toggleSelect($id)
    {
    if (!Auth::guard('customer')->check()) {
        return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
    }

    $customer = Auth::guard('customer')->user();
    
    $cartItem = Keranjang::where('id', $id)
        ->where('customer_id', $customer->id)
        ->first();

    if (!$cartItem) {
        return response()->json(['success' => false, 'message' => 'Item not found'], 404);
    }

    // Toggle is_selected
    $cartItem->update([
        'is_selected' => !$cartItem->is_selected
    ]);

    // Hitung ulang total HANYA yang selected
    $cartItems = Keranjang::with(['produk', 'varian'])
        ->where('customer_id', $customer->id)
        ->where('is_selected', 1)
        ->get();

    $totalTerpilih = 0;
    $jumlahTerpilih = 0;
    
    foreach ($cartItems as $item) {
        $harga = $item->produk->harga;
        if ($item->varian) {
            $harga += $item->varian->harga_tambahan;
        }
        $totalTerpilih += $harga * $item->qty;
        $jumlahTerpilih++;
    }

    return response()->json([
        'success' => true,
        'totalTerpilih' => number_format($totalTerpilih, 0, ',', '.'),
        'jumlahTerpilih' => $jumlahTerpilih,
    ]);
    }

    // Pilih semua
    public function selectAll()
    {
        if (!Auth::guard('customer')->check()) {
            return response()->json(['success' => false], 401);
        }

        $customer = Auth::guard('customer')->user();
        
        Keranjang::where('customer_id', $customer->id)
            ->update(['is_selected' => true]);

        return $this->recalculateTotal();
    }

    // Hapus item
    public function remove($id)
    {
        if (!Auth::guard('customer')->check()) {
            return back()->with('error', 'Unauthorized');
        }

        $customer = Auth::guard('customer')->user();
        
        $cartItem = Keranjang::where('id', $id)
            ->where('customer_id', $customer->id)
            ->firstOrFail();

        $cartItem->delete();

        return back()->with('success', 'Produk berhasil dihapus dari keranjang');
    }

    // Hapus semua
    public function clear()
    {
        if (!Auth::guard('customer')->check()) {
            return back()->with('error', 'Unauthorized');
        }

        $customer = Auth::guard('customer')->user();
        
        Keranjang::where('customer_id', $customer->id)->delete();

        return back()->with('success', 'Keranjang berhasil dikosongkan');
    }

    // Get cart count (untuk badge notifikasi)
    public function getCount()
    {
    if (!Auth::guard('customer')->check()) {
        return response()->json(['count' => 0]);
    }

    $customer = Auth::guard('customer')->user();
    
    $count = Keranjang::where('customer_id', $customer->id)->count();
    
    return response()->json(['count' => $count]);
    }

    // Helper: Recalculate total
    private function recalculateTotal()
    {
        $customer = Auth::guard('customer')->user();
        
        $cartItems = Keranjang::with(['produk', 'varian'])
            ->where('customer_id', $customer->id)
            ->get();

        $total = 0;
        $selectedCount = 0;
        
        foreach ($cartItems as $item) {
            if ($item->is_selected) {
                $harga = $item->produk->harga;
                if ($item->varian) {
                    $harga += $item->varian->harga_tambahan;
                }
                $total += $harga * $item->qty;
                $selectedCount++;
            }
        }

        return response()->json([
            'success' => true,
            'total' => number_format($total, 0, ',', '.'),
            'selectedCount' => $selectedCount,
        ]);
    }
}