<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('tblusers', function (Blueprint $table) {
            // role: admin/user (or others)
            $table->string('role', 20)->default('user')->after('password');

            // phone + address (nullable so old records won't break)
            $table->string('phone', 30)->nullable()->after('role');
            $table->string('address', 255)->nullable()->after('phone');

            // status: active/inactive
            // If you prefer boolean, tell me and I’ll switch it to is_active boolean instead.
            $table->string('status', 20)->default('active')->after('address');
        });
    }

    public function down(): void
    {
        Schema::table('tblusers', function (Blueprint $table) {
            $table->dropColumn(['role', 'phone', 'address', 'status']);
        });
    }
};