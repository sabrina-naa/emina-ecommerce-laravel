<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $table = "produk";
    protected $guarded = ['id'];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function fotoProduk()
    {
        return $this->hasMany(FotoProduk::class, 'produk_id');
    }

    public function varian()
    {
        return $this->hasMany(VarianProduk::class, 'produk_id');
    }

    // Relasi ke reviews
    public function reviews()
    {
        return $this->hasMany(Review::class, 'produk_id');
    }

    // rating
    public function averageRating()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

    // total reviews 
    public function totalReviews()
    {
        return $this->reviews()->count();
    }

    // reviews yang sudah dibalas admin
    public function repliedReviews()
    {
        return $this->reviews()->whereNotNull('admin_reply');
    }
}