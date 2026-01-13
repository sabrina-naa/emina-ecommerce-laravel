<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('transaksi', function (Blueprint $table) {
            $table->string('bukti_pembayaran')->nullable()->after('metode_pembayaran');
            $table->timestamp('tanggal_bayar')->nullable()->after('bukti_pembayaran');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::table('transaksi', function (Blueprint $table) {
            $table->dropColumn(['bukti_pembayaran', 'tanggal_bayar']);
        });
    }
};
