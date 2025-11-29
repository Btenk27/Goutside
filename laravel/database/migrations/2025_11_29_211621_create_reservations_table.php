<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();

            // relasi ke users (boleh nullable kalau belum pakai auth)
            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            // relasi ke produk.idbarang (PENTING)
            $table->unsignedBigInteger('produk_id');

            $table->date('start_date');
            $table->date('end_date');
            $table->integer('qty');
            $table->decimal('total_price', 15, 2);
            $table->string('reservation_code')->unique();
            $table->enum('status', ['pending', 'approved', 'cancelled'])->default('pending');

            $table->timestamps();

            // definisi foreign key-nya
            $table->foreign('produk_id')
                  ->references('idbarang')
                  ->on('produk')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};

