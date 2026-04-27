<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasColumn('tblusers', 'status')) {
            Schema::table('tblusers', function (Blueprint $table) {
                $table->string('status', 20)->default('active')->nullable();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('tblusers', 'status')) {
            Schema::table('tblusers', function (Blueprint $table) {
                $table->dropColumn('status');
            });
        }
    }
};