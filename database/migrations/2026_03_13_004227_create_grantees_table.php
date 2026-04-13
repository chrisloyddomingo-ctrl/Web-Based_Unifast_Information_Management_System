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
        Schema::create('grantees', function (Blueprint $table) {
            $table->id();
            $table->integer('seq')->nullable();

            $table->string('last_name');
            $table->string('first_name');
            $table->string('extension_name')->nullable();

            $table->string('mobile_number')->nullable();
            $table->string('email')->nullable();

            $table->string('course')->nullable();
            $table->integer('year')->nullable();
            $table->integer('years_of_stay')->nullable();

            $table->enum('status', ['Enrolled','Graduated','Shifted','Transferred'])->default('Enrolled');

            $table->text('remarks')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grantees');
    }
};
