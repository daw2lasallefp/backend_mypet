<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVaccinationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vaccinations', function (Blueprint $table) {
            $table->id();
            $table->date('date')->nullable(false);
            $table->boolean('done')->nullable(false);
            $table->unsignedBigInteger('pet_id')->nullable(false);
            $table->unsignedBigInteger('vaccine_id')->nullable(false);
            $table->timestamps();

            $table->foreign('vaccine_id')->references('id')->on('vaccines');
            $table->foreign('pet_id')->references('id')->on('pets');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vaccinations');
    }
}
