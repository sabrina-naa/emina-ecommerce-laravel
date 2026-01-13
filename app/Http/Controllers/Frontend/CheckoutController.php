<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Keranjang;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    public function index()
    {
        if (!Auth::guard('customer')->check()) {
            return redirect()->route('customer.login')
                ->with('error', 'Silakan login terlebih dahulu');
        }

        $customer = Auth::guard('customer')->user();

        $cartItems = Keranjang::with(['produk', 'varian'])
            ->where('customer_id', $customer->id)
            ->where('is_selected', 1)
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Pilih produk yang ingin di-checkout terlebih dahulu');
        }

        $cart = [];
        $total = 0;

        foreach ($cartItems as $item) {
            if (!$item->produk) continue;

            $harga = $item->produk->harga;
            if ($item->varian) {
                $harga += $item->varian->harga_tambahan;
            }

            $subtotal = $harga * $item->qty;
            $total += $subtotal;

            $cart[] = [
                'id' => $item->id,
                'produk_id' => $item->produk_id,
                'varian_id' => $item->varian_id,
                'nama' => $item->produk->nama_produk,
                'harga' => $harga,
                'qty' => $item->qty,
                'foto' => $item->produk->foto,
                'varian_nama' => $item->varian ? $item->varian->nama_varian : null,
            ];
        }

        return view('frontend.checkout', compact('cart', 'total', 'customer'));
    }

    public function process(Request $request)
    {
        if (!Auth::guard('customer')->check()) {
            return redirect()->route('customer.login')
                ->with('error', 'Silakan login terlebih dahulu');
        }

        $validated = $request->validate([
            'nama_customer'     => 'required|string|max:255',
            'email_customer'    => 'required|email|max:255',
            'no_hp'             => 'required|string|max:20',
            'alamat_lengkap'    => 'required|string',
            'metode_pembayaran' => 'required|in:transfer_bank,ewallet,cod',
            'metode_pengiriman' => 'required|in:jne,jnt,sicepat,anteraja,ninja',
            'bank_terpilih'     => 'required_if:metode_pembayaran,transfer_bank',
            'ewallet_terpilih'  => 'required_if:metode_pembayaran,ewallet',
            'catatan'           => 'nullable|string|max:500',
        ]);

        $customer = Auth::guard('customer')->user();

        $cartItems = Keranjang::with(['produk', 'varian'])
            ->where('customer_id', $customer->id)
            ->where('is_selected', 1)
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Tidak ada produk yang dipilih untuk checkout');
        }

        DB::beginTransaction();

        try {
            $totalHarga = 0;
            foreach ($cartItems as $item) {
                $harga = $item->produk->harga;
                if ($item->varian) {
                    $harga += $item->varian->harga_tambahan;
                }
                $totalHarga += $harga * $item->qty;
            }

            $transaksi = Transaksi::create([
                'kode_transaksi'     => Transaksi::generateKodeTransaksi(),
                'customer_id'        => $customer->id,
                'nama_customer'      => $validated['nama_customer'],
                'email_customer'     => $validated['email_customer'],
                'no_hp'              => $validated['no_hp'],
                'alamat_lengkap'     => $validated['alamat_lengkap'],
                'metode_pembayaran'  => $validated['metode_pembayaran'],
                'bank_terpilih'      => $request->bank_terpilih ?? null,
                'ewallet_terpilih'   => $request->ewallet_terpilih ?? null,
                'metode_pengiriman'  => $validated['metode_pengiriman'],
                'total_harga'        => $totalHarga,
                'status_pembayaran'  => 'pending',
                'status_pengiriman'  => 'pending',
                'catatan'            => $validated['catatan'] ?? null,
            ]);

            foreach ($cartItems as $item) {
                $produk = \App\Models\Produk::lockForUpdate()->find($item->produk_id);

                if (!$produk) {
                    throw new \Exception('Produk tidak ditemukan');
                }

                if ($produk->stok < $item->qty) {
                    throw new \Exception('Stok produk "' . $produk->nama_produk . '" tidak mencukupi');
                }

                $harga = $produk->harga;
                if ($item->varian) {
                    $harga += $item->varian->harga_tambahan;
                }

                DetailTransaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'produk_id'    => $produk->id,
                    'qty'          => $item->qty,
                    'subtotal'     => $harga * $item->qty,
                ]);

                $produk->decrement('stok', $item->qty);
            }

            Keranjang::where('customer_id', $customer->id)
                ->where('is_selected', 1)
                ->delete();

            DB::commit();

            return redirect()->route('checkout.success', $transaksi->id)
                ->with('success', 'Pesanan berhasil dibuat!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Checkout Error: ' . $e->getMessage());

            return back()->with('error', 'Checkout gagal: ' . $e->getMessage());
        }
    }

    public function success($id)
    {
        $transaksi = Transaksi::with(['details.produk'])->findOrFail($id);
        return view('frontend.checkout_success', compact('transaksi'));
    }

    public function uploadBukti(Request $request, $id)
    {
        $request->validate([
            'bukti_pembayaran' => 'required|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        try {
            $transaksi = Transaksi::findOrFail($id);

            $file = $request->file('bukti_pembayaran');
            $filename = 'bukti_' . $transaksi->kode_transaksi . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/bukti-pembayaran', $filename);

            $transaksi->update([
                'bukti_pembayaran'  => $filename,
                'status_pembayaran' => 'paid',
                'tanggal_bayar'     => now(),
            ]);

            return redirect()->route('checkout.success', $id)
                ->with('success', 'Bukti pembayaran berhasil diupload');

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal upload bukti pembayaran');
        }
    }
}