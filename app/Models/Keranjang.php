<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    use HasFactory;

    protected $table = 'keranjang';
    
    protected $fillable = [
        'customer_id',
        'produk_id',
        'varian_id',
        'qty',
        'is_selected',
    ];

    protected $casts = [
        'is_selected' => 'boolean',
    ];

    // Relasi ke Customer
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // Relasi ke Produk
    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }

    // Relasi ke Varian
    public function varian()
    {
        return $this->belongsTo(VarianProduk::class);
    }
}