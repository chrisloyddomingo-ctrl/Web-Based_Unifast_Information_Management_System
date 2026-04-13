<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->string('event_name')->nullable()->after('barcode');
            $table->date('event_date')->nullable()->after('event_name');
            $table->dateTime('time_in')->nullable()->after('event_date');
            $table->text('remarks')->nullable()->after('time_in');
        });
    }

    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropColumn([
                'event_name',
                'event_date',
                'time_in',
                'remarks',
            ]);
        });
    }
};