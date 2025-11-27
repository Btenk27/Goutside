<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdukTable extends Migration
{
    public function up()
    {
        Schema::create('produk', function (Blueprint $table) {
            $table->id('idbarang');
            $table->string('nama_barang');
            $table->decimal('harga', 15, 2);
            $table->string('gambar')->nullable();
            $table->text('deskripsi')->nullable();
            $table->text('spesifikasi')->nullable();
            $table->enum('status', ['Tersedia', 'Tidak tersedia'])->default('Tersedia');
            $table->integer('stok')->default(0);
            $table->string('kategori')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('produk');
    }
}
