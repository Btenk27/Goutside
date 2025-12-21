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
        Schema::create('keranjang_items', function (Blueprint $table) {
        $table->id();

        $table->foreignId('keranjang_id')
            ->constrained('keranjang')
            ->cascadeOnDelete();

        $table->unsignedBigInteger('produk_id');

        $table->integer('qty')->default(1);

        // snapshot harga saat masuk keranjang
        $table->decimal('harga_satuan', 15, 2);

        $table->timestamps();

        $table->foreign('produk_id')
            ->references('idbarang')
            ->on('produk')
            ->cascadeOnDelete();

        $table->unique(['keranjang_id', 'produk_id']); // anti duplikat produk
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keranjang_items');
    }
};
