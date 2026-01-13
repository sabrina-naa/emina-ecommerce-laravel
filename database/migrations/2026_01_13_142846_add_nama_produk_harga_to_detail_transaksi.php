<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('detail_transaksi', function (Blueprint $table) {
            $table->string('nama_produk')->nullable()->after('produk_id');
            $table->decimal('harga', 10, 2)->nullable()->after('nama_produk');
        });
    }

    public function down()
    {
        Schema::table('detail_transaksi', function (Blueprint $table) {
            $table->dropColumn(['nama_produk', 'harga']);
        });
    }
};