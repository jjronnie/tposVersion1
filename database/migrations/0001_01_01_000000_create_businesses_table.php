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
        Schema::create('businesses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('account_number')->unique()->nullable();
            $table->string('short_name')->nullable();
            $table->string('currency', 10)->nullable()->default('USD');
            $table->string('currency_symbol', 10)->nullable()->default('$');
            $table->string('email')->unique()->nullable();
            $table->string('phone')->unique()->nullable();
            $table->string('country')->nullable();
            $table->string('address')->nullable();
            $table->string('timezone')->nullable();
            $table->string('tin_no')->nullable();
            $table->string('logo_path')->nullable();
            $table->string('date_format')->default('Y-m-d');
            $table->enum('source', [
                'facebook',
                'x',
                'tiktok',
                'instagram',
                'google',
                'website',
                'referral',
                'walk_in',
                'agent',
                'other'

            ])->nullable();
            $table->text('source_details')->nullable();

            $table->boolean('onboarding_completed')->default(false);
            $table->timestamp('onboarding_completed_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('businesses');
    }
};
