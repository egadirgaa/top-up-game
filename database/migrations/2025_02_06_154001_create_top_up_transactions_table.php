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
        Schema::create('top_up_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');  // Relasi ke tabel users
            $table->decimal('amount', 10, 2); // Jumlah yang dibayar (misalnya 100 atau 200)
            $table->enum('status', ['pending', 'success', 'failed'])->default('pending');
            $table->string('payment_type')->nullable();  // Misalnya: 'credit_card', 'bank_transfer', dsb.
            $table->string('transaction_id')->nullable(); // ID transaksi dari Midtrans
            $table->text('payment_url')->nullable(); // URL untuk melanjutkan ke halaman pembayaran (jika menggunakan Midtrans)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('top_up_transactions');
    }
};
