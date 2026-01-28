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
        Schema::create('distributions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('offering_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->decimal('amount_per_unit', 15, 2); // Amount per unit
            $table->decimal('total_amount', 15, 2)->nullable(); // Total distributed
            $table->string('status')->default('pending'); // pending, processed
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('distributions');
    }
};
