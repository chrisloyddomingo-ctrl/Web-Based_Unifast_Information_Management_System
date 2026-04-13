<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('attendances', function (Blueprint $table) {

            if (!Schema::hasColumn('attendances', 'event_id')) {
                $table->unsignedBigInteger('event_id')->nullable();
            }

        });

        Schema::table('attendances', function (Blueprint $table) {

            try {
                $table->foreign('event_id')
                    ->references('id')
                    ->on('events')
                    ->onDelete('cascade');
            } catch (\Throwable $e) {
                // ignore if already exists
            }

        });
    }

    public function down()
    {
        Schema::table('attendances', function (Blueprint $table) {

            try {
                $table->dropForeign(['event_id']);
            } catch (\Throwable $e) {
                // ignore
            }

            if (Schema::hasColumn('attendances', 'event_id')) {
                $table->dropColumn('event_id');
            }

        });
    }
};