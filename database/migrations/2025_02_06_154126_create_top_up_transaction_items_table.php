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
        Schema::create('top_up_transaction_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_id')->constrained('top_up_transactions')->onDelete('cascade');  // Relasi ke transaksi
            $table->foreignId('top_up_item_id')->constrained('top_up_items')->onDelete('cascade');  // Relasi ke item top up
            $table->integer('quantity')->default(1); // Jumlah item yang dibeli
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('top_up_transaction_items');
    }
};
