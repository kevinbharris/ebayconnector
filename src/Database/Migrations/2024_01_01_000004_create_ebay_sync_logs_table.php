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
        Schema::create('ebay_sync_logs', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // product, order
            $table->string('action'); // sync, create, update, delete
            $table->unsignedBigInteger('entity_id')->nullable();
            $table->string('entity_type')->nullable();
            $table->string('status'); // success, error, pending
            $table->text('message')->nullable();
            $table->json('request_data')->nullable();
            $table->json('response_data')->nullable();
            $table->json('error_details')->nullable();
            $table->timestamps();

            $table->index('type');
            $table->index('status');
            $table->index(['entity_id', 'entity_type']);
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ebay_sync_logs');
    }
};
