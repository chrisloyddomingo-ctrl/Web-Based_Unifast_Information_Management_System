<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('student_accounts', 'is_temp_password')) {
            Schema::table('student_accounts', function (Blueprint $table) {
                $table->boolean('is_temp_password')->default(true)->after('password');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('student_accounts', 'is_temp_password')) {
            Schema::table('student_accounts', function (Blueprint $table) {
                $table->dropColumn('is_temp_password');
            });
        }
    }
};