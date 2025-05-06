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
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->string('delivery_code');
            $table->string('recipient_name');
            $table->string('recipient_address');
            $table->string('delivery_items');
            // $table->boolean('is_pickup')->default(false);
            $table->foreignId('users_id')->nullable()->constrained('users')->cascadeOnDelete();
            // $table->foreignId('checkpoints_id')->nullable()->constrained('checkpoints')->cascadeOnDelete();
            // $table->foreignId('delivery_statuses_id')->constrained('delivery_statuses')->cascadeOnDelete();
            // $table->string('delivery_status');
            // $table->boolean('is_send')->default(false);
            // $table->boolean('is_done')->default(false);
            // $table->string('delivery_photo')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deliveries');
    }
};
