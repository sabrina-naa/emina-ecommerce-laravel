<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';

    protected $fillable = [
        'kode_transaksi',
        'customer_id',
        'nama_customer',
        'email_customer',
        'no_hp',
        'alamat_lengkap',
        'total_harga',
        'status_pembayaran',
        'status_pengiriman',
        'metode_pembayaran',
        'bank_terpilih',
        'ewallet_terpilih',
        'metode_pengiriman',
        'nomor_resi',
        'bukti_pembayaran',
        'tanggal_bayar', 
        'catatan'
    ];

    // Relasi ke detail transaksi
    public function details()
    {
        return $this->hasMany(DetailTransaksi::class, 'transaksi_id');
    }

    // Relasi ke customer
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    // Relasi ke reviews
    public function reviews()
    {
        return $this->hasMany(Review::class, 'transaksi_id');
    }

    // Generate kode transaksi otomatis
    public static function generateKodeTransaksi()
    {
        $date = date('Ymd');
        $lastTransaction = self::whereDate('created_at', today())
            ->orderBy('id', 'desc')
            ->first();
        
        if ($lastTransaction) {
            $lastNumber = intval(substr($lastTransaction->kode_transaksi, -4));
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        
        return 'TRX' . $date . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    // Helper untuk nama metode pembayaran
    public function getMetodePembayaranLengkap()
    {
        if ($this->metode_pembayaran == 'transfer_bank') {
            return 'Transfer Bank ' . strtoupper($this->bank_terpilih ?? '');
        } elseif ($this->metode_pembayaran == 'ewallet') {
            return 'E-Wallet ' . strtoupper($this->ewallet_terpilih ?? '');
        } else {
            return 'COD (Bayar di Tempat)';
        }
    }
}