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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('category_id');
            $table->string('product_name');
            $table->decimal('price', 10, 2);
            $table->string('stream_url')->nullable();
            $table->string('image');
            $table->timestamp('start_time');
            $table->integer('duration_seconds')->default(0);
            $table->decimal('current_price', 10, 2)->default(0.00);
            $table->string('last_bid_user')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
