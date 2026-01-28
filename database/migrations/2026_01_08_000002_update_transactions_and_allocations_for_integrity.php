<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            if (! Schema::hasColumn('transactions', 'allocation_id')) {
                $table->foreignId('allocation_id')->nullable()->constrained('allocations')->cascadeOnDelete();
            }
            if (! Schema::hasColumn('transactions', 'user_id')) {
                $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            }
        });

        Schema::table('allocations', function (Blueprint $table) {
            if (! Schema::hasColumn('allocations', 'moa_signed')) {
                $table->boolean('moa_signed')->default(false);
            }
            if (! Schema::hasColumn('allocations', 'moa_signed_date')) {
                $table->string('moa_signed_date')->nullable(); // encrypted cast in model
            }
            $table->unique(['user_id', 'offering_id', 'block_name', 'unit_number'], 'allocations_unique_key');
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            if (Schema::hasColumn('transactions', 'allocation_id')) {
                $table->dropConstrainedForeignId('allocation_id');
            }
            if (Schema::hasColumn('transactions', 'user_id')) {
                $table->dropConstrainedForeignId('user_id');
            }
        });

        Schema::table('allocations', function (Blueprint $table) {
            if (Schema::hasColumn('allocations', 'moa_signed')) {
                $table->dropColumn('moa_signed');
            }
            if (Schema::hasColumn('allocations', 'moa_signed_date')) {
                $table->dropColumn('moa_signed_date');
            }
            $table->dropUnique('allocations_unique_key');
        });
    }
};
