<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('import_sessions', function (Blueprint $table) {
            if (! Schema::hasColumn('import_sessions', 'checksum')) {
                $table->string('checksum')->nullable()->index();
                $table->unique(['admin_id', 'checksum']);
            }
        });
    }

    public function down(): void
    {
        Schema::table('import_sessions', function (Blueprint $table) {
            if (Schema::hasColumn('import_sessions', 'checksum')) {
                $table->dropUnique(['admin_id', 'checksum']);
                $table->dropColumn('checksum');
            }
        });
    }
};
