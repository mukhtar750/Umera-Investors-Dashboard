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
        Schema::table('users', function (Blueprint $table) {
            $table->text('phone')->nullable()->change();
            $table->text('dob')->nullable()->change();
            $table->text('address')->nullable()->change();
            $table->text('next_of_kin_name')->nullable()->change();
            $table->text('next_of_kin_email')->nullable()->change();
            $table->text('next_of_kin_relationship')->nullable()->change();
            $table->text('next_of_kin_phone')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->change();
            $table->string('dob')->nullable()->change();
            $table->string('address')->nullable()->change();
            $table->string('next_of_kin_name')->nullable()->change();
            $table->string('next_of_kin_email')->nullable()->change();
            $table->string('next_of_kin_relationship')->nullable()->change();
            $table->string('next_of_kin_phone')->nullable()->change();
        });
    }
};
