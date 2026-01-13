<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
    Schema::table('transaksi', function (Blueprint $table) {

        if (!Schema::hasColumn('transaksi', 'kode_transaksi')) {
            $table->string('kode_transaksi')->after('id');
        }

        if (!Schema::hasColumn('transaksi', 'nama_customer')) {
            $table->string('nama_customer');
        }

        if (!Schema::hasColumn('transaksi', 'email_customer')) {
            $table->string('email_customer');
        }

        if (!Schema::hasColumn('transaksi', 'no_hp')) {
            $table->string('no_hp');
        }

        if (!Schema::hasColumn('transaksi', 'alamat_lengkap')) {
            $table->text('alamat_lengkap');
        }

        if (!Schema::hasColumn('transaksi', 'total_harga')) {
            $table->integer('total_harga')->default(0);
        }

        if (!Schema::hasColumn('transaksi', 'status_pembayaran')) {
            $table->string('status_pembayaran')->default('pending');
        }

        if (!Schema::hasColumn('transaksi', 'status_pengiriman')) {
            $table->string('status_pengiriman')->default('pending');
        }

        if (!Schema::hasColumn('transaksi', 'metode_pembayaran')) {
            $table->string('metode_pembayaran')->nullable();
        }

        if (!Schema::hasColumn('transaksi', 'catatan')) {
            $table->text('catatan')->nullable();
        }
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksi', function (Blueprint $table) {
            //
        });
    }
};
