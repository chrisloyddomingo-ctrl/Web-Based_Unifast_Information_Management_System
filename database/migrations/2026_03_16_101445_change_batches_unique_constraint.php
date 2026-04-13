<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('batches', function (Blueprint $table) {
            $table->dropUnique('batches_name_unique');
            $table->unique(['scholarship_id', 'name'], 'batches_scholarship_id_name_unique');
        });
    }

    public function down(): void
    {
        Schema::table('batches', function (Blueprint $table) {
            $table->dropUnique('batches_scholarship_id_name_unique');
            $table->unique('name', 'batches_name_unique');
        });
    }
};