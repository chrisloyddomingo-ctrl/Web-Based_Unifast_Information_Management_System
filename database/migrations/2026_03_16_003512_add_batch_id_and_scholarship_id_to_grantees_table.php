<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('grantees', function (Blueprint $table) {
            $table->foreignId('batch_id')->nullable()->constrained('batches')->nullOnDelete();
            $table->foreignId('scholarship_id')->nullable()->constrained('scholarships')->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::table('grantees', function (Blueprint $table) {
            $table->dropForeign(['batch_id']);
            $table->dropForeign(['scholarship_id']);
            $table->dropColumn(['batch_id', 'scholarship_id']);
        });
    }
};
