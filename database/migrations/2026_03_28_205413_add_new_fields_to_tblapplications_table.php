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
    Schema::table('tblapplications', function (Blueprint $table) {
        $table->boolean('first_generation')->after('year_level');
        $table->string('parents_monthly_income')->after('first_generation');
    });
}

public function down(): void
{
    Schema::table('tblapplications', function (Blueprint $table) {
        $table->dropColumn(['first_generation', 'parents_monthly_income']);
    });
}
};
