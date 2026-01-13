<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CustomerProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:customer');
    }

    // Halaman Profile
    public function index()
    {
        $customer = Auth::guard('customer')->user();

        // Ambil statistik transaksi customer
        $totalTransaksi = Transaksi::where('email_customer', $customer->email)->count();
        $transaksiPending = Transaksi::where('email_customer', $customer->email)
            ->where('status_pembayaran', 'pending')
            ->count();
        $transaksiSelesai = Transaksi::where('email_customer', $customer->email)
            ->where('status_pembayaran', 'paid')
            ->where('status_pengiriman', 'delivered')
            ->count();

        return view('frontend.profile', [
            'customer' => $customer,
            'totalTransaksi' => $totalTransaksi,
            'transaksiPending' => $transaksiPending,
            'transaksiSelesai' => $transaksiSelesai,
        ]);
    }

    // Update Profile
    public function update(Request $request)
    {
        $customer = Auth::guard('customer')->user();

        $request->validate([
            'nama' => 'required|max:255',
            'email' => 'required|email|unique:customer,email,' . $customer->id,
            'no_hp' => 'required',
            'kota' => 'nullable|max:100',
            'provinsi' => 'nullable|max:100',
            'kode_pos' => 'nullable|max:10',
            'alamat' => 'nullable',
        ]);

        $customer->update([
            'nama' => $request->nama,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'kota' => $request->kota,
            'provinsi' => $request->provinsi,
            'kode_pos' => $request->kode_pos,
            'alamat' => $request->alamat,
        ]);

        return redirect()->back()
            ->with('success', 'Profil berhasil diperbarui!');
    }

    // Update Foto Profile (FIXED - SIMPAN KE img-customer)
    public function updateFoto(Request $request)
    {
        $customer = Auth::guard('customer')->user();

        $request->validate([
            'foto' => 'required|image|mimes:jpeg,jpg,png|max:2048',
        ], [
            'foto.required' => 'Foto harus dipilih',
            'foto.image' => 'File harus berupa gambar',
            'foto.mimes' => 'Format foto harus jpeg, jpg, atau png',
            'foto.max' => 'Ukuran foto maksimal 2MB',
        ]);

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada (KECUALI default)
            if ($customer->foto && $customer->foto != 'img-default.jpg') {
                $oldPhotoPath = public_path('storage/img-customer/' . $customer->foto);
                if (file_exists($oldPhotoPath)) {
                    unlink($oldPhotoPath);
                }
            }

            // Upload foto baru
            $file = $request->file('foto');
            $extension = $file->getClientOriginalExtension();
            $fileName = 'customer_' . $customer->id . '_' . time() . '.' . $extension;
            
            // Simpan ke public/storage/img-customer/
            $destinationPath = public_path('storage/img-customer');
            
            // Pastikan folder ada
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            
            // Move file
            $file->move($destinationPath, $fileName);

            // Update database
            $customer->update([
                'foto' => $fileName
            ]);

            return redirect()->back()
                ->with('success', 'Foto profil berhasil diperbarui!');
        }

        return redirect()->back()
            ->with('error', 'Gagal mengupload foto');
    }

    // Update Password
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:4|confirmed',
        ], [
            'current_password.required' => 'Password lama harus diisi.',
            'password.min' => 'Password baru minimal 4 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $customer = Auth::guard('customer')->user();

        // Cek password lama
        if (!Hash::check($request->current_password, $customer->password)) {
            return back()->withErrors([
                'current_password' => 'Password lama salah.'
            ]);
        }

        // Update password
        $customer->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->back()
            ->with('success', 'Password berhasil diubah!');
    }

    // Riwayat Transaksi
    public function orders()
    {
        $customer = Auth::guard('customer')->user();

        $orders = Transaksi::with('details.produk')
            ->where('email_customer', $customer->email)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('frontend.orders.index', [
            'orders' => $orders,
        ]);
    }

    // Detail Transaksi
    public function orderDetail($id)
    {
        $customer = Auth::guard('customer')->user();

        $order = Transaksi::with('details.produk')
            ->where('id', $id)
            ->where('email_customer', $customer->email)
            ->firstOrFail();

        return view('frontend.orders.show', [
            'order' => $order,
        ]);
    }
}