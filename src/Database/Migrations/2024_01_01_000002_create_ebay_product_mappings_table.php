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
        Schema::create('ebay_product_mappings', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('product_id');
            $table->string('ebay_item_id')->nullable();
            $table->string('ebay_listing_id')->nullable();
            $table->string('status')->default('pending');
            $table->timestamp('last_synced_at')->nullable();
            $table->json('sync_data')->nullable();
            $table->timestamps();

            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');

            $table->index('product_id');
            $table->index('ebay_item_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ebay_product_mappings');
    }
};
