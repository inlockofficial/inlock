<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->string('ali_link');

            // user choices
            $table->string('size')->nullable();
            $table->string('color')->nullable();
            $table->string('gender')->nullable();
            $table->integer('quantity')->default(1);
            $table->text('custom_note')->nullable();

            // optional screenshot
            $table->string('screenshot')->nullable();

            // workflow status
            $table->enum('status', [
                'pending_review',
                'priced',
                'completed'
            ])->default('pending_review');

            // admin filled later
            $table->string('title')->nullable();
            $table->string('image')->nullable();
            $table->decimal('price_usd', 10, 2)->nullable();
            $table->decimal('shipping_usd', 10, 2)->nullable();
            $table->decimal('final_price_dzd', 10, 2)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};