<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('stock', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // Foreign key linking to products
            $table->integer('quantity');  // The quantity purchased
            $table->decimal('total_price', 8, 2);  // Total price for the purchased quantity
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // User who made the purchase
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('stock');
    }
};
