<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('student_accounts', function (Blueprint $table) {
            $table->boolean('is_temp_password')->default(true)->after('password');
        });
    }

    public function down(): void
    {
        Schema::table('student_accounts', function (Blueprint $table) {
            $table->dropColumn('is_temp_password');
        });
    }
};
