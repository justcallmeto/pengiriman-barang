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
        Schema::create('delivery_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('delivery_id')->constrained('deliveries')->cascadeOnDelete();
            $table->foreignId('checkpoint_id')->constrained('checkpoints')->cascadeOnDelete();
            $table->foreignId('delivery_statuses_id')->constrained('delivery_statuses')->cascadeOnDelete();
            $table->foreignId('users_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->string('note')->nullable();
            $table->string('photos')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_events');
    }
};
