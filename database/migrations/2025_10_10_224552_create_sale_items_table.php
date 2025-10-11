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
        Schema::create('sale_items', function (Blueprint $table) {
            $table->id();
            
            // Relationships
            $table->foreignId('sale_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            
            // Product Snapshot (Store details in case product is modified/deleted later)
            $table->string('product_name');
            $table->decimal('selling_price', 15, 2); // Price at the time of sale
            $table->integer('quantity');
            $table->string('unit')->nullable();
            
            // Item Totals
            $table->decimal('item_discount', 15, 2)->default(0.00);
            $table->decimal('item_tax', 15, 2)->default(0.00);
            $table->decimal('subtotal', 15, 2); // (price * quantity) - discount + tax

            $table->timestamps();
            
            $table->index('sale_id');
            $table->index('product_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_items');
    }
};
