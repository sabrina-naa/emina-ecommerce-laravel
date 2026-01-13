<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('keranjang', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('produk_id');
            $table->unsignedBigInteger('varian_id')->nullable();
            $table->integer('qty')->default(1);
            $table->boolean('is_selected')->default(true); 
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customer')->onDelete('cascade');
            $table->foreign('produk_id')->references('id')->on('produk')->onDelete('cascade');
            $table->foreign('varian_id')->references('id')->on('varian_produk')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('keranjang');
    }
};