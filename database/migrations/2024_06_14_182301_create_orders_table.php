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
                $table->foreignId('user_id')->nullable()->references('id')->on('users')->onDelete('cascade');
                $table->string('user_ip')->nullable();
                $table->foreignId('product_id')->references('id')->on('products')->onDelete('cascade');
                $table->integer('quantity');
                $table->enum('status', ['paid', 'waiting', 'delivered']);
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