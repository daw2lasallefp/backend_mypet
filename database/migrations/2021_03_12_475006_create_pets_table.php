<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('sex');
            $table->float('weight');
            $table->unsignedBigInteger('age');
            $table->string('species');
            $table->unsignedBigInteger('client_id');
            $table->string('breed');
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('clients');
      
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pets');
    }
}
