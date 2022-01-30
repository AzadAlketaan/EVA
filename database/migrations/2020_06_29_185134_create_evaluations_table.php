<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvaluationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('Price');
            $table->integer('Cleanliness');
            $table->integer('Speed_of_Order_Arrival');
            $table->integer('Food_Quality');
            $table->integer('Location_of_The_Place');
            $table->integer('Treatment_of_Employees');
            $table->string('Positives');
            $table->string('Negatives');
            $table->string('Description');
            $table->string('Note');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('evaluations');
    }
}
