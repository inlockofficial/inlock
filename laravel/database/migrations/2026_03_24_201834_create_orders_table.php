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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            
        $table->foreignId('user_id')->constrained()->cascadeOnDelete();

        // product snapshot (VERY IMPORTANT)
        $table->string('product_title');
        $table->string('product_image');
        $table->decimal('price_usd', 10, 2);

        // conversion snapshot
        $table->integer('rate_used');
        $table->integer('total_dzd');

        // status system
        $table->enum('status', [
            'pending_payment',
            'payment_review',
            'paid',
            'ordered',
            'shipped',
            'completed',
            'cancelled'
        ])->default('pending_payment');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
