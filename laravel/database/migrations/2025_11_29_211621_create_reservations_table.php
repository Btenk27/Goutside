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

        $table->foreignId('user_id')
            ->constrained('users')
            ->cascadeOnDelete();

        $table->string('reservation_code')->unique();

        $table->date('start_date');
        $table->date('end_date');

        $table->decimal('grand_total', 15, 2);

        $table->enum('status', ['pending', 'approved', 'cancelled', 'dikembalikan'])
            ->default('pending');

        $table->timestamps();

        $table->index(['status', 'start_date']);
    });

    }

    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};