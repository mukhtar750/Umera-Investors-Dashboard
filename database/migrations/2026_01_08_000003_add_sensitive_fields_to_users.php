<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'dob')) {
                $table->string('dob')->nullable(); // encrypted
            }
            if (! Schema::hasColumn('users', 'address')) {
                $table->string('address')->nullable(); // encrypted
            }
            if (! Schema::hasColumn('users', 'next_of_kin_name')) {
                $table->string('next_of_kin_name')->nullable(); // encrypted
            }
            if (! Schema::hasColumn('users', 'next_of_kin_email')) {
                $table->string('next_of_kin_email')->nullable(); // encrypted
            }
            if (! Schema::hasColumn('users', 'next_of_kin_relationship')) {
                $table->string('next_of_kin_relationship')->nullable(); // encrypted
            }
            if (! Schema::hasColumn('users', 'next_of_kin_phone')) {
                $table->string('next_of_kin_phone')->nullable(); // encrypted
            }
            if (! Schema::hasColumn('users', 'must_reset_password')) {
                $table->boolean('must_reset_password')->default(false);
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            foreach ([
                'dob', 'address', 'next_of_kin_name', 'next_of_kin_email',
                'next_of_kin_relationship', 'next_of_kin_phone', 'must_reset_password',
            ] as $col) {
                if (Schema::hasColumn('users', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
