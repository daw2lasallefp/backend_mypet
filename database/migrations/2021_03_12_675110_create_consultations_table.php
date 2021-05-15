<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsultationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consultations', function (Blueprint $table) {
            $table->id();
            $table->datetime('date_time')->nullable(false);
            $table->string('comments');
            $table->unsignedBigInteger('pet_id')->nullable(false);
            $table->unsignedBigInteger('employee_id')->nullable(false);
            $table->timestamps();

            $table->foreign('pet_id')->references('id')->on('pets');
            $table->foreign('employee_id')->references('id')->on('employees');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consultations');
    }
}
