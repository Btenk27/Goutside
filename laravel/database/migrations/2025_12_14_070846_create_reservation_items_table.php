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
        Schema::create('reservation_items', function (Blueprint $table) {
        $table->id();

        $table->foreignId('reservation_id')
            ->constrained('reservations')
            ->cascadeOnDelete();

        $table->unsignedBigInteger('produk_id');

        // snapshot produk
        $table->string('produk_nama');
        $table->string('produk_kategori')->nullable();
        $table->decimal('harga_satuan', 15, 2);

        $table->integer('qty');
        $table->decimal('subtotal', 15, 2);

        $table->timestamps();

        $table->foreign('produk_id')
            ->references('idbarang')
            ->on('produk')
            ->cascadeOnDelete();

        $table->index('produk_kategori');
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservation_items');
    }
};
