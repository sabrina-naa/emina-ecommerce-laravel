<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    // HANYA LIHAT DATA
    public function index()
    {
        $customer = Customer::orderBy('created_at', 'desc')->get();
        return view('backend.v_customer.index', [
            'judul' => 'Data Customer',
            'index' => $customer
        ]);
    }

    // HAPUS FUNGSI create(), store(), edit(), update()
    // Admin TIDAK BISA tambah/edit customer manual
    
    // Optional: Admin bisa ubah status (ban/unban customer)
    public function updateStatus(Request $request, string $id)
    {
        $customer = Customer::findOrFail($id);
        
        $customer->update([
            'status' => $request->status
        ]);

        return redirect()->route('backend.customer.index')->with('success', 'Status customer berhasil diubah');
    }

    // Optional: Admin bisa hapus customer (kalau spam/abuse)
    public function destroy(string $id)
    {
        $customer = Customer::findOrFail($id);
        
        // Hapus foto jika ada
        if ($customer->foto) {
            $oldImagePath = public_path('storage/img-customer/') . $customer->foto;
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
        }
        
        $customer->delete();
        return redirect()->route('backend.customer.index')->with('success', 'Customer berhasil dihapus');
    }
}