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
        Schema::create('offerings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type')->nullable(); // e.g., Land Banking, Rental, Flip
            $table->text('description')->nullable();
            $table->decimal('price', 15, 2)->nullable(); // Unit price or total price
            $table->decimal('target_amount', 15, 2)->nullable();
            $table->decimal('min_investment', 15, 2)->nullable();
            $table->decimal('total_units', 10, 2)->nullable();
            $table->decimal('available_units', 10, 2)->nullable();
            $table->string('location')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('status')->default('open'); // open, coming_soon, closed
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offerings');
    }
};
