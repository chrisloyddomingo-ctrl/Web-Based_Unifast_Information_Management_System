<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
public function up(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->string('role', 20)->default('user')->after('password');
        $table->string('phone', 30)->nullable()->after('role');
        $table->string('address', 255)->nullable()->after('phone');
        $table->string('status', 20)->default('active')->after('address');
    });
}

public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['role', 'phone', 'address', 'status']);
    });
}
};