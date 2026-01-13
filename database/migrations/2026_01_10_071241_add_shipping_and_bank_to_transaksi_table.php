<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('transaksi', function (Blueprint $table) {
            $table->string('metode_pengiriman')->nullable()->after('metode_pembayaran');
            $table->string('bank_terpilih')->nullable()->after('metode_pembayaran');
            $table->string('ewallet_terpilih')->nullable()->after('bank_terpilih');
            $table->string('nomor_resi')->nullable()->after('status_pengiriman');
        });
    }

    public function down()
    {
        Schema::table('transaksi', function (Blueprint $table) {
            $table->dropColumn(['metode_pengiriman', 'bank_terpilih', 'ewallet_terpilih', 'nomor_resi']);
        });
    }
};