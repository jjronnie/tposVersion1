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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();

            $table->foreignId('business_id')->constrained()->onDelete('cascade');
            $table->foreignId('customer_id')->nullable()->constrained('customers')->nullOnDelete();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete(); 

            // Sale Details
            $table->string('invoice_number')->unique(); // Unique identifier for the sale/invoice
            $table->timestamp('sale_date')->nullable(); // For sales recorded later, null for instant POS sales (use created_at)

            // Financial Totals
            $table->decimal('subtotal', 15, 2)->default(0.00); // Sum of all item prices * quantity
            $table->decimal('tax_amount', 15, 2)->default(0.00); // Total tax applied
            $table->decimal('discount_amount', 15, 2)->default(0.00); // Total discount applied
            $table->decimal('grand_total', 15, 2)->default(0.00); // subtotal + tax - discount

            // Payment
            $table->decimal('amount_paid', 15, 2)->default(0.00);
            $table->decimal('balance', 15, 2)->default(0.00); // amount_paid - grand_total (for change/credit)
            $table->enum('payment_status', ['paid', 'pending', 'partial'])->default('paid'); // Payment status
            $table->enum('payment_method', ['cash', 'card', 'transfer', 'other'])->default('cash');

            // Additional fields
            $table->text('notes')->nullable();

            $table->timestamps();

            $table->index('business_id');
            $table->index('sale_date');
            $table->index('customer_id');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
