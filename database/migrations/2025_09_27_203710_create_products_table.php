<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->foreignId('business_id')->constrained()->onDelete('cascade');
            $table->foreignId('supplier_id')
                ->nullable()
                ->constrained('suppliers')
                ->onDelete('set null');

            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('type', ['product', 'service'])->default('product');


            $table->decimal('purchase_price', 15, 2)->default(0.00);
            $table->decimal('selling_price', 15, 2)->default(0.00);

            $table->string('unit')->nullable();
            $table->integer('quantity')->default(0);
            $table->integer('quantity_alert')->default(10);

            $table->string('barcode')->unique()->nullable();
            $table->string('barcode_image_path')->nullable();


            $table->string('avatar')->nullable();

            $table->boolean('is_active')->default(true);

            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();


            $table->index('business_id');
            $table->index('name');
            $table->index('created_by');

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
